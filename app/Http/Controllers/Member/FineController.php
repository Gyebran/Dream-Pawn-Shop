<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Fines\Fine;
use App\Services\Member\Fines\FineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class FineController extends Controller {
 public function index(Request $r,FineService $s):JsonResponse{
  $f=$r->validate(['status'=>['sometimes',Rule::in([Fine::UNPAID,Fine::PAID])]]);
  return response()->json(['data'=>$s->paginate($r->user(),$f)]);
 }
}
