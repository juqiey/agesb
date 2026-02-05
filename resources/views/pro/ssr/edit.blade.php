@extends('layouts.user_type.auth')

@section('title', 'Procurement Approve SSR')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Procurement Approval SSR</h4>
                        </div>

                        <div class="card-body px-4 pt-4 pb-4">

                            <form action="{{ route('pro.ssr.update', $ssr) }}" method="POST" enctype="multipart/form-data" onsubmit="console.log('Submitting form'); return true;">
                                @csrf
                                @method('PUT')

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="ni ni-fat-remove"></i></span>
                                        <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                {{-- SSR Details --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Requested By</label>
                                            <input disabled class="form-control"
                                                   value="{{ $ssr->users->name ?? '-' }}">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Created At</label>
                                            <input disabled class="form-control"
                                                   value="{{ $ssr->created_at->format('d/m/Y H:i') }}">
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSR Details</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSR No.</label>
                                            <input disabled name="ssr_no" class=" form-control" value="{{ old('ssr_no',$ssr->ssr_no) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Location</label>
                                            <input disabled name="location" class=" form-control" value="{{ old('location',$ssr->location) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Vessel</label>
                                            <select disabled name="vessel" class="form-select" required>
                                                @foreach($vessels as $code=>$name)
                                                    <option value="{{ $code }}" {{ $ssr->vessel==$code?'selected':'' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSR Date</label>
                                            <input disabled type="date" name="ssr_date" class="form-control" value="{{ \Carbon\Carbon::parse($ssr->ssr_date)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    @php
                                        $departments=['ENGINE'=>'Engine','DECK'=>'Deck'];
                                        $items=['DECK STORES'=>'Deck Stores','ENGINE STORE'=>'Engine Store','SPARE PART'=>'Spare Part'];
                                    @endphp

                                    <div class="row mb-0">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach($departments as $k=>$v)
                                                <div class="form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio" name="department" value="{{ $k }}" {{ $ssr->department==$k?'checked':'' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Item</label>
                                            @foreach($items as $k=>$v)
                                                <div class="form-check form-check-inline">
                                                    <input disabled class=" form-check-input" type="radio" name="item" value="{{ $k }}" {{ $ssr->item==$k?'checked':'' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Attachment --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Upload Attachment</h6>
                                    <input type="file" name="attachment" class="form-control" disabled>

                                    @if($ssr->doc_url)
                                        <div class="mt-2 align-items-center">
                                            <a href="{{ asset($ssr->doc_url) }}" target="_blank" class="btn btn-info">Current Attachment</a>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <span class="text-muted">No current attachment available.</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Items</h6>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle datatable">
                                                <thead class="table-light">
                                                <tr class="text-center">
                                                    <th>Description</th>
                                                    <th>Unit</th>
                                                    <th>Qty Req</th>
                                                    <th>Balance</th>
                                                    <th>Approved</th>
                                                    <th>IMPA</th>
                                                    <th>Remarks</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($ssr_items as $index => $item)
                                                    <tr>
                                                        <td>{{ $item->description }}</td>
                                                        <td>{{ $item->unit }}</td>
                                                        <td>
                                                            {{ $item->quantity_req }}
                                                        </td>

                                                        <td>
                                                            {{ $item->balance }}
                                                        </td>

                                                        <td>
                                                            {{ $item->quantity_app }}
                                                        </td>
                                                        <td>{{ $item->impa_code }}</td>
                                                        <td>{{ $item->remark }}</td>
                                                        <td>
                                                            <span class="badge
                                                            {{ match($item->status ?? 'OPEN') {
                                                                'OPEN' => 'bg-success text-white',
                                                                'CLOSE' => 'bg-warning text-white',
                                                                'CANCEL'=> 'bg-danger text-white',
                                                                default => 'bg-secondary text-white',
                                                            } }}">
                                                            {{ $item->status ?? 'OPEN' }}
                                                        </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- Verification --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Verification</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Verified By</small>
                                            <div class="fw-semibold">
                                                {{ $ssr->verifiedBy->name ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Designation</small>
                                            <div class="fw-semibold">
                                                {{ $ssr->verifiedBy->position ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Remark</small>
                                        <div class="fst-italic text-secondary">
                                            {{ $ssr->verified_remark ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">Status</small>

                                        <span class="badge
                                            {{ match($ssr->verified_status ?? 'N/A') {
                                                'VERIFIED' => 'bg-success',
                                                'PENDING' => 'bg-warning',
                                                default => 'bg-secondary',
                                            } }}">
                                            {{ $ssr->verified_status ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Approval --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Approval</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Approved By</small>
                                            <div class="fw-semibold">
                                                {{ $ssr->approvedBy->name ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Designation</small>
                                            <div class="fw-semibold">
                                                {{ $ssr->approvedBy->position ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Remark</small>
                                        <div class="fst-italic text-secondary">
                                            {{ $ssr->approved_remark ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">Status</small>

                                        <span class="badge
                                            {{ match($ssr->verified_status ?? 'N/A') {
                                                'VERIFIED' => 'bg-success',
                                                'PENDING' => 'bg-warning',
                                                default => 'bg-secondary',
                                            } }}">
                                            {{ $ssr->verified_status ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Procurement approval --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Procurement Approval</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Approval</label>
                                            <input disabled class="form-control" value="{{ auth()->user()->name }}">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Designation</label>
                                            <input disabled class="form-control" value="{{ auth()->user()->position ?? '-' }}">
                                        </div>
                                    </div>

                                    {{-- Remark input --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Remark</label>
                                            <input type="text" name="approved_remark" class="form-control"
                                                   value="{{ old('pro_remark', $ssr->pro_remark ?? '') }}"
                                                   placeholder="Enter any remark">
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <span class="small fw-bold">Status:</span>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="approvedSwitch"
                                                {{ old('pro_status', $ssr->pro_status) === 'APPROVED' ? 'checked' : '' }}>

                                            <span id="approvedBadge" class="badge {{ $ssr->pro_status === 'APPROVED' ? 'bg-success' : 'bg-warning' }}">
                                                {{ old('pro_status', $ssr->pro_status) ?? 'PENDING' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Hidden input for submit --}}
                                    <input type="hidden" name="approved_status" id="approvedStatus"
                                           value="{{ old('pro_status', $ssr->pro_status) ?? 'PENDING' }}">
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script>
            $('#approvedSwitch').on('change', function () {

                if ($(this).is(':checked')) {
                    $('#approvedBadge')
                        .removeClass('bg-warning')
                        .addClass('bg-success')
                        .text('APPROVED');

                    $('#approvedStatus').val('APPROVED');

                } else {
                    $('#approvedBadge')
                        .removeClass('bg-success')
                        .addClass('bg-warning')
                        .text('PENDING');

                    $('#approvedStatus').val('PENDING');
                }

            });
        </script>

    @endpush
@endsection
