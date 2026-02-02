<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }

        .outer-box {
            border: 1px solid black;
            padding: 8px;
        }

        .title-box {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .line-break {
            margin: 15px 0;
            border-bottom: 1px solid black;
        }

        .row-label {
            width: 35%;
            font-weight: bold;
        }

        td {
            padding: 6px 0;  /* Increase vertical space between rows */
        }

        /* Fixed at bottom of page */
        .signature-section {
            position: fixed;
            bottom: 80px;
            left: 0;
            width: 100%;
        }

        /* Table layout */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        /* Each column width */
        .signature-table td {
            width: 33.33%;
            vertical-align: top;
            padding: 5px 20px;
        }

        /* Signature line */
        .signature-line {
            border-bottom: 1px solid #000;
            height: 40px;
            margin-top: 40px;
        }

        /* Label */
        .signature-label {
            font-weight: bold;
            text-align: left;
        }

        /* Name & Position aligned left */
        .signature-detail {
            text-align: left;
        }


        .summary{
            text-align: center;
        }

    </style>
</head>

<body>

{{-- HEADER --}}
<table>
    <tr>
        <td style="width: 60%; vertical-align: top;">
            <table>
                <tr>
                    <td style="width: 20%;">
                        <img src="{{ public_path('img/agesb_logo.png') }}" width="65">
                    </td>
                    <td>
                        <strong>Aims-Global Engineering Sdn Bhd (595546-H)</strong><br>
                        No. 20 & 21, Blok B, Bestari Centre<br>
                        Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman<br>
                        <table>
                            <tr>
                                <td>No. Tel: 09-622 8848</td>
                                <td>No.Faks: 09-623 8848</td>
                            </tr>
                            <tr>
                                <td>Email: aims@aimsglobal.com.my</td>
                                <td>Website: www.aimsglobal.com.my</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>

        <td style="width: 40%; vertical-align: middle;">
            <div class="title-box">PURCHASE REQUEST</div>
        </td>
    </tr>
</table>

<div class="line-break"></div>

{{-- REQUISITIONER & PROCUREMENT SECTION --}}
<table style="margin-top: 10px;">
    <tr>

        {{-- LEFT BOX --}}
        <td style="width: 50%; padding-right: 10px;">
            <div class="outer-box">
                <strong>REQUISITIONER (Staff making the request)</strong><hr><br>

                <table>
                    <tr><td class="row-label">Requested By:</td><td>{{ $pr->requestedBy->name ?? ' ' }}</td></tr>
                    <tr><td class="row-label">Position:</td><td>{{ $pr->requestedBy->position ?? '' }}</td></tr>
                    <tr><td class="row-label">Date:</td><td>{{ $pr->date->format('d/m/Y') ?? '' }}</td></tr>
                </table>

                <div class="line-break"></div>

                <table>
                    <tr><td class="row-label">Reference No:</td><td>{{ $pr->pr_no }}</td></tr>
                    <tr><td class="row-label">Item Request:</td><td>{{ $pr->item_req }}</td></tr>
                    <tr><td class="row-label">Title:</td><td>{{ $pr->title }}</td></tr>
                </table>
            </div>
        </td>

        {{-- RIGHT BOX --}}
        <td style="width: 50%;">
            <div class="outer-box">
                <strong>PROCUREMENT DEPARTMENT USE ONLY</strong><hr><br>

                <table>
                    <tr><td class="row-label">Received By: {{ $pr->proBy->name ?? '' }}</td><td></td></tr>
                    <tr><td class="row-label">Position: {{ $pr->proBy->position ?? '' }}</td><td></td></tr>
                    <tr><td class="row-label">Date:</td><td></td></tr>
                </table>

                <div class="line-break"></div>

                <table>
                    <tr>
                        <td class="row-label">Status:</td>
                        <td>
                            <strong>
                                @if ($pr->status == "OPEN")
                                    OPEN
                                @elseif ($pr->status == "CLOSE")
                                    CLOSE
                                @endif
                            </strong>
                        </td>
                    </tr>
                </table>

            </div>
        </td>

    </tr>
</table>

<br>

{{-- SUMMARY --}}
<div style="border:1px solid #000; padding:6px 10px; display:inline-block; margin-bottom:8px;">
    <strong>SUMMARY OF PURCHASE REQUEST</strong>
</div>

<table border="1" style="margin-top: 5px;">
    <thead style="background:#d1d5db; height:30px">
    <tr>
        <th style="width: 15%;">ITEM</th>
        <th style="width: 50%;">DESCRIPTION</th>
        <th style="width: 15%;">QUANTITY</th>
        <th style="width: 20%;">REMARK</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($pr->pr_items as $item)
        <tr>
            <td class="summary">{{ $loop->iteration }}</td>
            <td class="summary">{{ $item['description'] }} </td>
            <td class="summary">{{ $item['quantity'] }} {{ $item['unit'] }}</td>
            <td class="summary">{{ $item['remark'] }}</td>
        </tr>
    @empty
        <tr>
            <td class="summary" colspan="4" style="text-align: center;">
                No items in this request
            </td>
        </tr>
    @endforelse
    </tbody>

</table>

<br><br>

<div class="signature-section">
    <table class="signature-table">
        <!-- LABEL ROW -->
        <tr>
            <td class="signature-label">PREPARED BY:</td>
            <td class="signature-label">CONFIRMED BY:</td>
            <td class="signature-label">APPROVED BY:</td>
        </tr>

        <!-- SIGNATURE LINE ROW -->
        <tr>
            <td><div class="signature-line"></div></td>
            <td><div class="signature-line"></div></td>
            <td><div class="signature-line"></div></td>
        </tr>

        <!-- NAME ROW -->
        <tr>
            <td class="signature-detail">
                Name: <strong>{{ $pr->requestedBy->name ?? '' }}</strong>
            </td>
            <td class="signature-detail">
                Name: <strong>{{ $pr->confirmedBy->name ?? '' }}</strong>
            </td>
            <td class="signature-detail">
                Name:
                <strong>
                    {{ $pr->approvedBy->name ?? '' }}
                </strong>
            </td>
        </tr>

        <!-- POSITION ROW -->
        <tr>
            <td class="signature-detail">
                Position: {{ $pr->requestedBy->position ?? ' ' }}
            </td>
            <td class="signature-detail">
                Position: {{ $pr->checkedBy->position ?? ' ' }}
            </td>
            <td class="signature-detail">
                Position: {{ $pr->approvedBy->position ?? '' }}
            </td>
        </tr>

        <!-- DATE ROW -->
        <tr>
            <td class="signature-detail">
                Date: {{ optional($pr->requested_at)->format('d/m/Y') }}
            </td>
            <td class="signature-detail">
                Date: {{ optional($pr->confirmed_at)->format('d/m/Y') }}
            </td>
            <td class="signature-detail">
                Date: {{ optional($pr->approved_at)->format('d/m/Y') }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
