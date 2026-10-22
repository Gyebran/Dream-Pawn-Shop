<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class ItemController extends Controller {
 public function index(Request $request): JsonResponse {
  $items=Item::with('categories')->when($request->filled('status'),fn($q)=>$q->where('status',$request->string('status')->toString()))->orderBy('name')->paginate(20);
  return response()->json(['data'=>$items]);
 }
 public function store(Request $request): JsonResponse {
  $data=$request->validate(['unit_code'=>['required','string','max:255','unique:items,unit_code'],'name'=>['required','string','max:255'],'description'=>['nullable','string'],'category_ids'=>['sometimes','array'],'category_ids.*'=>['integer','distinct','exists:categories,id']]);
  $ids=$data['category_ids']??[]; unset($data['category_ids']);
  $item=DB::transaction(function()use($data,$ids){$item=Item::create($data+['status'=>'available']);$item->categories()->sync($ids);return $item->load('categories');});
  return response()->json(['message'=>'Barang dibuat.','data'=>$item],201);
 }
 public function show(Item $item): JsonResponse { return response()->json(['data'=>$item->load('categories')]); }
 public function update(Request $request, Item $item): JsonResponse {
  $data=$request->validate(['unit_code'=>['sometimes','required','string','max:255',Rule::unique('items','unit_code')->ignore($item->id)],'name'=>['sometimes','required','string','max:255'],'description'=>['sometimes','nullable','string'],'category_ids'=>['sometimes','array'],'category_ids.*'=>['integer','distinct','exists:categories,id']]);
  if(in_array($item->status,['reserved','loaned'],true))return response()->json(['message'=>'Barang yang sedang direservasi atau dipinjam tidak dapat diedit.'],409);
  $ids=$data['category_ids']??null;unset($data['category_ids']);
  DB::transaction(function()use($item,$data,$ids){$item->update($data);if($ids!==null)$item->categories()->sync($ids);});
  return response()->json(['message'=>'Barang diperbarui.','data'=>$item->fresh()->load('categories')]);
 }
 public function archive(Item $item): JsonResponse {
  if(in_array($item->status,['reserved','loaned'],true))return response()->json(['message'=>'Barang yang sedang direservasi atau dipinjam tidak dapat diarsipkan.'],409);
  $item->update(['status'=>'archived']);return response()->json(['message'=>'Barang diarsipkan.','data'=>$item]);
 }
}