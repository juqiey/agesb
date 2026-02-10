@extends('layouts.user_type.auth')

@section('title', 'SSA Details - Procurement')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">SSA Details - Procurement View</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">

                            {{-- Basic Information --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Details</h6>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">SSA No:</strong>
                                            <span>{{ $ssa->ssa_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Location:</strong>
                                            <span>{{ $ssa->location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Vessel:</strong>
                                            <span>{{ $vessels[$ssa->vessel] ?? $ssa->vessel }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">SSA Date:</strong>
                                            <span>{{ \Carbon\Carbon::parse($ssa->date)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Department:</strong>
                                            <span>{{ $ssa->department }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">SSA Raised By:</strong>
                                            <span>{{ $ssa->ssa_raised }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status Section --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-4 text-uppercase fw-bold text-primary">Status Overview</h6>

                                <div class="row g-3">

                                    {{-- MAIN SSA STATUS --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>SSA Status</strong>
                                                <span
                                                    class="badge
                                                {{ match ($ssa->status ?? 'N/A') {
                                                    'OPEN' => 'bg-success',
                                                    'CLOSE' => 'bg-warning',
                                                    'CANCEL' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                    {{ $ssa->status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">Created By:
                                                {{ $ssa->user->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Created At:
                                                {{ optional($ssa->created_at)->format('d M Y, h:i A') }}</small>
                                        </div>
                                    </div>

                                    {{-- VERIFICATION --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Verification</strong>
                                                <span
                                                    class="badge
                                                {{ match ($ssa->verified_status ?? 'N/A') {
                                                    'VERIFIED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    default => 'bg-secondary',
                                                } }}">
                                                    {{ $ssa->verified_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By:
                                                {{ $ssa->verifiedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date:
                                                {{ optional($ssa->verified_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if ($ssa->verified_remark)
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $ssa->verified_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- APPROVAL --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Approval</strong>
                                                <span
                                                    class="badge
                                                {{ match ($ssa->approved_status ?? 'N/A') {
                                                    'APPROVED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    'REJECTED' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                    {{ $ssa->approved_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By:
                                                {{ $ssa->approvedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date:
                                                {{ optional($ssa->approved_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if ($ssa->approved_remark)
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $ssa->approved_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- PROCUREMENT --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Procurement</strong>
                                                <span
                                                    class="badge
                                                {{ match ($ssa->pro_status ?? 'N/A') {
                                                    'APPROVED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    'REJECTED' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                    {{ $ssa->pro_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By:
                                                {{ $ssa->proBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date:
                                                {{ optional($ssa->pro_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if ($ssa->pro_remark)
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $ssa->pro_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Attachment --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Attachment</h6>
                                @if ($ssa->doc_url)
                                    <a href="{{ asset($ssa->doc_url) }}" target="_blank" class="btn btn-info btn-sm">View
                                        Attachment</a>
                                @else
                                    <p class="mb-0 text-muted">No attachment available.</p>
                                @endif
                            </div>

                            {{-- SSA Items --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle datatable">
                                        <thead class="table-light">
                                            <tr class="text-center">
                                                <th>Description</th>
                                                <th>Model No.</th>
                                                <th>Remedial</th>
                                                <th>Assistance</th>
                                                <th>Remark</th>
                                                <th>Attachment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ssa_items as $item)
                                                <tr class="text-center">
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->model_no ?? '-' }}</td>
                                                    <td>{{ $item->remedial ?? '-' }}</td>
                                                    <td>{{ $item->assistance ?? '-' }}</td>
                                                    <td>{{ $item->remark ?? '-' }}</td>
                                                    <td>
                                                        @if ($item->doc_url)
                                                            <a href="{{ asset($item->doc_url) }}" target="_blank"
                                                                class="btn btn-sm btn-info">View</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge
                                                    {{ match ($item->status ?? 'OPEN') {
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
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
