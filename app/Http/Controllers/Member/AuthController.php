<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller {
 public function login(LoginRequest $request):JsonResponse{
  if(!Auth::attempt($request->safe()->only(['email','password'])))throw ValidationException::withMessages(['email'=>['Email atau password tidak valid.']]);
  $request->session()->regenerate();$u=$request->user();
  if(!$u->isMember()||!$u->memberProfile()->exists()){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return response()->json(['message'=>'Akun ini tidak memiliki akses Member atau sedang nonaktif.'],403);}
  return response()->json(['message'=>'Login Member berhasil.','data'=>['id'=>$u->id,'name'=>$u->name,'email'=>$u->email,'role'=>$u->role]]);
 }
 public function logout(Request $request):JsonResponse{Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return response()->json(['message'=>'Logout berhasil.']);}
}
