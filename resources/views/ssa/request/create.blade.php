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
                                                value="{{ date('Y-m-d') }}" required>
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
                                                        id="{{ Str::slug($option) }}" value="{{ $option }}"
                                                        required>
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
                                            {{-- Line 1: AA and BB --}}
                                            <div class="row g-2 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">AA: Brief Description on the SSA
                                                        Required</label>
                                                    <input id="aa" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">BB: Maker/Model No./Serial No.</label>
                                                    <input id="bb" class="form-control">
                                                </div>
                                            </div>

                                            {{-- Line 2: CC and DD --}}
                                            <div class="row g-2 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">CC: Remedial Action Carried Out on
                                                        Board</label>
                                                    <input id="cc" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">DD: Nature of Assistance Required</label>
                                                    <input id="dd" class="form-control">
                                                </div>
                                            </div>

                                            {{-- Line 3: EE File Upload --}}
                                            <div class="row g-2 mb-3">
                                                <div class="col-12" id="fileWrapper">
                                                    <label class="form-label">EE: Miscellaneous (Photo/Sketch/Drawing,
                                                        etc)</label>
                                                    <input id="ee" type="file" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                    <small class="text-muted">Max file size: 4 MB</small>
                                                </div>
                                            </div>

                                            {{-- Line 4: Remark --}}
                                            <div class="row g-2 mb-3">
                                                <div class="col-12">
                                                    <label class="form-label">Remark</label>
                                                    <input id="remark" class="form-control">
                                                </div>
                                            </div>

                                            <div class="text-end">
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
                                                    <th>AA: Description</th>
                                                    <th>BB: Maker/Model No.</th>
                                                    <th>CC: Remedial</th>
                                                    <th>DD: Assistance</th>
                                                    <th>Remark</th>
                                                    <th>EE: Document</th>
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

            document.addEventListener('DOMContentLoaded', function () {

                itemsTable = $('#itemsTable').DataTable();

                document.getElementById('confirmItem').addEventListener('click', function () {

                    const aa = document.getElementById('aa').value.trim();
                    const bb = document.getElementById('bb').value.trim();
                    const cc = document.getElementById('cc').value.trim();
                    const dd = document.getElementById('dd').value.trim();
                    const remark = document.getElementById('remark').value.trim();
                    const fileInput = document.getElementById('ee');

                    if (!aa) {
                        alert('AA: Description is required');
                        return;
                    }

                    // =========================
                    // HANDLE FILE (MOVE INPUT)
                    // =========================
                    let fileName = '';

                    if (fileInput.files.length > 0) {
                        fileName = fileInput.files[0].name;

                        fileInput.name = `items[${itemIndex}][ee]`;
                        fileInput.style.display = 'none';
                        document.querySelector('form').appendChild(fileInput);
                    }

                    // =========================
                    // ADD ROW TO TABLE
                    // =========================
                    itemsTable.row.add([
                        `${aa}<input type="hidden" name="items[${itemIndex}][aa]" value="${aa}">`,
                        `${bb}<input type="hidden" name="items[${itemIndex}][bb]" value="${bb}">`,
                        `${cc}<input type="hidden" name="items[${itemIndex}][cc]" value="${cc}">`,
                        `${dd}<input type="hidden" name="items[${itemIndex}][dd]" value="${dd}">`,
                        `${remark}<input type="hidden" name="items[${itemIndex}][remark]" value="${remark}">`,
                        fileName || '-',
                        `<button type="button" class="btn btn-danger btn-sm removeRow" data-index="${itemIndex}">&times;</button>`
                    ]).draw(false);

                    itemIndex++;

                    // =========================
                    // RESET INPUTS
                    // =========================
                    document.getElementById('aa').value = '';
                    document.getElementById('bb').value = '';
                    document.getElementById('cc').value = '';
                    document.getElementById('dd').value = '';
                    document.getElementById('remark').value = '';

                    // Create a NEW file input for next item
                    let newFileInput = document.createElement('input');
                    newFileInput.type = 'file';
                    newFileInput.id = 'ee';
                    newFileInput.className = 'form-control';

                    document.getElementById('fileWrapper').innerHTML = '';
                    document.getElementById('fileWrapper').appendChild(newFileInput);
                });

                // =========================
                // REMOVE ROW + FILE INPUT
                // =========================
                $('#itemsTable tbody').on('click', '.removeRow', function () {

                    const index = $(this).data('index');

                    // Remove hidden file input if exists
                    const fileInput = document.querySelector(`input[name="items[${index}][ee]"]`);
                    if (fileInput) {
                        fileInput.remove();
                    }

                    itemsTable.row($(this).parents('tr')).remove().draw();
                });
            });
        </script>
    @endpush
@endsection
