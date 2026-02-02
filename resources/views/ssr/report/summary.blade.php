<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SSR Summary Report</title>
    <style>
        @page { size: A4 landscape; margin: 20px; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; margin:0; padding:0; }
        table { width:100%; border-collapse: collapse; margin-bottom:10px; }
        th, td { padding: 5px; text-align: left; vertical-align: top; border: 1px solid #444; }
        th { background-color: #f2f2f2; text-transform: uppercase; font-size:12px; }
        .header-table { width: 100%; margin-bottom:10px; }
        .header-table td { vertical-align: top; }
        .logo { width: 80px; }
        .title { text-align:center; font-size:16px; font-weight:bold; text-transform: uppercase; }
        .section-title { font-weight: bold; margin-top:10px; margin-bottom:5px; font-size:13px; }
        .summary-table td { border: 1px solid #444; padding:5px; }
        .badge { display:inline-block; padding:2px 6px; font-size:10px; color:#fff; border-radius:3px; }
        .bg-success { background-color:#198754; }
        .bg-warning { background-color:#ffc107; color:#000; }
        .bg-danger { background-color:#dc3545; }
        .bg-secondary { background-color:#6c757d; }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <td style="width:80px;"><img src="{{ public_path('img/agesb_logo.png') }}" class="logo"></td>
        <td class="title">SSR Summary Report</td>
        <td style="text-align:center; font-size:12px;">
            Generated: {{ now()->format('d M Y, H:i') }}<br>
            Vessel: {{ $vessel ?? 'All' }}<br>
            Year: {{ $year ?? 'All' }}
        </td>
    </tr>
</table>

<!-- SUMMARY TABLE -->
<table>
    <thead>
    <tr>
        <th style="width:30%;">SSR DETAILS</th>
        <th style="width:15%;">ITEM</th>
        <th style="width:10%;">QUANTITY APPROVED</th>
        <th style="width:10%;">STATUS</th>
        <th style="width:35%">DO NUMBER</th>
    </tr>
    </thead>
    <tbody>
    @forelse($ssrs as $ssr)
        @php
            $itemCount = $ssr->ssr_items->count() ?: 1;
        @endphp

        @forelse($ssr->ssr_items as $index => $item)
            <tr>
                @if($index === 0)
                    <td rowspan="{{ $itemCount }}">
                        <strong>SSR No:</strong> {{ $ssr->ssr_no }}<br>
                        <strong>Date:</strong> {{ optional($ssr->date)->format('d M Y') ?? '-' }}<br>
                        <strong>Vessel:</strong> {{ $ssr->vessel ?? '-' }}<br>
                        <strong>Location:</strong> {{ $ssr->location ?? '-' }}<br>
                        <strong>Department:</strong> {{ $ssr->department ?? '-' }}<br>
                        <strong>Requested By:</strong> {{ $ssr->requestedBy->name ?? '-' }}
                    </td>
                @endif
                <td>{{ $item->description ?? '-' }}</td>
                <td>{{ $item->quantity_app ?? '-' }}</td>
                <td>
                <span class="badge
                    {{ match($item->status ?? '') {
                        'OPEN' => 'bg-success',
                        'CLOSE' => 'bg-danger',
                        default => 'bg-secondary'
                    } }}">
                    {{ $item->status ?? '-' }}
                </span>
                </td>
                <td>DO Number: </td>
            </tr>
        @empty
            {{-- SSR exists but has no items --}}
            <tr>
                <td rowspan="1">
                    <strong>SSR No:</strong> {{ $ssr->ssr_no }}<br>
                    <strong>Date:</strong> {{ optional($ssr->ssr_date)->format('d M Y') ?? '-' }}<br>
                    <strong>Vessel:</strong> {{ $ssr->vessel ?? '-' }}<br>
                    <strong>Location:</strong> {{ $ssr->location ?? '-' }}<br>
                    <strong>Department:</strong> {{ $ssr->department ?? '-' }}<br>
                    <strong>Requested By:</strong> {{ $ssr->requestedBy->name ?? '-' }}
                </td>
                <td colspan="4" style="text-align:center;">No items</td>
            </tr>
        @endforelse
    @empty
        {{-- Entire $ssrs collection is empty --}}
        <tr>
            <td colspan="5" style="text-align:center;">No SSR records found</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
