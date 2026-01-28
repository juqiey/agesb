@extends('layouts.user_type.auth')

@section('title', 'Edit SSR')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Edit SSR</h4>
                        </div>

                        <div class="card-body px-4 pt-4 pb-4">

                            <form action="{{ route('ssr.request.update', $ssr) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div id="hiddenInputs"></div>
                                {{-- SSR Details --}}
                                <div class="mb-4 p-3 border rounded bg-light">\
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span class="alert-icon"><i class="ni ni-fat-remove"></i></span>
                                            <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">SSR Details</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSR No.</label>
                                            <input name="ssr_no" class="form-control" value="{{ old('ssr_no',$ssr->ssr_no) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Location</label>
                                            <input name="location" class="form-control" value="{{ old('location',$ssr->location) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Vessel</label>
                                            <select name="vessel" class="form-select" required>
                                                @foreach($vessels as $code=>$name)
                                                    <option value="{{ $code }}" {{ $ssr->vessel==$code?'selected':'' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SSR Date</label>
                                            <input type="date" name="ssr_date" class="form-control" value="{{ \Carbon\Carbon::parse($ssr->ssr_date)->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    @php
                                        $departments=['ENGINE'=>'Engine','DECK'=>'Deck'];
                                        $items=['DECK STORES'=>'Deck Stores','ENGINE STORE'=>'Engine Store','SPARE PART'=>'Spare Part'];
                                    @endphp

                                    <div class="row mb-0">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Department</label>
                                            @foreach($departments as $k=>$v)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="department" value="{{ $k }}" {{ $ssr->department==$k?'checked':'' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Item</label>
                                            @foreach($items as $k=>$v)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="item" value="{{ $k }}" {{ $ssr->item==$k?'checked':'' }}>
                                                    <label class="form-check-label">{{ $v }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Attachment --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Upload Attachment</h6>
                                    <input type="file" name="attachment" class="form-control">

                                    @if($ssr->doc_url)
                                        <div class="mt-2 align-items-center">
                                            <a href="{{ asset($ssr->doc_url) }}" target="_blank" class="btn btn-info">Current Attachment</a>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <span class="text-muted">No current attachment available.</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Item Entry --}}
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Item Entry</h6>
                                        <div class="card-body">
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

                                                            <div class="col-md-3">
                                                                <label class="form-label">Unit</label>
                                                                <input id="unit" class="form-control">
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label class="form-label">Qty Required</label>
                                                                <input id="qty" type="number" class="form-control">
                                                            </div>

                                                            <div class="col-md-4 mt-2">
                                                                <label class="form-label">Balance On Board</label>
                                                                <input id="balance" type="number" class="form-control">
                                                            </div>

                                                            <div class="col-md-4 mt-2">
                                                                <label class="form-label">Qty Approved</label>
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
                                            {{-- Entry Card --}}
                                            <div class="card shadow-sm mb-3">
                                                <div class="card-body">
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

                                            </div>
                                        </div>
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-primary">Submit</button>
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
            let itemIndex = {{ $ssr_items->count() ?? 0 }};
            let table = $('#itemsTable').DataTable();
            let hiddenContainer = $('#hiddenInputs');

            // Load existing items
            @foreach($ssr_items as $i)
            table.row.add([
                "{{ $i->description }}",
                "{{ $i->unit ?? '' }}",
                "{{ $i->quantity_req ?? '' }}",
                "{{ $i->balance ?? '' }}",
                "{{ $i->quantity_app ?? '' }}",
                "{{ $i->impa_code ?? '' }}",
                "{{ $i->remark ?? '' }}",
                `<button type="button" class="btn btn-danger btn-sm removeRow">X</button>`
            ]).draw(false);

            hiddenContainer.append(`
                <input type="hidden" name="items[${itemIndex}][description]" value="{{ $i->description }}">
                <input type="hidden" name="items[${itemIndex}][unit]" value="{{ $i->unit ?? '' }}">
                <input type="hidden" name="items[${itemIndex}][qty_required]" value="{{ $i->quantity_req ?? '' }}">
                <input type="hidden" name="items[${itemIndex}][balance]" value="{{ $i->balance ?? '' }}">
                <input type="hidden" name="items[${itemIndex}][qty_approved]" value="{{ $i->quantity_app ?? '' }}">
                <input type="hidden" name="items[${itemIndex}][impa]" value="{{ $i->impa_code ?? '' }}">
                <input type="hidden" name="items[${itemIndex}][remarks]" value="{{ $i->remark ?? '' }}">
            `);
            itemIndex++;
            @endforeach

            // Add new item
            $('#confirmItem').click(function(){
                let descVal = $('#desc').val();
                if(!descVal) return alert('Description required');

                let unitVal = $('#unit').val();
                let qtyVal = $('#qty').val();
                let balanceVal = $('#balance').val();
                let approvedVal = $('#approved').val();
                let impaVal = $('#impa').val();
                let remarksVal = $('#remarks').val();

                // Append row for display
                table.row.add([
                    descVal, unitVal, qtyVal, balanceVal, approvedVal, impaVal, remarksVal,
                    `<button type="button" class="btn btn-danger btn-sm removeRow">X</button>`
                ]).draw(false);

                // Append hidden inputs for form submission
                hiddenContainer.append(`
                    <input type="hidden" name="items[${itemIndex}][description]" value="${descVal}">
                    <input type="hidden" name="items[${itemIndex}][unit]" value="${unitVal}">
                    <input type="hidden" name="items[${itemIndex}][qty_required]" value="${qtyVal}">
                    <input type="hidden" name="items[${itemIndex}][balance]" value="${balanceVal}">
                    <input type="hidden" name="items[${itemIndex}][qty_approved]" value="${approvedVal}">
                    <input type="hidden" name="items[${itemIndex}][impa]" value="${impaVal}">
                    <input type="hidden" name="items[${itemIndex}][remarks]" value="${remarksVal}">
                `);

                itemIndex++;

                $('#desc,#unit,#qty,#balance,#approved,#impa,#remarks').val('');
            });

            // Remove row
            $('#itemsTable tbody').on('click', '.removeRow', function(){
                let row = table.row($(this).parents('tr'));
                let rowIndex = row.index();
                row.remove().draw();

                // Remove corresponding hidden inputs
                hiddenContainer.find(`input[name^="items[${rowIndex}]"]`).remove();
            });

        </script>
    @endpush

@endsection
