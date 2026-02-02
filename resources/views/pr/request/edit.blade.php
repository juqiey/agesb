@extends('layouts.user_type.auth')

@section('title', 'Purchase Request Update')

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
                            <form action="{{ route('pr.request.update', $pr) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="ni ni-single-02 me-2"></i>Requisitioner
                                    </h6>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Requested By</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $pr->requestedBy->name ?? '-' }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $pr->date->format('d/m/Y') ?? '-' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PR No.</label>
                                            <input type="text" class="form-control" value="{{ $pr->pr_no ?? '-' }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Vessel</label>
                                            <select name="vessel" class="form-select" required>
                                                @foreach($vessels as $code=>$name)
                                                    <option value="{{ $code }}" {{ $pr->vessel==$code?'selected':'' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <textarea class="form-control" name="title" rows="2">{{ $pr->title ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Category Section --}}
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-3">Category</h6>

                                    <div class="row g-3">

                                        @php
                                            $categories = ['Material','Services','Assets','Others'];
                                        @endphp

                                        @foreach($categories as $cat)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input category-radio"
                                                           type="radio"
                                                           name="category"
                                                           value="{{ $cat }}"
                                                           {{ $pr->item_req === $cat ? 'checked' : '' }}
                                                           required>
                                                    <label class="form-check-label">{{ $cat }}</label>
                                                </div>

                                                {{-- Others input only under Others --}}
                                                @if($cat === 'Others')
                                                    <div class="mt-2"
                                                         id="otherCategoryWrapper"
                                                         style="{{ $pr->item_req === 'Others' ? 'display:block;' : 'display:none;' }}">
                                                        <input type="text"
                                                               class="form-control"
                                                               name="category_others"
                                                               value="{{ $pr->item_req }}"
                                                               placeholder="Specify other category">
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                {{-- 3. Items --}}
                                <div class="mb-4 p-3 border rounded">

                                    <h6 class="fw-bold text-primary mb-3">
                                        Summary of Purchase Request
                                    </h6>

                                    <table class="table table-bordered align-middle mb-2">
                                        <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody id="itemsTable"></tbody>
                                    </table>

                                    <input type="hidden" name="removed_items" id="removed_items">

                                    <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                                        <i class="ni ni-fat-add"></i> Add Item
                                    </button>

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

            window.addEventListener('DOMContentLoaded', () => {
                const checked = document.querySelector('.category-radio:checked');
                if (checked) checked.dispatchEvent(new Event('change'));
            });

            const items = @json($pr->pr_items);
            let removed = [];

            const tbody = document.getElementById('itemsTable');
            const removedInput = document.getElementById('removed_items');

            if (items.length === 0) {
                items.push({id:null, description:'', unit:'', quantity:1, remark:''});
            }

            // ------------------
            // Sync DOM → JS
            // ------------------

            function syncItemsFromInputs() {
                items.forEach((item, index) => {

                    item.description = document.querySelector(`[name="items[${index}][description]"]`)?.value ?? '';
                    item.unit = document.querySelector(`[name="items[${index}][unit]"]`)?.value ?? '';
                    item.quantity = document.querySelector(`[name="items[${index}][quantity]"]`)?.value ?? 1;
                    item.remark = document.querySelector(`[name="items[${index}][remark]"]`)?.value ?? '';

                });
            }

            // ------------------
            // Render Table
            // ------------------

            function renderItems() {
                tbody.innerHTML = '';

                items.forEach((item, index) => {

                    tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td class="text-center">${index + 1}</td>

            <td>
                <input type="hidden" name="items[${index}][id]" value="${item.id ?? ''}">
                <input type="text" class="form-control"
                       name="items[${index}][description]"
                       value="${item.description ?? ''}" required>
            </td>

            <td>
                <input type="text" class="form-control"
                       name="items[${index}][unit]"
                       value="${item.unit ?? ''}" required>
            </td>

            <td>
                <input type="number" class="form-control"
                       name="items[${index}][quantity]"
                       value="${item.quantity ?? 1}" min="1" required>
            </td>

            <td>
                <input type="text" class="form-control"
                       name="items[${index}][remark]"
                       value="${item.remark ?? ''}">
            </td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="removeItem(${index})">
                    <i class="ni ni-fat-remove"></i>
                </button>
            </td>
        </tr>
        `);
                });

                removedInput.value = removed.join(',');
            }

            // ------------------
            // Remove Item
            // ------------------

            function removeItem(index) {

                syncItemsFromInputs();

                if (items[index].id) {
                    removed.push(items[index].id);
                }

                items.splice(index, 1);

                if (items.length === 0) {
                    items.push({id:null, description:'', unit:'', quantity:1, remark:''});
                }

                renderItems();
            }

            // ------------------
            // Add Item
            // ------------------

            document.getElementById('addItemBtn').addEventListener('click', () => {

                syncItemsFromInputs();

                items.push({id:null, description:'', unit:'', quantity:1, remark:''});

                renderItems();

                // Autofocus new row
                setTimeout(() => {
                    document.querySelector(`[name="items[${items.length-1}][description]"]`)?.focus();
                }, 50);
            });

            // Initial render
            renderItems();

        </script>
    @endpush
@endsection
