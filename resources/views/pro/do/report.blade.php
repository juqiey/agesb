<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>DELIVERY ORDER</title>

    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            margin: 20px 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 2px;
            line-height: 1.2;
        }

        .company-name {
            font-size: 15px;
            font-weight: bold;
            line-height: 1.2;
        }

        .address {
            line-height: 1.2;
        }

        .contact-table td {
            padding: 1px 0;
            line-height: 1.2;
        }

        img.logo {
            width: 90px;
        }

        .do-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 8px 0;
        }

        .order-details-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 10px;
        }

        .order-details-table td {
            padding: 4px 5px;
            vertical-align: top;
            line-height: 1.2;
        }

        .center-divider {
            border-left: 1px solid #000;
        }

        .label {
            font-weight: bold;
        }

        .value {
        }


        .content-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 8px;
        }

        .content-table th {
            background-color: #d3d3d3; /* light gray */
            font-weight: bold;
            padding: 6px 5px;
            text-align: center;
            border: 1px solid #000;
        }

        .content-table td {
            padding: 4px 5px;
            vertical-align: middle;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
        }

        .content-table .first-row td {
            height: 28px; /* taller first row */
        }

        .content-table .default-row td {
            height: 20px; /* default row height */
        }

        .content-table .footer-row td {
            border: 1px solid #000; /* full border */
            font-weight: bold;
            text-align: right;
            padding: 5px;
        }

        /* Column widths */
        .col-1 { width: 5%; }
        .col-2 { width: 55%; }
        .col-3 { width: 5%; }
        .col-4 { width: 10%; }
        .col-5 { width: 10%; }
        .col-6 { width: 15%; }

        .signature-container {
            position: absolute;
            bottom: 60px; /* distance from bottom of page */
            width: 100%;
        }

        .signature-table {
            width: 100%;
            border: 1px solid #000; /* outer border only */
            border-collapse: collapse;
            font-size: 10px;
            table-layout: fixed;
        }

        .signature-table td {
            vertical-align: top;
            padding: 5px;
            text-align: center;
        }

        .signature-table td + td {
            border-left: 1px solid #000; /* vertical separator between columns */
        }

        .signature-label {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .signature-space {
            height: 60px; /* space for signature */
        }

        .signature-name,
        .signature-date {
            margin-top: 2px;
        }

        .note-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px; /* very small text */
            margin-top: 5px;
        }

        .note-table td {
            padding: 2px 3px;
            vertical-align: top;
        }


    </style>
</head>

<body>

<!-- Organization Header -->
<table class="header-table">
    <tr>
        <!-- Logo -->
        <td width="15%">
            <img class="logo" src="{{ public_path('img/agesb_logo.png') }}">
        </td>

        <!-- Company Info -->
        <td width="85%">
            <table>
                <tr>
                    <td class="company-name">
                        Aims-Global Ship Management Sdn Bhd (1490217-V)
                    </td>
                </tr>

                <tr>
                    <td class="address">
                        No.20 & 21, Block B, Bestari Centre,
                        <br>
                        Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="contact-table">
                            <tr>
                                <td width="50%">No. Tel: : 09-622 8848</td>
                                <td width="50%">Email : aims@aimsglobal.com.my</td>
                            </tr>
                            <tr>
                                <td>No. Faks: 09-623 8848</td>
                                <td>Website: www.aimsglobal.com.my</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- DELIVERY ORDER Title -->
<div class="do-title">DELIVERY ORDER</div>

<!-- Order Details -->
<table class="order-details-table">

    <tr>
        <!-- LEFT SIDE (40%) -->
        <td class="label" style="width: 10%">To :</td>
        <td class="value" style="width: 40%">
            {{ $do->do_recipient ?? '-' }}
        </td>

        <!-- CENTER DIVIDER -->
        <td class="label center-divider" style="width: 10%">DO No :</td>

        <!-- RIGHT SIDE (60%) -->
        <td class="value" style="width: 40%">
            {{ $do->do_no ?? '-' }}
        </td>
    </tr>

    <tr>
        <td class="label" rowspan="2">Location:</td>
        <td class="value" rowspan="2">
            {{ $do->location ?? '-' }}
        </td>
        <td class="label center-divider">Delivery Date:</td>
        <td class="value">
            {{ $do->date->format('d/m/Y') ?? '-' }}
        </td>
    </tr>

    <tr>
        <td class="label center-divider">Job No :</td>
        <td class="value">
            {{ $do->job_no ?? '-' }}
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="value"></td>
        <td class="label center-divider"></td>
        <td class="value"></td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="value"></td>

        <td class="label center-divider"></td>
        <td class="value">

        </td>
    </tr>

</table>

<!-- Content Table -->
<table class="content-table">

    <!-- Table Header -->
    <thead>
    <tr>
        <th class="col-1">ITEM NO.</th>
        <th class="col-2">DESCRIPTION</th>
        <th class="col-3">UNIT</th>
        <th class="col-4">QUANTITY</th>
        <th class="col-5">UNIT PRICE</th>
        <th class="col-6">TOTAL PRICE</th>
    </tr>
    </thead>

    <!-- Table Body -->
    <tbody>
    <!-- First row (taller) -->
    <tr class="first-row">
        <td></td>
        <td style="font-weight: bolder; text-decoration: underline ">
            VESSEL NAME: {{ $do->vessel }}
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <!-- Default row -->
    <tr class="default-row">
        <td></td>
        <td style="font-weight: bolder; text-decoration: underline ">
            SUBJECT: TO SUPPLY ITEMS AS BELOW:
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    @foreach($do->pr_items as $pr_items)
        <tr class="default-row">
            <td></td>
            <td>
                {{ $pr_items->description }}
            </td>
            <td>
                {{ $pr_items->unit }}
            </td>
            <td style="text-align: center">
                {{ $pr_items->quantity_pro }}
            </td>
            <td style="text-align: center">
                RM{{ $pr_items->unit_price }}
            </td>
            <td style="text-align: center">
                RM{{ $pr_items->total_price }}
            </td>
        </tr>
    @endforeach

    @foreach($do->ssr_items as $ssr_items)
        <tr class="default-row">
            <td></td>
            <td>
                {{ $ssr_items->description }}
            </td>
            <td>
                {{ $ssr_items->unit }}
            </td>
            <td style="text-align: center">
                {{ $ssr_items->quantity_pro }}
            </td>
            <td style="text-align: center">
                RM{{ $ssr_items->unit_price }}
            </td>
            <td style="text-align: center">
                RM{{ $ssr_items->total_price }}
            </td>
        </tr>
    @endforeach

    <!-- Add more rows as needed -->
    </tbody>

    <!-- Table Footer -->
    <tfoot>
    <tr class="footer-row">
        <td colspan="4"></td>
        <td style="font-weight: bold">TOTAL</td>
        <td style="font-weight: bold; text-align: center">
            RM{{ $do->total }}
        </td>
    </tr>
    </tfoot>

</table>

<!-- Signature Section Fixed at Bottom -->
<div class="signature-container">
    <table class="signature-table">
        <tr>
            <!-- Authorized By -->
            <td style="width: 30%">
                <div class="signature-label">AUTHORIZATION</div>
                <div class="signature-space"></div>
                <div class="signature-name" style="text-align: left">AUTHORISE SIGNED</div>
                <div class="signature-date" style="text-align: left">DATE: {{$do->date->format('d/m/Y')}}</div>
            </td>

            <!-- Customer -->
            <td style="width: 70%">
                <div class="signature-label">RECEIVED BY</div>
                <div class="signature-space"></div>
                <div class="signature-name" style="text-align: left">CUSTOMER CHOP & SIGN</div>
                <div class="signature-date" style="text-align: left">DATE: </div>
            </td>
        </tr>
    </table>

    <!-- Small Note Section -->
    <table class="note-table">
        <tr>
                <td>NOTE:</td>
        </tr>
        <tr>
            <td>1) In case of any discrepancies, please inform us in writing within seven (7) days upon receipt of no goods. If no remarks are made within seven (7) days, account will be considered as correct.</td>
        </tr>
        <tr>
            <td>2) Risk of damages to or loss of the goods shall pass to you upon delivery of the goods.</td>
        </tr>
    </table>
</div>

</body>
</html>
