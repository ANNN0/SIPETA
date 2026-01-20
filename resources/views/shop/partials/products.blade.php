@foreach ($products as $product)
    <div class="product-card-wrapper {{ $itemClass ?? '' }}">
        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
            <div class="pc__img-wrapper">
                <div class="product-status position-absolute top-0 start-0 p-2" style="z-index: 99;">
                    @php
                        $organicStatus = trim($product->organic_status ?? '');
                    @endphp
                    @if (strtolower($organicStatus) == 'organik')
                        <span class="badge bg-success">Organik</span>
                    @elseif(strtolower($organicStatus) == 'non-organik')
                        <span class="badge bg-danger">Non-Organik</span>
                    @endif
                </div>
                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a
                                href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}{{ request()->has('order') || request()->has('size') || request()->has('categories') || request()->has('regions') || request()->has('product_types') || request()->has('min_price') || request()->has('max_price') ? '?' . http_build_query(request()->only(['order', 'size', 'categories', 'regions', 'product_types', 'min_price', 'max_price'])) : '' }}"><img
                                    loading="lazy" src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image, 330, 400, 'fill')" width="330" height="400"
                                    alt="{{ $product->name }}" class="pc__img"></a>
                        </div>
                        <div class="swiper-slide">
                            @foreach (explode(',', $product->images) as $gimg)
                                <a
                                    href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}{{ request()->has('order') ? '?' . http_build_query(request()->only('order')) : '' }}"><img
                                        loading="lazy" src="@cloudinary(Str::startsWith($gimg, 'http') ? $gimg : asset('uploads/products') . '/' . $gimg, 330, 400, 'fill')" width="330" height="400"
                                        alt="{{ $product->name }}" class="pc__img">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_sm" />
                        </svg></span>
                    <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_sm" />
                        </svg></span>
                </div>
                @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                    <a href="{{ route('cart.index') }}"
                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go
                        to Cart</a>
                @else
                    <form name="addtocart-form" method="post" action="{{ route('cart.add') }}"
                        class="ajax-add-to-cart-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="quantity" value="1" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        @if ($product->primaryUnitPrice)
                            <input type="hidden" name="unit_id" value="{{ $product->primaryUnitPrice->unit_id }}" />
                        @endif
                        <button type="submit"
                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                            title="Add To Cart">
                            <span class="btn-text">Add To Cart</span>
                            <span class="btn-spinner d-none">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                <span>Loading...</span>
                            </span>
                        </button>
                    </form>
                @endif
            </div>

            <div class="pc__info position-relative">
                <p class="pc__category">{{ $product->category->name }}</p>
                @if ($product->region)
                    <div class="pc__region mb-1" style="font-size: 0.75rem; color: #6c757d;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            style="display: inline-block; vertical-align: middle; margin-right: 2px;">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"
                                fill="currentColor" />
                        </svg>
                        {{ $product->region->name }}
                    </div>
                @endif
                @if ($product->farmer)
                    <div class="pc__farmer mb-1" style="font-size: 0.75rem; color: #6c757d;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            style="display: inline-block; vertical-align: middle; margin-right: 2px;">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                fill="currentColor" />
                        </svg>
                        {{ $product->farmer->name }}
                    </div>
                @endif
                <h6 class="pc__title"><a
                        href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}{{ request()->has('sort') ? '?sort=' . request('sort') : '' }}">{{ $product->name }}</a>
                </h6>
                <div class="product-card__price d-flex">
                    <span class="money price">
                        @if ($product->primaryUnitPrice)
                            @php
                                $primaryPrice = $product->primaryUnitPrice;
                                $displayPrice = $primaryPrice->sale_price ?: $primaryPrice->regular_price;
                            @endphp
                            @if ($primaryPrice->sale_price)
                                <s>Rp {{ number_format($primaryPrice->regular_price, 0, ',', '.') }}</s>
                            @endif
                            Rp {{ number_format($displayPrice, 0, ',', '.') }}
                            <span class="text-muted" style="font-size: 0.85em;"> /
                                {{ $primaryPrice->unit->symbol }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </span>
                </div>
                <div class="product-card__review d-flex align-items-center">
                    <div class="reviews-group d-flex align-items-center">
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                            style="width: 14px; height: 14px; fill: #ffc107;">
                            <use href="#icon_star" />
                        </svg>
                        <span class="ms-1 fw-bold text-dark" style="font-size: 0.9rem;">
                            {{ number_format($product->average_rating, 1) }}
                        </span>
                    </div>
                    <span class="reviews-note text-lowercase text-secondary ms-1" style="font-size: 0.85rem;">
                        ({{ $product->review_count }} ulasan)
                    </span>
                </div>

                @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                    <form method="POST"
                        action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="wishlist-btn filled-heart" title="Remove From Wishlist">
                            <svg viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_heart" />
                            </svg>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('wishlist.add') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        <input type="hidden" name="quantity" value="1" />
                        <button type="submit" class="wishlist-btn" title="Add To Wishlist">
                            <svg viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_heart" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endforeach
