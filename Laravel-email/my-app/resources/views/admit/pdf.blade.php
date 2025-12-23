<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Acknowledgement Slip</title>
    <style>
        @page {
            margin: 30px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-decoration: underline;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: bold;
        }
        .top-section {
            margin-bottom: 20px;
        }
        .unit-roll-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .unit-box {
            display: table-cell;
            border: 2px solid #000;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 12px;
            width: 100px;
        }
        .roll-box {
            display: table-cell;
            border: 2px solid #000;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            padding-left: 100px;
        }
        .roll-digits {
            display: inline-block;
            letter-spacing: 8px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }
        .info-right {
            display: table-cell;
            width: 40%;
            text-align: right;
            vertical-align: top;
        }
        .photo-box {
            border: 2px solid #000;
            width: 110px;
            height: 130px;
            display: inline-block;
            text-align: center;
            overflow: hidden;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .info-item {
            margin: 6px 0;
            font-size: 11px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px 8px;
            font-size: 11px;
        }
        th {
            background-color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: left;
        }
        .center {
            text-align: center;
        }
        .subject-header {
            text-align: center;
            font-weight: bold;
            margin: 20px 0 10px 0;
            font-size: 12px;
            text-decoration: underline;
        }
        .note-box {
            border: 2px solid #000;
            padding: 12px;
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            line-height: 1.5;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(200, 200, 200, 0.15);
            z-index: -1;
            font-weight: bold;
            letter-spacing: 10px;
        }
    </style>
</head>
<body>
    <div class="watermark">MBSTU</div>
    
    <div class="header">
        <h2>Undergraduate Admission {{ date('Y') }}-{{ date('y', strtotime('+1 year')) }}</h2>
        <h3>Acknowledgement Slip</h3>
    </div>

    <div class="unit-roll-row">
        <div class="unit-box">UNIT &nbsp;&nbsp;&nbsp; {{ $data['unit'] }}</div>
        <div class="roll-box">GST ROLL: <span class="roll-digits">@foreach(str_split($data['gst_roll']) as $digit){{ $digit }}@endforeach</span></div>
    </div>

    <div class="info-row">
        <div class="info-left">
            <div class="info-item">
                <span class="info-label">Candidate:</span> {{ strtoupper($data['candidate_name']) }}
            </div>
            <div class="info-item">
                <span class="info-label">Father:</span> {{ strtoupper($data['father_name']) }}
            </div>
            <div class="info-item">
                <span class="info-label">Mother:</span> {{ strtoupper($data['mother_name']) }}
            </div>
            <div class="info-item">
                <span class="info-label">Quota:</span> {{ $data['quota'] }}
            </div>
            <div class="info-item">
                <span class="info-label">Last Modified:</span> {{ date('Y-m-d H:i:s') }}
            </div>
        </div>
        <div class="info-right">
            <div class="photo-box">
                @if(isset($data['photo']))
                    <img src="{{ $data['photo'] }}" alt="Photo">
                @endif
            </div>
        </div>
    </div>

    @if(isset($data['pending_bill_no']) || isset($data['paid_bill_no']))
    <table>
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">Bill No.</th>
                <th style="text-align: center;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data['pending_bill_no']))
            <tr>
                <td width="20%" style="font-weight: bold;">Pending</td>
                <td width="50%">{{ $data['pending_bill_no'] }}</td>
                <td width="30%" style="text-align: center;">{{ $data['pending_amount'] ?? '' }}</td>
            </tr>
            @endif
            @if(isset($data['paid_bill_no']))
            <tr>
                <td width="20%" style="font-weight: bold;">Paid</td>
                <td width="50%">{{ $data['paid_bill_no'] }}</td>
                <td width="30%" style="text-align: center;">{{ $data['paid_amount'] ?? '' }}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif

    <div class="subject-header">Subject Choice Order</div>
    <table>
        <thead>
            <tr>
                <th width="80%">Subject</th>
                <th width="20%" class="center">Choice</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['subjects'] as $subject => $choice)
                @if($choice)
                <tr>
                    <td>{{ $subject }}</td>
                    <td class="center">{{ $choice }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="note-box">
        <strong>Pay your bill using DBBL Mobile banking (Rocket).</strong><br>
        Please visit "Payment Instruction" page on the website for detail instruction.
    </div>
</body>
</html>
