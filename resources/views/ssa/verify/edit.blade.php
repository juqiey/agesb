@extends('layouts.user_type.auth')

@section('title', 'Verify SSA')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Verify SSA</h4>
                        </div>

                        <div class="card-body px-4 pt-4 pb-4">

                            <form action="{{ route('ssa.verify.update', $ssa) }}" method="POST" enctype="multipart/form-data"
                                onsubmit="console.log('Submitting form'); return true;">
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
                                {{-- SSA Details --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Requested By</label>
                                            <input disabled class="form-control" value="{{ $ssa->user->name ?? '-' }}">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Created At</label>
                                            <input disabled class="form-control"
                                                value="{{ $ssa->created_at->format('d/m/Y H:i') }}">
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Details</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSA No.</label>
                                            <input disabled name="ssa_no" class=" form-control"
                                                value="{{ old('ssa_no', $ssa->ssa_no) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Location</label>
                                            <input disabled name="location" class=" form-control"
                                                value="{{ old('location', $ssa->location) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Vessel</label>
                                            <select disabled name="vessel" class="form-select" required>
                                                @foreach ($vessels as $code => $name)
                                                    <option value="{{ $code }}"
                                                        {{ $ssa->vessel == $code ? 'selected' : '' }}>{{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSA Date</label>
                                            <input disabled type="date" name="ssa_date" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($ssa->date)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    @php
                                        $departments = ['ENGINE' => 'Engine', 'DECK' => 'Deck'];
                                        $ssaRaisedOptions = [
                                            'LSA/FFA ANNUAL SERVICING',
                                            'FLAG STATE INSPECTION',
                                            'EXT/INT AUDIT',
                                            'VOYAGE REPAIR',
                                            'CLASS SURVEY',
                                            'SAFETY INSPECTION',
                                            'VESSEL INSPECTION',
                                            'OTHERS',
                                        ];
                                    @endphp

                                    <div class="row mb-0">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach ($departments as $k => $v)
                                                <div class="form-check form-check-inline">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="department" value="{{ $k }}"
                                                        {{ $ssa->department == $k ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">SSA Raised By</label>
                                            @foreach ($ssaRaisedOptions as $option)
                                                <div class="form-check form-check-inline">
                                                    <input disabled class=" form-check-input" type="radio"
                                                        name="ssa_raised" value="{{ $option }}"
                                                        {{ $ssa->ssa_raised == $option ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Attachment --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Attachment</h6>
                                    <input type="file" name="attachment" class="form-control" disabled>

                                    @if ($ssa->doc_url)
                                        <div class="mt-2 align-items-center">
                                            <a href="{{ asset($ssa->doc_url) }}" target="_blank"
                                                class="btn btn-info">Current Attachment</a>
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
                                                        <th>Maker/Model No.</th>
                                                        <th>Remedial</th>
                                                        <th>Assistance</th>
                                                        <th>Remarks</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ssa_items as $index => $item)
                                                        <tr>
                                                            <td>{{ $item->description }}</td>
                                                            <td>{{ $item->model_no }}</td>
                                                            <td>{{ $item->remedial }}</td>
                                                            <td>{{ $item->assistance }}</td>
                                                            <td>{{ $item->remark }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ match ($item->status ?? 'OPEN') {
                                                                        'OPEN' => 'bg-success text-white',
                                                                        'CLOSE' => 'bg-warning text-white',
                                                                        'CANCEL' => 'bg-danger text-white',
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
                                            <label class="form-label">Verified By</label>
                                            <input disabled class="form-control" value="{{ auth()->user()->name }}">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Designation</label>
                                            <input disabled class="form-control"
                                                value="{{ auth()->user()->position ?? '-' }}">
                                        </div>
                                    </div>

                                    {{-- Remark input --}}
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Remark</label>
                                            <input type="text" name="verified_remark" class="form-control"
                                                value="{{ old('verified_remark', $ssa->verified_remark ?? '') }}"
                                                placeholder="Enter any remark">
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <span class="small fw-bold">Status:</span>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="verifySwitch"
                                                {{ old('verified_status', $ssa->verified_status) === 'VERIFIED' ? 'checked' : '' }}>

                                            <span id="verifyBadge"
                                                class="badge {{ $ssa->verified_status === 'VERIFIED' ? 'bg-success' : 'bg-warning' }}">
                                                {{ old('verified_status', $ssa->verified_status) ?? 'PENDING' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Hidden input for submit --}}
                                    <input type="hidden" name="verified_status" id="verificationStatus"
                                        value="{{ old('verified_status', $ssa->verified_status) ?? 'PENDING' }}">

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
            $('#verifySwitch').on('change', function() {

                if ($(this).is(':checked')) {
                    $('#verifyBadge')
                        .removeClass('bg-warning')
                        .addClass('bg-success')
                        .text('VERIFIED');

                    $('#verificationStatus').val('VERIFIED');

                } else {
                    $('#verifyBadge')
                        .removeClass('bg-success')
                        .addClass('bg-warning')
                        .text('PENDING');

                    $('#verificationStatus').val('PENDING');
                }

            });
        </script>
    @endpush
@endsection
