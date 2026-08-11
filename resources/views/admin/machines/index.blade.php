@extends('layouts.admin')

@section('page-title', 'Machine Details')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-white">Registered Machines</h4>
                <p class="text-muted mb-0">Manage machines, view components, warranty status, and access generated QR codes.</p>
            </div>
            <a href="{{ route('admin.machines.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <span>➕</span> Register Machine
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Machine Name</th>
                        <th scope="col">Components</th>
                        <th scope="col">Purchase Date</th>
                        <th scope="col">Warranty</th>
                        <th scope="col">Warranty Ending</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($machines as $machine)
                        <tr>
                            <td><strong>{{ $machine->name }}</strong></td>
                            <td>
                                <span class="text-muted">{{ Str::limit($machine->components ?? 'N/A', 40) }}</span>
                            </td>
                            <td>{{ $machine->purchase_date ? $machine->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $machine->warranty ?? 'N/A' }}</td>
                            <td>
                                @if($machine->warranty_ending_date)
                                    @if($machine->warranty_ending_date->isPast())
                                        <span class="badge bg-danger">Expired ({{ $machine->warranty_ending_date->format('Y-m-d') }})</span>
                                    @else
                                        <span class="badge bg-success">Active ({{ $machine->warranty_ending_date->format('Y-m-d') }})</span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.machines.qr', $machine->id) }}" class="btn btn-sm btn-outline-info">
                                    🖨️ QR Code
                                </a>
                                <a href="{{ route('machines.show', $machine->id) }}" class="btn btn-sm btn-outline-light ms-1" target="_blank">
                                    👁️ View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No machines registered yet. Click "Register Machine" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $machines->links() }}
        </div>
    </div>
</div>
@endsection
