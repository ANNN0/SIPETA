@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="farmer-profile-page">
            <div class="container">
                {{-- Farmer Profile Header --}}
                <div class="farmer-profile-header mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="farmer-photo">
                                @if ($farmer->photo)
                                    <img src="@cloudinary(Str::startsWith($farmer->photo, 'http') ? $farmer->photo : asset('uploads/farmers/' . $farmer->photo), 300, 300, 'fill')" alt="{{ $farmer->name }}" class="rounded-circle">
                                @else
                                    <div class="farmer-photo-placeholder rounded-circle">
                                        <i class="fa fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <div>
                                <h1 class="farmer-name">{{ $farmer->name }}</h1>
                                @if ($farmer->region)
                                    <p class="farmer-location">
                                        {{ $farmer->region->name }},
                                        {{ $farmer->region->province }}
                                    </p>
                                @endif
                                @if ($farmer->description || $farmer->bio)
                                    <p class="farmer-bio mt-3">{{ $farmer->description ?? $farmer->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistics Cards --}}
                <div class="farmer-statistics mb-5">
                    <div class="row g-4">
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20 7h-4V5c0-.55-.22-1.05-.59-1.41C15.05 3.22 14.55 3 14 3h-4c-.55 0-1.05.22-1.41.59C8.22 3.95 8 4.45 8 5v2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zM10 5h4v2h-4V5zm10 15H4V9h16v11z"
                                            fill="#6B7280" />
                                        <path
                                            d="M12 11c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm0 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"
                                            fill="#6B7280" />
                                    </svg>
                                </div>
                                <div class="stat-value">{{ $statistics['products_count'] }}</div>
                                <div class="stat-label">Produk</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"
                                            fill="#6B7280" />
                                    </svg>
                                </div>
                                <div class="stat-value">{{ number_format($statistics['avg_rating'], 1) }}</div>
                                <div class="stat-label">Rating Rata-rata</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z"
                                            fill="#6B7280" />
                                        <path d="M7 9h10v2H7V9zm0-3h10v2H7V6zm0 6h7v2H7v-2z" fill="#6B7280" />
                                    </svg>
                                </div>
                                <div class="stat-value">{{ $statistics['total_reviews'] }}</div>
                                <div class="stat-label">Ulasan</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V9h14v10zM5 7V5h14v2H5z"
                                            fill="#6B7280" />
                                        <circle cx="12" cy="14" r="2" fill="#6B7280" />
                                    </svg>
                                </div>
                                <div class="stat-value">{{ $statistics['member_since'] }}</div>
                                <div class="stat-label">Bergabung Sejak</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Farmer's Products --}}
                <div class="farmer-products">
                    <h2 class="section-title mb-4">Produk dari {{ $farmer->name }}</h2>

                    @if ($farmer->products->count() > 0)
                        <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                            @include('shop.partials.products', ['products' => $farmer->products])
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="icon-info"></i> This farmer hasn't listed any products yet.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
