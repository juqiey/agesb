@extends('layouts.user_type.auth')

@section('title', 'DO Procurement')

@section('content')

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                            <h6>Delivery Orders</h6>
                            <a href="{{ route('pro.do.create', ['vessel'=> request('vessel')]) }}" class="btn btn-sm btn-primary">
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
                                       href="{{ route('pro.do.index') }}">
                                        All
                                    </a>
                                </li>

                                @foreach($vessels as $code => $name)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $selectedVessel == $code ? 'active' : '' }}"
                                           href="{{ route('pro.do.index',['vessel'=>$code]) }}">
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
                                            <th>DO No.</th>
                                            <th>Date</th>
                                            <th>Job No.</th>
                                            <th>Vessel</th>
                                            <th>Total (RM)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dos as $do)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $do->do_no }}</td>
                                                <td>{{ $do->date }}</td>
                                                <td>{{ $do->job_no }}</td>
                                                <td>{{ $do->vessel }}</td>
                                                <td>{{ $do->total }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                            <li>
                                                                <a href="{{ route('pro.do.show', $do) }}" class="dropdown-item" type="button">View</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{--{{ route('pro.ssr.edit', $ssr) }}--}}" class="dropdown-item" type="button">Update</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('pro.do.report', $do) }}" class="dropdown-item" type="button">Print</a>
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
    @push('scripts')
        <script>

        </script>
    @endpush
@endsection
