@extends('layouts.user_type.auth')

@section('title', 'SSA Form')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">SSA Form</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <form action="{{ route('ssa.request.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Section 1: SSA Details --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Details</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="ssa_no" class="form-label">SSA No.</label>
                                            <input type="text" name="ssa_no" id="ssa_no" class="form-control"
                                                placeholder="Enter SSA No." required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" name="location" id="location" class="form-control"
                                                placeholder="Enter Location" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel" class="form-label">Vessel</label>
                                            <select name="vessel" id="vessel" class="form-select" required>
                                                <option value="" {{ !$selectedVessel ? 'selected' : '' }}>Select
                                                    Vessel</option>
                                                @foreach ($vessels as $code => $name)
                                                    <option value="{{ $code }}"
                                                        {{ $selectedVessel == $code ? 'selected' : '' }}>
                                                        {{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ssa_date" class="form-label">SSA Date</label>
                                            <input type="date" name="ssa_date" id="ssa_date" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Department and SSA Raised --}}
                                    <div class="row mb-3">
                                        @php
                                            $departments = [
                                                'ENGINE' => 'Engine',
                                                'DECK' => 'Deck',
                                            ];
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach ($departments as $key => $name)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="department"
                                                        id="{{ $key }}" value="{{ $key }}" required>
                                                    <label class="form-check-label"
                                                        for="{{ $key }}">{{ $name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">SSA Raised By</label>
                                            @php
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
                                            @foreach ($ssaRaisedOptions as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ssa_raised"
                                                        id="{{ Str::slug($option) }}" value="{{ $option }}" required>
                                                    <label class="form-check-label" for="{{ Str::slug($option) }}">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> {{-- End SSA Details --}}

                                {{-- Section 2: Upload Document --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Upload Document</h6>
                                    <input type="file" name="attachment" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png" />
                                    <small class="text-muted">Max file size: 4 MB</small>
                                </div>

                                {{-- Section 3: SSA Items --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Items</h6>

                                    {{-- Entry Card --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-light mb-0">
                                            <h6>Add Items</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Description</label>
                                                    <input id="desc" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Model No.</label>
                                                    <input id="model_no" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Remedial</label>
                                                    <input id="remedial" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Assistance</label>
                                                    <input id="assistance" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Remark</label>
                                                    <input id="remark" class="form-control">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label class="form-label">Document URL</label>
                                                    <input id="item_doc" type="file" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                </div>
                                            </div>

                                            <div class="text-end mt-3">
                                                <button type="button" id="confirmItem" class="btn btn-success btn-sm">
                                                    Confirm Item
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Confirmed Items Table --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle datatable" id="itemsTable">
                                            <thead class="table-light">
                                                <tr class="text-center">
                                                    <th>Description</th>
                                                    <th>Model No.</th>
                                                    <th>Remedial</th>
                                                    <th>Assistance</th>
                                                    <th>Remark</th>
                                                    <th>Document</th>
                                                    <th width="80">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Section 4: Reminder Message --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Reminder Message</h6>
                                    <div class="p-3 border rounded bg-white">
                                        <ol>
                                            <li>ALL COLUMNS SHOULD BE DULY FILLED. OTHERWISE THE SSA WILL BE REJECTED.</li>
                                            <li>INDICATE N/A WHERE ITEM(S) IS/ARE NOT APPLICABLE.</li>
                                            <li>ENGINE AND DECK ITEMS SHOULD BE REQUESTED UNDER THE SAME REQUISITION.</li>
                                            <li>FOR ITEMS WITHOUT MODEL NO., PROVIDE CLEAR SPECIFICATIONS.</li>
                                            <li>RELEVANT INFO SUCH AS SERIAL NO., DRAWINGS, OR PHOTOS SHOULD BE INDICATED IN
                                                REMARKS.</li>
                                            <li>WHEN SSA IS CLOSED, SUPPORTING DOCUMENTS MUST BE ATTACHED.</li>
                                        </ol>
                                    </div>
                                </div>

                                {{-- Section 5: Submit Button --}}
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            let itemIndex = 0;
            let itemsTable;

            document.addEventListener('DOMContentLoaded', function() {
                itemsTable = $('#itemsTable').DataTable();

                document.getElementById('confirmItem').addEventListener('click', function() {
                    const item = {
                        desc: document.getElementById('desc').value,
                        model_no: document.getElementById('model_no').value,
                        remedial: document.getElementById('remedial').value,
                        assistance: document.getElementById('assistance').value,
                        remark: document.getElementById('remark').value,
                    };

                    if (!item.desc) {
                        alert('Description is required');
                        return;
                    }

                    itemsTable.row.add([
                        `${item.desc}<input type="hidden" name="items[${itemIndex}][description]" value="${item.desc}">`,
                        `${item.model_no}<input type="hidden" name="items[${itemIndex}][model_no]" value="${item.model_no}">`,
                        `${item.remedial}<input type="hidden" name="items[${itemIndex}][remedial]" value="${item.remedial}">`,
                        `${item.assistance}<input type="hidden" name="items[${itemIndex}][assistance]" value="${item.assistance}">`,
                        `${item.remark}<input type="hidden" name="items[${itemIndex}][remark]" value="${item.remark}">`,
                        `<input type="hidden" name="items[${itemIndex}][doc_url]" value="">`,
                        `<button type="button" class="btn btn-danger btn-sm removeRow">&times;</button>`
                    ]).draw(false);

                    itemIndex++;

                    // Clear inputs
                    document.getElementById('desc').value = '';
                    document.getElementById('model_no').value = '';
                    document.getElementById('remedial').value = '';
                    document.getElementById('assistance').value = '';
                    document.getElementById('remark').value = '';
                });

                $('#itemsTable tbody').on('click', '.removeRow', function() {
                    itemsTable.row($(this).parents('tr')).remove().draw();
                });
            });
        </script>
    @endpush
@endsection
