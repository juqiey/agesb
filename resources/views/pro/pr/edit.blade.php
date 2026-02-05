@extends('layouts.user_type.auth')

@section('title', 'Purchase Request Procurement Approval')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">Purchase Request Procurement Approval</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <form action="{{ route('pro.pr.update', $pr) }}" method="POST" enctype="multipart/form-data">
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
                                            <select name="vessel" class="form-select" disabled>
                                                @foreach($vessels as $code=>$name)
                                                    <option value="{{ $code }}" {{ $pr->vessel==$code?'selected':'' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <textarea class="form-control" name="title" rows="2" disabled>{{ $pr->title ?? '-' }}</textarea>
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
                                                           disabled>
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
                                                               placeholder="Specify other category" disabled>
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

                                    <table class="table table-bordered align-middle mb-2 datatable">
                                        <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Remark</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($pr->pr_items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->remark }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                {{-- Approval --}}
                                <div class="mb-4 p-3 border rounded bg-white">
                                    <h6 class="mb-3 text-uppercase fw-bold text-primary">Approval</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Approved By</label>
                                            <input disabled class="form-control" value="{{ auth()->user()->name }}">
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Designation</label>
                                            <input disabled class="form-control" value="{{ auth()->user()->position ?? '-' }}">
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <span class="small fw-bold">Status:</span>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="verifySwitch"
                                                {{ old('pro_status', $pr->pro_status) === 'APPROVED' ? 'checked' : '' }}>

                                            <input type="hidden" name="approval_status" id="approvalStatus"
                                                   value="{{ old('pro_status', $pr->pro_status) ?? 'PENDING' }}">

                                            <span id="verifyBadge" class="badge {{ $pr->pro_status === 'APPROVED' ? 'bg-success' : 'bg-warning' }}">
                                                {{ old('pro_status', $pr->pro_status) ?? 'PENDING' }}
                                            </span>
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
            $('#verifySwitch').on('change', function () {

                if ($(this).is(':checked')) {
                    $('#verifyBadge')
                        .removeClass('bg-warning')
                        .addClass('bg-success')
                        .text('APPROVED');

                    $('#approvalStatus').val('APPROVED');

                } else {
                    $('#verifyBadge')
                        .removeClass('bg-success')
                        .addClass('bg-warning')
                        .text('PENDING');

                    $('#approvalStatus').val('PENDING');
                }

            });
        </script>

    @endpush
@endsection
