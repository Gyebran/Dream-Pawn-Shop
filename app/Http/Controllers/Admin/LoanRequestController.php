<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Loans\LoanRequest;
use App\Services\Admin\Loans\LoanWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class LoanRequestController extends Controller {
 public function index(Request $r,LoanWorkflowService $s):JsonResponse{$f=$r->validate(['status'=>['sometimes',Rule::in([LoanRequest::PENDING,LoanRequest::APPROVED,LoanRequest::REJECTED,LoanRequest::CANCELLED,LoanRequest::ACTIVE,LoanRequest::RETURNED])],'member_id'=>['sometimes','integer','exists:members,user_id']]);return response()->json(['data'=>$s->paginate($f)]);}
 public function approve(LoanRequest $loan,LoanWorkflowService $s):JsonResponse{return $this->respond($s->approve($loan,(int)auth()->id()),'Permintaan disetujui; barang telah direservasi.');}
 public function reject(LoanRequest $loan,LoanWorkflowService $s):JsonResponse{return $this->respond($s->reject($loan,(int)auth()->id()),'Permintaan ditolak.');}
 public function handover(LoanRequest $loan,LoanWorkflowService $s):JsonResponse{return $this->respond($s->handover($loan),'Serah terima dicatat.');}
 public function confirmReturn(LoanRequest $loan,LoanWorkflowService $s):JsonResponse{return $this->respond($s->confirmReturn($loan,(int)auth()->id()),'Pengembalian dikonfirmasi.');}
 private function respond(array $r,string $message):JsonResponse{if(isset($r['error']))return response()->json(['message'=>$r['error']],$r['http_status']??422);return response()->json(['message'=>$message,'data'=>$r['data']]);}
}