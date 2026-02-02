<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PR Summary Report</title>
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
        .badge { display:inline-block; padding:2px 6px; font-size:10px; color:#fff; border-radius:3px; }
        .bg-success { background-color:#198754; }
        .bg-warning { background-color:#ffc107; color:#000; }
        .bg-danger { background-color:#dc3545; }
        .bg-secondary { background-color:#6c757d; }
        tr { page-break-inside: avoid; } /* Avoid breaking rows */

        /* Styling for repeated PR rows */
        .empty-pr-cell {
            background-color: #f9f9f9;
            border-left: 3px solid #444; /* subtle vertical line to connect to PR */
        }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <td style="width:80px;"><img src="{{ public_path('img/agesb_logo.png') }}" class="logo"></td>
        <td class="title">PR Summary Report</td>
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
        <th style="width:30%;">PR DETAILS</th>
        <th style="width:15%;">DESCRIPTION</th>
        <th style="width:10%;">QUANTITY</th>
        <th style="width:10%;">STATUS</th>
        <th style="width:35%">DO NUMBER</th>
    </tr>
    </thead>
    <tbody>
    @forelse($prs as $pr)

        @if($pr->pr_items->isNotEmpty())
            @foreach($pr->pr_items as $index => $item)
                <tr>
                    {{-- Display PR details only for the first item --}}
                    @if($index === 0)
                        <td>
                            <strong>PR No:</strong> {{ $pr->pr_no }}<br>
                            <strong>Date:</strong> {{ optional($pr->date)->format('d M Y') ?? '-' }}<br>
                            <strong>Vessel:</strong> {{ $pr->vessel ?? '-' }}<br>
                            <strong>Title:</strong> {{ $pr->title ?? '-' }}<br>
                            <strong>Requested By:</strong> {{ $pr->requestedBy->name ?? '-' }}
                        </td>
                    @else
                        <td class="empty-pr-cell"></td>
                    @endif

                    <td>{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->quantity ?? '-' }}</td>
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
            @endforeach
        @else
            {{-- PR exists but has no items --}}
            <tr>
                <td>
                    <strong>PR No:</strong> {{ $pr->pr_no }}<br>
                    <strong>Date:</strong> {{ optional($pr->date)->format('d M Y') ?? '-' }}<br>
                    <strong>Vessel:</strong> {{ $pr->vessel ?? '-' }}<br>
                    <strong>Title:</strong> {{ $pr->title ?? '-' }}<br>
                    <strong>Requested By:</strong> {{ $pr->requestedBy->name ?? '-' }}
                </td>
                <td colspan="4" style="text-align:center;">No items</td>
            </tr>
        @endif

    @empty
        {{-- Entire PR collection is empty --}}
        <tr>
            <td colspan="5" style="text-align:center;">No PR records found</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
