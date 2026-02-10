@extends('layouts.user_type.auth')

@section('title', 'Edit SSA')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Edit SSA</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <form action="{{ route('ssa.request.update', $ssa) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div id="hiddenInputs"></div>

                                {{-- Section 1: SSA Details --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Details</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="ssa_no" class="form-label">SSA No.</label>
                                            <input type="text" name="ssa_no" id="ssa_no" class="form-control"
                                                value="{{ old('ssa_no', $ssa->ssa_no) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" name="location" id="location" class="form-control"
                                                value="{{ old('location', $ssa->location) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel" class="form-label">Vessel</label>
                                            <select name="vessel" id="vessel" class="form-select" required>
                                                @foreach ($vessels as $code => $name)
                                                    <option value="{{ $code }}"
                                                        {{ $ssa->vessel == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ssa_date" class="form-label">SSA Date</label>
                                            <input type="date" name="ssa_date" id="ssa_date" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($ssa->date)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    {{-- Department and SSA Raised --}}
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
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach ($departments as $k => $v)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="department"
                                                        value="{{ $k }}"
                                                        {{ $ssa->department == $k ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">SSA Raised By</label>
                                            @foreach ($ssaRaisedOptions as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ssa_raised"
                                                        value="{{ $option }}"
                                                        {{ $ssa->ssa_raised == $option ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 2: Upload Document --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Upload Document</h6>
                                    <input type="file" name="attachment" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png" />
                                    @if ($ssa->doc_url)
                                        <div class="mt-2">
                                            <a href="{{ asset($ssa->doc_url) }}" target="_blank"
                                                class="btn btn-info btn-sm">Current Attachment</a>
                                        </div>
                                    @else
                                        <div class="mt-2 text-muted">No current attachment available.</div>
                                    @endif
                                </div>

                                {{-- Section 3: SSA Items --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSA Items</h6>

                                    {{-- Entry Card --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-light">Add Items</div>
                                        <div class="card-body">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">AA: Brief Description</label>
                                                    <input id="aa" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">BB: Maker/Model No.</label>
                                                    <input id="bb" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">CC: Remedial</label>
                                                    <input id="cc" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">DD: Assistance</label>
                                                    <input id="dd" class="form-control">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Remark</label>
                                                    <input id="remark" class="form-control">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label class="form-label">EE: Miscellaneous
                                                        (Photo/Sketch/Drawing)</label>
                                                    <input id="ee" type="file" class="form-control"
                                                        accept=".pdf,.jpg,.jpeg,.png,.gif">
                                                </div>
                                            </div>

                                            <div class="text-end mt-3">
                                                <button type="button" id="confirmItem"
                                                    class="btn btn-success btn-sm">Confirm Item</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Confirmed Items Table --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle datatable" id="itemsTable">
                                            <thead class="table-light text-center">
                                                <tr>
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

                                {{-- Submit --}}
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary" id="submitBtn">Update SSA</button>
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
            let itemIndex = {{ $ssa_items->count() ?? 0 }};
            let table = $('#itemsTable').DataTable();
            let hiddenContainer = $('#hiddenInputs');
            let fileStorage = {}; // Store files here!
            let deletedItemIds = []; // Track deleted items

            // Load existing items
            @foreach ($ssa_items as $i)
                table.row.add([
                    "{{ $i->description }}",
                    "{{ $i->model_no ?? '' }}",
                    "{{ $i->remedial ?? '' }}",
                    "{{ $i->assistance ?? '' }}",
                    "{{ $i->remark ?? '' }}",
                    "{{ $i->doc_url ? basename($i->doc_url) : '' }}",
                    `<button type="button" class="btn btn-danger btn-sm removeRow" data-existing="true" data-id="{{ $i->id }}">X</button>`
                ]).draw(false);
            @endforeach

            // Add new item
            $('#confirmItem').click(function() {
                let aa = $('#aa').val();
                if (!aa) return alert('AA is required');
                let bb = $('#bb').val();
                let cc = $('#cc').val();
                let dd = $('#dd').val();
                let remark = $('#remark').val();

                let fileObj = $('#ee')[0].files[0];
                let fileName = fileObj ? fileObj.name : 'No file';

                fileStorage[itemIndex] = fileObj;

                table.row.add([
                    aa + `<input type="hidden" name="items[${itemIndex}][aa]" value="${aa}">`,
                    bb + `<input type="hidden" name="items[${itemIndex}][bb]" value="${bb}">`,
                    cc + `<input type="hidden" name="items[${itemIndex}][cc]" value="${cc}">`,
                    dd + `<input type="hidden" name="items[${itemIndex}][dd]" value="${dd}">`,
                    remark + `<input type="hidden" name="items[${itemIndex}][remark]" value="${remark}">`,
                    fileName,
                    `<button type="button" class="btn btn-danger btn-sm removeRow" data-index="${itemIndex}">X</button>`
                ]).draw(false);

                itemIndex++;
                $('#aa,#bb,#cc,#dd,#remark,#ee').val('');
            });

            // Remove row
            $('#itemsTable tbody').on('click', '.removeRow', function() {
                let isExisting = $(this).data('existing');
                let itemId = $(this).data('id');

                if (isExisting) {
                    // For existing items, track for deletion
                    deletedItemIds.push(itemId);
                    let row = table.row($(this).parents('tr'));
                    row.remove().draw();
                } else {
                    // For new items, remove hidden inputs and file
                    let index = $(this).data('index');
                    let row = table.row($(this).parents('tr'));
                    row.remove().draw();
                    hiddenContainer.find(`input[name^="items[${index}]"]`).remove();
                    delete fileStorage[index];
                }
            });

            // SUBMIT FORM WITH FILES
            $('#submitBtn').click(function() {
                let formData = new FormData($('form')[0]);

                // ADD THE FILES TO FormData
                Object.keys(fileStorage).forEach(function(index) {
                    if (fileStorage[index]) {
                        formData.append('items[' + index + '][ee]', fileStorage[index]);
                    }
                });

                // ADD DELETED ITEM IDS
                if (deletedItemIds.length > 0) {
                    deletedItemIds.forEach(function(id) {
                        formData.append('delete_items[]', id);
                    });
                }

                // SUBMIT
                $.ajax({
                    url: $('form').attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = '{{ route('ssa.request.index') }}';
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        </script>
    @endpush
@endsection
