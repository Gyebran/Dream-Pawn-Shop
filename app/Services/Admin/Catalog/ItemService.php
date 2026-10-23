<?php
namespace App\Services\Admin\Catalog;
use App\Models\Catalog\Category;
use App\Models\Catalog\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class ItemService {
 public function paginate(array $f){return Item::with('categories')->when(isset($f['status']),fn($q)=>$q->where('status',$f['status']))->when(isset($f['search']),fn($q)=>$q->whereRaw('LOWER(name) LIKE ?', ['%'.mb_strtolower($f['search']).'%']))->orderBy('name')->paginate(20)->withQueryString();}
 public function create(array $data):Item{$ids=$data['category_ids']??[];unset($data['category_ids']);$this->assertCategoriesActive($ids);return DB::transaction(function()use($data,$ids){$item=Item::create($data+['status'=>Item::AVAILABLE]);$item->categories()->sync($ids);return $item->load('categories');});}
 public function show(Item $item):Item{return $item->load('categories');}
 public function update(Item $item,array $data):Item{$ids=$data['category_ids']??null;unset($data['category_ids']);return DB::transaction(function()use($item,$data,$ids){$locked=Item::whereKey($item->id)->lockForUpdate()->firstOrFail();$this->assertEditable($locked);if($ids!==null)$this->assertCategoriesActive($ids);$locked->update($data);if($ids!==null)$locked->categories()->sync($ids);return $locked->fresh()->load('categories');});}
 public function archive(Item $item):Item{return DB::transaction(function()use($item){$locked=Item::whereKey($item->id)->lockForUpdate()->firstOrFail();$this->assertEditable($locked);$locked->update(['status'=>Item::ARCHIVED]);return $locked->refresh();});}
 private function assertEditable(Item $item):void{if(in_array($item->status,[Item::RESERVED,Item::LOANED],true))throw ValidationException::withMessages(['item'=>'Barang yang sedang direservasi atau dipinjam tidak dapat diubah.']);if($item->status===Item::ARCHIVED)throw ValidationException::withMessages(['item'=>'Barang yang sudah diarsipkan tidak dapat diubah.']);}
 private function assertCategoriesActive(array $ids):void{if($ids===[])return;$count=Category::whereIn('id',$ids)->where('is_archived',false)->count();if($count!==count(array_unique($ids)))throw ValidationException::withMessages(['category_ids'=>'Kategori tidak ditemukan atau sudah diarsipkan.']);}
}