@extends('layouts.admin')
@section('page-title', 'Machine QR Code')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card text-center" id="printable-area">
            <div class="card-header bg-dark border-secondary py-3">
                <h5 class="mb-0 text-white">QR Code Generated</h5>
                <small class="text-muted">Scan to view machine details</small>
            </div>
            <div class="card-body p-5 d-flex flex-column align-items-center">
                <div class="mb-3">
                    <h3 class="text-white">{{ $machine->name }}</h3>
                </div>
                
                <!-- QR Code Container -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4 d-inline-block">
                    <div id="qrcode"></div>
                </div>
                <div class="text-muted small mb-4 word-break" style="max-width: 100%; word-break: break-all;">
                    Scans to: <br>

                    @php
                        $dynamicUrl = request()->getSchemeAndHttpHost() . '/machines/' . $machine->id;
                    @endphp
                    <a href="{{ $dynamicUrl }}" target="_blank" class="text-info">{{ $dynamicUrl }}</a>
                    @if(str_contains($dynamicUrl, '127.0.0.1') || str_contains($dynamicUrl, 'localhost'))
                       
                    @endif
                </div>
                <div class="no-print d-flex gap-3">
                    <button onclick="window.print()" class="btn btn-success d-flex align-items-center gap-2">
                        <span>🖨️</span> Print Label
                    </button>
                    <a href="{{ route('admin.machines.index') }}" class="btn btn-outline-light">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            background: white !important;
            color: black !important;
        }
        #printable-area .card-header {
            background: white !important;
            color: black !important;
            border-bottom: 2px solid #000 !important;
        }
        #printable-area h3, #printable-area small, #printable-area a {
            color: black !important;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ route('machines.show', $machine->id) }}",
            text: "{{ $dynamicUrl }}",
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });
</script>
@endpush