@extends('layouts.user_type.auth')

@section('title', 'User Details')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">

                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light">
                            <h4 class="mb-0 text-center">User Details</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="text-center mb-3 text-uppercase fw-bold text-primary">Personal Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Name:</strong>
                                            <span>{{ $user->name ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Staff No.:</strong>
                                            <span>{{ $user->staff_no ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Gender:</strong>
                                            <span>{{ $user->gender ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Marital Status:</strong>
                                            <span>{{ $user->marital ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong class="me-2">Address:</strong>
                                        <span>{{ $user->address ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="text-center mb-3 text-uppercase fw-bold text-primary">Contact Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Phone Number:</strong>
                                            <span>{{ $user->phone ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Email:</strong>
                                            <span>{{ $user->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="text-center mb-3 text-uppercase fw-bold text-primary">Employment Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Position:</strong>
                                            <span>{{ $user->position ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Company:</strong>
                                            <span>{{ $user->company ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Branch:</strong>
                                            <span>{{ $user->branch ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Department:</strong>
                                            <span>{{ $user->department ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-4 border rounded bg-light">
                                <h6 class="text-center mb-3 text-uppercase fw-bold text-primary">Account Details</h6>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Role:</strong>
                                            <span>{{ $user->role ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Status:</strong>
                                            <span class="badge
                                                {{ match($user->status ?? 'N/A') {
                                                    'ACTIVE' => 'bg-success',
                                                    'INACTIVE' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                } }}">
                                                {{ $user->status ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Created At:</strong>
                                            <span>{{ $user->created_at ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <strong class="me-2">Updated At:</strong>
                                            <span>{{ $user->updated_at ?? '-' }}</span>
                                        </div>
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
