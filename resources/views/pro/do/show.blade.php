@extends('layouts.user_type.auth')

@section('title', 'DO Details')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">Delivery Orders Details</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Created By:</strong>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Created At:</strong>
                                            <span>{{ $do->created_at }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">DO No:</strong>
                                            <span>{{ $do->do_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Date:</strong>
                                            <span>{{ $do->date->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">To:</strong>
                                            <span>{{ $do->do_recipient }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Vessel:</strong>
                                            <span>{{ $do->vessel ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <strong class="me-2">Location:</strong>
                                            <span>{{ $do->location ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">PR Items</h6>

                                <div class="row mb-2">
                                    <div class="table-responsive table-bordered">
                                        <table class="table table-bordered datatable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>PR No.</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Unit Price (RM)</th>
                                                <th>Total Price (RM)</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($do->pr_items as $pr_items)
                                                <tr>
                                                    <td>{{ $pr_items->pr->pr_no ?? '-' }}</td>
                                                    <td>{{ $pr_items->description }}</td>
                                                    <td>{{ $pr_items->unit }}</td>
                                                    <td>{{ $pr_items->quantity_pro }}</td>
                                                    <td>{{ $pr_items->unit_price }}</td>
                                                    <td>{{ $pr_items->total_price }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="mb-3 text-uppercase fw-bold text-primary">SSR Items</h6>

                                <div class="row mb-2">
                                    <div class="table-responsive table-bordered">
                                        <table class="table table-bordered datatable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>SSR No.</th>
                                                    <th>Description</th>
                                                    <th>Unit</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price (RM)</th>
                                                    <th>Total Price (RM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                    @foreach($do->ssr_items as $ssr_items)
                                                        <tr>
                                                            <td>{{ $ssr_items->ssr->ssr_no }}</td>
                                                            <td>{{ $ssr_items->description }}</td>
                                                            <td>{{ $ssr_items->unit }}</td>
                                                            <td>{{ $ssr_items->quantity_pro }}</td>
                                                            <td>{{ $ssr_items->unit_price }}</td>
                                                            <td>{{ $ssr_items->total_price }}</td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
