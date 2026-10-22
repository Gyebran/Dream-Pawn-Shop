<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Services\Member\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class DashboardController extends Controller {
 public function __invoke(Request $request,DashboardService $service):JsonResponse{return response()->json(['data'=>$service->summary($request->user())]);}
}
