<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Item;
use App\Models\LoanRequest as Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
class LoanRequestController extends Controller {
 public function index(): JsonResponse {
  return response()->json(['data'=>Loan::with(['member:id,name,email','details.item','reviewer:id,name'])->orderByDesc('requested_at')->paginate(20)]);
 }
 public function approve(Loan $loan): JsonResponse {
  $result=DB::transaction(function()use($loan):array{
   $loan=Loan::whereKey($loan->id)->lockForUpdate()->firstOrFail();
   if($loan->status!=='pending')return ['error'=>'Hanya permintaan pending yang bisa disetujui.','status'=>409];
   if(Fine::whereHas('loanRequestItem.loanRequest',fn($q)=>$q->where('member_id',$loan->member_id))->where('status','unpaid')->exists())return ['error'=>'Member memiliki denda yang belum lunas.','status'=>422];
   $details=$loan->details()->orderBy('item_id')->get();
   if($details->isEmpty()||$details->pluck('item_id')->unique()->count()!==$details->count())return ['error'=>'Permintaan kosong atau memuat barang duplikat.','status'=>422];
   $items=Item::whereIn('id',$details->pluck('item_id'))->orderBy('id')->lockForUpdate()->get();
   if($items->count()!==$details->count()||$items->contains(fn($item)=>$item->status!=='available'))return ['error'=>'Satu atau lebih barang tidak tersedia.','status'=>409];
   $count=DB::table('loan_request_items')->join('loan_requests','loan_requests.id','=','loan_request_items.loan_request_id')->where('loan_requests.member_id',$loan->member_id)->whereIn('loan_requests.status',['approved','active'])->count();
   if($count+$details->count()>2)return ['error'=>'Batas maksimal dua unit yang direservasi atau dipinjam akan terlampaui.','status'=>422];
   Item::whereIn('id',$items->pluck('id'))->update(['status'=>'reserved']);$now=now();
   $loan->update(['status'=>'approved','reviewed_by'=>auth()->id(),'reviewed_at'=>$now,'handover_deadline_at'=>$now->copy()->addDay()]);
   return ['loan'=>$loan->fresh()->load(['details.item','member:id,name,email'])];
  });
  if(isset($result['error']))return response()->json(['message'=>$result['error']],$result['status']);
  return response()->json(['message'=>'Permintaan disetujui; barang telah direservasi.','data'=>$result['loan']]);
 }
 public function reject(Loan $loan): JsonResponse {
  if($loan->status!=='pending')return response()->json(['message'=>'Hanya permintaan pending yang bisa ditolak.'],409);
  $loan->update(['status'=>'rejected','reviewed_by'=>auth()->id(),'reviewed_at'=>now()]);
  return response()->json(['message'=>'Permintaan ditolak.','data'=>$loan->fresh()]);
 }
 public function handover(Loan $loan): JsonResponse {
  $result=DB::transaction(function()use($loan):array{
   $loan=Loan::whereKey($loan->id)->lockForUpdate()->firstOrFail();
   if($loan->status!=='approved')return ['error'=>'Hanya permintaan approved yang bisa diserahterimakan.','status'=>409];
   if($loan->handover_deadline_at&&$loan->handover_deadline_at->lte(now())){
    $ids=$loan->details()->pluck('item_id');Item::whereIn('id',$ids)->where('status','reserved')->update(['status'=>'available']);$loan->update(['status'=>'cancelled']);
    return ['error'=>'Batas serah terima terlewat; permintaan dibatalkan dan barang dilepas.','status'=>409];
   }
   $details=$loan->details()->with('item')->get();
   if($details->isEmpty()||$details->contains(fn($d)=>!$d->item||$d->item->status!=='reserved'))return ['error'=>'Status reservasi barang tidak konsisten.','status'=>409];
   foreach($details as $detail)$detail->item->update(['status'=>'loaned']);
   $now=now();$loan->update(['status'=>'active','handed_over_at'=>$now,'due_at'=>$now->copy()->addDays(5)]);
   return ['loan'=>$loan->fresh()->load(['details.item','member:id,name,email'])];
  });
  if(isset($result['error']))return response()->json(['message'=>$result['error']],$result['status']);
  return response()->json(['message'=>'Serah terima dicatat.','data'=>$result['loan']]);
 }
 public function confirmReturn(Loan $loan): JsonResponse {
  $result=DB::transaction(function()use($loan):array{
   $loan=Loan::whereKey($loan->id)->lockForUpdate()->firstOrFail();
   if($loan->status!=='active'||!$loan->due_at)return ['error'=>'Hanya peminjaman aktif yang dapat dikonfirmasi pengembaliannya.','status'=>409];
   $now=now();$seconds=$loan->due_at->diffInSeconds($now,false);$lateDays=max(0,(int)floor($seconds/86400));
   $details=$loan->details()->with('item')->get();
   foreach($details as $detail){
    if(!$detail->item||$detail->item->status!=='loaned')return ['error'=>'Status barang tidak konsisten dengan peminjaman aktif.','status'=>409];
   }
   foreach($details as $detail){
    $detail->item->update(['status'=>'available']);
    if($lateDays>0)Fine::firstOrCreate(['loan_request_item_id'=>$detail->id],['recorded_by'=>auth()->id(),'amount'=>$lateDays*10000,'status'=>'unpaid','assessed_at'=>$now]);
   }
   $loan->update(['status'=>'returned','returned_at'=>$now,'return_confirmed_by'=>auth()->id()]);
   return ['loan'=>$loan->fresh()->load(['details.item','details.fine'])];
  });
  if(isset($result['error']))return response()->json(['message'=>$result['error']],$result['status']);
  return response()->json(['message'=>'Pengembalian dikonfirmasi.','data'=>$result['loan']]);
 }
}