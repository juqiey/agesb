@extends('layouts.user_type.auth')

@section('title', 'SSR Details')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">SSR Details</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">

                            {{-- Basic Information --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">SSR No:</strong>
                                            <span>{{ $ssr->ssr_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Location:</strong>
                                            <span>{{ $ssr->location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Vessel:</strong>
                                            <span>{{ $vessels[$ssr->vessel] ?? $ssr->vessel }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">SSR Date:</strong>
                                            <span>{{ \Carbon\Carbon::parse($ssr->ssr_date)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Department:</strong>
                                            <span>{{ $ssr->department }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Item:</strong>
                                            <span>{{ $ssr->item }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status Section --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Status</h6>

                                <div class="row g-3">
                                    {{-- SSR Status --}}
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <strong class="me-2">SSR Status:</strong>
                                            <span class="badge
                                                {{ match($ssr->status ?? 'N/A') {
                                                    'OPEN' => 'bg-success text-white',
                                                    'CLOSE' => 'bg-warning text-white',
                                                    'CANCEL'=> 'bg-danger text-white',
                                                    default => 'bg-secondary text-white',
                                                } }}">
                                                {{ $ssr->status ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Other statuses with remarks --}}
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2">Verification Status:</strong>
                                                <span class="badge
                                                    {{ match($ssr->verified_status ?? 'N/A') {
                                                        'PENDING' => 'bg-warning text-white',
                                                        'VERIFIED' => 'bg-success text-white',
                                                        default => 'bg-secondary text-white',
                                                    } }}">
                                                    {{ $ssr->verified_status ?? 'N/A' }}
                                                </span>
                                            </div>
                                            @if($ssr->verified_remark)
                                                <small class="text-muted ms-2">Remark: {{ $ssr->verified_remark }}</small>
                                            @endif
                                        </div>

                                        <div class="d-flex flex-column mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2">Approval Status:</strong>
                                                <span class="badge
                                                    {{ match($ssr->approved_status ?? 'N/A') {
                                                        'APPROVED' => 'bg-success text-white',
                                                        'PENDING' => 'bg-warning text-white',
                                                        'REJECTED' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white',
                                                    } }}">
                                                    {{ $ssr->approved_status ?? 'N/A' }}
                                                </span>
                                            </div>
                                            @if($ssr->approved_remark)
                                                <small class="text-muted ms-2">Remark: {{ $ssr->approval_remark }}</small>
                                            @endif
                                        </div>

                                        <div class="d-flex flex-column mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="me-2">Procurement Approval Status:</strong>
                                                <span class="badge
                                                    {{ match($ssr->pro_status ?? 'N/A') {
                                                        'APPROVED' => 'bg-success text-white',
                                                        'PENDING' => 'bg-warning text-white',
                                                        'REJECTED' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white',
                                                    } }}">
                                                    {{ $ssr->pro_status ?? 'N/A' }}
                                                </span>
                                            </div>
                                            @if($ssr->pro_remark)
                                                <small class="text-muted ms-2">Remark: {{ $ssr->approval_remark }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Attachment --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Attachment</h6>
                                @if($ssr->doc_url)
                                    <a href="{{ asset($ssr->doc_url) }}" target="_blank" class="btn btn-info btn-sm">View Attachment</a>
                                @else
                                    <p class="mb-0 text-muted">No attachment available.</p>
                                @endif
                            </div>

                            {{-- SSR Items --}}
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">SSR Items</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle datatable">
                                            <thead class="table-light">
                                            <tr class="text-center">
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Quantity Required</th>
                                                <th>Balance</th>
                                                <th>Quantity Approved</th>
                                                <th>IMPA</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ssr_items as $item)
                                                <tr class="text-center">
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->unit ?? '-' }}</td>
                                                    <td>{{ $item->quantity_req ?? '-' }}</td>
                                                    <td>{{ $item->balance ?? '-' }}</td>
                                                    <td>{{ $item->quantity_app ?? '-' }}</td>
                                                    <td>{{ $item->impa_code ?? '-' }}</td>
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
