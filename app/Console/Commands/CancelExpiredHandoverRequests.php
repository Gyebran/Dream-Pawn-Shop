<?php
namespace App\Console\Commands;
use App\Models\Catalog\Item;
use App\Models\Loans\LoanRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class CancelExpiredHandoverRequests extends Command {
 protected $signature='loans:cancel-expired-handover';
 protected $description='Cancel approved loan requests whose handover deadline has passed.';
 public function handle():int{
  LoanRequest::where('status',LoanRequest::APPROVED)->whereNotNull('handover_deadline_at')->where('handover_deadline_at','<=',now())->orderBy('id')->chunkById(100,function($rows){foreach($rows as $row)DB::transaction(function()use($row){$l=LoanRequest::whereKey($row->id)->lockForUpdate()->first();if(!$l||$l->status!==LoanRequest::APPROVED||!$l->handover_deadline_at||$l->handover_deadline_at->gt(now()))return;Item::whereIn('id',$l->details()->pluck('item_id'))->where('status',Item::RESERVED)->update(['status'=>Item::AVAILABLE]);$l->update(['status'=>LoanRequest::CANCELLED]);});});
  $this->info('Expired handover requests processed.');return self::SUCCESS;
 }
}