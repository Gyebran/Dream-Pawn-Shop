<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Item extends Model {
 protected $fillable=['unit_code','name','description','status'];
 public function categories(): BelongsToMany { return $this->belongsToMany(Category::class,'item_category'); }
 public function loanRequestItems(): HasMany { return $this->hasMany(LoanRequestItem::class); }
}