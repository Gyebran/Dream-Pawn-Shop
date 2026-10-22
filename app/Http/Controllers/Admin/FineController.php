<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Fines\Fine;
use App\Services\Admin\Fines\FineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class FineController extends Controller {
 public function index(Request $r,FineService $s):JsonResponse{$f=$r->validate(['status'=>['sometimes',Rule::in([Fine::UNPAID,Fine::PAID])]]);return response()->json(['data'=>$s->paginate($f)]);}
 public function confirmPayment(Fine $fine,FineService $s):JsonResponse{$r=$s->confirmPayment($fine,(int)auth()->id());if(isset($r['error']))return response()->json(['message'=>$r['error']],$r['http_status']);return response()->json(['message'=>'Pembayaran denda dikonfirmasi.','data'=>$r['data']]);}
}