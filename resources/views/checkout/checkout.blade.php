@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            {{-- Session Messages for Toast Conversion --}}
            <div data-session-messages='{"success":"{{ session('success') }}", "error":"{{ session('error') }}", "errors":@json($errors->all())}'
                style="display:none;"></div>

            <h2 class="page-title">Pengiriman dan Pembayaran</h2>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Display Session Messages --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Tas Belanja</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Pengiriman dan Pembayaran</span>
                        <em>Periksa Daftar Barang Anda</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Konfirmasi</span>
                        <em>Tinjau dan Kirim Pesanan Anda</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" id="checkout-form" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        {{-- Product List Section - Grouped by Product --}}
                        <div class="product-order-section">
                            <h4>PESANAN ANDA</h4>
                            @php
                                // Group cart items by product ID
                                $groupedItems = Cart::instance('cart')->content()->groupBy('id');
                            @endphp
                            @forelse ($groupedItems as $productId => $items)
                                @php
                                    // Get first item for product info (name, image, etc)
                                    $firstItem = $items->first();
                                @endphp
                                <div class="product-order-card">
                                    {{-- Yellow Header --}}
                                    <div class="order-header">
                                        <div>Nama Pesanan</div>
                                        <div>Harga/Satuan</div>
                                        <div>Status Organic</div>
                                        <div>Daerah Asal</div>
                                        <div>Aksi</div>
                                    </div>
                                    {{-- Product Rows - One per unit variant --}}
                                    @foreach ($items as $item)
                                        <div class="product-row">
                                            {{-- Column 1: Product Name with Image --}}
                                            <div class="product-main">
                                                @php
                                                    // Get image path - prioritize Cloudinary URL
                                                    $imageSrc = $item->options->image ?? 'default.png';
                                                    if (!str_starts_with($imageSrc, 'http')) {
                                                        $imageSrc = asset('uploads/products/thumbnails/' . $imageSrc);
                                                    }
                                                @endphp
                                                <img loading="lazy" src="{{ $imageSrc }}" alt="{{ $item->name }}"
                                                    class="product-image"
                                                    onerror="this.src='{{ asset('images/default-product.png') }}'">

                                                <div class="product-info">
                                                    <div class="product-name">{{ $item->name }}</div>
                                                    <div class="product-qty">
                                                        <span class="qty-badge">{{ $item->qty }}x</span>
                                                        @php
                                                            $unitSymbol = $item->options->unit_symbol ?? null;
                                                            if (!$unitSymbol && isset($item->options->unit_id)) {
                                                                $unit = \App\Models\Unit::find($item->options->unit_id);
                                                                $unitSymbol = $unit?->symbol;
                                                            }
                                                        @endphp
                                                        @if ($unitSymbol)
                                                            <span class="text-muted">{{ $unitSymbol }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Column 2: Price per Unit --}}
                                            <div class="detail-item">
                                                <span class="detail-label">Harga:</span>
                                                <div class="product-price">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    @if ($unitSymbol)
                                                        <span class="unit-label">/{{ $unitSymbol }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Column 3: Organic Status --}}
                                            <div class="detail-item">
                                                <span class="detail-label">Status Organic:</span>
                                                @php
                                                    $organicStatus = trim($item->model?->organic_status ?? '');
                                                @endphp
                                                @if (strtolower($organicStatus) == 'organik')
                                                    <span class="badge badge-organic">Organik</span>
                                                @elseif(strtolower($organicStatus) == 'non-organik')
                                                    <span class="badge badge-non-organic">Non-Organik</span>
                                                @else
                                                    <span class="badge badge-non-organic">-</span>
                                                @endif
                                            </div>

                                            {{-- Column 4: Region --}}
                                            <div class="detail-item">
                                                <span class="detail-label">Daerah Asal:</span>
                                                <span class="detail-value">
                                                    {{ $item->model?->region?->name ?? '-' }}
                                                </span>
                                            </div>

                                            {{-- Remove Button for This Variant (AJAX, no nested form) --}}
                                            <div class="variant-action">
                                                <a href="javascript:void(0)"
                                                    class="remove-cart btn btn-sm btn-outline-danger btn-remove-variant delete-item"
                                                    data-rowid="{{ $item->rowId }}" data-name="{{ $item->name }}"
                                                    data-type="Produk" title="Hapus varian ini">
                                                    Hapus
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                                <div class="product-order-card">
                                    <div class="text-center py-4">
                                        <p class="text-muted">Tidak ada produk</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h4>DETAIL PENGIRIMAN</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('user.address.add', ['origin' => 'checkout']) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-plus me-2 mt-1"></i> Tambah Alamat Baru
                                </a>
                            </div>
                        </div>

                        @if ($addresses && $addresses->count() > 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted mb-3">Pilih alamat pengiriman dari alamat yang tersimpan:</p>

                                    <div class="address-selection">
                                        @foreach ($addresses as $address)
                                            <div class="address-card {{ $defaultAddress && $defaultAddress->id == $address->id ? 'selected' : '' }}"
                                                onclick="selectAddress({{ $address->id }})">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address_id"
                                                        id="address_{{ $address->id }}" value="{{ $address->id }}"
                                                        {{ $defaultAddress && $defaultAddress->id == $address->id ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label w-100"
                                                        for="address_{{ $address->id }}">
                                                        <div class="address-header">
                                                            <h6 class="mb-1">
                                                                {{ $address->name }}
                                                                @if ($address->isdefault)
                                                                    <span class="badge bg-success ms-2">Default</span>
                                                                @endif
                                                            </h6>
                                                        </div>
                                                        <div class="address-body">
                                                            <p class="mb-1 text-muted">{{ $address->address }},
                                                                {{ $address->locality }}</p>
                                                            <p class="mb-1 text-muted">{{ $address->city }},
                                                                {{ $address->state }} {{ $address->zip }}</p>
                                                            @if ($address->landmark)
                                                                <p class="mb-1 text-muted"><small>Landmark:
                                                                        {{ $address->landmark }}</small></p>
                                                            @endif
                                                            <p class="mb-0"><small><strong>Telepon:</strong>
                                                                    {{ $address->phone }}</small></p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <style>
                                        .address-selection {
                                            display: grid;
                                            gap: 15px;
                                        }

                                        .address-card {
                                            border: 2px solid #e0e0e0;
                                            border-radius: 12px;
                                            padding: 20px;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            background: #fff;
                                        }

                                        .address-card:hover {
                                            border-color: #007bff;
                                            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
                                            transform: translateY(-2px);
                                        }

                                        .address-card.selected {
                                            border-color: #28a745;
                                            background: #f8fff9;
                                            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
                                        }

                                        .address-card .form-check {
                                            margin: 0;
                                        }

                                        .address-card .form-check-input {
                                            width: 20px;
                                            height: 20px;
                                            margin-top: 2px;
                                            cursor: pointer;
                                        }

                                        .address-card .form-check-label {
                                            cursor: pointer;
                                            padding-left: 15px;
                                        }

                                        .address-header h6 {
                                            color: #333;
                                            font-weight: 600;
                                            margin-bottom: 8px;
                                        }

                                        .address-body {
                                            margin-top: 8px;
                                        }

                                        .address-body p {
                                            font-size: 14px;
                                            line-height: 1.6;
                                        }

                                        .badge {
                                            font-size: 11px;
                                            padding: 4px 8px;
                                            font-weight: 500;
                                        }
                                    </style>

                                    <script>
                                        function selectAddress(addressId) {
                                            // Remove selected class from all cards
                                            document.querySelectorAll('.address-card').forEach(card => {
                                                card.classList.remove('selected');
                                            });

                                            // Add selected class to clicked card
                                            event.currentTarget.classList.add('selected');

                                            // Check the radio button
                                            document.getElementById('address_' + addressId).checked = true;
                                        }
                                    </script>
                                </div>
                            </div>
                        @else
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required=""
                                            value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required=""
                                            value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip" required=""
                                            value="{{ old('zip') }}">
                                        <label for="zip">Pincode *</label>
                                        @error('zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required=""
                                            value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required=""
                                            value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" required=""
                                            value="{{ old('address') }}">
                                        <label for="address">House no, Building Name *</label>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="locality" required=""
                                            value="{{ old('locality') }}">
                                        <label for="locality">Road Name, Area, Colony *</label>
                                        @error('locality')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="landmark" required=""
                                            value="{{ old('landmark') }}">
                                        <label for="landmark">Landmark *</label>
                                        @error('landmark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            {{-- Modern Order Summary Card --}}
                            <div class="order-summary-card">
                                <div class="summary-header">
                                    <h4>Ringkasan Pesanan</h4>
                                </div>

                                {{-- Cart Items List --}}
                                @foreach (Cart::instance('cart') as $item)
                                    <div class="summary-item">
                                        <div class="item-label">
                                            {{ $item->name }} <span class="text-muted">x{{ $item->qty }}</span>
                                            @if (isset($item->options->unit_symbol))
                                                <span class="text-muted small">{{ $item->options->unit_symbol }}</span>
                                            @endif
                                        </div>
                                        <div class="item-value">
                                            Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach

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

                                {{-- Hidden Field & Submit Button --}}
                                <input type="hidden" name="mode" value="card">

                                <button type="submit" class="btn btn-primary btn-checkout w-100">
                                    Buat Pesanan
                                </button>

                                <div class="policy-text mt-3">
                                    <small class="text-muted">
                                        Data pribadi Anda akan digunakan untuk memproses pesanan Anda.
                                        Lihat <a href="#" target="_blank">kebijakan privasi</a> kami.
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
            </form>
        </section>

        <!-- Midtrans Snap.js -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('checkout-form');

                if (!form) {
                    console.error('Checkout form not found!');
                    return;
                }

                // CRITICAL FIX: Disable theme.js redirect listener
                if (window.jQuery) {
                    $('.checkout-form .btn-checkout').off('click');
                    console.log('✅ Theme.js redirect listener disabled');
                }

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation(); // Stop ALL other submit handlers
                    console.log('✅ Form submit prevented, handling with AJAX');

                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;

                    // Disable button and show loading
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Memproses...';

                    // Send AJAX request
                    fetch('{{ route('cart.place.an.order') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => {
                            console.log('📥 Response received:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('📦 Data:', data);

                            if (data.success && data.snap_token) {
                                console.log('✅ Got snap_token, opening Snap popup');

                                // Trigger Midtrans Snap popup
                                window.snap.pay(data.snap_token, {
                                    onSuccess: function(result) {
                                        console.log('✅ Payment SUCCESS', result);
                                        Toast.success('Pembayaran berhasil! Mengalihkan...');
                                        // Redirect to finish route with order_id to sync data
                                        setTimeout(() => {
                                            window.location.href =
                                                '{{ route('payment.finish') }}?order_id=' +
                                                data.order_id;
                                        }, 1000);
                                    },
                                    onPending: function(result) {
                                        console.log('⏳ Payment PENDING', result);
                                        Toast.info(
                                            'Pembayaran tertunda, mohon selesaikan pembayaran'
                                        );
                                        setTimeout(() => {
                                            window.location.href =
                                                '{{ route('payment.finish') }}?order_id=' +
                                                data.order_id;
                                        }, 1500);
                                    },
                                    onError: function(result) {
                                        console.log('❌ Payment ERROR', result);
                                        Toast.error('Pembayaran gagal! Silakan coba lagi');
                                        setTimeout(() => {
                                            window.location.href =
                                                '{{ route('payment.error') }}?order_id=' +
                                                data.order_id;
                                        }, 1500);
                                    },
                                    onClose: function() {
                                        console.log('ℹ️ Snap popup CLOSED');
                                        submitBtn.disabled = false;
                                        submitBtn.textContent = originalText;
                                    }
                                });
                            } else {
                                console.error('❌ Invalid response:', data);
                                Toast.error('Error: ' + (data.message || 'Gagal memproses pembayaran'));
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('❌ AJAX Error:', error);
                            Toast.error('Terjadi kesalahan: ' + error.message);
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        });
                });

                // AJAX Remove Variant Handler with Modal
                document.querySelectorAll('.btn-remove-variant').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const rowId = this.getAttribute('data-rowid');
                        const name = this.getAttribute('data-name');
                        const type = this.getAttribute('data-type');

                        ModalUtils.showDelete(name, type, function() {
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
                                        Toast.success('Item berhasil dihapus');
                                        setTimeout(() => window.location.reload(), 800);
                                    } else {
                                        Toast.error('Gagal menghapus item');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    window.location.reload();
                                });
                        });
                    });
                });

                console.log('✅ Event listener attached to checkout form');
            });
        </script>
    </main>
@endsection
