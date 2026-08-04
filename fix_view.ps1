$c = [System.IO.File]::ReadAllText('resources/views/admin/work_sites/show.blade.php')
$old = '<div class="sectionx d-flex align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#securityActivityBody" aria-expanded="false" id="security-activity">'
$new = @'
<div class="sectionx d-flex justify-content-between align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#dailyUpdateBody" aria-expanded="false">
    <h4 class="mb-0 d-flex align-items-center gap-2"><span class="toggle-chevron">&#9660;</span> Daily Work Update</h4>
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#dailyUpdateForm" aria-expanded="false">+ Add Update</button>
</div>
<div class="collapse toggle-body mt-3" id="dailyUpdateBody">
    <div class="collapse mb-3" id="dailyUpdateForm">
        <div class="cardx">
            <form method="POST" action="{{ route('admin.work-sites.daily-updates.store', $workSite) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Note (optional)</label>
                    <textarea name="note" class="form-control" rows="3" maxlength="5000" placeholder="Add any notes about today's work"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Upload Daily Update</button>
            </form>
        </div>
    </div>
    <div class="cardx">
        @forelse($dailyWorkUpdates as $update)
        <div class="d-flex gap-3 align-items-start mb-3 pb-3 border-bottom border-secondary">
            @if($update->photo)
            <img class="photo" src="{{ asset('storage/' . $update->photo) }}" style="width:80px;height:80px;object-fit:cover;border-radius:12px">
            @endif
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $update->user->name ?? 'Unknown' }}</strong>
                        <small class="text-muted d-block">{{ $update->date->format('d M Y') }} at {{ $update->created_at->format('h:i A') }}</small>
                    </div>
                </div>
                @if($update->note)
                <p class="mt-2 mb-0">{{ $update->note }}</p>
                @endif
            </div>
        </div>
        @empty
        <p class="text-muted text-center mb-0">No daily work updates yet.</p>
        @endforelse
    </div>
</div>

<div class="sectionx d-flex align-items-center toggle-header" data-bs-toggle="collapse" data-bs-target="#securityActivityBody" aria-expanded="false" id="security-activity">
'@
$c = $c.Replace($old, $new)
[System.IO.File]::WriteAllText('resources/views/admin/work_sites/show.blade.php', $c)
Write-Host "Done - Daily Work Update section added"