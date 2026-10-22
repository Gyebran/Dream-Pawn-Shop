<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreItemRequest;
use App\Http\Requests\Admin\UpdateItemRequest;
use App\Models\Catalog\Item;
use App\Services\Admin\Catalog\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ItemController extends Controller {
 public function index(Request $r,ItemService $s):JsonResponse{$f=$r->validate(['status'=>['sometimes',Rule::in([Item::AVAILABLE,Item::RESERVED,Item::LOANED,Item::ARCHIVED])],'search'=>['sometimes','string','max:100']]);return response()->json(['data'=>$s->paginate($f)]);}
 public function store(StoreItemRequest $r,ItemService $s):JsonResponse{return response()->json(['message'=>'Barang dibuat.','data'=>$s->create($r->validated())],201);}
 public function show(Item $item,ItemService $s):JsonResponse{return response()->json(['data'=>$s->show($item)]);}
 public function update(UpdateItemRequest $r,Item $item,ItemService $s):JsonResponse{return response()->json(['message'=>'Barang diperbarui.','data'=>$s->update($item,$r->validated())]);}
 public function archive(Item $item,ItemService $s):JsonResponse{return response()->json(['message'=>'Barang diarsipkan.','data'=>$s->archive($item)]);}
}