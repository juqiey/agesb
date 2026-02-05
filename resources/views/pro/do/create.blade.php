@extends('layouts.user_type.auth')

@section('title', 'Delivery Order Form')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">SSR Form</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <form method="POST" action="{{ route('pro.do.store') }}">
                                @csrf

                                <div class="card shadow-sm p-4 mb-4">
                                    <h4 class="mb-4 text-primary">Delivery Order Details</h4>

                                    <div class="row mb-2">
                                        <!-- Created By -->
                                        <div class="col-md-6">
                                            <label for="created_by" class="form-label fw-semibold">Created By</label>
                                            <input type="text" id="created_by" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                        </div>

                                        <!-- Position -->
                                        <div class="col-md-6">
                                            <label for="position" class="form-label fw-semibold">Position</label>
                                            <input type="text" id="position" class="form-control" value="{{ auth()->user()->position ?? '-' }}" disabled>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-4">
                                        <!-- DO Number -->
                                        <div class="col-md-6">
                                            <label for="do_no" class="form-label fw-semibold">DO Number</label>
                                            <input type="text" name="do_no" id="do_no" class="form-control" placeholder="Enter Delivery Order Number" required>
                                        </div>

                                        <!-- Delivery Date -->
                                        <div class="col-md-6">
                                            <label for="do_date" class="form-label fw-semibold">Delivery Date</label>
                                            <input type="date" name="do_date" id="do_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <!-- Job Number -->
                                        <div class="col-md-6">
                                            <label for="job_no" class="form-label fw-semibold">Job Number</label>
                                            <input type="text" name="job_no" id="job_no" class="form-control" placeholder="Enter Job Number" required>
                                        </div>

                                        <!-- Vessel -->
                                        <div class="col-md-6 mb-3">
                                            <label for="vessel" class="form-label">Vessel</label>
                                            <select name="vessel" id="vessel" class="form-select" required>
                                                <option value="" {{ !$selectedVessel ? 'selected' : '' }}>Select Vessel</option>
                                                @foreach($vessels as $code => $name)
                                                    <option value="{{ $code }}" {{ ($selectedVessel == $code) ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-3">
                                            <label for="do_recipient" class="form-label">DO Recepient</label>
                                            <textarea class="form-control" rows="2" name="do_recipient" required>

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-3">
                                            <label for="location" class="form-label">Location</label>
                                            <textarea class="form-control" rows="2" name="location" required>

                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- PR Items Section -->
                                <div class="card shadow-sm p-4 mb-4">
                                    <h4 class="mb-4 text-primary">PR Items</h4>

                                    <div class="row g-3 align-items-end">
                                        <div class="card shadow-blur mb-2">
                                            <div class="row mb-2">
                                                <!-- Select PR Number -->
                                                <div class="col-md-6">
                                                    <label for="pr_no" class="form-label fw-semibold">PR Number</label>
                                                    <select id="pr_no" class="form-select">
                                                        <option value="">-- Select PR Number --</option>
                                                        @foreach($prs as $pr)
                                                            <option value="{{ $pr->id }}">{{ $pr->pr_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Select Item -->
                                                <div class="col-md-6">
                                                    <label for="pr_item" class="form-label fw-semibold">Item</label>
                                                    <select id="pr_item" class="form-select">
                                                        <option value="">-- Select Item --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <label for="pr_quantity" class="form-label fw-semibold">Quantity</label>
                                                    <input type="number" id="pr_quantity" class="form-control" min="1" placeholder="Quantity">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="pr_unit" class="form-label fw-semibold">Unit Price (RM)</label>
                                                    <input type="number" id="pr_unit" class="form-control" min="0" placeholder="Unit Price">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="pr_total" class="form-label fw-semibold">Total Price (RM)</label>
                                                    <input type="number" id="pr_total" class="form-control" disabled placeholder="Total">
                                                </div>
                                            </div>

                                            <div class="text-end col-12 mt-2">
                                                <button type="button" id="addPrItem" class="btn btn-primary">Add Item</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered table-striped datatable" id="prItemsTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>PR No</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- SSR Items Section -->
                                <div class="card shadow-sm p-4 mb-4">
                                    <h4 class="mb-4 text-primary">SSR Items</h4>

                                    <div class="row g-3 align-items-end">
                                        <div class="card shadow-blur mb-2">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label for="ssr_no" class="form-label fw-semibold">SSR Number</label>
                                                    <select id="ssr_no" class="form-select">
                                                        <option value="">-- Select SSR Number --</option>
                                                        @foreach($ssrs as $ssr)
                                                            <option value="{{ $ssr->id }}">{{ $ssr->ssr_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="ssr_item" class="form-label fw-semibold">Item</label>
                                                    <select id="ssr_item" class="form-select">
                                                        <option value="">-- Select Item --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <label for="ssr_quantity" class="form-label fw-semibold">Quantity</label>
                                                    <input type="number" id="ssr_quantity" class="form-control" min="1" placeholder="Quantity">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="ssr_unit" class="form-label fw-semibold">Unit Price (RM)</label>
                                                    <input type="number" id="ssr_unit" class="form-control" min="0" placeholder="Unit Price">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="ssr_total" class="form-label fw-semibold">Total Price (RM)</label>
                                                    <input type="number" id="ssr_total" class="form-control" disabled placeholder="Total">
                                                </div>
                                            </div>

                                            <div class="text-end col-12 mt-2">
                                                <button type="button" id="addSsrItem" class="btn btn-primary">Add Item</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered table-striped datatable" id="ssrItemsTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>SSR No</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
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
            const sections = {
                pr: {
                    selectNo: 'pr_no',
                    selectItem: 'pr_item',
                    quantity: 'pr_quantity',
                    unit: 'pr_unit',
                    total: 'pr_total',
                    addBtn: 'addPrItem',
                    table: 'prItemsTable',
                    route: 'pr'
                },
                ssr: {
                    selectNo: 'ssr_no',
                    selectItem: 'ssr_item',
                    quantity: 'ssr_quantity',
                    unit: 'ssr_unit',
                    total: 'ssr_total',
                    addBtn: 'addSsrItem',
                    table: 'ssrItemsTable',
                    route: 'ssr'
                }
            };

            const itemArrays = { pr: [], ssr: [] };

            // Generic total calculation
            function calcTotal(section) {
                const qty = parseFloat(document.getElementById(sections[section].quantity).value) || 0;
                const price = parseFloat(document.getElementById(sections[section].unit).value) || 0;
                document.getElementById(sections[section].total).value = (qty * price).toFixed(2);
            }

            // Attach input events
            Object.keys(sections).forEach(section => {
                document.getElementById(sections[section].quantity).addEventListener('input', () => calcTotal(section));
                document.getElementById(sections[section].unit).addEventListener('input', () => calcTotal(section));

                // Fetch items dynamically on PR/SSR number change
                document.getElementById(sections[section].selectNo).addEventListener('change', function() {
                    fetch(`/pro/do/${sections[section].route}_items/${this.value}`)
                        .then(res => res.json())
                        .then(items => {
                            const select = document.getElementById(sections[section].selectItem);
                            select.innerHTML = '<option value="">-- Select Item --</option>';
                            items.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.text = item.description;
                                select.appendChild(option);
                            });
                        });
                });

                // Add item button
                document.getElementById(sections[section].addBtn).addEventListener('click', () => {
                    const selNo = document.getElementById(sections[section].selectNo);
                    const selItem = document.getElementById(sections[section].selectItem);
                    const qty = document.getElementById(sections[section].quantity).value;
                    const unit = document.getElementById(sections[section].unit).value;
                    const total = document.getElementById(sections[section].total).value;

                    if (!selNo.value || !selItem.value || !qty || !unit) return;

                    if (itemArrays[section].includes(selItem.value)) {
                        alert('Item already added!');
                        return;
                    }

                    itemArrays[section].push(selItem.value);

                    const table = $(`#${sections[section].table}`).DataTable();
                    table.row.add([
                        selNo.options[selNo.selectedIndex].text,
                        selItem.options[selItem.selectedIndex].text,
                        qty,
                        parseFloat(unit).toFixed(2),
                        parseFloat(total).toFixed(2),
                        `<button class="btn btn-sm btn-danger remove-btn" data-section="${section}" data-id="${selItem.value}">Remove</button>
                         <input type="hidden" name="${section}_items[${selItem.value}][no_id]" value="${selNo.value}">
                         <input type="hidden" name="${section}_items[${selItem.value}][item_id]" value="${selItem.value}">
                         <input type="hidden" name="${section}_items[${selItem.value}][qty]" value="${qty}">
                         <input type="hidden" name="${section}_items[${selItem.value}][unit_price]" value="${unit}">`
                    ]).draw();

                    selItem.value = '';
                    document.getElementById(sections[section].quantity).value = '';
                    document.getElementById(sections[section].unit).value = '';
                    document.getElementById(sections[section].total).value = '';
                });
            });

            // Generic remove handler
            $('#prItemsTable tbody, #ssrItemsTable tbody').on('click', '.remove-btn', function() {
                const section = $(this).data('section');
                const id = $(this).data('id');
                itemArrays[section] = itemArrays[section].filter(x => x != id);
                $(this).closest('table').DataTable().row($(this).parents('tr')).remove().draw();
            });
        </script>
    @endpush
@endsection
