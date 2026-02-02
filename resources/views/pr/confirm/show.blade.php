@extends('layouts.user_type.auth')

@section('title', 'PR Details')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">PR Details</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            {{-- Basic Information --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">PR No:</strong>
                                            <span>{{ $pr->pr_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Requested By:</strong>
                                            <span>{{ $pr->requestedBy->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Vessel:</strong>
                                            <span>{{ $vessels[$pr->vessel] ?? $pr->vessel }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">PR Date:</strong>
                                            <span>{{ $pr->date->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Item:</strong>
                                            <span>{{ $pr->item_req }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <strong class="me-2">Title:</strong>
                                            <span>{{ $pr->title }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status Section --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-4 text-uppercase fw-bold text-primary">Status Overview</h6>

                                <div class="row g-3">

                                    {{-- MAIN PR STATUS --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>PR Status</strong>
                                                <span class="badge
                                                    {{ match($pr->status ?? 'N/A') {
                                                        'OPEN' => 'bg-success',
                                                        'CLOSE' => 'bg-warning',
                                                        'CANCEL'=> 'bg-danger',
                                                        default => 'bg-secondary',
                                                    } }}">
                                                    {{ $pr->status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">Created By: {{ $pr->requestedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Created At: {{ optional($pr->date)->format('d M Y, h:i A') }}</small>
                                        </div>
                                    </div>

                                    {{-- Confirmation --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Confirmation</strong>
                                                <span class="badge
                                                    {{ match($pr->confirmed_status ?? 'N/A') {
                                                        'VERIFIED' => 'bg-success',
                                                        'PENDING' => 'bg-warning',
                                                        default => 'bg-secondary',
                                                    } }}">
                                                    {{ $pr->confirmed_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $pr->confirmedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($pr->confirmed_at)->format('d M Y, h:i A') ?? '-' }}</small>
                                            <br>
                                            @if($pr->confirmed_remark)
                                                <small class="text-muted d-block">Remark:</small>
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $pr->confirmed_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- APPROVAL --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Approval</strong>
                                                <span class="badge
                                                    {{ match($pr->approved_status ?? 'N/A') {
                                                        'APPROVED' => 'bg-success',
                                                        'PENDING' => 'bg-warning',
                                                        'REJECTED' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    } }}">
                                                    {{ $pr->approved_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $pr->approvedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($pr->approved_at)->format('d M Y, h:i A') ?? '-' }}</small><br>
                                            <br>
                                            @if($pr->approved_remark)
                                                <small class="text-muted d-block">Remark:</small>
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $pr->approved_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- PROCUREMENT --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Procurement</strong>
                                                <span class="badge
                                                    {{ match($pr->pro_status ?? 'N/A') {
                                                        'APPROVED' => 'bg-success',
                                                        'PENDING' => 'bg-warning',
                                                        'REJECTED' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    } }}">
                                                    {{ $pr->pro_status ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $pr->procurementBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($pr->pro_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if($pr->pro_remark)
                                                <div class="mt-2 small fst-italic text-secondary">
                                                    "{{ $pr->pro_remark }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- PR Items --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">PR Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle datatable">
                                        <thead class="table-light">
                                        <tr class="text-center">
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pr->pr_items as $item)
                                            <tr class="text-center">
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->unit ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->remark ?? '-' }}</td>
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
                                                    {{-- Settle DO then comeback here --}}
                                                    @if(!empty($ssr->approved_remark))
                                                        <div class="text-muted small mt-1">
                                                            DO Number: {{ $item->do_no }}
                                                        </div>
                                                    @endif
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
