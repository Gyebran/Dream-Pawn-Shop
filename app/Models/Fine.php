<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Fine extends Model {
 protected $fillable=['loan_request_item_id','recorded_by','paid_confirmed_by','amount','status','assessed_at','paid_at'];
 protected function casts(): array { return ['amount'=>'integer','assessed_at'=>'datetime','paid_at'=>'datetime']; }
 public function loanRequestItem(): BelongsTo { return $this->belongsTo(LoanRequestItem::class); }
 public function recorder(): BelongsTo { return $this->belongsTo(User::class,'recorded_by'); }
 public function paymentConfirmer(): BelongsTo { return $this->belongsTo(User::class,'paid_confirmed_by'); }
}