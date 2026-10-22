<?php
namespace App\Services\Loans;
use App\Models\Fines\Fine;
use App\Models\Loans\LoanRequest;
use Illuminate\Support\Facades\DB;

/**
 * Shared borrowing eligibility rules for both Admin approval and Member request flows.
 * Keep role-specific HTTP handling outside this service.
 */
class LoanEligibilityService
{
    public function hasUnpaidFines(int $memberId): bool
    {
        return Fine::whereHas('loanRequestItem.loanRequest', fn ($query) => $query->where('member_id', $memberId))
            ->where('status', Fine::UNPAID)->exists();
    }

    public function allocatedUnitCount(int $memberId): int
    {
        return (int) DB::table('loan_request_items')
            ->join('loan_requests', 'loan_requests.id', '=', 'loan_request_items.loan_request_id')
            ->where('loan_requests.member_id', $memberId)
            ->whereIn('loan_requests.status', [LoanRequest::APPROVED, LoanRequest::ACTIVE])
            ->count();
    }

    public function canAllocate(int $memberId, int $additionalUnits): bool
    {
        return $additionalUnits > 0 && $this->allocatedUnitCount($memberId) + $additionalUnits <= 2;
    }
}
