<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Catalog\Category;
use App\Services\Admin\Catalog\CategoryService;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller {
 public function index(CategoryService $s):JsonResponse{return response()->json(['data'=>$s->paginate()]);}
 public function store(StoreCategoryRequest $r,CategoryService $s):JsonResponse{return response()->json(['message'=>'Kategori dibuat.','data'=>$s->create($r->validated())],201);}
 public function show(Category $category,CategoryService $s):JsonResponse{return response()->json(['data'=>$s->show($category)]);}
 public function update(UpdateCategoryRequest $r,Category $category,CategoryService $s):JsonResponse{return response()->json(['message'=>'Kategori diperbarui.','data'=>$s->update($category,$r->validated())]);}
 public function archive(Category $category,CategoryService $s):JsonResponse{return response()->json(['message'=>'Kategori diarsipkan.','data'=>$s->archive($category)]);}
}