$c = [System.IO.File]::ReadAllText('app/Http/Controllers/WorkSiteController.php')
$old = "use App\Models\WorkSite;"
$new = "use App\Models\WorkSite;`nuse App\Models\DailyWorkUpdate;`nuse Illuminate\Support\Facades\Storage;"
$c = $c.Replace($old, $new)

$old2 = "    public function create()
    {"
$new2 = "    /** Store a daily work update (photo + optional note) for a work site. */
    public function storeDailyUpdate(Request `$request, WorkSite `$workSite)
    {
        `$validated = `$request->validate([
            'photo' => ['nullable', 'image', 'max:10240'],
            'note' => ['nullable', 'string', 'max:5000'],
            'date' => ['required', 'date'],
        ]);

        `$photoPath = null;
        if (`$request->hasFile('photo')) {
            `$photoPath = `$request->file('photo')->store('daily-work-updates', 'public');
        }

        DailyWorkUpdate::create([
            'work_site_id' => `$workSite->id,
            'user_id' => Auth::id(),
            'photo' => `$photoPath,
            'note' => `$validated['note'] ?? null,
            'date' => `$validated['date'],
        ]);

        return back()->with('success', 'Daily work update added successfully.');
    }

    public function create()
    {"
$c = $c.Replace($old2, $new2)
[System.IO.File]::WriteAllText('app/Http/Controllers/WorkSiteController.php', $c)
Write-Host "Done - storeDailyUpdate method added"