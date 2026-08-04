@extends('layouts.admin')

@section('content')
<style>
    :root {
        --bg-primary: #0e1320;
        --bg-secondary: #151b29;
        --bg-hover: #1c2436;
        --border-color: #262f47;
        --primary: #3f6fe0;
        --text-primary: #e8edf6;
        --text-secondary: #8794ac;
        --text-heading: #ffffff;
    }

    body {
        margin: 0;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .navbar,
    header {
        display: none !important;
    }

    .container {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .parks-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 25px;
    }

    .parks-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .parks-header h3 {
        margin: 0 0 4px;
        color: var(--text-heading);
        font-size: 24px;
        font-weight: 700;
    }

    .parks-header p {
        margin: 0;
        color: var(--text-secondary);
    }

    .btn-blue {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border: 0;
        border-radius: 10px;
        background: var(--primary);
        color: #ffffff;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .btn-blue:hover {
        color: #ffffff;
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .parks-table {
        width: 100%;
        margin: 0;
        color: var(--text-heading) !important;
    }

    .parks-table thead th {
        padding: 15px;
        border-color: var(--border-color) !important;
        background: var(--bg-primary);
        color: #8fa3c7 !important;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .parks-table tbody td {
        padding: 15px;
        border-color: var(--border-color) !important;
        background: var(--bg-secondary);
        color: var(--text-heading) !important;
        font-size: 15px;
        font-weight: 500;
        vertical-align: middle;
    }

    .parks-table tbody tr:hover td {
        background: var(--bg-hover);
    }

    .parks-table td strong {
        color: var(--text-heading);
        font-weight: 800;
    }

    .empty-state {
        padding: 40px 20px !important;
        color: var(--text-secondary) !important;
        text-align: center;
    }

    .pagination-wrapper {
        margin-top: 24px;
    }

    @media (max-width: 768px) {
        .parks-card {
            padding: 18px;
            border-radius: 14px;
        }

        .parks-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-blue {
            width: 100%;
        }
    }
</style>

<div class="parks-card">
    <div class="parks-header">
        <div>
            <h3>Parks / Clients</h3>
            <p>All customer parks</p>
        </div>

        <a
            href="{{ route('admin.parks.create') }}"
            class="btn-blue"
        >
            + Add Park
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table parks-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Park Name</th>
                    <th scope="col">Contact Person</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Location</th>
                    <th scope="col">Created</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($parks as $park)
                    <tr>
                        <td>#{{ $park->id }}</td>

                        <td>
                            <strong>{{ $park->name }}</strong>
                        </td>

                        <td>{{ $park->contact_person ?: '—' }}</td>

                        <td>
                            @if ($park->phone)
                                <a
                                    href="tel:{{ $park->phone }}"
                                    class="text-white text-decoration-none"
                                >
                                    {{ $park->phone }}
                                </a>
                            @else
                                —
                            @endif
                        </td>

                        <td>{{ $park->location ?: '—' }}</td>

                        <td>
                            {{ optional($park->created_at)->format('d M Y') ?: '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No parks have been added yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($parks->hasPages())
        <div class="pagination-wrapper">
            {{ $parks->links() }}
        </div>
    @endif
</div>
@endsection