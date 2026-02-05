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
                                            <input type="text" name="ssa_no" id="ssa_no" class="form-control" placeholder="Enter SSA No." required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel" class="form-label">Vessel</label>
                                            <select name="vessel" id="vessel" class="form-select" required>
                                                <option value="" {{ !$selectedVessel ? 'selected' : '' }}>Select Vessel</option>
                                                @foreach($vessels as $code => $name)
                                                    <option value="{{ $code }}" {{ ($selectedVessel == $code) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ssa_date" class="form-label">SSA Date</label>
                                            <input type="date" name="ssa_date" id="ssa_date" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        @php
                                            $departments = [
                                                'ENGINE' => 'Engine',
                                                'DECK' => 'Deck',
                                            ];
                                        @endphp

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach($departments as $key => $name)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="department" id="{{ $key }}" value="{{ $key }}" required>
                                                    <label class="form-check-label" for="{{ $key }}">{{ $name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        @php
                                            $items = [
                                                'DECK STORES' => 'Deck Stores',
                                                'ENGINE STORE' => 'Engine Store',
                                                'SPARE PART' => 'Spare Part',
                                            ];
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Item</label>
                                            @foreach($items as $key => $name)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="item" id="{{ $key }}" value="{{ $key }}" required>
                                                    <label class="form-check-label" for="{{ $key }}">{{ $name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> {{-- End SSA Details --}}

                                {{-- Section 2: Upload Attachment --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Upload Attachment</h6>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png" />
                                    <small class="text-muted">Max file size: 4 MB</small>
                                </div>

                                {{-- Section 3: Item Entry --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Item Entry</h6>

                                    {{-- Entry Card --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-light mb-0">
                                            <h6>Add Items</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-light py-2 small">
                                                <strong>How to add an item:</strong>
                                                <ol class="mb-0 ps-3">
                                                    <li>Fill in all required fields such as <b>Description</b>, <b>Unit</b>, and <b>Qty Required</b>.</li>
                                                    <li>Enter the current <b>Balance On Board</b> and the <b>Qty Approved</b> if available.</li>
                                                    <li>Provide the <b>IMPA Code</b> (if applicable) and any additional notes in <b>Remarks</b>.</li>
                                                    <li>Once everything is complete, click <b>Confirm Item</b> to add it to the list.</li>
                                                </ol>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Description</label>
                                                    <input id="desc" class="form-control">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Unit</label>
                                                    <input id="unit" class="form-control">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Quantity Required</label>
                                                    <input id="qty" type="number" class="form-control">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Balance On Board</label>
                                                    <input id="balance" type="number" class="form-control">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">Quantity Approved</label>
                                                    <input id="approved" type="number" class="form-control">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <label class="form-label">IMPA Code</label>
                                                    <input id="impa" class="form-control">
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <label class="form-label">Remarks</label>
                                                    <textarea id="remarks" class="form-control" rows="2"></textarea>
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
                                    <div class="table-responsive ">
                                        <table class="table table-bordered align-middle datatable" id="itemsTable">
                                            <thead class="table-light">
                                            <tr class="text-center">
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Qty Req</th>
                                                <th>Balance</th>
                                                <th>Approved</th>
                                                <th>IMPA</th>
                                                <th>Remarks</th>
                                                <th width="80">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>


                                {{-- Section 3: Reminder Message --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Reminder Message</h6>
                                    <div class="p-3 border rounded bg-white">
                                        <ol>
                                            <li>
                                                <p class="mb-2">ALL COLUMN SHOULD BE DULY FILLED. OTHERWISE THE REQUISITION WILL BE REJECTED</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">N/A SHOULD BE INDICATED WHERE ITEM(S) IS/ARE NOT APPLICABLE</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">DECK STORES AND ENGINE STORES SHOULD BE REQUESTED UNDER THE SAME REQUISITION. THE STORE FALLS UNDER DIFFERENT CODE INDEX FOR EACH CATEGORY TO BE REQUESTED
                                                SEPARATED I.E. CLOTH & LINEN PRODUCTS, TABLEWARE AND GALLEY UTENSILS & ETC.</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">FOR ITEM WITHOUT IMPA CODE. USER IS ADVISABLE TO INDICATE A CLEAR SPECIFICATION OF ITEM REQUESTED I.E. DIMENSION, LENGTH, MATERIAL, DRAWING/SKETCH/PHOTO AND ETC.</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">FOR SPAREPART, USER IS ADVISABLE TO PROVIDE RELEVANT INFORMATION I.E. EQUIPMENT/MACHINERY'S NAME, MAKER, MODEL, SERIAL NO., DRAWING/SKETCH/PHOTO AND ETC.</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">POINT 4 & 5 TO BE INDICATED UNDER COLUMN "REMARKS"</p>
                                            </li>
                                            <li>
                                                <p class="mb-2">WHEN  THE REQUISITION IS CLOSED, THE DELIVERY ORDER OR SUPPORTING DOCUMENT MUST BE ATTACHED</p>
                                            </li>
                                        </ol>

                                    </div>
                                </div>

                                {{-- Section 4: Buttons --}}
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

                // Get EXISTING DataTable instance (created globally)
                itemsTable = $('#itemsTable').DataTable();

                // Confirm Item
                document.getElementById('confirmItem').addEventListener('click', function () {

                    const item = {
                        desc: document.getElementById('desc').value,
                        unit: document.getElementById('unit').value,
                        qty: document.getElementById('qty').value,
                        balance: document.getElementById('balance').value,
                        approved: document.getElementById('approved').value,
                        impa: document.getElementById('impa').value,
                        remarks: document.getElementById('remarks').value
                    };

                    if (!item.desc) {
                        alert('Description is required');
                        return;
                    }

                    // Add row using DataTables API
                    itemsTable.row.add([
                        `${item.desc}<input type="hidden" name="items[${itemIndex}][description]" value="${item.desc}">`,
                        `${item.unit}<input type="hidden" name="items[${itemIndex}][unit]" value="${item.unit}">`,
                        `${item.qty}<input type="hidden" name="items[${itemIndex}][qty_required]" value="${item.qty}">`,
                        `${item.balance}<input type="hidden" name="items[${itemIndex}][balance]" value="${item.balance}">`,
                        `${item.approved}<input type="hidden" name="items[${itemIndex}][qty_approved]" value="${item.approved}">`,
                        `${item.impa}<input type="hidden" name="items[${itemIndex}][impa]" value="${item.impa}">`,
                        `${item.remarks}<input type="hidden" name="items[${itemIndex}][remarks]" value="${item.remarks}">`,
                        `<button type="button" class="btn btn-danger btn-sm removeRow">&times;</button>`
                    ]).draw(false);

                    itemIndex++;

                    // Clear inputs
                    desc.value = '';
                    unit.value = '';
                    qty.value = '';
                    balance.value = '';
                    approved.value = '';
                    impa.value = '';
                    remarks.value = '';
                });

                // Remove row (DataTables safe)
                $('#itemsTable tbody').on('click', '.removeRow', function () {
                    itemsTable.row($(this).parents('tr')).remove().draw();
                });

            });
        </script>
    @endpush


@endsection
