<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CategoryController extends Controller {
 public function index(): JsonResponse { return response()->json(['data'=>Category::withCount('items')->orderBy('name')->paginate(20)]); }
 public function store(Request $request): JsonResponse {
  $data=$request->validate(['name'=>['required','string','max:255','unique:categories,name'],'description'=>['nullable','string']]);
  $category=Category::create($data+['is_archived'=>false]);
  return response()->json(['message'=>'Kategori dibuat.','data'=>$category],201);
 }
 public function show(Category $category): JsonResponse { return response()->json(['data'=>$category->load('items')]); }
 public function update(Request $request, Category $category): JsonResponse {
  $data=$request->validate(['name'=>['sometimes','required','string','max:255',Rule::unique('categories','name')->ignore($category->id)],'description'=>['sometimes','nullable','string']]);
  $category->update($data); return response()->json(['message'=>'Kategori diperbarui.','data'=>$category]);
 }
 public function archive(Category $category): JsonResponse {
  $category->update(['is_archived'=>true]); return response()->json(['message'=>'Kategori diarsipkan.','data'=>$category]);
 }
}