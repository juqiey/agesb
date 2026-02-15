@extends('layouts.user_type.auth')

@section('title', 'Purchase Request')

@section('content')

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                            <h6>Ship Store Requisition</h6>
                            <a href="{{ route('pr.request.create', ['vessel'=> request('vessel')]) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus"></i> Add New
                            </a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                    <span class="alert-text"><strong>Success!</strong> {{session('success')}}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <ul class="nav nav-tabs mb-3">

                                <li class="nav-item">
                                    <a class="nav-link {{ empty($selectedVessel) ? 'active' : '' }}"
                                       href="{{ route('pr.request.index') }}">
                                        All
                                    </a>
                                </li>

                                @foreach($vessels as $code => $name)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $selectedVessel == $code ? 'active' : '' }}"
                                           href="{{ route('pr.request.index',['vessel'=>$code]) }}">
                                            {{ $name }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>

                            <div class="table-responsive p-0">
                                <table class="table table-bordered align-items-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PR Info</th>
                                            <th>Confirmation</th>
                                            <th>Approval</th>
                                            <th>Procurement</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prs as $pr)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>PR No.:</strong> {{ $pr->pr_no }}
                                                    <br>
                                                    <strong>Date:</strong> {{ $pr->date }}
                                                    <br>
                                                    <strong>Vessel:</strong> {{ $pr->vessel }}
                                                </td>
                                                <td>
                                                    @if($pr->confirmed_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($pr->confirmed_status === 'CONFIRMED')
                                                        <span class="badge bg-success">CONFIRMED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pr->confirmed_status }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($pr->approved_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($pr->approved_status === 'APPROVED')
                                                        <span class="badge bg-success">APPROVED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pr->approved_status }}</span>
                                                    @endif

                                                    {{-- Remark under badge --}}
                                                    @if(!empty($pr->approved_remark))
                                                        <div class="text-muted small mt-1">
                                                            Remark: {{ $pr->approved_remark }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pr->pro_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($pr->pro_status === 'APPROVED')
                                                        <span class="badge bg-success">APPROVED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pr->pro_status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pr->status === 'CLOSE')
                                                        <span class="badge bg-warning text-white">CLOSE</span>
                                                    @elseif($pr->status === 'OPEN')
                                                        <span class="badge bg-success">OPEN</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pr->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                            <li>
                                                                <a href="{{ route('pr.request.show', $pr) }}" class="dropdown-item" type="button">View</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('pr.request.edit', $pr) }}" class="dropdown-item" type="button">Update</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('pr.report.export', $pr) }}" class="dropdown-item" type="button">Print</a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button">Delete</button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" type="button">Close</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
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
    </main>
@endsection
