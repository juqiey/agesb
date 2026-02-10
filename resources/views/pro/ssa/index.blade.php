@extends('layouts.user_type.auth')

@section('title', 'SSA Procurement Approve')

@section('content')

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                            <h6>Spare Store Authorization</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                    <span class="alert-text"><strong>Success!</strong> {{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <ul class="nav nav-tabs mb-3">

                                <li class="nav-item">
                                    <a class="nav-link {{ empty($selectedVessel) ? 'active' : '' }}"
                                        href="{{ route('pro.ssa.index') }}">
                                        All
                                    </a>
                                </li>

                                @foreach ($vessels as $code => $name)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $selectedVessel == $code ? 'active' : '' }}"
                                            href="{{ route('pro.ssa.index', ['vessel' => $code]) }}">
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
                                            <th>SSA No.</th>
                                            <th>Date</th>
                                            <th>Vessel</th>
                                            <th>Item</th>
                                            <th>Location</th>
                                            <th>Verified</th>
                                            <th>Approved</th>
                                            <th>Procurement Approved</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ssas as $ssa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ssa->ssa_no }}</td>
                                                <td>{{ $ssa->date }}</td>
                                                <td>{{ $ssa->vessel }}</td>
                                                <td>{{ $ssa->item }}</td>
                                                <td>{{ $ssa->location }}</td>
                                                <td>
                                                    @if ($ssa->verified_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($ssa->verified_status === 'VERIFIED')
                                                        <span class="badge bg-success">VERIFIED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $ssa->verified_status }}</span>
                                                    @endif

                                                    {{-- Remark under badge --}}
                                                    @if (!empty($ssa->verified_remark))
                                                        <div class="text-muted small mt-1">
                                                            Remark: {{ $ssa->verified_remark }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($ssa->approved_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($ssa->approved_status === 'APPROVED')
                                                        <span class="badge bg-success">APPROVED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $ssa->approved_status }}</span>
                                                    @endif

                                                    {{-- Remark under badge --}}
                                                    @if (!empty($ssa->approved_remark))
                                                        <div class="text-muted small mt-1">
                                                            Remark: {{ $ssa->approved_remark }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ssa->pro_status === 'PENDING')
                                                        <span class="badge bg-warning text-white">PENDING</span>
                                                    @elseif($ssa->pro_status === 'APPROVED')
                                                        <span class="badge bg-success">APPROVED</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $ssa->pro_status }}</span>
                                                    @endif

                                                    {{-- Remark under badge --}}
                                                    @if (!empty($ssa->pro_remark))
                                                        <div class="text-muted small mt-1">
                                                            Remark: {{ $ssa->pro_remark }}
                                                        </div>
                                                    @endif
                                                </td>
                                                @php
                                                    $statusColors = [
                                                        'CLOSE' => 'bg-warning text-white',
                                                        'OPEN' => 'bg-success',
                                                        'CANCEL' => 'bg-danger',
                                                    ];

                                                    // Default class if status not in the array
                                                    $badgeClass = $statusColors[$ssa->status] ?? 'bg-secondary';
                                                @endphp

                                                <td class="text-center">
                                                    <span class="badge {{ $badgeClass }}">{{ $ssa->status }}</span>
                                                </td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle"
                                                            type="button" id="actionDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                            <li>
                                                                <a href="{{ route('pro.ssa.show', $ssa) }}"
                                                                    class="dropdown-item" type="button">View</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('pro.ssa.edit', $ssa) }}"
                                                                    class="dropdown-item" type="button">Update</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('ssa.report.export', $ssa) }}"
                                                                    class="dropdown-item" type="button">Print</a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('pro.ssa.destroy', $ssa) }}"
                                                                    method="POST" style="display:inline;"
                                                                    onsubmit="return confirm('Are you sure you want to delete this SSA? This action cannot be undone.')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger"
                                                                        type="submit">Delete</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item show-attachment" type="button"
                                                                    data-url="{{ $ssa->doc_url ?? '' }}">
                                                                    Show Attachment
                                                                </button>
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
        <!-- Attachment Modal -->
        <div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="attachmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attachmentModalLabel">Attachment Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <iframe id="attachmentFrame" src="" width="100%" height="500px" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('attachmentModal'));
                const iframe = document.getElementById('attachmentFrame');

                document.querySelectorAll('.show-attachment').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const url = this.dataset.url;
                        if (url) {
                            iframe.src = "{{ asset('') }}" + url; // append base asset URL
                            modal.show();
                        } else {
                            alert('No attachment available for this SSA.');
                        }
                    });
                });

                // Clear iframe when modal closes to avoid caching issues
                document.getElementById('attachmentModal').addEventListener('hidden.bs.modal', function() {
                    iframe.src = '';
                });
            });

            document.getElementById('statusSwitch').addEventListener('change', function() {

                const isClose = this.checked;
                const status = isClose ? 'close' : 'open';

                const url = new URL(window.location.href);
                url.searchParams.set('status', status);

                window.location.href = url.toString();
            });
        </script>
    @endpush
@endsection
