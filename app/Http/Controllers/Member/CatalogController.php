<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Item;
use App\Services\Member\CatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CatalogController extends Controller {
 public function index(Request $r,CatalogService $s):JsonResponse{
  $f=$r->validate(['search'=>['sometimes','string','max:100'],'category_id'=>['sometimes','integer','exists:categories,id'],'available'=>['sometimes','boolean']]);
  return response()->json(['data'=>$s->paginateItems($f)]);
 }
 public function show(Item $item,CatalogService $s):JsonResponse{return response()->json(['data'=>$s->showItem($item)]);}
 public function categories(CatalogService $s):JsonResponse{return response()->json(['data'=>$s->categories()]);}
}
