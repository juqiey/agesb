@extends('layouts.user_type.auth')

@section('title', 'Ship Store Requisition')

@section('content')

<main class="main-content position-relative mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mb-4 pb-0 d-flex justify-content-between align-items-center">
                        <h6>Ship Store Requisition</h6>
                        <a href="{{ route('ssr.request.create', ['vessel'=> request('vessel')]) }}" class="btn btn-sm btn-primary">
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
                                       href="{{ route('ssr.request.index') }}">
                                        All
                                    </a>
                                </li>

                                @foreach($vessels as $code => $name)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $selectedVessel == $code ? 'active' : '' }}"
                                           href="{{ route('ssr.request.index',['vessel'=>$code]) }}">
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
                                        <th>SSR No.</th>
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
                                    @foreach($ssrs as $ssr)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ssr->ssr_no }}</td>
                                            <td>{{ $ssr->date }}</td>
                                            <td>{{ $ssr->vessel }}</td>
                                            <td>{{ $ssr->item }}</td>
                                            <td>{{ $ssr->location }}</td>
                                            <td>
                                                @if($ssr->verified_status === 'PENDING')
                                                    <span class="badge bg-warning text-white">PENDING</span>
                                                @elseif($ssr->verified_status === 'VERIFIED')
                                                    <span class="badge bg-success">VERIFIED</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $ssr->verified_status }}</span>
                                                @endif

                                                {{-- Remark under badge --}}
                                                @if(!empty($ssr->verified_remark))
                                                    <div class="text-muted small mt-1">
                                                        Remark: {{ $ssr->verified_remark }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                @if($ssr->approved_status === 'PENDING')
                                                    <span class="badge bg-warning text-white">PENDING</span>
                                                @elseif($ssr->approved_status === 'APPROVED')
                                                    <span class="badge bg-success">APPROVED</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $ssr->approved_status }}</span>
                                                @endif

                                                {{-- Remark under badge --}}
                                                @if(!empty($ssr->approved_remark))
                                                    <div class="text-muted small mt-1">
                                                        Remark: {{ $ssr->approved_remark }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ssr->pro_status === 'PENDING')
                                                    <span class="badge bg-warning text-white">PENDING</span>
                                                @elseif($ssr->pro_status === 'APPROVED')
                                                    <span class="badge bg-success">APPROVED</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $ssr->pro_status }}</span>
                                                @endif
                                            </td>
                                            @php
                                                $statusColors = [
                                                    'CLOSE' => 'bg-warning text-white',
                                                    'OPEN' => 'bg-success',
                                                    'CANCEL' => 'bg-danger'
                                                ];

                                                // Default class if status not in the array
                                                $badgeClass = $statusColors[$ssr->status] ?? 'bg-secondary';
                                            @endphp

                                            <td class="text-center">
                                                <span class="badge {{ $badgeClass }}">{{ $ssr->status }}</span>
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                        <li>
                                                            <a href="{{ route('ssr.request.show', $ssr) }}" class="dropdown-item" type="button">View</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('ssr.request.edit', $ssr) }}" class="dropdown-item" type="button">Update</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('ssr.report.export', $ssr) }}" class="dropdown-item" type="button">Print</a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger" type="button">Delete</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item show-attachment"
                                                                    type="button"
                                                                    data-url="{{ $ssr->doc_url ?? '' }}">
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
    <div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="attachmentModalLabel" aria-hidden="true">
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
