<?php
namespace App\Console\Commands;
use App\Models\Item;
use App\Models\LoanRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class CancelExpiredHandoverRequests extends Command {
 protected $signature='loans:cancel-expired-handover';
 protected $description='Cancel approved loan requests whose handover deadline has passed.';
 public function handle(): int {
  LoanRequest::where('status','approved')->whereNotNull('handover_deadline_at')->where('handover_deadline_at','<=',now())->orderBy('id')->chunkById(100,function($requests):void{
   foreach($requests as $request)DB::transaction(function()use($request):void{
    $loan=LoanRequest::whereKey($request->id)->lockForUpdate()->first();
    if(!$loan||$loan->status!=='approved'||$loan->handover_deadline_at->gt(now()))return;
    Item::whereIn('id',$loan->details()->pluck('item_id'))->where('status','reserved')->update(['status'=>'available']);
    $loan->update(['status'=>'cancelled']);
   });
  });
  $this->info('Expired handover requests processed.');return self::SUCCESS;
 }
}