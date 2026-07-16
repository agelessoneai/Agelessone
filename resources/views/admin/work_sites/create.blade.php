@extends('layouts.admin')

@section('title', 'Add Work Site')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Add Work Site</h2>
        <p class="muted mb-0">
            Create a site and assign security, supervisor, site manager and project manager.
        </p>
    </div>

    <a href="{{ route('admin.work-sites') }}" class="btn-back">
        ← Back
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-dark">

    <form method="POST" action="{{ route('admin.work-sites.store') }}">
        @csrf

        <div class="form-grid">

            <div class="field">
                <label class="form-label">Site Name *</label>

                <input
                    type="text"
                    name="site_name"
                    class="form-control"
                    value="{{ old('site_name') }}"
                    placeholder="Example: Wonderla Expansion Project"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Client Name</label>

                <input
                    type="text"
                    name="client_name"
                    class="form-control"
                    value="{{ old('client_name') }}"
                    placeholder="Client or company name"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Location</label>

                <input
                    type="text"
                    name="location"
                    class="form-control"
                    value="{{ old('location') }}"
                    placeholder="Kochi, Kerala"
                >
            </div>

            <div class="field">
                <label class="form-label">Site Security</label>

                <select name="site_security_id" class="form-select">
                    <option value="">Select Security</option>

                    @foreach($securityUsers as $security)
                        <option
                            value="{{ $security->id }}"
                            {{ old('site_security_id') == $security->id ? 'selected' : '' }}
                        >
                            {{ $security->name }} — {{ $security->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Site Supervisor</label>

                <select name="site_supervisor_id" class="form-select">
                    <option value="">Select Supervisor</option>

                    @foreach($supervisors as $supervisor)
                        <option
                            value="{{ $supervisor->id }}"
                            {{ old('site_supervisor_id') == $supervisor->id ? 'selected' : '' }}
                        >
                            {{ $supervisor->name }} — {{ $supervisor->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Site Manager</label>

                <select name="site_manager_id" class="form-select">
                    <option value="">Select Site Manager</option>

                    @foreach($siteManagers as $manager)
                        <option
                            value="{{ $manager->id }}"
                            {{ old('site_manager_id') == $manager->id ? 'selected' : '' }}
                        >
                            {{ $manager->name }} — {{ $manager->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Project Manager</label>

                <select name="project_manager_id" class="form-select">
                    <option value="">Select Project Manager</option>

                    @foreach($projectManagers as $manager)
                        <option
                            value="{{ $manager->id }}"
                            {{ old('project_manager_id') == $manager->id ? 'selected' : '' }}
                        >
                            {{ $manager->name }} — {{ $manager->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Start Date</label>

                <input
                    type="date"
                    name="start_date"
                    class="form-control"
                    value="{{ old('start_date') }}"
                >
            </div>

            <div class="field">
                <label class="form-label">Expected End Date</label>

                <input
                    type="date"
                    name="expected_end_date"
                    class="form-control"
                    value="{{ old('expected_end_date') }}"
                >
            </div>

            <div class="field">
                <label class="form-label">Site Status *</label>

                <select name="status" class="form-select" required>
                    <option value="planning" {{ old('status') === 'planning' ? 'selected' : '' }}>
                        Planning
                    </option>

                    <option
                        value="active"
                        {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>
                        On Hold
                    </option>

                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                </select>
            </div>

            <div class="field full-width">
                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                    placeholder="Project description, scope, special instructions..."
                >{{ old('description') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.work-sites') }}" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-blue">
                💾 Save Work Site
            </button>
        </div>

    </form>

</div>

<style>
.form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:20px;
}

.field{
    min-width:0;
}

.full-width{
    grid-column:1/-1;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#9fb3d9;
    font-size:13px;
    font-weight:700;
}

.form-control,
.form-select{
    width:100%;
    min-height:50px;
    padding:12px 14px;
    border:1px solid #2b3854;
    border-radius:12px;
    outline:none;
    color:#fff;
    background:#0e1320;
    transition:.2s ease;
}

textarea.form-control{
    min-height:125px;
    resize:vertical;
}

.form-control::placeholder{
    color:#667793;
}

.form-control:focus,
.form-select:focus{
    border-color:#3f6fe0;
    background:#0e1320;
    color:#fff;
    box-shadow:0 0 0 4px rgba(63,111,224,.12);
}

.form-select option{
    color:#fff;
    background:#151b29;
}

.form-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px;
    margin-top:28px;
    padding-top:22px;
    border-top:1px solid #262f47;
}

.btn-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:43px;
    padding:10px 18px;
    border:1px solid #334155;
    border-radius:10px;
    color:#d4deef;
    background:#1c2436;
    text-decoration:none;
    font-weight:700;
}

.alert-danger{
    margin-bottom:20px;
    padding:16px 18px;
    border:1px solid rgba(255,90,110,.35);
    border-radius:14px;
    color:#ffd4da;
    background:rgba(255,90,110,.12);
}

@media(max-width:780px){
    .form-grid{
        grid-template-columns:1fr;
    }

    .full-width{
        grid-column:auto;
    }

    .form-actions{
        align-items:stretch;
        flex-direction:column-reverse;
    }

    .form-actions .btn-blue,
    .form-actions .btn-back{
        width:100%;
    }
}
</style>

@endsection