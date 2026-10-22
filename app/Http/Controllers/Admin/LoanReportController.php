<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Loans\LoanRequest;
use App\Services\Admin\Reports\LoanReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;
class LoanReportController extends Controller {
 private function filters(Request $r):array{
  $f=$r->validate(['status'=>['sometimes',Rule::in([LoanRequest::PENDING,LoanRequest::APPROVED,LoanRequest::REJECTED,LoanRequest::CANCELLED,LoanRequest::ACTIVE,LoanRequest::RETURNED])],'member_id'=>['sometimes','integer','exists:members,user_id'],'from'=>['sometimes','date'],'to'=>['sometimes','date']]);
  if(isset($f['from'],$f['to'])&&Carbon::parse($f['to'])->lt(Carbon::parse($f['from'])))throw ValidationException::withMessages(['to'=>['Tanggal akhir tidak boleh sebelum tanggal awal.']]);
  return $f;
 }
 public function index(Request $r,LoanReportService $s):JsonResponse{return response()->json(['data'=>$s->paginate($this->filters($r))]);}
 public function export(Request $r,LoanReportService $s):StreamedResponse{return $s->exportCsv($this->filters($r));}
}