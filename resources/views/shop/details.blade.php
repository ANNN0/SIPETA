@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .product-gallery .main-image {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                margin-bottom: 1rem;
                aspect-ratio: 1/1;
                width: 100%;
                position: relative;
                border: 1px solid #f0f0f0;
            }

            .product-gallery .main-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                cursor: grab;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .product-gallery .main-image img.loading {
                opacity: 0.5;
                transform: scale(0.98);
            }

            .product-gallery .main-image:active img {
                cursor: grabbing;
            }

            .product-gallery .thumbnails {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
            }

            .product-gallery .thumbnail {
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
                aspect-ratio: 1/1;
                cursor: pointer;
                border: 2px solid transparent;
                transition: border-color 0.2s;
            }

            .product-gallery .thumbnail img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .product-gallery .thumbnail:hover,
            .product-gallery .thumbnail.active {
                border-color: #EFA927;
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .product-gallery {
                    display: block;
                }

                .product-gallery .thumbnails {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    width: 100%;
                    margin-top: 1rem;
                    flex-direction: row;
                    height: auto;
                    max-height: none;
                }

                /* Side-by-side Unit & Qty on Mobile */
                .product-addtocart-wrapper {
                    display: flex !important;
                    flex-direction: row !important;
                    gap: 12px;
                    /* Standardize gap */
                    align-items: flex-end;
                    flex-wrap: nowrap !important;
                }

                /* Harmonize Widths: ~55% for Unit, ~45% for Qty */
                .unit-selector-wrapper {
                    flex: 0 0 55%;
                    min-width: 0;
                }

                .qty-wrapper {
                    flex: 0 0 45%;
                    min-width: 0;
                }

                .unit-selector-wrapper select {
                    width: 100%;
                    text-overflow: ellipsis;
                }

                /* Standardize Control styling */
                .qty-control-modern {
                    margin-top: 0;
                    width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    /* Distribute buttons/input */
                }

                .qty-control-modern button {
                    padding: 0 10px;
                    /* Standard padding */
                }

                /* Allow input to fill space between buttons */
                .qty-control-modern input {
                    flex: 1;
                    width: auto !important;
                    /* Remove fixed width */
                    min-width: 0;
                    padding: 0;
                    text-align: center;
                }

                /* Unified Height */
                #unit-selector,
                .qty-control-modern,
                .qty-control-modern input,
                .qty-control-modern button {
                    height: 48px;
                    /* Slightly larger, touch friendly */
                }
            }
        </style>
    @endpush
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 flex-grow-1">
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Shop</a>
                </div><!-- /.breadcrumb -->

                <div
                    class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    @if ($prevProduct)
                        <a href="{{ route('shop.product.details', $prevProduct->slug) }}?sort={{ $sort ?? 'latest' }}"
                            class="text-uppercase fw-medium"
                            style="cursor: pointer !important; position: relative; z-index: 10; pointer-events: auto !important;">
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg>
                            <span class="menu-link menu-link_us-s">Prev</span>
                        </a>
                    @else
                        <span class="text-uppercase fw-medium"
                            style="opacity: 0.3; cursor: not-allowed; pointer-events: none;">
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg>
                            <span class="menu-link menu-link_us-s">Prev</span>
                        </span>
                    @endif

                    @if ($nextProduct)
                        <a href="{{ route('shop.product.details', $nextProduct->slug) }}?sort={{ $sort ?? 'latest' }}"
                            class="text-uppercase fw-medium"
                            style="cursor: pointer !important; position: relative; z-index: 10; pointer-events: auto !important;">
                            <span class="menu-link menu-link_us-s">Next</span>
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg>
                        </a>
                    @else
                        <span class="text-uppercase fw-medium"
                            style="opacity: 0.3; cursor: not-allowed; pointer-events: none;">
                            <span class="menu-link menu-link_us-s">Next</span>
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg>
                        </span>
                    @endif
                </div><!-- /.shop-acs -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{-- NEW GRID GALLERY IMPLEMENTATION --}}
                    <div class="product-gallery">
                        <div class="main-image">
                            @if ($product->image)
                                <img id="mainImage" src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image, 4020)" alt="{{ $product->name }}">
                                <a id="mainImageZoom" data-fancybox="gallery" href="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image)"
                                    style="position: absolute; bottom: 10px; right: 10px; background: rgba(255,255,255,0.8); padding: 8px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer;"
                                    data-bs-toggle="tooltip" title="Zoom">
                                    <svg width="18" height="18" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_zoom" />
                                    </svg>
                                </a>
                            @else
                                <div
                                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #4a4a4a; background: #f8f9fa;">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                                        class="feather feather-image">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></circle>
                                        <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></polyline>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        @php
                            $images = explode(',', $product->images);
                        @endphp
                        @if (count($images) > 0 && $images[0] != '')
                            <div class="thumbnails">
                                {{-- Main Image as first thumbnail --}}
                                <div class="thumbnail active"
                                    onclick="changeImage(this, '@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image, 4020)', '@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image)')">
                                    <img src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products/thumbnails') . '/' . $product->image, 104, 104, 'fill')" alt="Main Image">
                                </div>

                                @foreach ($images as $gimg)
                                    <div class="thumbnail"
                                        onclick="changeImage(this, '@cloudinary(Str::startsWith($gimg, 'http') ? $gimg : asset('uploads/products') . '/' . $gimg, 4020)', '@cloudinary(Str::startsWith($gimg, 'http') ? $gimg : asset('uploads/products') . '/' . $gimg)')">
                                        <img src="@cloudinary(Str::startsWith($gimg, 'http') ? $gimg : asset('uploads/products/thumbnails') . '/' . $gimg, 104, 104, 'fill')" alt="Thumbnail">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="product-single__name">{{ $product->name }}</h1>
                    <div class="product-single__rating d-flex align-items-center mb-1">
                        <div class="reviews-group d-flex align-items-center">
                            <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"
                                style="width: 18px; height: 18px; fill: #ffc107;">
                                <use href="#icon_star" />
                            </svg>
                            <span class="ms-1 fw-bold text-dark" style="font-size: 1.1rem;">
                                {{ number_format($product->average_rating, 1) }}
                            </span>
                        </div>
                        <span class="reviews-note text-lowercase text-secondary ms-2" style="font-size: 0.95rem;">
                            ({{ $reviewCount }} ulasan pelanggan)
                        </span>
                    </div>
                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->primaryUnitPrice)
                                @php
                                    $primaryPrice = $product->primaryUnitPrice;
                                    $displayPrice = $primaryPrice->sale_price ?: $primaryPrice->regular_price;
                                @endphp
                                @if ($primaryPrice->sale_price)
                                    <s>Rp {{ number_format($primaryPrice->regular_price, 0, ',', '.') }}</s>
                                @endif
                                Rp {{ number_format($displayPrice, 0, ',', '.') }}
                                <span id="unit-symbol-display" class="text-muted" style="font-size: 0.85em;"> /
                                    {{ $primaryPrice->unit->symbol }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    @php
                        // Check if this specific product+unit combination is in cart
                        $currentUnitId = $product->primaryUnitPrice->unit_id ?? null;
                        $inCartWithUnit = false;

                        if ($currentUnitId) {
                            $inCartWithUnit = Cart::instance('cart')
                                ->content()
                                ->first(function ($item) use ($product, $currentUnitId) {
                                    return $item->id == $product->id &&
                                        isset($item->options->unit_id) &&
                                        $item->options->unit_id == $currentUnitId;
                                });
                        }
                    @endphp

                    @if ($inCartWithUnit)
                        <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3">Lihat Keranjang</a>
                    @else
                        <form name="addtocart-form" method="post" action="{{ route('cart.add') }}"
                            class="ajax-add-to-cart-form">
                            @csrf
                            <div class="product-single__addtocart">
                                {{-- Unit Selector & Qty Control - Modern Aligned Grid --}}
                                <div class="product-addtocart-wrapper">
                                    {{-- Unit Selector --}}
                                    @if ($product->unitPrices && $product->unitPrices->count() > 0)
                                        <div class="unit-selector-wrapper">
                                            <label for="unit-selector">Pilih Satuan</label>
                                            <select id="unit-selector" name="unit_id" required>
                                                @foreach ($product->unitPrices as $unitPrice)
                                                    <option value="{{ $unitPrice->unit_id }}"
                                                        data-regular-price="{{ $unitPrice->regular_price }}"
                                                        data-sale-price="{{ $unitPrice->sale_price ?? 0 }}"
                                                        data-min-order="{{ $unitPrice->minimum_order }}"
                                                        {{ $unitPrice->is_primary ? 'selected' : '' }}>
                                                        {{ $unitPrice->unit->name }} ({{ $unitPrice->unit->symbol }})
                                                        @if ($unitPrice->sale_price)
                                                            - Rp {{ number_format($unitPrice->sale_price, 0, ',', '.') }}
                                                        @else
                                                            - Rp
                                                            {{ number_format($unitPrice->regular_price, 0, ',', '.') }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    {{-- Quantity Control --}}
                                    <div class="qty-wrapper">
                                        <label for="product-quantity">Jumlah</label>
                                        <div class="qty-control-modern">
                                            <button type="button" class="qty-decrease">−</button>
                                            <input type="number" name="quantity" id="product-quantity" value="1"
                                                min="{{ $product->primaryUnitPrice->minimum_order ?? 1 }}">
                                            <button type="button" class="qty-increase">+</button>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <button type="submit" class="btn btn-primary btn-addtocart">
                                    <span class="btn-content">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                                            <circle cx="9" cy="21" r="1" stroke="currentColor"
                                                stroke-width="2" />
                                            <circle cx="20" cy="21" r="1" stroke="currentColor"
                                                stroke-width="2" />
                                            <path
                                                d="M1 1H5L7.68 14.39C7.77 14.79 8.13 15.08 8.55 15.08H19.4C19.82 15.08 20.18 14.79 20.27 14.39L22 6H6"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="btn-text">Tambah ke Keranjang</span>
                                    </span>
                                    <span class="btn-spinner d-none">
                                        <span class="spinner-border spinner-border-sm me-1" role="status"
                                            aria-hidden="true"></span>
                                        <span>Loading...</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    @endif
                    <div class="product-single__addtolinks">
                        @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                            <form method="POST"
                                action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                                id="frm-remove-item">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart"
                                    onclick="document.getElementById('frm-remove-item').submit();"><svg width="16"
                                        height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg><span>Hapus dari Wishlist</span></a>
                            </form>
                        @else
                            <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="price"
                                    value="{{ $product->primaryUnitPrice ? ($product->primaryUnitPrice->sale_price ?: $product->primaryUnitPrice->regular_price) : 0 }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist"
                                    onclick="document.getElementById('wishlist-form').submit();"><svg width="16"
                                        height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg><span>Tambah ke Wishlist</span></a>
                            </form>
                        @endif

                        <share-button class="share-button">
                            <button
                                class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_sharing" />
                                </svg>
                                <span>Bagikan</span>
                            </button>
                            <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                                <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                                <div id="Article-share-template__main"
                                    class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                                    <div class="field grow mr-4">
                                        <label class="field__label sr-only" for="url">Link</label>
                                        <input type="text" class="field__input w-full" id="url"
                                            value="https://uomo-crystal.myshopify.com/blogs/news/go-to-wellness-tips-for-mental-health"
                                            placeholder="Link" onclick="this.select();" readonly="">
                                    </div>
                                    <button class="share-button__copy no-js-hidden">
                                        <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                            focusable="false" viewBox="0 0 11 13">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="sr-only">Copy link</span>
                                    </button>
                                </div>
                            </details>
                        </share-button>
                    </div>
                    <div class="product-single__meta-info">
                        <div class="meta-item">
                            <label>Status:</label>
                            <span>
                                @php
                                    $organicStatus = trim($product->organic_status ?? '');
                                @endphp
                                @if (strtolower($organicStatus) == 'organik')
                                    <span class="badge bg-success">Organik</span>
                                @elseif(strtolower($organicStatus) == 'non-organik')
                                    <span class="badge bg-danger">Non-Organik</span>
                                @endif
                            </span>
                        </div>
                        <div class="meta-item">
                            <label>SKU:</label>
                            <span>{{ $product->SKU }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Categories:</label>
                            <span>{{ $product->category->name }}</span>
                        </div>
                        @if ($product->region)
                            <div class="meta-item">
                                <label>Daerah Asal:</label>
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"
                                            fill="currentColor" />
                                    </svg>
                                    {{ $product->region->name }}, {{ $product->region->province }}
                                </span>
                            </div>
                        @endif
                        @if ($product->farmer)
                            <div class="meta-item">
                                <label>Dari Petani:</label>
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                        <path
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                            fill="currentColor" />
                                    </svg>
                                    <a href="{{ route('farmer.profile', $product->farmer->slug) }}"
                                        style="color: inherit; text-decoration: none; transition: color 0.2s ease;"
                                        onmouseover="this.style.color='#087990'; this.style.textDecoration='underline';"
                                        onmouseout="this.style.color='inherit'; this.style.textDecoration='none';">
                                        {{ $product->farmer->name }}
                                    </a>
                                    @if ($product->farmer->certification == 'Organik')
                                        <span class="badge ms-1"
                                            style="background-color: #228B22; color: white; font-size: 0.7rem; font-weight: 600;">{{ $product->farmer->certification }}</span>
                                    @elseif($product->farmer->certification == 'Non-GMO')
                                        <span class="badge ms-1"
                                            style="background-color: #FF8C00; color: white; font-size: 0.7rem; font-weight: 600;">{{ $product->farmer->certification }}</span>
                                    @elseif($product->farmer->certification == 'Fair Trade')
                                        <span class="badge ms-1"
                                            style="background-color: #4169E1; color: white; font-size: 0.7rem; font-weight: 600;">{{ $product->farmer->certification }}</span>
                                    @elseif($product->farmer->certification == 'GAP')
                                        <span class="badge ms-1"
                                            style="background-color: #9370DB; color: white; font-size: 0.7rem; font-weight: 600;">{{ $product->farmer->certification }}</span>
                                    @elseif($product->farmer->certification)
                                        <span class="badge ms-1"
                                            style="background-color: #6c757d; color: white; font-size: 0.7rem; font-weight: 600;">{{ $product->farmer->certification }}</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                        <div class="meta-item">
                            <label>Tags:</label>
                            <span>NA</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-separator dashed"></div>
            <div class="product-single__details-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Deskripsi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                            href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                            aria-selected="false">Informasi
                            Tambahan</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                            href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false"> Ulasan
                            ({{ $reviewCount }})</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                        aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            {{ $product->description }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                        aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__additional-info-grid">
                            {{-- Organic Specific Information --}}
                            @if ($product->organic_status == 'Organik')
                                @if ($product->harvest_period)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M16 2V6" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 2V6" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M3 10H21" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Periode Panen</label>
                                            <span>{{ $product->harvest_period }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->shelf_life)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Masa Simpan</label>
                                            <span>{{ $product->shelf_life }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            {{-- Non-Organic Specific Information --}}
                            @if ($product->organic_status == 'Non-Organik')
                                @if ($product->production_date)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M16 2V6" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 2V6" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <circle cx="12" cy="14" r="3" stroke="currentColor"
                                                    stroke-width="2" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Tanggal Produksi</label>
                                            <span>{{ \Carbon\Carbon::parse($product->production_date)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->expiry_date)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M12 8V12L14 14" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M16 16L20 20" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Masa Berlaku</label>
                                            <span>{{ \Carbon\Carbon::parse($product->expiry_date)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->bpom_number)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C12 22 20 18 20 12V5L12 2L4 5V12C4 18 12 22 12 22Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Nomor Izin Edar</label>
                                            <span>{{ $product->bpom_number }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->composition)
                                    <div class="info-card">
                                        <div class="icon-wrapper">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21 7V17C21 18.1046 20.1046 19 19 19H5C3.89543 19 3 18.1046 3 17V7C3 5.89543 3.89543 5 5 5H19C20.1046 5 21 5.89543 21 7Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M7 9H17" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7 12H17" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7 15H13" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="info-content">
                                            <label>Komposisi</label>
                                            <span>{{ $product->composition }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            {{-- Common Information --}}
                            @if ($product->organic_status)
                                <div class="info-card">
                                    <div
                                        class="icon-wrapper {{ $product->organic_status == 'Organik' ? 'text-success' : 'text-secondary' }}">
                                        @if ($product->organic_status == 'Organik')
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @else
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18.36 6.64C19.61 7.89 20.32 9.55 20.32 11.32C20.32 13.09 19.61 14.75 18.36 16M5.64 17.36C4.39 16.11 3.68 14.45 3.68 12.68C3.68 10.91 4.39 9.25 5.64 8"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M12 2V4M12 20V22M2 12H4M20 12H22" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="info-content">
                                        <label>Status Organik</label>
                                        <span
                                            class="badge {{ $product->organic_status == 'Organik' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->organic_status }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if ($product->storage_info)
                                <div class="info-card">
                                    <div class="icon-wrapper">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 16V8C20.9996 7.64927 20.9044 7.30481 20.725 7.00385C20.5456 6.70289 20.2892 6.45684 19.983 6.292L13.983 2.292C13.3804 1.8906 12.6196 1.8906 12.017 2.292L6.017 6.292C5.71082 6.45684 5.45436 6.70289 5.27498 7.00385C5.0956 7.30481 5.00043 7.64927 5 8V16C5.00043 16.3507 5.0956 16.6952 5.27498 16.9962C5.45436 17.2971 5.71082 17.5432 6.017 17.708L12.017 21.708C12.6196 22.1094 13.3804 22.1094 13.983 21.708L19.983 17.708C20.2892 17.5432 20.5456 17.2971 20.725 16.9962C20.9044 16.6952 20.9996 16.3507 21 16Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M3.27002 6.96002L12 12.01L20.73 6.96002" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12 22.08V12" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <label>Cara Penyimpanan</label>
                                        <span>{{ $product->storage_info }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if (!$product->harvest_period && !$product->shelf_life && !$product->organic_status && !$product->storage_info)
                            <div class="col-12 text-center py-4">
                                <p class="text-muted mb-0">Tidak ada informasi tambahan tersedia.</p>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        @include('shop.review-section')
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="section-separator dashed"></div>
        </div>
        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Produk <strong>Terkait</strong></h2>

            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
                    <div class="swiper-wrapper">
                        @include('shop.partials.products', [
                            'products' => $rproducts,
                            'itemClass' => 'swiper-slide',
                        ])
                    </div>
                </div>

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                <!-- /.products-pagination -->
            </div><!-- /.position-relative -->

        </section><!-- /.products-carousel container -->

        {{-- Recently Viewed Products Section --}}
        @if ($recentlyViewed && $recentlyViewed->count() > 0)
            <div class="container">
                <div class="section-separator dashed"></div>
            </div>
            <section class="products-carousel container recently-viewed-section">
                <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Terakhir <strong>Dilihat</strong></h2>

                <div id="recently_viewed_products" class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                        "autoplay": false,
                        "slidesPerView": 4,
                        "slidesPerGroup": 4,
                        "effect": "none",
                        "loop": false,
                        "pagination": {
                            "el": "#recently_viewed_products .products-pagination",
                            "type": "bullets",
                            "clickable": true
                        },
                        "navigation": {
                            "nextEl": "#recently_viewed_products .products-carousel__next",
                            "prevEl": "#recently_viewed_products .products-carousel__prev"
                        },
                        "breakpoints": {
                            "320": {
                                "slidesPerView": 2,
                                "slidesPerGroup": 2,
                                "spaceBetween": 14
                            },
                            "768": {
                                "slidesPerView": 3,
                                "slidesPerGroup": 3,
                                "spaceBetween": 24
                            },
                            "992": {
                                "slidesPerView": 4,
                                "slidesPerGroup": 4,
                                "spaceBetween": 30
                            }
                        }
                    }'>
                        <div class="swiper-wrapper">
                            @include('shop.partials.products', [
                                'products' => $recentlyViewed,
                                'itemClass' => 'swiper-slide',
                            ])
                        </div>
                    </div>

                    <div
                        class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->

            </section><!-- /.recently-viewed-section -->
        @endif
        {{-- Sticky Add to Cart for Mobile (Inserted via Agent) --}}
        <div class="sticky-add-to-cart">
            <div class="sticky-add-to-cart__img">
                <img src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products/thumbnails') . '/' . $product->image, 100)" alt="{{ $product->name }}">
            </div>
            <div class="sticky-add-to-cart__info">
                <h5>{{ $product->name }}</h5>
                <div class="price">
                    @if ($product->primaryUnitPrice)
                        @php
                            $dispPrice =
                                $product->primaryUnitPrice->sale_price ?: $product->primaryUnitPrice->regular_price;
                        @endphp
                        Rp {{ number_format($dispPrice, 0, ',', '.') }}
                    @endif
                </div>
            </div>
            <div class="sticky-add-to-cart__btn">
                {{-- Triggers the main add to cart button click --}}
                <button type="button" class="btn btn-primary"
                    onclick="window.scrollTo({top: 100, behavior: 'smooth'}); document.querySelector('.btn-addtocart').focus();">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </button>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Gallery Image Switcher
        function changeImage(element, src, largeSrc) {
            const img = document.getElementById('mainImage');
            img.classList.add('loading');

            setTimeout(() => {
                img.src = src;
                const zoomLink = document.getElementById('mainImageZoom');
                if (zoomLink) {
                    zoomLink.href = largeSrc;
                }

                img.onload = () => {
                    img.classList.remove('loading');
                };
                // Fallback
                setTimeout(() => img.classList.remove('loading'), 100);

            }, 200);

            // Handle active state
            document.querySelectorAll('.product-gallery .thumbnail').forEach(el => el.classList.remove('active'));
            if (element) {
                element.classList.add('active');
            }
        }

        $(document).ready(function() {
            // Swipe Functionality for Main Image
            const mainImageContainer = document.querySelector('.product-gallery .main-image');
            let touchStartX = 0;
            let touchEndX = 0;

            if (mainImageContainer) {
                // Touch Events (Mobile)
                mainImageContainer.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                });

                mainImageContainer.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });

                // Mouse Events (Desktop optional, but requested "digerakkan" so good to have)
                let isDragging = false;
                mainImageContainer.addEventListener('mousedown', e => {
                    isDragging = true;
                    touchStartX = e.screenX;
                    e.preventDefault(); // Prevent default drag behavior
                });

                mainImageContainer.addEventListener('mouseup', e => {
                    if (!isDragging) return;
                    isDragging = false;
                    touchEndX = e.screenX;
                    handleSwipe();
                });

                mainImageContainer.addEventListener('mouseleave', () => {
                    isDragging = false;
                });
            }

            function handleSwipe() {
                const threshold = 50; // min distance for swipe
                if (touchEndX < touchStartX - threshold) {
                    navigateGallery('next'); // Swiped Left -> Next Image
                }
                if (touchEndX > touchStartX + threshold) {
                    navigateGallery('prev'); // Swiped Right -> Prev Image
                }
            }

            function navigateGallery(direction) {
                const thumbnails = document.querySelectorAll('.product-gallery .thumbnail');
                let activeIndex = -1;

                thumbnails.forEach((thumb, index) => {
                    if (thumb.classList.contains('active')) {
                        activeIndex = index;
                    }
                });

                if (activeIndex !== -1) {
                    let nextIndex;
                    if (direction === 'next') {
                        nextIndex = activeIndex + 1;
                        if (nextIndex >= thumbnails.length) nextIndex = 0; // Loop back to start
                    } else {
                        nextIndex = activeIndex - 1;
                        if (nextIndex < 0) nextIndex = thumbnails.length - 1; // Loop to end
                    }

                    // Trigger click on the next/prev thumbnail
                    thumbnails[nextIndex].click();
                }
            }
            console.log('=== Product Detail Scripts Loaded ===');

            // Sticky Bar Logic
            const $stickyBar = $('.sticky-add-to-cart');
            const $mainBtn = $('.btn-addtocart');

            if ($stickyBar.length && $mainBtn.length) {
                $(window).on('scroll', function() {
                    const btnTop = $mainBtn.offset().top;
                    const btnBottom = btnTop + $mainBtn.outerHeight();
                    const windowTop = $(window).scrollTop();

                    // Show if scrolled past the main button
                    if (windowTop > btnBottom) {
                        $stickyBar.addClass('visible');
                    } else {
                        $stickyBar.removeClass('visible');
                    }
                });
            }

            // Unit selector change event - dynamic price AND unit symbol update
            $('#unit-selector').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const regularPrice = parseFloat(selectedOption.data('regular-price'));
                const salePrice = parseFloat(selectedOption.data('sale-price'));
                const minOrder = parseFloat(selectedOption.data('min-order'));
                const unitSymbol = selectedOption.text().match(/\(([^)]+)\)/)[
                    1]; // Extract symbol from "Unit (symbol)"

                // Format Rupiah with thousand separators
                const formatRupiah = (price) => {
                    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                };

                // Update main price display
                if (salePrice > 0) {
                    $('.current-price').html(
                        '<s>' + formatRupiah(regularPrice) + '</s> ' + formatRupiah(salePrice) +
                        ' <span id="unit-symbol-display" class="text-muted" style="font-size: 0.85em;">/ ' +
                        unitSymbol + '</span>'
                    );
                } else {
                    $('.current-price').html(
                        formatRupiah(regularPrice) +
                        ' <span id="unit-symbol-display" class="text-muted" style="font-size: 0.85em;">/ ' +
                        unitSymbol + '</span>'
                    );
                }

                // Update quantity minimum based on selected unit
                $('#product-quantity').attr('min', minOrder);

                // Adjust quantity if below minimum
                const currentQty = parseFloat($('#product-quantity').val());
                if (currentQty < minOrder) {
                    $('#product-quantity').val(minOrder);
                }

                console.log('Unit changed to:', unitSymbol, 'Price:', salePrice > 0 ? salePrice :
                    regularPrice);
            });

            // Modern Qty Control - Increase Button
            $('.qty-increase').on('click', function() {
                const input = $('#product-quantity');
                const currentVal = parseInt(input.val()) || 1;
                const maxVal = parseInt(input.attr('max')) || 9999;

                if (currentVal < maxVal) {
                    input.val(currentVal + 1);
                }
            });

            // Modern Qty Control - Decrease Button
            $('.qty-decrease').on('click', function() {
                const input = $('#product-quantity');
                const currentVal = parseInt(input.val()) || 1;
                const minVal = parseInt(input.attr('min')) || 1;

                if (currentVal > minVal) {
                    input.val(currentVal - 1);
                }
            });

            // Fancybox v5 - Image Zoom
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind('[data-fancybox="gallery"]', {
                    Toolbar: {
                        display: {
                            left: [],
                            middle: [],
                            right: ["zoom", "slideshow", "thumbs", "close"],
                        },
                    },
                    Thumbs: {
                        type: "classic"
                    },
                    click: "close",
                    Images: {
                        zoom: true
                    },
                });
                console.log('✓ Fancybox zoom initialized');
            }
        });
    </script>
@endpush
