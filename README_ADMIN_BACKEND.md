# Admin backend architecture

- `app/Http/Controllers/Admin`: thin HTTP controllers.
- `app/Http/Requests/Admin`: request validation.
- `app/Services/Admin`: Admin use cases grouped by catalog, loans, fines, reports, and Member accounts.
- `app/Services/Loans/LoanEligibilityService.php`: shared eligibility and two-unit allocation rules for reuse by Member request flows.
- `app/Models/Admin` and `app/Models/Member`: role profile records; shared login identity is `App\Models\User`.
- `app/Models/Catalog`, `app/Models/Loans`, and `app/Models/Fines`: business entities.
- Member controllers, requests, and services have dedicated folders; Member workflows are not implemented in this Admin scope.

## Implemented business rules
- Approval atomically reserves all requested units and requires an active Member with no unpaid fines.
- Approved reservations and active loans count toward the two-unit allocation cap.
- Handover must occur within 24 hours of approval; expired approvals are cancelled and reserved units released.
- The five-day period starts at handover, not approval.
- Late fine is `floor(overdue_seconds / 86400) * 10000` per physical unit.
- Only Admin can confirm returns and fine payments.
- Items are archived and Member accounts deactivated rather than permanently deleted.
- Loan reports can be filtered and exported as CSV.
- A migration adds a unique request/unit constraint and indexes for common operational queries.

## Admin routes
- `POST /admin/login`, `POST /admin/logout`
- `GET /admin/dashboard`
- `GET|POST /admin/categories`; `GET|PATCH /admin/categories/{category}`; `PATCH /admin/categories/{category}/archive`
- `GET|POST /admin/items`; `GET|PATCH /admin/items/{item}`; `PATCH /admin/items/{item}/archive`
- `GET|POST /admin/members`; `GET|PATCH /admin/members/{member}`
- `GET /admin/loan-requests`; POST actions: `approve`, `reject`, `handover`, `confirm-return`
- `GET /admin/fines`; `POST /admin/fines/{fine}/confirm-payment`
- `GET /admin/reports/loans`; `GET /admin/reports/loans/export`

The feature tests cover authentication, authorization, catalog/member management, loan allocation, return/fine boundaries, unpaid-fine restrictions, reports, and handover timeout. They must pass on the latest commit before the branch is considered ready for NeonDB validation.
