<?php
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureMember;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
return Application::configure(basePath:dirname(__DIR__))
 ->withRouting(web:__DIR__.'/../routes/web.php',commands:__DIR__.'/../routes/console.php',health:'/up')
 ->withMiddleware(function(Middleware $middleware):void{$middleware->alias(['admin'=>EnsureAdmin::class,'member'=>EnsureMember::class]);
  // Tanpa halaman login, callback bawaan Laravel memanggil route('login') dan melempar RouteNotFoundException (HTTP 500).
  $middleware->redirectGuestsTo(fn(Request $request)=>null);})
 ->withExceptions(function(Exceptions $exceptions):void{
  // Admin dan Member backend bersifat JSON-only dan belum memiliki halaman login. Semua error di prefix ini
  // dirender sebagai JSON (tamu menerima 401, bukan redirect ke route "login" yang tidak ada / HTTP 500).
  $exceptions->shouldRenderJsonWhen(fn(Request $request,Throwable $e)=>$request->expectsJson()||$request->is('admin/*')||$request->is('member/*'));
 })->create();
