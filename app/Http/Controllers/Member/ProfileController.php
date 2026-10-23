<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\UpdateProfileRequest;
use App\Services\Member\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ProfileController extends Controller {
 public function show(Request $r,ProfileService $s):JsonResponse{return response()->json(['data'=>$s->show($r->user())]);}
 public function update(UpdateProfileRequest $r,ProfileService $s):JsonResponse{return response()->json(['message'=>'Profil diperbarui.','data'=>$s->update($r->user(),$r->validated())]);}
}
