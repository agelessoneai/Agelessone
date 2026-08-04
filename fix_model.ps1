$c = [System.IO.File]::ReadAllText('app/Models/WorkSite.php')
$old = '    public function tickets(): HasMany
    {
        return $this->hasMany(SiteTicket::class);
    }
}'
$new = '    public function tickets(): HasMany
    {
        return $this->hasMany(SiteTicket::class);
    }

    public function dailyWorkUpdates(): HasMany
    {
        return $this->hasMany(DailyWorkUpdate::class);
    }
}'
$c = $c.Replace($old, $new)
[System.IO.File]::WriteAllText('app/Models/WorkSite.php', $c)
Write-Host "Done - dailyWorkUpdates relationship added"