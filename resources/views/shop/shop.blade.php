@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Product Categories
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3 category-list">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" class="chk-category" name="categories"
                                                    value="{{ $category->id }}"
                                                    @if (in_array($category->id, explode(',', $f_categories))) checked="checked" @endif />
                                                {{ $category->name }}
                                            </span>
                                            <span class="text-right float-end">{{ $category->products->count() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Types Filter (New) --}}
                <div class="accordion" id="product-types-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-types">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-types" aria-expanded="true"
                                aria-controls="accordion-filter-types">
                                Product Types
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-types" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-types" data-bs-parent="#product-types-list">
                            <div class="accordion-body px-0 pb-0 pt-3 category-list">
                                <ul class="list list-inline mb-0">
                                    @foreach ($productTypes as $type)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" class="chk-product-type" name="product_types"
                                                    value="{{ $type->id }}"
                                                    @if (is_array($f_product_types) && in_array($type->id, $f_product_types)) checked="checked" @endif />
                                                {!! $type->icon !!} {{ $type->name }}
                                            </span>
                                            <span class="text-right float-end">{{ $type->products_count }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Advanced Sort Filter --}}
                <div class="accordion" id="sort-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-sort">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-sort" aria-expanded="true"
                                aria-controls="accordion-filter-sort">
                                Urutkan
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-sort" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-sort" data-bs-parent="#sort-filters">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <div class="custom-dropdown" id="sort-dropdown" data-name="sort">
                                    <div class="custom-dropdown__selected">
                                        <span class="selected-text">
                                            @if (request('sort') == 'price_asc')
                                                Price: Low to High
                                            @elseif(request('sort') == 'price_desc')
                                                Price: High to Low
                                            @elseif(request('sort') == 'newest')
                                                Newest First
                                            @elseif(request('sort') == 'rating')
                                                Best Rating
                                            @elseif(request('sort') == 'reviews')
                                                Most Reviewed
                                            @else
                                                Default
                                            @endif
                                        </span>
                                        <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                                <path
                                                    d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="custom-dropdown__options">
                                        <div class="custom-dropdown__option {{ !request('sort') ? 'selected' : '' }}"
                                            data-value="">Default</div>
                                        <div class="custom-dropdown__option {{ request('sort') == 'price_asc' ? 'selected' : '' }}"
                                            data-value="price_asc">Price: Low to High</div>
                                        <div class="custom-dropdown__option {{ request('sort') == 'price_desc' ? 'selected' : '' }}"
                                            data-value="price_desc">Price: High to Low</div>
                                        <div class="custom-dropdown__option {{ request('sort') == 'newest' ? 'selected' : '' }}"
                                            data-value="newest">Newest First</div>
                                        <div class="custom-dropdown__option {{ request('sort') == 'rating' ? 'selected' : '' }}"
                                            data-value="rating">Best Rating</div>
                                        <div class="custom-dropdown__option {{ request('sort') == 'reviews' ? 'selected' : '' }}"
                                            data-value="reviews">Most Reviewed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4">
                        <h5 class="accordion-header mb-2" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                                aria-controls="accordion-filter-price">
                                Price
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <input class="price-range-slider" type="text" name="price_range" value=""
                                data-slider-min="1" data-slider-max="100000000" data-slider-step="100000"
                                data-slider-value="[{{ $min_price }},{{ $max_price }}]" data-currency="Rp" />
                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">Min Price: </span>
                                    <span class="price-range__min">Rp 1</span>
                                </div>
                                <div>
                                    <span class="text-secondary">Max Price: </span>
                                    <span class="price-range__max">Rp 100.000.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop-list flex-grow-1">
                @if ($slideSplits->count() > 0)
                    <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split"
                        data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": {{ $slideSplits->count() > 1 ? 'true' : 'false' }},
            "autoHeight": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                        <div class="swiper-wrapper">
                            @foreach ($slideSplits as $slideSplit)
                                <div class="swiper-slide">
                                    <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                        <div class="slide-split_text position-relative d-flex align-items-center"
                                            style="background-color: {{ $slideSplit->background_color }};">
                                            <div class="slideshow-text container p-3 p-xl-5">
                                                <h2
                                                    class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                                    {!! nl2br(e($slideSplit->title)) !!}
                                                </h2>
                                                @if ($slideSplit->subtitle)
                                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                                                        {{ $slideSplit->subtitle }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="slide-split_media position-relative">
                                            <div class="slideshow-bg">
                                                <img loading="lazy" src="@cloudinary(Str::startsWith($slideSplit->background_image, 'http') ? $slideSplit->background_image : asset('uploads/slide-splits/' . $slideSplit->background_image), 800)" width="630"
                                                    height="450" alt="{{ $slideSplit->title }}"
                                                    class="slideshow-bg__img object-fit-cover" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="container p-3 p-xl-5">
                            <div
                                class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                            </div>

                        </div>
                    </div>

                    <div class="mb-3 pb-2 pb-xl-3"></div>
                @endif

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home.index') }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Toko</a>
                    </div>

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">




                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        {{-- Search Bar (Moved from Sidebar) --}}
                        <div class="shop-search d-flex align-items-center order-1 flex-grow-1" style="max-width: 400px;">
                            <div class="position-relative w-100">
                                <input type="text" id="search-input-top" class="form-control form-control-sm"
                                    placeholder="Cari produk, kategori, petani, daerah, type..."
                                    value="{{ request('search') }}" style="padding-right: 30px; padding-left: 35px;">
                                <svg class="position-absolute top-50 start-0 translate-middle-y ms-2" width="16"
                                    height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM18.5 18.5L15 15" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                @if (request('search'))
                                    <button type="button" id="search-clear-top"
                                        class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-1 border-0 p-0"
                                        style="background: none; font-size: 18px; line-height: 1; width: 20px; height: 20px;">×</button>
                                @endif

                                {{-- Suggestions Dropdown --}}
                                <div class="suggestions-container" id="search-suggestions">
                                    {{-- Populated by JavaScript --}}
                                </div>
                            </div>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Saring</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Search Results Info --}}
                @if (request('search'))
                    <div class="search-results-info">
                        <div class="result-count">
                            Menampilkan <span class="query-text">"{{ request('search') }}"</span>
                        </div>
                        <a href="{{ route('shop.index') }}" class="clear-search-link">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                            </svg>
                            Hapus Filter
                        </a>
                    </div>
                @endif

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @include('shop.partials.products')
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
    </main>

    <form id="frmfilter" method="GET" action="{{ route('shop.index') }}">
        <input type="hidden" name="page" value="{{ $products->currentPage() }}">
        <input type="hidden" name="size" id="size" value="{{ $size }}" />
        <input type="hidden" name="order" id="order" value="{{ $order }}" />
        <input type="hidden" name="categories" id="hdnCategories" />
        <input type="hidden" name="min" id="hdnMinPrice" value="{{ $min_price }}" />
        <input type="hidden" name="max" id="hdnMaxPrice" value="{{ $max_price }}" />
        <input type="hidden" name="search" id="hdnSearch" value="{{ request('search') }}" />
        <input type="hidden" name="sort" id="hdnSort" value="{{ request('sort') }}" />
        @if (is_array($f_product_types))
            @foreach ($f_product_types as $typeId)
                <input type="hidden" name="product_types[]" value="{{ $typeId }}" />
            @endforeach
        @endif
    </form>
@endsection


@push('scripts')
    {{-- Load Autocomplete Module --}}
    @vite(['resources/js/shop-autocomplete.js'])

    <script>
        $(function() {
            $("#pagesize").on("change", function() {
                $("#size").val($("#pagesize option:selected").val());
                $("#frmfilter").submit();
            });



            // Custom Dropdown for Urutkan
            console.log('Sort dropdown script loading...');
            const sortDropdown = document.getElementById('sort-dropdown');
            console.log('Sort dropdown element:', sortDropdown);

            if (sortDropdown) {
                const selected = sortDropdown.querySelector('.custom-dropdown__selected');
                const selectedText = sortDropdown.querySelector('.selected-text');
                const optionElements = sortDropdown.querySelectorAll('.custom-dropdown__option');
                const hiddenInput = document.getElementById('hdnSort');

                console.log('Sort dropdown initialized:', {
                    selected: !!selected,
                    selectedText: !!selectedText,
                    optionsCount: optionElements.length,
                    hiddenInput: !!hiddenInput
                });

                function checkDropdownDirection() {
                    const rect = sortDropdown.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    const spaceAbove = rect.top;
                    if (spaceBelow < 300 && spaceAbove > 300) {
                        sortDropdown.classList.add('dropup');
                    } else {
                        sortDropdown.classList.remove('dropup');
                    }
                }

                selected.addEventListener('click', (e) => {
                    e.stopPropagation();
                    console.log('Sort dropdown clicked, toggling open');
                    checkDropdownDirection();
                    sortDropdown.classList.toggle('open');
                });

                optionElements.forEach(option => {
                    option.addEventListener('click', () => {
                        console.log('Sort option selected:', option.getAttribute('data-value'));
                        selectedText.textContent = option.textContent;
                        optionElements.forEach(opt => opt.classList.remove('selected'));
                        option.classList.add('selected');
                        hiddenInput.value = option.getAttribute('data-value');
                        sortDropdown.classList.remove('open');
                        console.log('Submitting filter form with sort:', hiddenInput.value);
                        $("#frmfilter").submit();
                    });
                });

                document.addEventListener('click', (e) => {
                    if (!sortDropdown.contains(e.target)) sortDropdown.classList.remove('open');
                });

                window.addEventListener('scroll', () => {
                    if (sortDropdown.classList.contains('open')) checkDropdownDirection();
                });
            } else {
                console.error('Sort dropdown element not found!');
            }


            $("input[name='categories']").on("change", function() {
                var categories = "";
                $("input[name='categories']:checked").each(function() {
                    if (categories == "") {
                        categories += $(this).val();
                    } else {
                        categories += "," + $(this).val();
                    }
                });
                $("#hdnCategories").val(categories);
                $("#frmfilter").submit();
            });
            $("[name='price_range']").on("change", function() {
                var min = $(this).val().split(',')[0];
                var max = $(this).val().split(',')[1];
                $("#hdnMinPrice").val(min);
                $("#hdnMaxPrice").val(max);
                setTimeout(() => {
                    $("#frmfilter").submit();
                }, 2000);
            });

            // ===================================
            // OLD SEARCH - DISABLED (Replaced by Autocomplete)
            // ===================================
            // let searchTimeout;
            // $("#search-input-top").on("input", ...) --> Handled by autocomplete module
            // $("#search-clear-top").on("click", ...) --> Handled by autocomplete module

            // AJAX Search Function
            function performAjaxSearch(searchQuery) {
                // Get current filter values
                var formData = $("#frmfilter").serialize();
                formData += '&search=' + encodeURIComponent(searchQuery);
                formData += '&ajax=1'; // Flag for AJAX request

                // Show loading indicator
                $("#products-grid").css('opacity', '0.5');

                $.ajax({
                    url: "{{ route('shop.index') }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Update products grid
                            $("#products-grid").html(response.productsHtml);
                            // Update pagination if included
                            if (response.paginationHtml) {
                                $(".wgp-pagination").html(response.paginationHtml);
                            }
                            // Update result count if needed
                            if (response.resultCount !== undefined) {
                                // Can add result count display here
                            }
                        }
                        $("#products-grid").css('opacity', '1');
                    },
                    error: function() {
                        $("#products-grid").css('opacity', '1');
                        alert('Error loading products. Please try again.');
                    }
                });
            }

            // Region filter (OUTSIDE the performAjaxSearch function but INSIDE document.ready)
            $("input[name='regions']").on("change", function() {
                var regions = "";
                $("input[name='regions']:checked").each(function() {
                    if (regions == "") {
                        regions += $(this).val();
                    } else {
                        regions += "," + $(this).val();
                    }
                });
                $("#hdnRegions").val(regions);
                $("#frmfilter").submit();
            });

            // Product Types filter (NEW)
            $("input[name='product_types']").on("change", function() {
                var productTypes = [];
                $("input[name='product_types']:checked").each(function() {
                    productTypes.push($(this).val());
                });

                // Clear existing product_types hidden inputs
                $("input[name^='product_types']").remove();

                // Add new hidden inputs for each selected type
                productTypes.forEach(function(typeId) {
                    var input = $('<input>').attr({
                        type: 'hidden',
                        name: 'product_types[]',
                        value: typeId
                    });
                    $("#frmfilter").append(input);
                });

                $("#frmfilter").submit();
            });


            // ===================================
            // INITIALIZE AUTOCOMPLETE
            // ===================================
            if (typeof initShopAutocomplete === 'function') {
                initShopAutocomplete({
                    shopRoute: "{{ route('shop.index') }}",
                    detailsRoute: "{{ route('shop.product.details', ['product_slug' => '__SLUG__']) }}",
                    assetPath: "{{ asset('uploads/products/thumbnails') }}",
                    performAjaxSearchFn: typeof performAjaxSearch !== 'undefined' ? performAjaxSearch : null
                });
            }

        }); // End of $(function())
    </script>
@endpush
