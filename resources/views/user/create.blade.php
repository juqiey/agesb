@extends('layouts.user_type.auth')

@section('title', 'New User')

@section('content')
    <main class="main-content position-relative mt-4 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        {{-- Card Header --}}
                        <div class="card-header pb-0 bg-light text-white">
                            <h4 class="mb-0 text-center">New User</h4>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-4 pb-4">
                            <div class="card-body px-4 pt-4 pb-4">

                                <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    {{-- ================= Personal Information ================= --}}
                                    <h5 class="text-primary mb-3">Personal Information</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Staff Number</label>
                                            <input type="text" name="staff_no" class="form-control" placeholder="Enter staff number">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">IC Number</label>
                                            <input type="text" name="noic" class="form-control" placeholder="Enter IC number">
                                            <small class="form-text text-muted">
                                                IC number will be used as default user account password.
                                            </small>
                                            <small id="icError" class="form-text text-danger d-none">
                                                Special characters are not allowed.
                                            </small>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter full name">
                                        </div>
                                    </div>

                                    {{-- ================= Contact Details ================= --}}
                                    <hr class="horizontal dark my-4">
                                    <h5 class="text-primary mb-3">Contact Details</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control" placeholder="e.g 0123456789">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" placeholder="example@email.com">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" rows="3" name="address"></textarea>
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
                                                    <option value="{{ $position }}">{{ $position }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Role</label>
                                            <select name="role" class="form-select">
                                                <option selected disabled>Choose role</option>
                                                @foreach($roles as $code=>$role)
                                                    <option value="{{ $code }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Department</label>
                                            <select name="department" class="form-select">
                                                <option selected disabled>Choose department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department }}">{{ $department }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Company</label>
                                            <select name="company" class="form-select">
                                                <option selected disabled>Choose company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company }}">{{ $company }}</option>
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
                                                    <option value="{{ $marital }}">{{ $marital }}</option>
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
                                                    <option value="{{ $gender }}">{{ $gender }}</option>
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
        </div>
    </main>
    @push('scripts')
        <script>
            document.getElementById("noic").addEventListener("input", function () {
                const error = document.getElementById("icError");

                if (/[^0-9]/.test(this.value)) {
                    error.classList.remove("d-none");
                } else {
                    error.classList.add("d-none");
                }
            });
        </script>
    @endpush
@endsection
