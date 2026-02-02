@extends('layouts.user_type.auth')

@section('title', 'Purchase Request Form')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">Purchase Request Form</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <form action="{{ route('pr.request.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                                {{-- Requester Details --}}
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-3">Requisitioner</h6>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Requested By</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date</label>
                                            <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row g-3">
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
                                    <div class="row g-3">
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <textarea class="form-control" name="title" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Category Section --}}
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-3">Category</h6>

                                    <div class="row g-3">

                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input category-radio" type="radio" name="category" value="Material" required>
                                                <label class="form-check-label">Material</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input category-radio" type="radio" name="category" value="Services">
                                                <label class="form-check-label">Services</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input category-radio" type="radio" name="category" value="Assets">
                                                <label class="form-check-label">Assets</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input category-radio" type="radio" name="category" value="Others">
                                                <label class="form-check-label">Others</label>
                                            </div>

                                            <!-- Others Input -->
                                            <div class="mt-2" id="otherCategoryWrapper" style="display:none;">
                                                <input type="text" class="form-control" name="category_others"
                                                       placeholder="Specify other category">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- 3. Summary of Purchase Request --}}
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-3">Summary of Purchase Request</h6>
                                    {{-- Entry Card --}}
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-light mb-0">
                                            <h6>Add Items</h6>

                                            <div class="row g-2">
                                                <div class="col-md-12">
                                                    <label class="form-label">Description</label>
                                                    <input id="desc" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Unit</label>
                                                    <input id="unit" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Quantity</label>
                                                    <input id="qty" type="number" class="form-control">
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
                                                <th>Quantity</th>
                                                <th>Remarks</th>
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
            document.querySelectorAll('.category-radio').forEach(radio => {
                radio.addEventListener('change', function () {

                    const otherWrapper = document.getElementById('otherCategoryWrapper');

                    if (this.value === 'Others') {
                        otherWrapper.style.display = 'block';
                    } else {
                        otherWrapper.style.display = 'none';
                        otherWrapper.querySelector('input').value = '';
                    }

                });
            });

            let itemIndex = 0;
            let itemsTable;

            // Get EXISTING DataTable instance (created globally)
            itemsTable = $('#itemsTable').DataTable();

            // Confirm Item
            document.getElementById('confirmItem').addEventListener('click', function () {

                const item = {
                    desc: document.getElementById('desc').value,
                    unit: document.getElementById('unit').value,
                    qty: document.getElementById('qty').value,
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
                    `${item.qty}<input type="hidden" name="items[${itemIndex}][qty]" value="${item.qty}">`,
                    `${item.remarks}<input type="hidden" name="items[${itemIndex}][remarks]" value="${item.remarks}">`,
                    `<button type="button" class="btn btn-danger btn-sm removeRow">&times;</button>`
                ]).draw(false);

                itemIndex++;

                // Clear inputs
                desc.value = '';
                unit.value = '';
                qty.value = '';
                remarks.value = '';
            });

            // Remove row (DataTables safe)
            $('#itemsTable tbody').on('click', '.removeRow', function () {
                itemsTable.row($(this).parents('tr')).remove().draw();
            });
        </script>
    @endpush
@endsection
