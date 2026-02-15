@extends('layouts.user_type.auth')

@section('title', 'Close SSA Item')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Close SSA Item</h4>
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
                                                <span class="badge
                                                {{ match($ssa->status ?? 'N/A') {
                                                    'OPEN' => 'bg-success',
                                                    'CLOSE' => 'bg-warning',
                                                    'CANCEL'=> 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                {{ $ssa->status ?? 'N/A' }}
                                            </span>
                                            </div>

                                            <small class="text-muted d-block">Created By: {{ $ssa->user->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Created At: {{ optional($ssa->created_at)->format('d M Y, h:i A') }}</small>
                                        </div>
                                    </div>

                                    {{-- VERIFICATION --}}
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-white h-100">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Verification</strong>
                                                <span class="badge
                                                {{ match($ssa->verified_status ?? 'N/A') {
                                                    'VERIFIED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    default => 'bg-secondary',
                                                } }}">
                                                {{ $ssa->verified_status ?? 'N/A' }}
                                            </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $ssa->verifiedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($ssa->verified_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if($ssa->verified_remark)
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
                                                <span class="badge
                                                {{ match($ssa->approved_status ?? 'N/A') {
                                                    'APPROVED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    'REJECTED' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                {{ $ssa->approved_status ?? 'N/A' }}
                                            </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $ssa->approvedBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($ssa->approved_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if($ssa->approved_remark)
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
                                                <span class="badge
                                                {{ match($ssa->pro_status ?? 'N/A') {
                                                    'APPROVED' => 'bg-success',
                                                    'PENDING' => 'bg-warning',
                                                    'REJECTED' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                {{ $ssa->pro_status ?? 'N/A' }}
                                            </span>
                                            </div>

                                            <small class="text-muted d-block">By: {{ $ssa->proBy->name ?? '-' }}</small>
                                            <small class="text-muted d-block">Date: {{ optional($ssa->pro_at)->format('d M Y, h:i A') ?? '-' }}</small>

                                            @if($ssa->pro_remark)
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
                                @if($ssa->doc_url)
                                    <a href="{{ asset($ssa->doc_url) }}" target="_blank" class="btn btn-info btn-sm">View Attachment</a>
                                @else
                                    <p class="mb-0 text-muted">No attachment available.</p>
                                @endif
                            </div>

                            <form action="{{ route('ssa.request.service', $ssa) }}" method="POST"
                                  enctype="multipart/form-data">
                            @method('PUT')
                            @csrf


                                <!-- SSA Items Section -->
                                <div class="card shadow-sm p-4 mb-4">

                                    <h4 class="mb-4 text-primary">PR Items</h4>

                                    <div class="row g-3 align-items-end">
                                        <div class="card shadow-blur mb-2">
                                            <div class="row mb-2">
                                                <!-- Select SSA Item -->
                                                <div class="col-md-6">
                                                    <label for="pr_no" class="form-label fw-semibold">SSA Items</label>
                                                    <select id="pr_no" class="form-select">
                                                        <option value="">-- Select SSA Item --</option>
                                                        @foreach($ssa->openItem as $item)
                                                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Service Report</label>
                                                    <div id="serviceFileWrapper">
                                                        <input type="file" id="service_report" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-end col-12 mt-2">
                                                <button type="button" id="addPrItem" class="btn btn-primary">Add Item</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered table-striped datatable" id="ssaItemsTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Description</th>
                                                <th>Service Report</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- Submit --}}
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update SSA</button>
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
            let prIndex = 0;
            let prTable;
            let addedItems = new Set(); // Track SSA item IDs already added

            document.addEventListener('DOMContentLoaded', function () {

                prTable = $('#ssaItemsTable').DataTable();

                document.getElementById('addPrItem').addEventListener('click', function () {

                    const prSelect = document.getElementById('pr_no');
                    const ssaItemId = prSelect.value;
                    const ssaItemText = prSelect.options[prSelect.selectedIndex]?.text;

                    const fileInput = document.getElementById('service_report');

                    if (!ssaItemId) {
                        alert('Please select SSA Item');
                        return;
                    }

                    // 🚫 DUPLICATE CHECK (ALERT ONLY)
                    if (addedItems.has(ssaItemId)) {
                        alert('This SSA item has already been added.');
                        return;
                    }

                    if (fileInput.files.length === 0) {
                        alert('Please attach service report');
                        return;
                    }

                    // =========================
                    // MOVE FILE INPUT
                    // =========================
                    fileInput.name = `service_items[${prIndex}][report]`;
                    fileInput.style.display = 'none';
                    document.querySelector('form').appendChild(fileInput);

                    // =========================
                    // HIDDEN SSA ITEM ID
                    // =========================
                    const hiddenId = `
                        <input type="hidden"
                               name="service_items[${prIndex}][ssa_item_id]"
                               value="${ssaItemId}">
                    `;

                    // =========================
                    // ADD ROW
                    // =========================
                    prTable.row.add([
                        `${ssaItemText}${hiddenId}`,
                        fileInput.files[0].name,
                        `<button type="button"
                     class="btn btn-danger btn-sm removePrItem"
                     data-index="${prIndex}"
                     data-item-id="${ssaItemId}">
                        &times;
                     </button>`
                    ]).draw(false);

                    addedItems.add(ssaItemId);
                    prIndex++;

                    // Reset selection
                    prSelect.value = '';

                    // =========================
                    // RESET FILE INPUT
                    // =========================
                    let newFileInput = document.createElement('input');
                    newFileInput.type = 'file';
                    newFileInput.id = 'service_report';
                    newFileInput.className = 'form-control';

                    document.getElementById('serviceFileWrapper').innerHTML = '';
                    document.getElementById('serviceFileWrapper').appendChild(newFileInput);
                });

                // =========================
                // REMOVE ROW
                // =========================
                $('#ssaItemsTable tbody').on('click', '.removePrItem', function () {

                    const index = this.dataset.index;
                    const itemId = this.dataset.itemId;

                    // Remove hidden file input
                    const fileInput = document.querySelector(
                        `input[name="service_items[${index}][report]"]`
                    );
                    if (fileInput) fileInput.remove();

                    // Remove hidden SSA item ID
                    const hiddenId = document.querySelector(
                        `input[name="service_items[${index}][ssa_item_id]"]`
                    );
                    if (hiddenId) hiddenId.remove();

                    addedItems.delete(itemId);

                    prTable.row($(this).parents('tr')).remove().draw();
                });
            });
        </script>

    @endpush
@endsection
