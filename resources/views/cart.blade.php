@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Keranjang</h2>
            <div class="checkout-steps">
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Tas Belanja</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Periksa Daftar Barang Anda</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Tinjau dan Kirim Pesanan Anda</em>
                    </span>
                </a>
            </div>
            <div class="shopping-cart">
                @if ($items->count() > 0)
                    <div class="cart-table__wrapper">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Status Organic</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ Str::startsWith($item->options->image, 'http') ? $item->options->image : asset('uploads/products/thumbnails') . '/' . $item->options->image }}"
                                                    width="120" height="120" alt="{{ $item->name }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $item->name }}</h4>
                                                @if (isset($item->options->unit_name))
                                                    <p class="text-muted small mb-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                                            <rect x="2" y="2" width="20" height="8" rx="2"
                                                                ry="2"></rect>
                                                            <rect x="2" y="14" width="20" height="8" rx="2"
                                                                ry="2"></rect>
                                                            <line x1="6" y1="6" x2="6"
                                                                y2="6"></line>
                                                            <line x1="6" y1="18" x2="6"
                                                                y2="18"></line>
                                                        </svg>
                                                        Unit: {{ $item->options->unit_name }}
                                                        ({{ $item->options->unit_symbol }})
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                                @if (isset($item->options->unit_symbol))
                                                    <span class="text-muted small">/
                                                        {{ $item->options->unit_symbol }}</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $organicStatus = trim($item->model?->organic_status ?? '');
                                            @endphp
                                            @if (strtolower($organicStatus) == 'organik')
                                                <span class="badge bg-success">Organik</span>
                                            @elseif(strtolower($organicStatus) == 'non-organik')
                                                <span class="badge bg-danger">Non-Organik</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div
                                                class="qty-control position-relative d-flex align-items-center justify-content-center">
                                                <form method="POST"
                                                    action="{{ route('cart.qty.decrease', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-control__reduce"
                                                        style="border: none; background: transparent; cursor: pointer; font-size: 18px; padding: 5px 10px;">-</button>
                                                </form>

                                                <input type="number" name="quantity" value="{{ $item->qty }}"
                                                    min="1" class="qty-control__number text-center" readonly
                                                    style="width: 60px; border: 1px solid #ddd; padding: 5px; margin: 0 5px;">

                                                <form method="POST"
                                                    action="{{ route('cart.qty.increase', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-control__increase"
                                                        style="border: none; background: transparent; cursor: pointer; font-size: 18px; padding: 5px 10px;">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                class="remove-cart btn btn-sm btn-outline-danger delete-item"
                                                data-name="{{ $item->name }}" data-type="Cart Item"
                                                data-rowid="{{ $item->rowId }}">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Desktop Coupon & Clear (hidden on mobile) --}}
                        <div class="cart-table-footer cart-table-footer--desktop">
                            @if (!Session::has('coupon'))
                                <form action="{{ route('cart.coupon.apply') }}" method="POST"
                                    class="position-relative bg-body">
                                    @csrf
                                    <input class="form-control" type="text" name="coupon_code" placeholder="Kode Kupon"
                                        value="">
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                                        type="submit" value="Gunakan Kupon">
                                </form>
                            @else
                                <form action="{{ route('cart.coupon.remove') }}" method="POST"
                                    class="position-relative bg-body">
                                    @csrf
                                    @method('DELETE')
                                    <input class="form-control" type="text" name="coupon_code" placeholder="Kode Kupon"
                                        value="@if (Session::has('coupon')) {{ Session::get('coupon')['code'] }} Applied! @endif">
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                                        type="submit" value="Hapus Kupon">
                                </form>
                            @endif
                            <form action="{{ route('cart.empty') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-clear" type="submit">
                                    <i class="fa fa-trash me-2"></i>HAPUS KERANJANG
                                </button>
                            </form>
                        </div>

                        <div>
                            @if (Session::has('success'))
                                <p class="text-success">{{ Session::get('success') }}</p>
                            @elseif(Session::has('error'))
                                <p class="text-danger">{{ Session::get('error') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Mobile Card View (hidden on desktop, shown on mobile via CSS) --}}
                    <div class="cart-mobile-view" style="display: none;">
                        @foreach ($items as $item)
                            <div class="cart-item-mobile">
                                <div class="item-row">
                                    <div class="item-image">
                                        <img loading="lazy"
                                            src="{{ Str::startsWith($item->options->image, 'http') ? $item->options->image : asset('uploads/products/thumbnails') . '/' . $item->options->image }}"
                                            alt="{{ $item->name }}">
                                    </div>
                                    <div class="item-details">
                                        <h4>{{ $item->name }}</h4>
                                        @if (isset($item->options->unit_name))
                                            <p class="unit-info">
                                                Unit: {{ $item->options->unit_name }} ({{ $item->options->unit_symbol }})
                                            </p>
                                        @endif
                                        <p class="price">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                            @if (isset($item->options->unit_symbol))
                                                <span class="text-muted small">/ {{ $item->options->unit_symbol }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="item-meta">
                                    @php
                                        $organicStatus = trim($item->model?->organic_status ?? '');
                                    @endphp
                                    @if (strtolower($organicStatus) == 'organik')
                                        <span class="badge bg-success">Organik</span>
                                    @elseif(strtolower($organicStatus) == 'non-organik')
                                        <span class="badge bg-danger">Non-Organik</span>
                                    @endif
                                </div>

                                <div class="item-actions">
                                    <div class="qty-control">
                                        <form method="POST"
                                            action="{{ route('cart.qty.decrease', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="qty-control__reduce">-</button>
                                        </form>

                                        <input type="number" name="quantity" value="{{ $item->qty }}"
                                            min="1" class="qty-control__number" readonly>

                                        <form method="POST"
                                            action="{{ route('cart.qty.increase', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="qty-control__increase">+</button>
                                        </form>
                                    </div>

                                    <a href="javascript:void(0)"
                                        class="remove-cart btn btn-sm btn-outline-danger delete-item"
                                        data-name="{{ $item->name }}" data-type="Cart Item"
                                        data-rowid="{{ $item->rowId }}">
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Mobile Coupon & Clear (shown after cards on mobile, hidden on desktop) --}}
                    <div class="cart-table-footer cart-table-footer--mobile">
                        @if (!Session::has('coupon'))
                            <form action="{{ route('cart.coupon.apply') }}" method="POST"
                                class="position-relative bg-body">
                                @csrf
                                <input class="form-control" type="text" name="coupon_code" placeholder="Kode Kupon"
                                    value="">
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                    value="Gunakan Kupon">
                            </form>
                        @else
                            <form action="{{ route('cart.coupon.remove') }}" method="POST"
                                class="position-relative bg-body">
                                @csrf
                                @method('DELETE')
                                <input class="form-control" type="text" name="coupon_code" placeholder="Kode Kupon"
                                    value="@if (Session::has('coupon')) {{ Session::get('coupon')['code'] }} Applied! @endif">
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                    value="Hapus Kupon">
                            </form>
                        @endif
                        <form action="{{ route('cart.empty') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-clear" type="submit">
                                <i class="fa fa-trash me-2"></i>HAPUS KERANJANG
                            </button>
                        </form>
                    </div>

                    <div class="shopping-cart__totals-wrapper">

                        <div class="sticky-content">
                            {{-- Modern Order Summary Card (same as checkout) --}}
                            <div class="order-summary-card">
                                <div class="summary-header">
                                    <h4>Total Keranjang</h4>
                                </div>

                                {{-- Pricing Breakdown --}}
                                @if (Session::has('discounts'))
                                    <div class="summary-item">
                                        <div class="item-label">Subtotal</div>
                                        <div class="item-value">
                                            Rp
                                            {{ number_format(str_replace(',', '', Cart::instance('cart')->subtotal()), 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item organic">
                                        <div class="item-label">Produk Organik</div>
                                        <div class="item-value">Rp {{ number_format($organicSubtotal, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item non-organic">
                                        <div class="item-label">Produk Non-Organik</div>
                                        <div class="item-value">Rp {{ number_format($nonOrganicSubtotal, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="item-label">Diskon ({{ Session::get('coupon')['code'] }})</div>
                                        <div class="item-value">
                                            -Rp {{ number_format(Session::get('discounts')['discount'], 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="item-label">Pengiriman</div>
                                        <div class="item-value">Gratis</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="item-label">Pajak (PPN)</div>
                                        <div class="item-value">
                                            Rp {{ number_format(Session::get('discounts')['tax'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @else
                                    <div class="summary-item">
                                        <div class="item-label">Subtotal</div>
                                        <div class="item-value">
                                            Rp
                                            {{ number_format(str_replace(',', '', Cart::instance('cart')->subtotal()), 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item organic">
                                        <div class="item-label">Produk Organik</div>
                                        <div class="item-value">Rp {{ number_format($organicSubtotal, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item non-organic">
                                        <div class="item-label">Produk Non-Organik</div>
                                        <div class="item-value">Rp {{ number_format($nonOrganicSubtotal, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="item-label">Pengiriman</div>
                                        <div class="item-value">Gratis</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="item-label">Pajak (PPN)</div>
                                        <div class="item-value">
                                            Rp
                                            {{ number_format(str_replace(',', '', Cart::instance('cart')->tax()), 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endif

                                {{-- Total Amount with Gradient Background --}}
                                <div class="summary-total">
                                    <div class="total-label">TOTAL KESELURUHAN</div>
                                    <div class="total-value">
                                        @if (Session::has('discounts'))
                                            Rp {{ number_format(Session::get('discounts')['total'], 0, ',', '.') }}
                                        @else
                                            Rp
                                            {{ number_format(str_replace(',', '', Cart::instance('cart')->total()), 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>

                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout w-100">
                                    LANJUT KE PEMBAYARAN
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Compact Empty Cart State --}}
                    <div class="empty-state">
                        <div class="empty-state__icon empty-state__icon--cart">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <h3 class="empty-state__title">Keranjang Anda Kosong</h3>
                        <p class="empty-state__description">
                            Belum ada produk di keranjang. Mulai belanja produk segar dari petani lokal!
                        </p>
                        <a href="{{ route('shop.index') }}" class="empty-state__cta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cart item delete with modal
            document.querySelectorAll('.delete-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const type = this.getAttribute('data-type');
                    const rowId = this.getAttribute('data-rowid');

                    ModalUtils.showDelete(name, type, function() {
                        // AJAX remove cart item
                        fetch(`/cart/remove/${rowId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Toast.success(
                                        'Produk berhasil dihapus dari keranjang');
                                    setTimeout(() => window.location.reload(), 1000);
                                } else {
                                    Toast.error('Gagal menghapus item dari keranjang');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Toast.error('Terjadi kesalahan');
                                setTimeout(() => window.location.reload(), 1000);
                            });
                    });
                });
            });
        });
    </script>
@endpush
