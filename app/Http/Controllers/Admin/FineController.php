<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
class FineController extends Controller {
 public function index(): JsonResponse {
  $fines=Fine::with(['loanRequestItem.item','loanRequestItem.loanRequest.member:id,name,email','recorder:id,name','paymentConfirmer:id,name'])->orderByDesc('assessed_at')->paginate(20);
  return response()->json(['data'=>$fines]);
 }
 public function confirmPayment(Fine $fine): JsonResponse {
  $updated=DB::transaction(function()use($fine):bool{
   $locked=Fine::whereKey($fine->id)->lockForUpdate()->firstOrFail();
   if($locked->status!=='unpaid')return false;
   $locked->update(['status'=>'paid','paid_at'=>now(),'paid_confirmed_by'=>auth()->id()]);
   return true;
  });
  if(!$updated)return response()->json(['message'=>'Denda ini tidak berstatus unpaid.'],409);
  return response()->json(['message'=>'Pembayaran denda dikonfirmasi.','data'=>$fine->fresh()]);
 }
}