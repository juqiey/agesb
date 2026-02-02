<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SSR Report - {{ $ssr->ssr_no }}</title>
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
            <td class="title">SSR Report</td>
            <td class="report-info">
                <div><strong>Generated:</strong> {{ now()->format('d M Y, H:i') }}</div>
                <div><strong>SSR No:</strong> {{ $ssr->ssr_no }}</div>
            </td>
        </tr>
    </table>
    <div class="header-separator"></div>
</div>

<!-- SSR DETAILS -->
<div class="section-title">SSR Details</div>
<div class="section-separator"></div>
<table class="details-table">
    <tr>
        <td class="details-label">SSR No:</td><td>{{ $ssr->ssr_no }}</td>
        <td class="details-label">SSR Date:</td><td>{{ optional($ssr->ssr_date)->format('d M Y') ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Vessel:</td><td>{{ $ssr->vessel ?? '-' }}</td>
        <td class="details-label">Location:</td><td>{{ $ssr->location ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Department:</td><td>{{ $ssr->department ?? '-' }}</td>
        <td class="details-label">Requested By:</td><td>{{ $ssr->requestedBy->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="details-label">Current Status:</td>
        <td colspan="3">
            <span class="badge
                {{ match($ssr->status ?? '') {
                    'OPEN' => 'bg-success',
                    'CLOSE' => 'bg-warning',
                    'CANCEL' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssr->status ?? '-' }}</span>
        </td>
    </tr>
</table>

<!-- SSR ITEMS -->
<div class="section-title">SSR Items</div>
<div class="section-separator"></div>
<table class="items-table">
    <thead>
    <tr>
        <th>No</th>
        <th>Description</th>
        <th>Qty Approved</th>
        <th>Unit</th>
        <th>Qty Required</th>
        <th>Balance</th>
        <th>Remark</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ssr->ssr_items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->description ?? '-' }}</td>
            <td>{{ $item->quantity_app ?? '-' }}</td>
            <td>{{ $item->unit ?? '-' }}</td>
            <td>{{ $item->quantity_req ?? '-' }}</td>
            <td>{{ $item->balance ?? '-' }}</td>
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
<!-- SSR STATUS -->
<div class="section-title">SSR Status</div>
<div class="section-separator"></div>

<table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
    <tr>
        <!-- Verified Status -->
        <td style="width:50%; vertical-align: top; padding:8px;">
            <div style="font-weight:bold; margin-bottom:5px;">Verified Status</div>
            <span class="badge
                {{ match($ssr->verified_status ?? '') {
                    'VERIFIED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    default => 'bg-secondary'
                } }}">{{ $ssr->verified_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssr->verifiedBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssr->verified_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssr->verified_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssr->verified_remark }}</div>@endif
        </td>

        <!-- Approval Status -->
        <td style="width:50%; vertical-align: top; padding:8px;">
            <div style="font-weight:bold; margin-bottom:5px;">Approval Status</div>
            <span class="badge
                {{ match($ssr->approved_status ?? '') {
                    'APPROVED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    'REJECTED' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssr->approved_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssr->approvedBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssr->approved_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssr->approved_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssr->approved_remark }}</div>@endif
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
                {{ match($ssr->pro_status ?? '') {
                    'APPROVED' => 'bg-success',
                    'PENDING' => 'bg-warning',
                    'REJECTED' => 'bg-danger',
                    default => 'bg-secondary'
                } }}">{{ $ssr->pro_status ?? '-' }}</span>
            <div style="margin-top:5px;"><span style="font-weight:bold;">By:</span> {{ $ssr->proBy->name ?? '-' }}</div>
            <div><span style="font-weight:bold;">At:</span> {{ optional($ssr->pro_at)->format('d M Y, h:i A') ?? '-' }}</div>
            @if($ssr->pro_remark)<div><span style="font-weight:bold;">Remark:</span> {{ $ssr->pro_remark }}</div>@endif
        </td>
    </tr>
</table>


<!-- Footer -->
<div class="footer">
    Generated by {{ auth()->user()->name }} | {{ now()->format('d M Y, H:i') }}
</div>

</body>
</html>
