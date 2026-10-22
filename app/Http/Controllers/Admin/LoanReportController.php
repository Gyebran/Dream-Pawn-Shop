<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Loans\LoanRequest;
use App\Services\Admin\Reports\LoanReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
class LoanReportController extends Controller {
 private function filters(Request $r):array{return $r->validate(['status'=>['sometimes',Rule::in([LoanRequest::PENDING,LoanRequest::APPROVED,LoanRequest::REJECTED,LoanRequest::CANCELLED,LoanRequest::ACTIVE,LoanRequest::RETURNED])],'member_id'=>['sometimes','integer','exists:members,user_id'],'from'=>['sometimes','date'],'to'=>['sometimes','date','after_or_equal:from']]);}
 public function index(Request $r,LoanReportService $s):JsonResponse{return response()->json(['data'=>$s->paginate($this->filters($r))]);}
 public function export(Request $r,LoanReportService $s):StreamedResponse{return $s->exportCsv($this->filters($r));}
}