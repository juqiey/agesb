@extends('layouts.user_type.auth')

@section('title', 'User Profile')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">User Profile</h4>
                        </div>

                        {{-- Card Body --}}
                            <div class="card-body px-4 pt-4 pb-4">

                                <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                            <span class="alert-text"><strong>Success!</strong> {{session('success')}}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{-- ================= Personal Information ================= --}}
                                    <h5 class="text-primary mb-3">Personal Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Staff Number</label>
                                            <input type="text" name="staff_no" class="form-control" value="{{ $user->staff_no }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">IC Number</label>
                                            <input type="text" name="noic" class="form-control" value="{{ $user->noic }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                        </div>
                                    </div>

                                    {{-- ================= Contact Details ================= --}}
                                    <hr class="horizontal dark my-4">
                                    <h5 class="text-primary mb-3">Contact Details</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" rows="3" name="address">{{ $user->address }}</textarea>
                                        </div>
                                    </div>

                                    {{-- ================= Employment Details ================= --}}
                                    <hr class="horizontal dark my-4">
                                    <h5 class="text-primary mb-3">Employment Details</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Position</label>
                                            <select name="position" class="form-select">
                                                <option selected disabled>Choose position</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position }}" {{ $user->position == $position ?'selected':'' }}>{{ $position }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Department</label>
                                            <select name="department" class="form-select">
                                                <option selected disabled>Choose department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department }}" {{ $user->department == $department ?'selected':'' }}>{{ $department }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Company</label>
                                            <select name="company" class="form-select">
                                                <option selected disabled>Choose company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company }}" {{ $user->company == $company ?'selected':'' }}>{{ $company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ================= Additional Info ================= --}}
                                    <hr class="horizontal dark my-4">
                                    <h5 class="text-primary mb-3">Additional Information</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Marital Status</label>
                                            <select name="marital" class="form-select">
                                                <option selected disabled>Choose status</option>
                                                @php
                                                    $maritals = [
                                                     'Single',
                                                     'Married'
                                                    ]
                                                @endphp

                                                @foreach($maritals as $marital)
                                                    <option value="{{ $marital }}" {{ $user->marital==$marital ? 'selected':'' }}>{{ $marital }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-select">
                                                <option selected disabled>Choose gender</option>
                                                @php
                                                    $genders = [
                                                     'Male',
                                                     'Female'
                                                    ]
                                                @endphp

                                                @foreach($genders as $gender)
                                                    <option value="{{ $gender }}" {{ $user->gender==$gender ? 'selected':'' }}>{{ $gender }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ================= Actions ================= --}}
                                    <div class="text-end mt-4">
                                        <button type="reset" class="btn btn-secondary">Clear</button>
                                        <button type="submit" class="btn btn-primary ms-2">Save User</button>
                                    </div>

                                </form>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
