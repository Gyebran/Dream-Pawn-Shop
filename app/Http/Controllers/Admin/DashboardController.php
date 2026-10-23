<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\JsonResponse;
class DashboardController extends Controller {public function __invoke(DashboardService $service):JsonResponse{return response()->json(['data'=>$service->summary()]);}}