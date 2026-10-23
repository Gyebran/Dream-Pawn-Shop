<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use App\Models\User;
use App\Services\Admin\MemberAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class MemberAccountController extends Controller {
 public function index(Request $r,MemberAccountService $s):JsonResponse{$f=$r->validate(['search'=>['sometimes','string','max:100'],'is_active'=>['sometimes','boolean']]);return response()->json(['data'=>$s->paginate($f)]);}
 public function store(StoreMemberRequest $r,MemberAccountService $s):JsonResponse{return response()->json(['message'=>'Akun Member dibuat.','data'=>$s->create($r->validated())],201);}
 public function show(User $member,MemberAccountService $s):JsonResponse{return response()->json(['data'=>$s->show($member)]);}
 public function update(UpdateMemberRequest $r,User $member,MemberAccountService $s):JsonResponse{return response()->json(['message'=>'Akun Member diperbarui.','data'=>$s->update($member,$r->validated())]);}
}