<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $order_id_formatted }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }

        .invoice-container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Header */
        .invoice-header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px dashed #ccc;
            margin-bottom: 15px;
        }

        .invoice-header h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .invoice-header p {
            font-size: 11px;
            color: #666;
        }

        /* Section */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            margin-bottom: 8px;
        }

        /* Row */
        .row {
            display: table;
            width: 100%;
            padding: 4px 0;
        }

        .row .label {
            display: table-cell;
            width: 40%;
            color: #666;
        }

        .row .value {
            display: table-cell;
            width: 60%;
            text-align: right;
            font-weight: 600;
        }

        /* Product Table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .product-table th {
            text-align: left;
            font-size: 10px;
            color: #888;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .product-table th:last-child {
            text-align: right;
        }

        .product-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: top;
        }

        .product-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .product-meta {
            font-size: 10px;
            color: #888;
        }

        /* Total */
        .total-row {
            padding-top: 10px;
            margin-top: 5px;
            border-top: 2px solid #222;
        }

        .total-row .label,
        .total-row .value {
            font-size: 14px;
            font-weight: bold;
            color: #1a7a3e;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #ccc;
            text-align: center;
        }

        .invoice-footer p {
            font-size: 10px;
            color: #888;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-declined {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <h1>SIPETA</h1>
            <p>Sistem Informasi Pertanian</p>
            <p style="margin-top: 10px; font-size: 14px; font-weight: bold;">INVOICE</p>
        </div>

        <!-- Info Pesanan -->
        <div class="section">
            <div class="section-title">Informasi Pesanan</div>
            <div class="row">
                <span class="label">ID Pesanan</span>
                <span class="value">{{ $order_id_formatted }}</span>
            </div>
            <div class="row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $order_date }}</span>
            </div>
        </div>

        <!-- Produk -->
        <div class="section">
            <div class="section-title">Produk</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <div class="product-name">{{ $item['name'] }}</div>
                                <div class="product-meta">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }} / {{ $item['unit_symbol'] }} ×
                                    {{ $item['quantity'] }}
                                </div>
                            </td>
                            <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Alamat Pengiriman -->
        <div class="section">
            <div class="section-title">Alamat Pengiriman</div>
            <div class="row">
                <span class="label">Nama</span>
                <span class="value">{{ $shipping['name'] }}</span>
            </div>
            <div class="row">
                <span class="label">Telepon</span>
                <span class="value">{{ $shipping['phone'] }}</span>
            </div>
            <div class="row">
                <span class="label">Alamat</span>
                <span class="value">{{ $shipping['address'] }}</span>
            </div>
            <div class="row">
                <span class="label">Kota</span>
                <span class="value">{{ $shipping['city'] }}, {{ $shipping['state'] }} {{ $shipping['zip'] }}</span>
            </div>
        </div>

        <!-- Pembayaran -->
        <div class="section">
            <div class="section-title">Pembayaran</div>
            <div class="row">
                <span class="label">Metode</span>
                <span class="value">{{ $payment['method'] }}</span>
            </div>
            <div class="row">
                <span class="label">Status</span>
                <span class="value">
                    @if ($payment['status'] == 'approved')
                        <span class="status-badge status-approved">Lunas</span>
                    @elseif($payment['status'] == 'declined')
                        <span class="status-badge status-declined">Ditolak</span>
                    @else
                        <span class="status-badge status-pending">Menunggu</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="section">
            <div class="section-title">Ringkasan Pembayaran</div>
            <div class="row">
                <span class="label">Subtotal</span>
                <span class="value">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span class="label">Pajak</span>
                <span class="value">Rp {{ number_format($summary['tax'], 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span class="label">Diskon</span>
                <span class="value">-Rp {{ number_format($summary['discount'], 0, ',', '.') }}</span>
            </div>
            <div class="row total-row">
                <span class="label">Total</span>
                <span class="value">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p>Terima kasih telah berbelanja di SIPETA!</p>
            <p>Dari Petani, Untuk Indonesia</p>
        </div>
    </div>
</body>

</html>
