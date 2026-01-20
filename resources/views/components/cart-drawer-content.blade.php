{{-- Item List Header --}}
<div class="cart-drawer-items-header">
    <span class="items-label">Item List</span>
    <span class="items-count">{{ Cart::instance('cart')->count() }} Items</span>
</div>

{{-- Cart Items (Scrollable) --}}
<div class="cart-drawer-items-list" id="cart-drawer-items-list">
    @forelse(Cart::instance('cart')->content() as $item)
        <div class="cart-item" data-row-id="{{ $item->rowId }}">
            <div class="cart-item-image">
                <img src="{{ Str::startsWith($item->options->image, 'http') ? $item->options->image : asset('uploads/products/thumbnails') . '/' . $item->options->image }}"
                    alt="{{ $item->name }}" />
            </div>
            <div class="cart-item-details">
                <h4 class="cart-item-name">{{ $item->name }}</h4>
                @php
                    // Try to get unit symbol from cart options, fallback to product's first unit
$unitSymbol = $item->options->unit_symbol ?? null;
if (!$unitSymbol && $item->model) {
    $defaultUnit = $item->model->unitPrices()->with('unit')->first();
                        $unitSymbol = $defaultUnit?->unit?->symbol;
                    }
                @endphp
                <p class="cart-item-price">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                    @if ($unitSymbol)
                        <span class="price-unit">/ {{ $unitSymbol }}</span>
                    @endif
                </p>
            </div>
            <div class="cart-item-actions">
                <div class="cart-qty-control">
                    <button class="qty-btn qty-decrease" data-row-id="{{ $item->rowId }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                    <span class="qty-value">{{ $item->qty }}</span>
                    <button class="qty-btn qty-increase" data-row-id="{{ $item->rowId }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                </div>
                <button class="cart-item-remove" data-row-id="{{ $item->rowId }}" title="Remove item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @empty
        <div class="cart-empty">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p>Keranjang Anda Kosong</p>
            <a href="{{ route('shop.index') }}" class="btn-shop-now">Belanja Sekarang</a>
        </div>
    @endforelse
</div>

{{-- Footer --}}
@if (Cart::instance('cart')->content()->count() > 0)
    <div class="cart-drawer-footer" id="cart-drawer-footer">
        <div class="cart-total">
            <span class="total-label">Total Pesanan</span>
            <span class="total-value">Rp
                {{ number_format(str_replace(',', '', Cart::instance('cart')->total()), 0, ',', '.') }}</span>
        </div>
        <a href="{{ route('cart.index') }}" class="btn-checkout">
            <span>Ke Pesanan</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
@endif
