<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Item;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
class DashboardController extends Controller {
 public function __invoke(): JsonResponse {
  return response()->json(['data'=>[
   'items_total'=>Item::where('status','!=','archived')->count(),
   'items_available'=>Item::where('status','available')->count(),
   'categories_active'=>Category::where('is_archived',false)->count(),
   'members_active'=>User::where('role','member')->where('is_active',true)->count(),
   'requests_pending'=>LoanRequest::where('status','pending')->count(),
   'loans_active'=>LoanRequest::where('status','active')->count(),
   'unpaid_fines_amount'=>(int)Fine::where('status','unpaid')->sum('amount'),
   'unpaid_fines_count'=>Fine::where('status','unpaid')->count(),
  ]]);
 }
}