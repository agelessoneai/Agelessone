<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ComplaintTicketController;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\WorkSiteController;
use App\Http\Controllers\SiteZoneController;
use App\Http\Controllers\SiteAssetController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\OfficeInventoryController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SiteSupervisorController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\SalesLeadController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DailyWorkUpdateController;

/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    /*
    |--------------------------------------------------------------------------
    | Staff Attendance (role protected)
    |--------------------------------------------------------------------------
    | Security and site supervisors use the same photo punch endpoints as
    | office/project staff. Keeping these routes in a dedicated role group
    | prevents valid security punch requests from being redirected away.
    */
    Route::middleware('role:security,site_supervisor,office_staff,project_manager,project_head,project_coordinator,site_manager,supervisor')->group(function () {
        Route::post('/attendance/punch-in', [AttendanceController::class, 'punchIn'])
            ->name('attendance.punchin');

        Route::post('/attendance/punch-out', [AttendanceController::class, 'punchOut'])
            ->name('attendance.punchout');
    });

    Route::middleware('role:site_supervisor')->group(function () {
    Route::get('/supervisor/dashboard', [SiteSupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    Route::post('/supervisor/workers', [SiteSupervisorController::class, 'storeWorker'])->name('supervisor.workers.store');
    Route::post('/supervisor/workers/{worker}/start', [SiteSupervisorController::class, 'punchInWorker'])->name('supervisor.workers.start');
    Route::post('/supervisor/worker-attendance/{workerAttendance}/change-work', [SiteSupervisorController::class, 'changeWorkerWork'])->name('supervisor.workers.change-work');
    Route::post('/supervisor/worker-attendance/{workerAttendance}/end', [SiteSupervisorController::class, 'punchOutWorker'])->name('supervisor.workers.end');
    Route::post('/supervisor/work-cases', [SiteSupervisorController::class, 'storeWorkCase'])->name('supervisor.work-cases.store');
    Route::put('/supervisor/work-cases/{siteZone}', [SiteSupervisorController::class, 'updateWorkCase'])->name('supervisor.work-cases.update');
    Route::post('/supervisor/attendance/{workerAttendance}/approve', [SiteSupervisorController::class, 'approveAttendance'])->name('supervisor.attendance.approve');
    Route::post('/supervisor/attendance/{workerAttendance}/reject', [SiteSupervisorController::class, 'rejectAttendance'])->name('supervisor.attendance.reject');
    Route::post('/supervisor/daily-update', [SiteSupervisorController::class, 'storeDailyUpdate'])->name('supervisor.daily-update.store');
    });

    Route::middleware('role:security')->group(function () {
    Route::get('/security/dashboard', [SecurityController::class, 'dashboard'])
        ->name('security.dashboard');
    Route::get('/security/history', [SecurityController::class, 'history'])
        ->name('security.history');
    Route::post('/security/workers', [SecurityController::class, 'storeWorker'])
        ->name('security.workers.store');
    Route::post('/security/visitors', [SecurityController::class, 'storeVisitor'])
        ->name('security.visitors.store');
    Route::post('/security/visitors/{visitor}/checkout', [SecurityController::class, 'visitorCheckout'])
        ->name('security.visitors.checkout');
    Route::post('/security/workers/{worker}/punch-in', [SecurityController::class, 'workerPunchIn'])
        ->name('security.workers.punch-in');
    Route::post('/security/workers/{worker}/punch-out', [SecurityController::class, 'workerPunchOut'])
        ->name('security.workers.punch-out');

    });

    Route::middleware('role:office_staff,project_manager,project_head,project_coordinator,site_manager,site_supervisor,supervisor,security')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'user'])
        ->name('user.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Staff Tickets
    |--------------------------------------------------------------------------
    */
    Route::get('/my-tickets', [ComplaintTicketController::class, 'myTickets'])
        ->name('staff.tickets');

    Route::post('/tickets/{ticket}/accept', [ComplaintTicketController::class, 'accept'])
        ->name('tickets.accept');

    Route::post('/tickets/{ticket}/start', [ComplaintTicketController::class, 'startWork'])
        ->name('tickets.start');

    Route::post('/tickets/{ticket}/update', [ComplaintTicketController::class, 'updateWork'])
        ->name('tickets.update');

    Route::post('/tickets/{ticket}/complete', [ComplaintTicketController::class, 'complete'])
        ->name('tickets.complete');

    /*
    |--------------------------------------------------------------------------
    | Ticket Travel Tracking
    |--------------------------------------------------------------------------
    */

    Route::post('/tickets/{ticket}/travel/start', [ComplaintTicketController::class, 'startTravel'])
        ->name('tickets.travel.start');

    Route::post('/tickets/{ticket}/travel/location', [ComplaintTicketController::class, 'updateLiveLocation'])
        ->name('tickets.travel.location');

    Route::post('/tickets/{ticket}/travel/arrived', [ComplaintTicketController::class, 'markArrived'])
        ->name('tickets.travel.arrived');

    Route::post('/site-tickets/{siteTicket}/accept', [ComplaintTicketController::class, 'acceptSiteTicket'])
        ->name('site.tickets.accept');

    Route::post('/site-tickets/{siteTicket}/reject', [ComplaintTicketController::class, 'rejectSiteTicket'])
        ->name('site.tickets.reject');

    /*
    |--------------------------------------------------------------------------
    | Staff Daily Work Updates
    |--------------------------------------------------------------------------
    */
    Route::get('/my-daily-updates', [DailyWorkUpdateController::class, 'index'])
        ->name('staff.daily-updates');

    Route::post('/my-daily-updates', [DailyWorkUpdateController::class, 'store'])
        ->name('staff.daily-updates.store');
    });
});




/*
|--------------------------------------------------------------------------
| Site Inventory - Security mobile access only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:security'])->group(function () {
    Route::get('/site-inventory', [SecurityController::class, 'inventory'])->name('security.inventory');
    Route::post('/site-inventory', [SecurityController::class, 'storeInventoryItem'])->name('security.inventory.store');
    Route::post('/site-inventory/{inventoryMovement}/assign', [SecurityController::class, 'assignInventoryItem'])->name('security.inventory.assign');
    Route::post('/site-inventory/{inventoryMovement}/return', [SecurityController::class, 'returnInventoryItem'])->name('security.inventory.return');
});

/*
|--------------------------------------------------------------------------
| Staff Expenses
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/my-expenses', [ExpenseController::class, 'myExpenses'])->name('expenses.my');
    Route::post('/my-expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/my-expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

Route::middleware(['auth', 'role:admin,accounts'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::put('/expenses/{expense}/review', [ExpenseController::class, 'review'])->name('expenses.review');
});

/*
|--------------------------------------------------------------------------
| Sales Routes - Admin and Sales users only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,sales'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [SalesLeadController::class, 'dashboard'])->name('dashboard');
    Route::get('/leads', [SalesLeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [SalesLeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [SalesLeadController::class, 'store'])->name('leads.store');
    Route::post('/leads/import', [SalesLeadController::class, 'import'])->name('leads.import');
    Route::get('/leads/export/excel', [SalesLeadController::class, 'exportExcel'])->name('leads.export.excel');
    Route::get('/leads/export/pdf', [SalesLeadController::class, 'exportPdf'])->name('leads.export.pdf');
    Route::get('/leads/{lead}', [SalesLeadController::class, 'show'])->name('leads.show');
    Route::get('/leads/{lead}/edit', [SalesLeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{lead}', [SalesLeadController::class, 'update'])->name('leads.update');
});

/*
|--------------------------------------------------------------------------
| Office Inventory - Admin and Inventory Manager
|--------------------------------------------------------------------------
*/
// Backward-compatible route name for older bookmarks/templates. Access remains
// restricted to Admin and Inventory Manager accounts on the destination route.
Route::middleware(['auth'])->get('/admin/inventory-items', function () {
    return redirect()->route('office-inventory.index');
})->name('admin.inventory-items');

Route::middleware(['auth', 'role:admin,inventory_manager'])->prefix('office-inventory')->name('office-inventory.')->group(function () {
    Route::get('/', [OfficeInventoryController::class, 'index'])->name('index');
    Route::post('/items', [OfficeInventoryController::class, 'storeItem'])->name('items.store');
    Route::put('/items/{inventoryItem}', [OfficeInventoryController::class, 'updateItem'])->name('items.update');
    Route::post('/stock-in', [OfficeInventoryController::class, 'stockIn'])->name('stock-in');
    Route::post('/stock-out', [OfficeInventoryController::class, 'stockOut'])->name('stock-out');
    Route::post('/adjust', [OfficeInventoryController::class, 'adjust'])->name('adjust');
});


/*
|--------------------------------------------------------------------------
| Single Workshop Dashboard - Admin and Workshop Manager
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,workshop_manager'])->prefix('workshops')->name('workshops.')->group(function () {
    Route::get('/', [WorkshopController::class, 'index'])->name('index');
    Route::post('/', [WorkshopController::class, 'store'])->name('store');
    Route::get('/{workshop}', [WorkshopController::class, 'show'])->name('show');
    Route::put('/{workshop}', [WorkshopController::class, 'update'])->name('update');
    Route::post('/{workshop}/inventory', [WorkshopController::class, 'storeInventory'])->name('inventory.store');
    Route::put('/{workshop}/inventory/{item}', [WorkshopController::class, 'updateInventory'])->name('inventory.update');
    Route::post('/{workshop}/projects', [WorkshopController::class, 'storeProject'])->name('projects.store');
    Route::get('/{workshop}/projects/{project}', [WorkshopController::class, 'project'])->name('projects.show');
    Route::put('/{workshop}/projects/{project}', [WorkshopController::class, 'updateProject'])->name('projects.update');
    Route::post('/{workshop}/projects/{project}/files', [WorkshopController::class, 'uploadProjectFile'])->name('projects.files.store');
    Route::delete('/{workshop}/projects/{project}/files/{file}', [WorkshopController::class, 'deleteProjectFile'])->name('projects.files.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::post('/admin/notifications/{notification}/read', [DashboardController::class, 'markNotificationRead'])
        ->name('admin.notifications.read');

    /*
    |--------------------------------------------------------------------------
    | Office Staff / Users
    |--------------------------------------------------------------------------
    |
    | Keep `admin.users` as the main list route because the existing sidebar
    | and Blade files use route('admin.users'). The remaining resource actions
    | continue to use admin.users.create, admin.users.store, etc.
    |
    */

    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    // Backward-compatible alias for older Blade/sidebar links.
    Route::get('/admin/users-list', function () {
        return redirect()->route('admin.users.index');
    })->name('admin.users');

    Route::resource('/admin/users', UserController::class)
        ->except(['index', 'show'])
        ->names([
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Admin Attendance
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/attendance', [AttendanceController::class, 'adminIndex'])
        ->name('admin.attendance');

    Route::post('/admin/worker-attendance/{workerAttendance}/approve', [AttendanceController::class, 'adminApproveWorkerAttendance'])
        ->name('admin.worker-attendance.approve');

    Route::post('/admin/worker-attendance/{workerAttendance}/reject', [AttendanceController::class, 'adminRejectWorkerAttendance'])
        ->name('admin.worker-attendance.reject');

    Route::redirect('/admin/security-activity', '/admin/work-sites')
        ->name('admin.security-activity');


    Route::get('/admin/work-history', [WorkHistoryController::class, 'index'])
        ->name('admin.work-history.index');
    Route::get('/admin/work-history/{workSite}', [WorkHistoryController::class, 'show'])
        ->name('admin.work-history.show');
    Route::get('/admin/work-history/{workSite}/export', [WorkHistoryController::class, 'export'])
        ->name('admin.work-history.export');

    /*
    |--------------------------------------------------------------------------
    | Parks / Clients
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/parks', [ParkController::class, 'index'])
        ->name('admin.parks');

    Route::get('/admin/parks/create', [ParkController::class, 'create'])
        ->name('admin.parks.create');

    Route::post('/admin/parks', [ParkController::class, 'store'])
        ->name('admin.parks.store');

    /*
    |--------------------------------------------------------------------------
    | Complaint Tickets
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/tickets', [ComplaintTicketController::class, 'index'])
        ->name('admin.tickets');

    Route::get('/admin/tickets/create', [ComplaintTicketController::class, 'create'])
        ->name('admin.tickets.create');

    Route::post('/admin/tickets', [ComplaintTicketController::class, 'store'])
        ->name('admin.tickets.store');

    Route::get('/admin/tickets/{ticket}', [ComplaintTicketController::class, 'adminShow'])
        ->name('admin.tickets.show');

    Route::get('/admin/tickets/{ticket}/live-location', [ComplaintTicketController::class, 'liveLocation'])
        ->name('admin.tickets.liveLocation');

    /* Legacy Spare Parts URLs now open the unified Inventory module. */
    Route::get('/admin/spare-parts', fn() => redirect()->route('office-inventory.index'))->name('admin.spare-parts');

    /*
    |--------------------------------------------------------------------------
    | Worksite Inventory Issue Workflow
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/inventory-movements', [InventoryMovementController::class, 'index'])
        ->name('admin.inventory-movements');
    Route::get('/admin/inventory/stock-in', [InventoryMovementController::class, 'createStockIn'])
        ->name('admin.inventory.stock-in');
    Route::post('/admin/inventory/stock-in', [InventoryMovementController::class, 'storeStockIn'])
        ->name('admin.inventory.stock-in.store');
    Route::get('/admin/inventory/stock-out', [InventoryMovementController::class, 'createStockOut'])
        ->name('admin.inventory.stock-out');
    Route::post('/admin/inventory/stock-out', [InventoryMovementController::class, 'storeStockOut'])
        ->name('admin.inventory.stock-out.store');

    /*
    |--------------------------------------------------------------------------
    | Work Sites
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/work-sites', [WorkSiteController::class, 'index'])
        ->name('admin.work-sites');

    Route::get('/admin/work-sites/create', [WorkSiteController::class, 'create'])
        ->name('admin.work-sites.create');

    Route::post('/admin/work-sites', [WorkSiteController::class, 'store'])
        ->name('admin.work-sites.store');

    Route::get('/admin/work-sites/{workSite}/edit', [WorkSiteController::class, 'edit'])
        ->name('admin.work-sites.edit');

    Route::put('/admin/work-sites/{workSite}', [WorkSiteController::class, 'update'])
        ->name('admin.work-sites.update');

    Route::put('/admin/work-sites/{workSite}/team', [WorkSiteController::class, 'updateTeamMember'])
        ->name('admin.work-sites.team.update');

    Route::post('/admin/work-sites/{workSite}/tickets', [WorkSiteController::class, 'storeTicket'])
        ->name('admin.work-sites.tickets.store');



    Route::delete('/admin/work-sites/{workSite}', [WorkSiteController::class, 'destroy'])
        ->name('admin.work-sites.destroy');

    Route::get('/admin/work-sites/{workSite}/inventory', [WorkSiteController::class, 'inventory'])
        ->whereNumber('workSite')
        ->name('admin.work-sites.inventory');

    // Keep the wildcard route last so /create and /{workSite}/edit are never intercepted.
    Route::get('/admin/work-sites/{workSite}', [WorkSiteController::class, 'show'])
        ->whereNumber('workSite')
        ->name('admin.work-sites.show');

    /*
    |--------------------------------------------------------------------------
    | Daily Work Update Approval (Admin / Supervisor / Project Manager)
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/daily-work-updates/{dailyWorkUpdate}/approve', [DailyWorkUpdateController::class, 'approve'])
        ->name('admin.daily-updates.approve');

    Route::post('/admin/daily-work-updates/{dailyWorkUpdate}/reject', [DailyWorkUpdateController::class, 'reject'])
        ->name('admin.daily-updates.reject');

    /*
    |--------------------------------------------------------------------------
    | Site Zones
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/site-zones', [SiteZoneController::class, 'index'])
        ->name('admin.site-zones.index');

    Route::get('/admin/site-zones/create', [SiteZoneController::class, 'create'])
        ->name('admin.site-zones.create');

    Route::post('/admin/site-zones', [SiteZoneController::class, 'store'])
        ->name('admin.site-zones.store');

    Route::get('/admin/site-zones/{siteZone}/edit', [SiteZoneController::class, 'edit'])
        ->name('admin.site-zones.edit');

    Route::put('/admin/site-zones/{siteZone}', [SiteZoneController::class, 'update'])
        ->name('admin.site-zones.update');

    Route::delete('/admin/site-zones/{siteZone}', [SiteZoneController::class, 'destroy'])
        ->name('admin.site-zones.destroy');

    /*
    |--------------------------------------------------------------------------
    | Machinery and Site Assets
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/site-assets', [SiteAssetController::class, 'index'])
        ->name('admin.site-assets');

    Route::get('/admin/site-assets/create', [SiteAssetController::class, 'create'])
        ->name('admin.site-assets.create');

    Route::post('/admin/site-assets', [SiteAssetController::class, 'store'])
        ->name('admin.site-assets.store');

    Route::get('/admin/site-assets/{siteAsset}/edit', [SiteAssetController::class, 'edit'])
        ->name('admin.site-assets.edit');

    Route::put('/admin/site-assets/{siteAsset}', [SiteAssetController::class, 'update'])
        ->name('admin.site-assets.update');

    Route::delete('/admin/site-assets/{siteAsset}', [SiteAssetController::class, 'destroy'])
        ->name('admin.site-assets.destroy');






    Route::prefix('/admin/work-sites/{workSite}/workers')
        ->name('admin.work-sites.workers.')
        ->group(function () {
            Route::get('/', [WorkerController::class, 'index'])->name('index');
            Route::get('/bulk-create', [WorkerController::class, 'bulkCreate'])->name('bulk-create');
            Route::post('/bulk', [WorkerController::class, 'bulkStore'])->name('bulk-store');
            Route::get('/create', [WorkerController::class, 'create'])->name('create');
            Route::post('/', [WorkerController::class, 'store'])->name('store');
            Route::get('/{worker}/edit', [WorkerController::class, 'edit'])->name('edit');
            Route::put('/{worker}', [WorkerController::class, 'update'])->name('update');
            Route::delete('/{worker}', [WorkerController::class, 'destroy'])->name('destroy');
        });

    });
