$c = [System.IO.File]::ReadAllText('routes/web.php')
$old = "    Route::post('/admin/work-sites/{workSite}/tickets', [WorkSiteController::class, 'storeTicket'])
        ->name('admin.work-sites.tickets.store');"
$new = "    Route::post('/admin/work-sites/{workSite}/tickets', [WorkSiteController::class, 'storeTicket'])
        ->name('admin.work-sites.tickets.store');

    Route::post('/admin/work-sites/{workSite}/daily-updates', [WorkSiteController::class, 'storeDailyUpdate'])
        ->name('admin.work-sites.daily-updates.store');"
$c = $c.Replace($old, $new)
[System.IO.File]::WriteAllText('routes/web.php', $c)
Write-Host "Done - route added"