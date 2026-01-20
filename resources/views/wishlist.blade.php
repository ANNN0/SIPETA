@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container wishlist-page">
            <h2 class="page-title">Wishlist Saya</h2>

            <div class="shopping-cart">
                @if ($items && $items->count() > 0)
                    {{-- Product Count --}}
                    <p class="page-subtitle">{{ $items->count() }} Produk</p>

                    {{-- Modern Product Grid --}}
                    <div class="wishlist-grid">
                        @foreach ($items as $item)
                            @php $product = $products[$item->id] ?? null; @endphp
                            @if ($product)
                                <div class="wishlist-product-card">
                                    {{-- Image Section --}}
                                    <div class="card-image-wrapper">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image }}"
                                                class="product-image" alt="{{ $product->name }}">
                                        </a>

                                        {{-- Wishlist Heart Icon --}}
                                        <div class="wishlist-icon">
                                            <i class="fa fa-heart"></i>
                                        </div>

                                        {{-- Remove Button --}}
                                        <form method="POST"
                                            action="{{ route('wishlist.item.remove', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="remove-btn" aria-label="Hapus dari wishlist"
                                                title="Hapus dari Wishlist">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Card Body --}}
                                    <div class="card-body-content">
                                        {{-- Category Badge --}}
                                        @if ($product->category)
                                            <span class="category-badge">{{ $product->category->name }}</span>
                                        @endif

                                        {{-- Product Title --}}
                                        <h6 class="product-title">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h6>

                                        {{-- Region --}}
                                        @if ($product->region)
                                            <div class="product-region">
                                                <i class="fa fa-map-marker"></i>
                                                {{ $product->region->name }}
                                            </div>
                                        @endif

                                        {{-- Rating --}}
                                        <div class="rating-section">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 9">
                                                <use href="#icon_star" />
                                            </svg>
                                            <div class="rating-text">
                                                <span
                                                    class="rating-value">{{ number_format($product->average_rating ?? 0, 1) }}</span>
                                                <span class="rating-count">({{ $product->review_count ?? 0 }})</span>
                                            </div>
                                        </div>

                                        {{-- Price --}}
                                        <div class="price-section">
                                            @if ($product->primaryUnitPrice)
                                                <div class="current-price">
                                                    Rp
                                                    {{ number_format($product->primaryUnitPrice->sale_price ?: $product->primaryUnitPrice->regular_price, 0, ',', '.') }}
                                                    <span
                                                        class="unit">/{{ $product->primaryUnitPrice->unit->symbol }}</span>
                                                </div>
                                                @if (
                                                    $product->primaryUnitPrice->sale_price &&
                                                        $product->primaryUnitPrice->sale_price < $product->primaryUnitPrice->regular_price)
                                                    <div class="original-price">
                                                        Rp
                                                        {{ number_format($product->primaryUnitPrice->regular_price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="current-price">Harga tidak tersedia</div>
                                            @endif
                                        </div>

                                        {{-- Add to Cart Button --}}
                                        <div class="card-actions">
                                            <form method="POST" action="{{ route('cart.add') }}"
                                                class="ajax-add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                                <input type="hidden" name="quantity" value="1" />
                                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                                <input type="hidden" name="price"
                                                    value="{{ $product->primaryUnitPrice->sale_price ?: $product->primaryUnitPrice->regular_price }}" />
                                                @if ($product->primaryUnitPrice)
                                                    <input type="hidden" name="unit_id"
                                                        value="{{ $product->primaryUnitPrice->unit_id }}" />
                                                @endif
                                                <button type="submit" class="add-to-cart-btn">
                                                    <span class="btn-text">
                                                        <i class="fa fa-cart-plus"></i>
                                                        Tambah ke Keranjang
                                                    </span>
                                                    <span class="btn-spinner d-none">
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Clear Wishlist Button (ke bawah) -->
                    <div class="cart-table-footer mt-4">
                        <form method="POST" action="{{ route('wishlist.items.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-clear border-0 bg-transparent text-uppercase fw-medium">
                                <i class="fa fa-trash me-2"></i>HAPUS SEMUA
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Compact Empty Wishlist State --}}
                    <div class="empty-state">
                        <div class="empty-state__icon empty-state__icon--wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="empty-state__title">Wishlist Anda Kosong</h3>
                        <p class="empty-state__description">
                            Belum ada produk favorit. Temukan produk terbaik dan simpan ke wishlist!
                        </p>
                        <a href="{{ route('shop.index') }}" class="empty-state__cta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            Jelajahi Produk
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
