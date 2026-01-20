@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="order-status-section container">
            {{-- Breadcrumb --}}
            <nav class="breadcrumb-nav mb-4">
                <a href="{{ route('home.index') }}">Beranda</a>
                <span>/</span>
                <span class="current">Lacak Pesanan Anda</span>
            </nav>

            <h1 class="order-status-title">Lacak Pesanan Anda</h1>

            {{-- Status Card --}}
            <div class="status-card">
                <div class="status-header">
                    <h3>Status Pesanan</h3>
                    <p class="order-id">ID Pesanan: {{ $order->id }}</p>
                </div>

                {{-- Timeline --}}
                @php
                    // Determine current step based on order & transaction status
                    $transactionStatus = $order->transaction?->status ?? 'pending';
                    $orderStatus = $order->status;

                    // Step logic based on order status:
                    // 1 = Pesanan Ditempatkan (pending/ordered)
                    // 2 = Diterima (approved by admin)
                    // 3 = Dalam Proses (processing)
                    // 4 = Dalam Perjalanan (delivered - in transit)
                    // 5 = Terkirim (delivered + delivered_date exists)

                    if ($orderStatus === 'canceled') {
                        $currentStep = 0; // Dibatalkan
                    } elseif ($orderStatus === 'delivered') {
                        // Check if delivered_date exists for final delivery
                        $currentStep = $order->delivered_date ? 5 : 4;
                    } elseif ($orderStatus === 'dalam_perjalanan') {
                        $currentStep = 4; // Dalam Perjalanan
                    } elseif ($orderStatus === 'processing') {
                        $currentStep = 3; // Dalam Proses
                    } elseif ($orderStatus === 'approved') {
                        $currentStep = 2; // Diterima
                    } elseif ($orderStatus === 'ordered') {
                        $currentStep = 1; // Pesanan Ditempatkan
                    } elseif ($orderStatus === 'pending') {
                        $currentStep = 1; // Pesanan Ditempatkan (menunggu)
                    } else {
                        $currentStep = 1;
                    }

                    // Dummy dates for simulation
                    $orderDate = $order->created_at;
                    $dates = [
                        1 => $orderDate->format('d/m/Y') . "\n" . $orderDate->format('H.i'),
                        2 => $orderDate->format('d/m/Y') . "\n" . $orderDate->format('H.i'),
                        3 => $orderDate->addDay()->format('d/m/Y'),
                        4 => 'Diperkirakan ' . $order->created_at->addDays(3)->format('d/m/Y'),
                        5 => 'Diperkirakan ' . $order->created_at->addDays(5)->format('d/m/Y'),
                    ];
                @endphp

                <div class="order-timeline">
                    {{-- Step 1: Pesanan Ditempatkan --}}
                    <div
                        class="timeline-step {{ $currentStep >= 1 ? 'active' : '' }} {{ $currentStep > 1 ? 'completed' : '' }}">
                        <div class="step-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <div class="step-content">
                            <span class="step-label">Pesanan Ditempatkan</span>
                            <span
                                class="step-date">{{ $order->created_at->format('d/m/Y') }}<br>{{ $order->created_at->format('H.i') }}</span>
                        </div>
                    </div>

                    {{-- Connector --}}
                    <div class="timeline-connector {{ $currentStep >= 2 ? 'active' : '' }}"></div>

                    {{-- Step 2: Diterima --}}
                    <div
                        class="timeline-step {{ $currentStep >= 2 ? 'active' : '' }} {{ $currentStep > 2 ? 'completed' : '' }}">
                        <div class="step-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="step-content">
                            <span class="step-label">Diterima</span>
                            @if ($currentStep >= 2)
                                <span
                                    class="step-date">{{ $order->created_at->format('d/m/Y') }}<br>{{ $order->created_at->format('H.i') }}</span>
                            @else
                                <span class="step-date pending">Menunggu konfirmasi</span>
                            @endif
                        </div>
                    </div>

                    {{-- Connector --}}
                    <div class="timeline-connector {{ $currentStep >= 3 ? 'active' : '' }}"></div>

                    {{-- Step 3: Dalam Proses --}}
                    <div
                        class="timeline-step {{ $currentStep >= 3 ? 'active' : '' }} {{ $currentStep > 3 ? 'completed' : '' }}">
                        <div class="step-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                        </div>
                        <div class="step-content">
                            <span class="step-label">Dalam Proses</span>
                            @if ($currentStep >= 3)
                                <span class="step-date">{{ $order->created_at->addDay()->format('d/m/Y') }}</span>
                            @else
                                <span class="step-date pending">Diperkirakan
                                    {{ $order->created_at->addDay()->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Connector --}}
                    <div class="timeline-connector {{ $currentStep >= 4 ? 'active' : '' }}"></div>

                    {{-- Step 4: Dalam Perjalanan --}}
                    <div
                        class="timeline-step {{ $currentStep >= 4 ? 'active' : '' }} {{ $currentStep > 4 ? 'completed' : '' }}">
                        <div class="step-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="step-content">
                            <span class="step-label">Dalam Perjalanan</span>
                            @if ($currentStep >= 4)
                                <span class="step-date">{{ $order->created_at->addDays(3)->format('d/m/Y') }}</span>
                            @else
                                <span class="step-date pending">Diperkirakan
                                    {{ $order->created_at->addDays(3)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Connector --}}
                    <div class="timeline-connector {{ $currentStep >= 5 ? 'active' : '' }}"></div>

                    {{-- Step 5: Terkirim --}}
                    <div class="timeline-step {{ $currentStep >= 5 ? 'active' : '' }}">
                        <div class="step-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <div class="step-content">
                            <span class="step-label">Terkirim</span>
                            @if ($currentStep >= 5)
                                <span class="step-date">{{ now()->format('d/m/Y') }}</span>
                            @else
                                <span class="step-date pending">Diperkirakan
                                    {{ $order->created_at->addDays(5)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Canceled Status --}}
                @if ($orderStatus === 'canceled')
                    <div class="order-canceled-notice">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <span>Pesanan ini telah dibatalkan</span>
                    </div>
                @endif
            </div>

            {{-- Actions - Repositioned above product section --}}
            <div class="order-actions-top">
                <a href="{{ route('shop.index') }}" class="btn btn-continue-shopping">
                    Lanjut Belanja
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
                <a href="{{ route('user.orders') }}" class="btn btn-back-orders">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    Kembali ke Pesanan
                </a>
            </div>

            {{-- Product Section --}}
            <div class="product-section">
                <h3>Produk</h3>
                <div class="product-list">
                    @foreach ($order->orderItems as $item)
                        <div class="product-item">
                            <div class="product-image">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                        alt="{{ $item->product->name ?? 'Product' }}">
                                @else
                                    <div class="no-image">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2"
                                                ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="product-details">
                                <h4>{{ $item->product->name ?? 'Produk' }}</h4>
                                <p>{{ $item->quantity }} Qty. - Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- Feature Cards - Contextually Relevant --}}
            <div class="feature-cards">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h4>Riwayat Pesanan</h4>
                        <p>Lihat semua pesanan Anda</p>
                    </div>
                    <a href="{{ route('user.orders') }}" class="feature-link"></a>
                </div>

                <div class="feature-card highlight">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h4>Butuh Bantuan?</h4>
                        <p>Hubungi customer service kami</p>
                    </div>
                    <a href="{{ route('home.contact') }}" class="feature-link"></a>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h4>Invoice Pesanan</h4>
                        <p>{{ $order->transaction && $order->transaction->status == 'approved' ? 'Cetak invoice' : 'Menunggu pembayaran' }}
                        </p>
                    </div>
                    @if ($order->transaction && $order->transaction->status == 'approved')
                        <a href="#" class="feature-link" onclick="window.print(); return false;"></a>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="order-actions">
                <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Kembali ke Pesanan
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    Lanjut Belanja
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
        </section>
    </main>
@endsection
