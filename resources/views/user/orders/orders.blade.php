@extends('layouts.app')

@section('content')
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Pesanan Saya'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Pesanan Saya</h2>

            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10 user-content">
                    <div class="base-card">
                        <div class="card-header-main">
                            <h3>Pesanan ({{ $orders->total() }})</h3>
                            <div class="filter-sort">
                                <span>Urutkan berdasarkan:</span>
                                <select>
                                    <option value="semua">Semua</option>
                                    <option value="proses">Diproses</option>
                                    <option value="terkirim">Terkirim</option>
                                </select>
                            </div>
                        </div>

                        @forelse ($orders as $order)
                            <div class="order-card-item">
                                {{-- Yellow Bar Header --}}
                                <div class="order-card-header">
                                    <div class="bar-item">
                                        <span class="label">ID Pesanan</span>
                                        <span
                                            class="value">SPT{{ $order->created_at->format('ymd') }}{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="bar-item">
                                        <span class="label">Total</span>
                                        <span class="value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="bar-item">
                                        <span class="label">Metode</span>
                                        <span class="value">
                                            @if ($order->transaction)
                                                @if ($order->transaction->mode == 'midtrans')
                                                    @if ($order->transaction->payment_type)
                                                        @php
                                                            $p_type = $order->transaction->payment_type;
                                                            $p_data = json_decode(
                                                                $order->transaction->payment_data,
                                                                true,
                                                            );
                                                            $specific_method = '';

                                                            if (
                                                                $p_type == 'bank_transfer' &&
                                                                isset($p_data['va_numbers'][0]['bank'])
                                                            ) {
                                                                $specific_method =
                                                                    strtoupper($p_data['va_numbers'][0]['bank']) .
                                                                    ' VA';
                                                            } elseif (
                                                                $p_type == 'bank_transfer' &&
                                                                isset($p_data['permata_va_number'])
                                                            ) {
                                                                $specific_method = 'PERMATA VA';
                                                            } elseif ($p_type == 'qris') {
                                                                $specific_method = 'QRIS';
                                                            } elseif ($p_type == 'gopay') {
                                                                $specific_method = 'GOPAY';
                                                            } elseif ($p_type == 'shopeepay') {
                                                                $specific_method = 'SHOPEEPAY';
                                                            } elseif ($p_type == 'cstore') {
                                                                $specific_method = strtoupper(
                                                                    $p_data['store'] ?? 'Mini Market',
                                                                );
                                                            } elseif ($p_type == 'echannel') {
                                                                $specific_method = 'MANDIRI BILL';
                                                            } else {
                                                                $specific_method = str_replace(
                                                                    '_',
                                                                    ' ',
                                                                    strtoupper($p_type),
                                                                );
                                                            }
                                                        @endphp
                                                        {{ $specific_method }}
                                                    @else
                                                        Midtrans
                                                    @endif
                                                @else
                                                    {{ strtoupper($order->transaction->mode) }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="bar-item">
                                        @if ($order->status == 'delivered')
                                            <span class="label">Diterima</span>
                                            <span
                                                class="value">{{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d/m/Y') : $order->updated_at->format('d/m/Y') }}</span>
                                        @else
                                            <span class="label">Estimasi</span>
                                            <span
                                                class="value">{{ $order->created_at->addDays(5)->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Body / Products List --}}
                                <div class="order-card-body">
                                    @foreach ($order->orderItems as $item)
                                        <div class="order-product-item">
                                            <div class="product-image">
                                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}">
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                    class="name">{{ $item->product->name }}</a>
                                                <div class="details">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }} /
                                                    {{ $item->unit_symbol ?: $item->unit->symbol ?? 'Satuan' }}
                                                    <span class="ms-2">x {{ $item->quantity }}</span>
                                                    {{-- <span class="ms-2 fw-bold text-dark">(Rp
                                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }})</span> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Footer / Status & Actions --}}
                                <div class="order-card-footer">
                                    <div class="status-info">
                                        @if ($order->returnRequest)
                                            {{-- Return Request Status --}}
                                            @php
                                                $returnBadgeClass = '';
                                                $returnStatusLabel = '';
                                                $returnStatusNote = '';
                                                switch ($order->returnRequest->status) {
                                                    case 'pending':
                                                        $returnBadgeClass = 'bg-return-pending';
                                                        $returnStatusLabel = 'Menunggu Pengajuan';
                                                        $returnStatusNote = 'Pengajuan pengembalian sedang ditinjau';
                                                        break;
                                                    case 'approved':
                                                        $returnBadgeClass = 'bg-return-approved';
                                                        $returnStatusLabel = 'Return Disetujui';
                                                        $returnStatusNote = 'Pengajuan pengembalian telah disetujui';
                                                        break;
                                                    case 'rejected':
                                                        $returnBadgeClass = 'bg-return-rejected';
                                                        $returnStatusLabel = 'Return Ditolak';
                                                        $returnStatusNote = 'Pengajuan pengembalian ditolak';
                                                        break;
                                                    case 'completed':
                                                        $returnBadgeClass = 'bg-return-completed';
                                                        $returnStatusLabel = 'Return Selesai';
                                                        $returnStatusNote = 'Proses pengembalian telah selesai';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $returnBadgeClass }}">{{ $returnStatusLabel }}</span>
                                            <span class="status-text">{{ $returnStatusNote }}</span>
                                        @else
                                            {{-- Regular Order Status --}}
                                            @php
                                                $badgeClass = '';
                                                $statusLabel = '';
                                                $statusNote = '';

                                                switch ($order->status) {
                                                    case 'delivered':
                                                        $badgeClass = 'bg-delivered';
                                                        $statusLabel = 'Terkirim';
                                                        $statusNote = 'Pesanan Anda telah Terkirim';
                                                        break;
                                                    case 'canceled':
                                                        $badgeClass = 'bg-canceled';
                                                        $statusLabel = 'Dibatalkan';
                                                        $statusNote = 'Pesanan ini telah dibatalkan';
                                                        break;
                                                    case 'processing':
                                                    case 'approved':
                                                        $badgeClass = 'bg-processing';
                                                        $statusLabel = 'Diproses';
                                                        $statusNote = 'Pesanan Anda sedang Diproses';
                                                        break;
                                                    case 'ordered':
                                                    case 'pending':
                                                    default:
                                                        $badgeClass = 'bg-processing';
                                                        $statusLabel = 'Dikemas';
                                                        $statusNote = 'Pesanan Anda sedang Dikemas';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                            <span class="status-text">{{ $statusNote }}</span>
                                        @endif
                                    </div>

                                    <div class="action-btns">
                                        @if ($order->status == 'delivered' && !$order->returnRequest)
                                            <a href="#" class="btn btn-review">Tambah Review</a>
                                        @endif

                                        @if ($order->status == 'delivered' && !$order->returnRequest)
                                            <a href="{{ route('user.order.return', $order->id) }}" class="btn btn-return">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                                    <path d="M3 12h18M3 12l6-6M3 12l6 6" />
                                                </svg>
                                                Return
                                            </a>
                                        @elseif ($order->status != 'delivered')
                                            <a href="{{ route('order.status', $order->id) }}" class="btn btn-track">Lacak
                                                Pesanan</a>
                                        @endif
                                        <button type="button" class="btn btn-invoice"
                                            data-order-id="{{ $order->id }}">Invoice</button>

                                        @if ($order->status != 'delivered' && $order->status != 'canceled')
                                            <form action="{{ route('user.order.cancel', $order->id) }}" method="POST"
                                                class="d-inline cancel-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-cancel"
                                                    onclick="confirmCancel(this)">Batalkan</button>
                                            </form>
                                        @endif

                                        @if ($order->status == 'canceled')
                                            <form action="{{ route('user.order.delete', $order->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete"
                                                    onclick="confirmDeleteOrder(this)">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted">Anda belum memiliki pesanan.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary">Mulai Belanja</a>
                            </div>
                        @endforelse

                        <div class="wgp-pagination">
                            <x-table-pagination :paginator="$orders" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Invoice Modal --}}
        <div class="invoice-modal-overlay" id="invoiceModalOverlay">
            <div class="invoice-modal">
                <div class="invoice-modal__header">
                    <h3>Detail Transaksi</h3>
                    <button type="button" class="close-btn" id="closeInvoiceModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <hr class="invoice-modal__separator">
                <div class="invoice-modal__body" id="invoiceModalBody">
                    {{-- Content akan di-load via JavaScript --}}
                    <div class="invoice-modal__loading">
                        <div class="spinner"></div>
                        <span>Memuat data...</span>
                    </div>
                </div>
                <div class="invoice-modal__footer" id="invoiceModalFooter" style="display: none;">
                    <button type="button" class="btn-print" id="btnPrintInvoice">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                            <rect x="6" y="14" width="12" height="8" />
                        </svg>
                        Cetak
                    </button>
                    <a href="#" class="btn-export" id="btnExportPdf">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function confirmCancel(button) {
            const orderId = button.closest('.order-card-item').querySelector('.order-card-header .bar-item .value')
                .textContent;
            if (typeof ModalUtils !== 'undefined') {
                ModalUtils.showDelete(
                    orderId,
                    'Pesanan',
                    function() {
                        button.closest('form').submit();
                    }
                );
            } else {
                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ' + orderId + '?')) {
                    button.closest('form').submit();
                }
            }
        }

        function confirmDeleteOrder(button) {
            const orderId = button.closest('.order-card-item').querySelector('.order-card-header .bar-item .value')
                .textContent;
            if (typeof ModalUtils !== 'undefined') {
                ModalUtils.showDelete(
                    orderId,
                    'Pesanan dari Riwayat',
                    function() {
                        button.closest('form').submit();
                    }
                );
            } else {
                if (confirm('Apakah Anda yakin ingin menghapus pesanan ' + orderId + ' dari riwayat?')) {
                    button.closest('form').submit();
                }
            }
        }

        // =============================================
        // INVOICE MODAL FUNCTIONALITY
        // =============================================
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('invoiceModalOverlay');
            const modalBody = document.getElementById('invoiceModalBody');
            const closeBtn = document.getElementById('closeInvoiceModal');

            // Format currency
            function formatRupiah(amount) {
                return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            }

            // Get status badge class
            function getStatusBadge(status) {
                const statusMap = {
                    'approved': {
                        class: 'status-badge--approved',
                        label: 'Lunas'
                    },
                    'pending': {
                        class: 'status-badge--pending',
                        label: 'Menunggu'
                    },
                    'declined': {
                        class: 'status-badge--declined',
                        label: 'Ditolak'
                    },
                };
                const s = statusMap[status] || statusMap['pending'];
                return `<span class="status-badge ${s.class}">${s.label}</span>`;
            }

            // Render modal content
            function renderInvoiceContent(data) {
                let productsHtml = '';
                data.items.forEach(item => {
                    const imgSrc = item.image.startsWith('http') ?
                        item.image :
                        '{{ asset('uploads/products/thumbnails') }}/' + item.image;
                    productsHtml += `
                        <div class="invoice-modal__product">
                            <div class="product-image">
                                <img src="${imgSrc}" alt="${item.name}">
                            </div>
                            <div class="product-info">
                                <p class="name">${item.name}</p>
                                <span class="price-qty">${formatRupiah(item.price)} / ${item.unit_symbol} × ${item.quantity}</span>
                            </div>
                            <div class="product-subtotal">${formatRupiah(item.subtotal)}</div>
                        </div>
                    `;
                });

                return `
                    <!-- Info Pesanan -->
                    <div class="invoice-modal__section">
                        <h4 class="invoice-modal__section-title">Informasi Pesanan</h4>
                        <div class="invoice-modal__row">
                            <span class="label">ID Pesanan</span>
                            <span class="value">${data.order_id_formatted}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Tanggal Pesanan</span>
                            <span class="value">${data.order_date}</span>
                        </div>
                    </div>

                    <!-- Produk -->
                    <div class="invoice-modal__section">
                        <h4 class="invoice-modal__section-title">Produk</h4>
                        ${productsHtml}
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="invoice-modal__section">
                        <h4 class="invoice-modal__section-title">Alamat Pengiriman</h4>
                        <div class="invoice-modal__row">
                            <span class="label">Nama</span>
                            <span class="value">${data.shipping.name}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Telepon</span>
                            <span class="value">${data.shipping.phone}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Alamat</span>
                            <span class="value">${data.shipping.address}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Kota</span>
                            <span class="value">${data.shipping.city}, ${data.shipping.state} ${data.shipping.zip}</span>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    <div class="invoice-modal__section">
                        <h4 class="invoice-modal__section-title">Pembayaran</h4>
                        <div class="invoice-modal__row">
                            <span class="label">Metode</span>
                            <span class="value">${data.payment.method}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Status</span>
                            <span class="value">${getStatusBadge(data.payment.status)}</span>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="invoice-modal__section">
                        <h4 class="invoice-modal__section-title">Ringkasan Pembayaran</h4>
                        <div class="invoice-modal__row">
                            <span class="label">Subtotal</span>
                            <span class="value">${formatRupiah(data.summary.subtotal)}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Pajak</span>
                            <span class="value">${formatRupiah(data.summary.tax)}</span>
                        </div>
                        <div class="invoice-modal__row">
                            <span class="label">Diskon</span>
                            <span class="value">-${formatRupiah(data.summary.discount)}</span>
                        </div>
                        <div class="invoice-modal__row invoice-modal__row--total">
                            <span class="label">Total</span>
                            <span class="value">${formatRupiah(data.summary.total)}</span>
                        </div>
                    </div>
                `;
            }

            // Current order ID for buttons
            let currentOrderId = null;
            const modalFooter = document.getElementById('invoiceModalFooter');
            const btnPrint = document.getElementById('btnPrintInvoice');
            const btnExport = document.getElementById('btnExportPdf');

            // Open modal
            function openInvoiceModal(orderId) {
                currentOrderId = orderId;
                modalFooter.style.display = 'none';
                modalBody.innerHTML = `
                    <div class="invoice-modal__loading">
                        <div class="spinner"></div>
                        <span>Memuat data...</span>
                    </div>
                `;
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';

                // Fetch invoice data
                fetch(`/order/${orderId}/invoice`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            modalBody.innerHTML = `<p class="text-center text-danger">${data.error}</p>`;
                        } else {
                            modalBody.innerHTML = renderInvoiceContent(data);
                            // Show footer buttons
                            modalFooter.style.display = 'flex';
                            // Update export PDF link
                            btnExport.href = `/order/${orderId}/invoice/pdf`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        modalBody.innerHTML =
                            `<p class="text-center text-danger">Gagal memuat data. Silakan coba lagi.</p>`;
                    });
            }

            // Print functionality
            btnPrint.addEventListener('click', function() {
                // Create print window with modal content
                const printContent = modalBody.innerHTML;
                const printWindow = window.open('', '_blank', 'width=500,height=700');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Invoice</title>
                        <style>
                            * { margin: 0; padding: 0; box-sizing: border-box; }
                            body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
                            .invoice-modal__section { margin-bottom: 15px; }
                            .invoice-modal__section-title { font-size: 10px; font-weight: bold; text-transform: uppercase; color: #888; margin-bottom: 8px; }
                            .invoice-modal__row { display: flex; justify-content: space-between; padding: 4px 0; }
                            .invoice-modal__row .label { color: #666; }
                            .invoice-modal__row .value { font-weight: 600; text-align: right; }
                            .invoice-modal__row--total { border-top: 2px solid #222; padding-top: 8px; margin-top: 8px; }
                            .invoice-modal__row--total .label, .invoice-modal__row--total .value { font-size: 14px; font-weight: bold; color: #1a7a3e; }
                            .invoice-modal__product { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
                            .invoice-modal__product .product-image { display: none; }
                            .invoice-modal__product .product-info .name { font-weight: 600; margin-bottom: 2px; }
                            .invoice-modal__product .product-info .price-qty { font-size: 10px; color: #666; }
                            .invoice-modal__product .product-subtotal { font-weight: 600; }
                            .status-badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; }
                            .status-badge--approved { background: #d4edda; color: #155724; }
                            .status-badge--pending { background: #fff3cd; color: #856404; }
                            .status-badge--declined { background: #f8d7da; color: #721c24; }
                            @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
                        </style>
                    </head>
                    <body>
                        <div style="text-align: center; margin-bottom: 20px;">
                            <h1 style="font-size: 18px; letter-spacing: 2px;">SIPETA</h1>
                            <p style="font-size: 10px; color: #666;">Sistem Informasi Pertanian</p>
                            <p style="margin-top: 10px; font-size: 14px; font-weight: bold;">INVOICE</p>
                        </div>
                        ${printContent}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 250);
            });

            // Close modal
            function closeInvoiceModal() {
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Event Listeners
            document.querySelectorAll('.btn-invoice').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const orderId = this.dataset.orderId;
                    openInvoiceModal(orderId);
                });
            });

            closeBtn.addEventListener('click', closeInvoiceModal);

            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeInvoiceModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && overlay.classList.contains('show')) {
                    closeInvoiceModal();
                }
            });
        });
    </script>
@endpush
