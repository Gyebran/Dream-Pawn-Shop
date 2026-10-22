<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller {
 public function login(Request $request): JsonResponse {
  $credentials=$request->validate(['email'=>['required','email'],'password'=>['required','string']]);
  if (!Auth::attempt($credentials)) throw ValidationException::withMessages(['email'=>['Email atau password tidak valid.']]);
  $request->session()->regenerate(); $user=$request->user();
  if (!$user->isAdmin() || !$user->adminProfile()->exists()) {
   Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
   return response()->json(['message'=>'Akun ini tidak memiliki akses Admin.'],403);
  }
  return response()->json(['message'=>'Login Admin berhasil.','user'=>['id'=>$user->id,'name'=>$user->name,'email'=>$user->email,'role'=>$user->role]]);
 }
 public function logout(Request $request): JsonResponse {
  Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
  return response()->json(['message'=>'Logout berhasil.']);
 }
}