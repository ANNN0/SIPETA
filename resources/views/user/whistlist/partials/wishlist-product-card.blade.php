@foreach ($products as $product)
    <div class="wishlist-card">
        {{-- Remove Button --}}
        @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
            <form method="POST"
                action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                class="wishlist-card__remove-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="wishlist-card__remove" title="Hapus dari Wishlist">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </form>
        @endif

        {{-- Product Image --}}
        <div class="wishlist-card__image">
            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                <img loading="lazy" src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image, 200, 200, 'fill')" alt="{{ $product->name }}">
            </a>
        </div>

        {{-- Product Info --}}
        <div class="wishlist-card__content">
            {{-- Header: Name & Category --}}
            <div class="wishlist-card__header">
                <h6 class="wishlist-card__title">
                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                        {{ $product->name }}
                    </a>
                </h6>
                <span class="wishlist-card__category">{{ $product->category->name ?? 'Produk' }}</span>
            </div>

            {{-- Price --}}
            <div class="wishlist-card__price">
                @if ($product->primaryUnitPrice)
                    @php
                        $primaryPrice = $product->primaryUnitPrice;
                        $displayPrice = $primaryPrice->sale_price ?: $primaryPrice->regular_price;
                    @endphp
                    @if ($primaryPrice->sale_price)
                        <span class="wishlist-card__price-old">Rp
                            {{ number_format($primaryPrice->regular_price, 0, ',', '.') }}</span>
                    @endif
                    <span class="wishlist-card__price-current">Rp {{ number_format($displayPrice, 0, ',', '.') }}</span>
                @else
                    <span class="wishlist-card__price-current">N/A</span>
                @endif
            </div>

            {{-- Rating --}}
            <div class="wishlist-card__rating">
                <svg class="star-icon" viewBox="0 0 24 24" fill="#ffc107">
                    <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                <span class="rating-value">{{ number_format($product->average_rating, 1) }}</span>
                <span class="rating-count">({{ $product->review_count }} ulasan)</span>
            </div>

            {{-- Region/Farmer --}}
            @if ($product->region || $product->farmer)
                <div class="wishlist-card__region">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                    <span>{{ $product->farmer->name ?? ($product->region->name ?? '') }}</span>
                </div>
            @endif

            {{-- Actions: Unit Selector & Add to Cart --}}
            <div class="wishlist-card__actions">
                {{-- Unit Selector --}}
                @if ($product->unitPrices && $product->unitPrices->count() > 1)
                    <select class="wishlist-card__unit-select" name="unit_id" data-product-id="{{ $product->id }}">
                        @foreach ($product->unitPrices as $unitPrice)
                            <option value="{{ $unitPrice->unit_id }}"
                                data-price="{{ $unitPrice->sale_price ?: $unitPrice->regular_price }}"
                                {{ $unitPrice->is_primary ? 'selected' : '' }}>
                                {{ $unitPrice->unit->symbol }}
                            </option>
                        @endforeach
                    </select>
                @elseif ($product->primaryUnitPrice)
                    <span class="wishlist-card__unit-badge">{{ $product->primaryUnitPrice->unit->symbol }}</span>
                @endif

                {{-- Add to Cart Button --}}
                @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                    <a href="{{ route('cart.index') }}"
                        class="wishlist-card__cart-btn wishlist-card__cart-btn--in-cart">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Di Keranjang
                    </a>
                @else
                    <form method="POST" action="{{ route('cart.add') }}"
                        class="ajax-add-to-cart-form wishlist-card__cart-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        @if ($product->primaryUnitPrice)
                            <input type="hidden" name="price"
                                value="{{ $product->primaryUnitPrice->sale_price ?: $product->primaryUnitPrice->regular_price }}">
                            <input type="hidden" name="unit_id" value="{{ $product->primaryUnitPrice->unit_id }}">
                        @endif
                        <button type="submit" class="wishlist-card__cart-btn">
                            <span class="btn-content">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <span class="btn-text">Add to Cart</span>
                            </span>
                            <span class="btn-spinner d-none">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                            </span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endforeach
