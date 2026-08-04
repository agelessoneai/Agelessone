$c = [System.IO.File]::ReadAllText('app/Http/Controllers/WorkSiteController.php')
$old = "            'visitors.recordedBy',"
$new = "            'visitors.recordedBy',`n            'dailyWorkUpdates.user',"
$c = $c.Replace($old, $new)

$old2 = "        `$siteVisitors = `$workSite->visitors->sortByDesc('check_in_at');"
$new2 = "        `$siteVisitors = `$workSite->visitors->sortByDesc('check_in_at');`n        `$dailyWorkUpdates = `$workSite->dailyWorkUpdates->sortByDesc('created_at');"
$c = $c.Replace($old2, $new2)

$old3 = "            'approvedWorkerAttendances', 'pendingWorkerAttendances', 'siteVisitors', 'teamMembers'"
$new3 = "            'approvedWorkerAttendances', 'pendingWorkerAttendances', 'siteVisitors', 'teamMembers', 'dailyWorkUpdates'"
$c = $c.Replace($old3, $new3)

[System.IO.File]::WriteAllText('app/Http/Controllers/WorkSiteController.php', $c)
Write-Host "Done - show method updated"