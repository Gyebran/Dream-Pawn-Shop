<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreLoanRequestRequest;
use App\Models\Loans\LoanRequest;
use App\Services\Member\Loans\LoanRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class LoanRequestController extends Controller {
 public function index(Request $r,LoanRequestService $s):JsonResponse{
  $f=$r->validate(['status'=>['sometimes',Rule::in([LoanRequest::PENDING,LoanRequest::APPROVED,LoanRequest::REJECTED,LoanRequest::CANCELLED,LoanRequest::ACTIVE,LoanRequest::RETURNED])]]);
  return response()->json(['data'=>$s->paginate($r->user(),$f)]);
 }
 public function store(StoreLoanRequestRequest $r,LoanRequestService $s):JsonResponse{
  $res=$s->create($r->user(),$r->validated()['item_ids']);
  if(isset($res['error']))return response()->json(['message'=>$res['error']],$res['http_status']??422);
  return response()->json(['message'=>'Pengajuan peminjaman dikirim dan menunggu tinjauan Admin.','data'=>$res['data']],201);
 }
 public function show(Request $r,LoanRequest $loan,LoanRequestService $s):JsonResponse{return response()->json(['data'=>$s->show($r->user(),$loan)]);}
}
