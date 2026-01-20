<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan SIPETA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            background: #fff;
            line-height: 1.5;
        }

        .page-container {
            padding: 30px 40px;
        }

        /* Header Section */
        .header {
            text-align: center;
            padding-bottom: 25px;
            border-bottom: 3px solid #1a7a3e;
            margin-bottom: 30px;
        }

        .header-logo {
            margin-bottom: 10px;
        }

        .header-logo img {
            width: 80px;
            height: 80px;
        }

        .header-title {
            font-size: 28px;
            font-weight: bold;
            color: #1a7a3e;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .header-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
            padding: 8px 20px;
            background-color: #e8f5e9;
            display: inline-block;
            border-radius: 5px;
        }

        .report-date {
            font-size: 11px;
            color: #888;
            margin-top: 10px;
        }

        /* Summary Section */
        .summary-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1a7a3e;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #c8e6c9;
        }

        .summary-grid {
            width: 100%;
        }

        .summary-grid td {
            width: 33.33%;
            padding: 10px;
            vertical-align: top;
        }

        .summary-card {
            background-color: #f1f8e9;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border: 1px solid #c8e6c9;
        }

        .summary-card.highlight {
            background-color: #1a7a3e;
            color: white;
        }

        .summary-card.highlight .card-label,
        .summary-card.highlight .card-value {
            color: white;
        }

        .card-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .card-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 20px;
            font-weight: bold;
            color: #1a7a3e;
        }

        /* Monthly Data Section */
        .monthly-section {
            margin-bottom: 30px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table th {
            background-color: #1a7a3e;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table th:first-child {
            border-radius: 8px 0 0 0;
        }

        .data-table th:last-child {
            border-radius: 0 8px 0 0;
        }

        .data-table td {
            padding: 10px 8px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            font-size: 11px;
        }

        .data-table tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .data-table tr:hover {
            background-color: #e8f5e9;
        }

        .data-table .total-row {
            background-color: #e8f5e9;
            font-weight: bold;
        }

        .data-table .total-row td {
            border-top: 2px solid #1a7a3e;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .currency {
            font-family: 'DejaVu Sans', monospace;
        }

        /* Recent Orders Section */
        .orders-section {
            margin-bottom: 30px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }

        .orders-table th {
            background-color: #1a7a3e;
            color: white;
            padding: 10px 6px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }

        .orders-table td {
            padding: 8px 6px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .orders-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #c8e6c9;
            color: #1b5e20;
        }

        .badge-warning {
            background-color: #fff3e0;
            color: #e65100;
        }

        .badge-danger {
            background-color: #ffebee;
            color: #c62828;
        }

        /* Footer Section */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
        }

        .footer-logo {
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 10px;
            color: #888;
        }

        .footer-brand {
            font-weight: bold;
            color: #1a7a3e;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Header -->
        <div class="header">
            <div class="header-logo">
                <svg width="80" height="80" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="#1a7a3e" />
                    <text x="50" y="55" text-anchor="middle" fill="white" font-size="14"
                        font-weight="bold">SIPETA</text>
                    <path d="M30 35 Q50 20 70 35 Q60 50 50 45 Q40 50 30 35" fill="#4caf50" opacity="0.7" />
                </svg>
            </div>
            <div class="header-title">SIPETA</div>
            <div class="header-subtitle">Sistem Informasi Perdagangan dan Pertanian</div>
            <div class="report-title">LAPORAN DASHBOARD ADMIN</div>
            <div class="report-date">Dicetak pada: {{ $generatedAt }}</div>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="section-title">📊 Ringkasan Statistik</div>
            <table class="summary-grid">
                <tr>
                    <td>
                        <div class="summary-card">
                            <div class="card-label">Total Pesanan</div>
                            <div class="card-value">{{ number_format($dashboardDatas[0]->Total) }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="summary-card highlight">
                            <div class="card-label">Total Pendapatan</div>
                            <div class="card-value currency">Rp
                                {{ number_format($dashboardDatas[0]->TotalAmount, 0, ',', '.') }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="summary-card">
                            <div class="card-label">Pesanan Terkirim</div>
                            <div class="card-value">{{ number_format($dashboardDatas[0]->TotalDelivered) }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-top: 10px;">
                        <div class="summary-card highlight" style="text-align: center;">
                            <div class="card-label">Nilai Pesanan Terkirim</div>
                            <div class="card-value currency">Rp
                                {{ number_format($dashboardDatas[0]->TotalDeliveredAmount, 0, ',', '.') }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Monthly Revenue Section -->
        <div class="monthly-section">
            <div class="section-title">📈 Pendapatan Bulanan ({{ date('Y') }})</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Pendapatan</th>
                        <th>Nilai Terkirim</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                        $grandDelivered = 0;
                    @endphp
                    @foreach ($monthlyDatas as $data)
                        <tr>
                            <td>{{ $data->MonthName }}</td>
                            <td class="currency">Rp {{ number_format($data->TotalAmount, 0, ',', '.') }}</td>
                            <td class="currency">Rp {{ number_format($data->TotalDeliveredAmount, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $grandTotal += $data->TotalAmount;
                            $grandDelivered += $data->TotalDeliveredAmount;
                        @endphp
                    @endforeach
                    <tr class="total-row">
                        <td><strong>TOTAL</strong></td>
                        <td class="currency"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                        <td class="currency"><strong>Rp {{ number_format($grandDelivered, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Recent Orders Section -->
        <div class="orders-section">
            <div class="section-title">🛒 Pesanan Terbaru</div>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders->take(10) as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td class="currency">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($order->status == 'delivered')
                                    <span class="badge badge-success">Terkirim</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge badge-danger">Dibatalkan</span>
                                @else
                                    <span class="badge badge-warning">Dipesan</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->orderItems->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                <span class="footer-brand">© {{ date('Y') }} SIPETA</span> - Sistem Informasi Perdagangan dan
                Pertanian
            </div>
            <div class="footer-text" style="margin-top: 5px;">
                Laporan ini digenerate secara otomatis pada {{ $generatedAt }}
            </div>
        </div>
    </div>
</body>

</html>
