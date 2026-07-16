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

    Route::get('/dashboard', [DashboardController::class, 'user'])
        ->name('user.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Attendance
    |--------------------------------------------------------------------------
    */

    Route::post('/attendance/punch-in', [AttendanceController::class, 'punchIn'])
        ->name('attendance.punchin');

    Route::post('/attendance/punch-out', [AttendanceController::class, 'punchOut'])
        ->name('attendance.punchout');

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

    Route::get('/admin/users', [DashboardController::class, 'users'])
        ->name('admin.users');

    /*
    |--------------------------------------------------------------------------
    | Admin Attendance
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/attendance', [AttendanceController::class, 'adminIndex'])
        ->name('admin.attendance');

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

    /*
    |--------------------------------------------------------------------------
    | Spare Parts
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/spare-parts', [SparePartController::class, 'index'])
        ->name('admin.spare-parts');

    Route::get('/admin/spare-parts/create', [SparePartController::class, 'create'])
        ->name('admin.spare-parts.create');

    Route::post('/admin/spare-parts', [SparePartController::class, 'store'])
        ->name('admin.spare-parts.store');

    Route::get('/admin/spare-parts/{sparePart}/edit', [SparePartController::class, 'edit'])
        ->name('admin.spare-parts.edit');

    Route::put('/admin/spare-parts/{sparePart}', [SparePartController::class, 'update'])
        ->name('admin.spare-parts.update');

    Route::delete('/admin/spare-parts/{sparePart}', [SparePartController::class, 'destroy'])
        ->name('admin.spare-parts.destroy');

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

    Route::delete('/admin/work-sites/{workSite}', [WorkSiteController::class, 'destroy'])
        ->name('admin.work-sites.destroy');

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


Route::get('/admin/inventory-items', [InventoryItemController::class, 'index'])
    ->name('admin.inventory-items');

Route::get('/admin/inventory-items/create', [InventoryItemController::class, 'create'])
    ->name('admin.inventory-items.create');

Route::post('/admin/inventory-items', [InventoryItemController::class, 'store'])
    ->name('admin.inventory-items.store');

Route::get('/admin/inventory-items/{inventoryItem}/edit', [InventoryItemController::class, 'edit'])
    ->name('admin.inventory-items.edit');

Route::put('/admin/inventory-items/{inventoryItem}', [InventoryItemController::class, 'update'])
    ->name('admin.inventory-items.update');

Route::delete('/admin/inventory-items/{inventoryItem}', [InventoryItemController::class, 'destroy'])
    ->name('admin.inventory-items.destroy');

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

    });