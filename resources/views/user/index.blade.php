@extends('layouts.user_type.auth')

@section('title', 'User Management')

@section('content')

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                            <h6>User Management</h6>
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
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
                            <div class="table-responsive p-0">
                                <table class="table table-bordered align-items-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->staff_no }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->department }}</td>
                                                <td>{{ $user->position }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                            <li>
                                                                <a href="{{ route('user.show', $user) }}" class="dropdown-item" type="button">View</a>
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
