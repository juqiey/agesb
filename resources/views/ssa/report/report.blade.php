<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SSA Report - {{ $ssa->ssa_no }}</title>
    <style>
        @page { size: A4 portrait; margin: 20px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin:0; padding:0; }

        /* HEADER */
        .header { margin-bottom: 15px; }
        .header-table { width: 100%; }
        .header-table td { vertical-align: top; }
        .logo { width: 80px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .report-info { font-size: 12px; text-align: right; }
        .header-separator { border-bottom: 2px solid #000; margin-top:10px; margin-bottom:15px; }

        /* SECTION TITLES */
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 5px; }
        .section-separator { border-bottom: 1px solid #000; margin-bottom: 10px; }

        /* DETAILS TABLE */
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .details-table td { padding: 4px; vertical-align: top; }
        .details-label { font-weight: bold; width: 30%; }

        /* ITEMS TABLE */
        table.items-table { width: 100%; border-collapse: collapse; margin-top: 8px; margin-bottom: 10px; }
        table.items-table th, table.items-table td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        table.items-table th { background-color: #f2f2f2; text-transform: uppercase; }

        /* BADGES */
        .badge { display: inline-block; padding: 3px 7px; border-radius: 3px; font-size: 11px; font-weight: bold; color: #fff; }
        .bg-success { background-color: #198754; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .bg-danger { background-color: #dc3545; }
        .bg-secondary { background-color: #6c757d; }

        /* STATUS CARDS */
        .status-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
        .status-card { flex: 1 1 48%; padding: 8px; box-sizing: border-box; }
        .status-card .label { font-weight: bold; margin-bottom: 5px; }
        .status-card .detail { margin-bottom: 4px; }
        .status-card .detail span { font-weight: bold; }

        /* Footer */
        .footer { position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; font-size: 12px; color: #555; }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <table class="header-table">
        <tr>
            <td style="width:80px;"><img src="{{ public_path('img/agesb_logo.png') }}" class="logo" alt="Logo"></td>
            <td class="title">SSA Report</td>
            <td class="report-info">
                <div><strong>Generated:</strong> {{ now()->format('d M Y, H:i') }}</div>
                <div><strong>SSA No:</strong> {{ $ssa->ssa_no }}</div>
            </td>
        </tr>
    </table>
    <div class="header-separator"></div>
</div>

<!-- SSA DETAILS -->
<div class="section-title">SSA Details</div>
<div class="section-separator"></div>
<table class="details-table">
    <tr>
        <td class="details-label">SSA No:</td><td>{{ $ssa->ssa_no }}</td>
        <td class="details-label">SSA Date:</td><td>{{ optional($ssa->date)->format('d M Y') ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Vessel:</td><td>{{ $ssa->vessel ?? '-' }}</td>
        <td class="details-label">Location:</td><td>{{ $ssa->location ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Department:</td><td>{{ $ssa->department ?? '-' }}</td>
        <td class="details-label">SSA Raised By:</td><td>{{ $ssa->ssa_raised ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Requested By:</td><td>{{ $ssa->user->name ?? '-' }}</td>
        <td class="details-label">Current Status:</td>
        <td>
            <span class="badge
                {{ match($ssa->status ?? '') {
                    'OPEN' => 'bg-success',
                    'CLOSE' => 'bg-warning',
                    'CANCEL' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssa->status ?? '-' }}</span>
        </td>
    </tr>
</table>

<!-- SSA ITEMS -->
<div class="section-title">SSA Items</div>
<div class="section-separator"></div>
<table class="items-table">
    <thead>
    <tr>
        <th>No</th>
        <th>Description</th>
        <th>Maker/Model No.</th>
        <th>Remedial</th>
        <th>Assistance</th>
        <th>Remark</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ssa->ssa_items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->description ?? '-' }}</td>
            <td>{{ $item->model_no ?? '-' }}</td>
            <td>{{ $item->remedial ?? '-' }}</td>
            <td>{{ $item->assistance ?? '-' }}</td>
            <td>{{ $item->remark ?? '-' }}</td>
            <td>
                <span class="badge
                    {{ match($item->status ?? '') {
                        'OPEN' => 'bg-success',
                        'CLOSE' => 'bg-danger',
                        default => 'bg-secondary'
                    } }}">{{ $item->status ?? '-' }}</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<br><br><br>
<!-- SSA STATUS -->
<div class="section-title">SSA Status</div>
<div class="section-separator"></div>

<table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
    <tr>
        <!-- Verified Status -->
        <td style="width:50%; vertical-align: top; padding:8px;">
            <div style="font-weight:bold; margin-bottom:5px;">Verified Status</div>
            <span class="badge
                {{ match($ssa->verified_status ?? '') {
                    'VERIFIED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    default => 'bg-secondary'
                } }}">{{ $ssa->verified_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssa->verifiedBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssa->verified_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssa->verified_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssa->verified_remark }}</div>@endif
        </td>

        <!-- Approval Status -->
        <td style="width:50%; vertical-align: top; padding:8px;">
            <div style="font-weight:bold; margin-bottom:5px;">Approval Status</div>
            <span class="badge
                {{ match($ssa->approved_status ?? '') {
                    'APPROVED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    'REJECTED' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssa->approved_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssa->approvedBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssa->approved_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssa->approved_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssa->approved_remark }}</div>@endif
        </td>
    </tr>
    <tr>
        <br>
        <br>
    </tr>
    <tr>
        <!-- Procurement Approval -->
        <td style="width:50%; vertical-align: top; padding:8px;">
            <div style="font-weight:bold; margin-bottom:5px;">Procurement Approval</div>
            <span class="badge
                {{ match($ssa->pro_status ?? '') {
                    'APPROVED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    'REJECTED' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssa->pro_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssa->proBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssa->pro_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssa->pro_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssa->pro_remark }}</div>@endif
        </td>
    </tr>
</table>

<!-- Footer -->
<div class="footer">
    Generated by {{ auth()->user()->name }} | {{ now()->format('d M Y, H:i') }}
</div>

</body>
</html>