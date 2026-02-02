@extends('layouts.user_type.auth')

@section('title', 'PR Confirmation')

@section('content')

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                            <h6>PR Confirmation</h6>
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
                                       href="{{ route('pr.approve.index') }}">
                                        All
                                    </a>
                                </li>

                                @foreach($vessels as $code => $name)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $selectedVessel == $code ? 'active' : '' }}"
                                           href="{{ route('pr.approve.index',['vessel'=>$code]) }}">
                                            {{ $name }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                            {{-- Status Filter --}}
                            <div class="d-flex align-items-center px-3 mb-3 gap-2">

                                <span class="small fw-bold">Status:</span>

                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="statusSwitch"
                                        {{ request('status') === 'close' ? 'checked' : '' }}>
                                </div>

                                <span id="statusBadge"
                                      class="badge {{ request('status') === 'close' ? 'bg-warning' : 'bg-success' }}">
                                        {{ request('status') === 'close' ? 'CLOSE' : 'OPEN' }}
                                    </span>

                            </div>

                            <div class="table-responsive p-0">
                                <table class="table table-bordered align-items-center mb-0 datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR No.</th>
                                        <th>Date</th>
                                        <th>Vessel</th>
                                        <th>Category</th>
                                        <th>Confirmation</th>
                                        <th>Approval</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prs as $pr)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pr->pr_no }}</td>
                                            <td>{{ $pr->date }}</td>
                                            <td>{{ $pr->vessel }}</td>
                                            <td>{{ $pr->item_req }}</td>
                                            <td>
                                                @if($pr->confirmed_status === 'PENDING')
                                                    <span class="badge bg-warning text-white">PENDING</span>
                                                @elseif($pr->confirmed_status === 'CONFIRMED')
                                                    <span class="badge bg-success">CONFIRMED</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $pr->confirmed_status }}</span>
                                                @endif

                                                {{-- Confirmed By --}}
                                                @if(!empty($pr->confirmedBy))
                                                    <div class="text-muted small mt-1">
                                                        Confirmed By: {{ $pr->confirmedBy->name }}
                                                    </div>
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

                                                {{-- Confirmed By --}}
                                                @if(!empty($pr->approvedBy))
                                                    <div class="text-muted small mt-1">
                                                        Approved By: {{ $pr->approvedBy->name }}
                                                    </div>
                                                @endif
                                            </td>
                                            @php
                                                $statusColors = [
                                                    'CLOSE' => 'bg-warning text-white',
                                                    'OPEN' => 'bg-success',
                                                    'CANCEL' => 'bg-danger'
                                                ];

                                                // Default class if status not in the array
                                                $badgeClass = $statusColors[$pr->status] ?? 'bg-secondary';
                                            @endphp

                                            <td class="text-center">
                                                <span class="badge {{ $badgeClass }}">{{ $pr->status }}</span>
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                        <li>
                                                            <a href="{{--{{ route('pr.confirm.show', $pr) }}--}}" class="dropdown-item" type="button">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('pr.approve.edit', $pr) }}" class="dropdown-item" type="button">Update</a>
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
            document.getElementById('statusSwitch').addEventListener('change', function () {

                const isClose = this.checked;
                const status = isClose ? 'close' : 'open';

                const url = new URL(window.location.href);
                url.searchParams.set('status', status);

                window.location.href = url.toString();
            });

            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('attachmentModal'));
                const iframe = document.getElementById('attachmentFrame');

                document.querySelectorAll('.show-attachment').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const url = this.dataset.url;
                        if(url) {
                            iframe.src = "{{ asset('') }}" + url; // append base asset URL
                            modal.show();
                        } else {
                            alert('No attachment available for this SSR.');
                        }
                    });
                });

                // Clear iframe when modal closes to avoid caching issues
                document.getElementById('attachmentModal').addEventListener('hidden.bs.modal', function() {
                    iframe.src = '';
                });
            });
        </script>
    @endpush
@endsection
