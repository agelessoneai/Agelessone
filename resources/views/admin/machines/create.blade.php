@extends('layouts.admin')

@section('page-title', 'Register Machine')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white">Add New Machine</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.machines.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Machine Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Caterpillar Excavator 320" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="components" class="form-label">Components / Sub-assemblies</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="components" name="components" rows="4" placeholder="List key components, e.g. Hydralic Pump, Engine Block, Control Valve">{{ old('components') }}</textarea>
                        @error('components')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="purchase_date" class="form-label">Purchase Date</label>
                            <input type="date" class="form-control bg-dark text-white border-secondary" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                            @error('purchase_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="warranty" class="form-label">Warranty Duration</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" id="warranty" name="warranty" value="{{ old('warranty') }}" placeholder="e.g. 24 Months / 2 Years">
                            @error('warranty')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="warranty_ending_date" class="form-label">Warranty Ending Date</label>
                        <input type="date" class="form-control bg-dark text-white border-secondary" id="warranty_ending_date" name="warranty_ending_date" value="{{ old('warranty_ending_date') }}">
                        @error('warranty_ending_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.machines.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
