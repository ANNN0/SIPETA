@extends('layouts.app')
@section('content')
    <main>

        <section class="swiper-container js-swiper-slider slideshow"
            data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true,
        "speed": 1000,
        "pagination": {
          "el": ".slideshow-pagination",
          "clickable": true
        }
      }'>
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div class="slideshow-bg position-relative h-100">
                            {{-- Full Background Image --}}
                            <div class="slideshow-bg__image position-absolute w-100 h-100"
                                style="background-image: url('@cloudinary(Str::startsWith($slide->image, 'http') ? $slide->image : asset('uploads/slides') . '/' . $slide->image, 1600)'); 
                                       background-size: cover; 
                                       background-position: center center;
                                       background-repeat: no-repeat;">
                                {{-- Dark Overlay for Text Readability --}}
                                <div class="slideshow-overlay position-absolute w-100 h-100"></div>
                            </div>

                            {{-- Left-Aligned Text Content --}}
                            <div class="slideshow-text container position-absolute start-0 bottom-0 text-white"
                                style="margin-bottom: 10%;">
                                @if ($slide->subtitle_small)
                                    <h6
                                        class="slideshow-subtitle-small text-uppercase fs-6 fw-medium mb-3 animate animate_fade animate_btt animate_delay-3">
                                        {{ $slide->subtitle_small }}
                                    </h6>
                                @endif

                                <h1
                                    class="slideshow-title display-3 fw-bold mb-4 animate animate_fade animate_btt animate_delay-5">
                                    {{ $slide->title_main }}
                                </h1>

                                @if ($slide->subtitle_large)
                                    <h2
                                        class="slideshow-subtitle-large h4 fw-normal mb-5 animate animate_fade animate_btt animate_delay-6">
                                        {{ $slide->subtitle_large }}
                                    </h2>
                                @endif

                                <a href="{{ route('shop.index') }}"
                                    class="btn btn-slideshow slideshow-cta px-5 py-3 animate animate_fade animate_btt animate_delay-7">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Dot Pagination --}}
            <div class="container">
                <div class="slideshow-pagination swiper-pagination position-absolute bottom-0 mb-5 w-100"></div>
            </div>
        </section>
        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <div class="section-title-wrapper">
                    <div class="title-decoration">
                        <span class="section-title">Anda Mungkin Suka</span>
                    </div>
                </div>

                <div class="category-marquee-wrapper">
                    <div class="category-marquee">
                        <div class="category-marquee-content">
                            @foreach ($categories as $category)
                                <div class="category-item">
                                    <img loading="lazy" class="w-100 h-auto mb-3" src="@cloudinary(Str::startsWith($category->image, 'http') ? $category->image : asset('uploads/categories') . '/' . $category->image, 124, 124, 'fill')" width="124"
                                        height="124" alt="{{ $category->name }}" />
                                    <div class="text-center">
                                        <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endforeach
                            {{-- Duplicate 1 for seamless loop --}}
                            @foreach ($categories as $category)
                                <div class="category-item">
                                    <img loading="lazy" class="w-100 h-auto mb-3" src="@cloudinary(Str::startsWith($category->image, 'http') ? $category->image : asset('uploads/categories') . '/' . $category->image, 124, 124, 'fill')" width="124"
                                        height="124" alt="{{ $category->name }}" />
                                    <div class="text-center">
                                        <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endforeach
                            {{-- Duplicate 2 for extra smooth loop --}}
                            @foreach ($categories as $category)
                                <div class="category-item">
                                    <img loading="lazy" class="w-100 h-auto mb-3" src="@cloudinary(Str::startsWith($category->image, 'http') ? $category->image : asset('uploads/categories') . '/' . $category->image, 124, 124, 'fill')" width="124"
                                        height="124" alt="{{ $category->name }}" />
                                    <div class="text-center">
                                        <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            {{-- Latest Products Section --}}
            <section class="latest-products-section">
                <div class="container">
                    <div class="section-title-wrapper">
                        {{-- <h2 class="section-title">Produk Terbaru Kami</h2> --}}
                        <div class="title-decoration">
                            <span class="section-title">
                                Produk Terbaru Kami
                            </span>
                        </div>
                    </div>

                    <div class="latest-products-carousel-wrapper position-relative">
                        <div class="swiper-container js-swiper-slider"
                            data-settings='{
                                "autoplay": {
                                    "delay": 4000,
                                    "disableOnInteraction": false
                                },
                                "slidesPerView": 3,
                                "spaceBetween": 30,
                                "loop": true,
                                "speed": 800,
                                "navigation": {
                                    "nextEl": ".latest-products-next",
                                    "prevEl": ".latest-products-prev"
                                },
                                "breakpoints": {
                                    "320": {
                                        "slidesPerView": 1,
                                        "spaceBetween": 15
                                    },
                                    "768": {
                                        "slidesPerView": 2,
                                        "spaceBetween": 20
                                    },
                                    "1024": {
                                        "slidesPerView": 3,
                                        "spaceBetween": 30
                                    }
                                }
                            }'>
                            <div class="swiper-wrapper">
                                @foreach ($lproducts as $product)
                                    <div class="swiper-slide">
                                        <div class="latest-product-card">
                                            <img src="@cloudinary(Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image, 400)" alt="{{ $product->name }}" class="card-bg">
                                            <div class="card-overlay"></div>
                                            <div class="card-content">
                                                <h3 class="product-name">{{ $product->name }}</h3>
                                                <p class="product-description">
                                                    {{ Str::limit($product->short_description ?? 'Produk berkualitas tinggi dengan harga terbaik untuk kebutuhan Anda.', 100) }}
                                                </p>
                                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                                                    class="product-link">Check Now</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Navigation Arrows - OUTSIDE swiper-container --}}
                        <div class="swiper-button-prev latest-products-prev"></div>
                        <div class="swiper-button-next latest-products-next"></div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>


            {{-- Growing Products Section - Overlapping Cards --}}
            <section class="growing-products-section">
                <div class="container">
                    <div class="growing-products-wrapper">

                        {{-- Left: Image Card with Separate Experience Badge --}}
                        <div class="image-card-container">
                            <div class="growing-image-card">
                                <img src="{{ asset('assets/images/home/demo3/cover-card.jpg') }}" alt="SIPETA Pertanian"
                                    loading="lazy">
                            </div>

                            {{-- Experience Badge - Positioned OUTSIDE the card --}}
                            <div class="experience-badge-wrapper">
                                <div class="experience-badge">
                                    <div class="badge-years">5+</div>
                                    <div class="badge-text">Tahun<br>Pengalaman</div>
                                </div>
                            </div>
                        </div>

                        {{-- Right: White Info Card (Overlaps left card) --}}
                        <div class="info-card-container">
                            <div class="growing-info-card">
                                <p class="section-subtitle">Produk Segar</p>
                                <h2 class="section-title">Produk Berkualitas</h2>
                                <div class="section-stars">★★★★★</div>
                                <p class="section-description">
                                    SIPETA merupakan platform e-commerce yang menghubungkan petani lokal dengan konsumen.
                                    Kami berkomitmen menyediakan produk pertanian segar, organik, dan berkualitas tinggi
                                    langsung dari petani ke meja Anda dengan harga terjangkau.
                                </p>

                                {{-- Progress Bars --}}
                                <div class="progress-bars-wrapper">
                                    {{-- Produk Organik --}}
                                    <div class="progress-item">
                                        <div class="progress-header">
                                            <span class="progress-label">Produk Organik</span>
                                            <span class="progress-percentage">92%</span>
                                        </div>
                                        <div class="progress-bar-container">
                                            <div class="progress-bar-fill" data-progress="92"></div>
                                        </div>
                                    </div>

                                    {{-- Produk Segar --}}
                                    <div class="progress-item">
                                        <div class="progress-header">
                                            <span class="progress-label">Produk Segar</span>
                                            <span class="progress-percentage">95%</span>
                                        </div>
                                        <div class="progress-bar-container">
                                            <div class="progress-bar-fill" data-progress="95"></div>
                                        </div>
                                    </div>

                                    {{-- Kepuasan Pelanggan --}}
                                    <div class="progress-item">
                                        <div class="progress-header">
                                            <span class="progress-label">Kepuasan Pelanggan</span>
                                            <span class="progress-percentage">88%</span>
                                        </div>
                                        <div class="progress-bar-container">
                                            <div class="progress-bar-fill" data-progress="88"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            {{-- CTA Banner Section --}}
            <section class="cta-banner-section"
                style="--bg-image: url('{{ asset('assets/images/home/demo3/cover-card-2.jpg') }}');">
                <div class="cta-content">
                    <h2 class="cta-title">
                        Kami Menyediakan Produk Pertanian Berkualitas Tinggi yang Memenuhi Harapan Anda
                    </h2>
                    <p class="cta-subtitle">
                        Dapatkan produk segar langsung dari petani lokal dengan kualitas terbaik dan harga terjangkau
                    </p>
                    <a href="{{ route('home.about') }}" class="cta-button">Selengkapnya</a>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>


            {{-- Testimonial Section --}}
            <section class="testimonial-section">
                <div class="container">
                    <div class="testimonial-header">
                        <h2 class="testimonial-title">Apa Kata Mereka Tentang SIPETA</h2>
                        <p class="testimonial-subtitle">Testimoni dari pelanggan yang puas</p>
                    </div>

                    <div class="testimonial-grid">
                        @forelse ($testimonials as $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">
                                    {{-- DEBUG: Check both fields --}}
                                    {{-- Email: {{ $testimonial->email }} | Image: {{ $testimonial->user?->image ?? 'NO' }} | Avatar: {{ $testimonial->user?->avatar ?? 'NO' }} --}}

                                    @php
                                        // Prioritize manual upload (image) over OAuth (avatar)
                                        $photoSource = $testimonial->user?->image ?? $testimonial->user?->avatar;
                                    @endphp

                                    @if ($testimonial->user && $photoSource)
                                        @if (Str::startsWith($photoSource, ['http://', 'https://']))
                                            {{-- URL (Google/Cloudinary) --}}
                                            <img src="{{ $photoSource }}" alt="{{ $testimonial->name }}"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @else
                                            {{-- Local file --}}
                                            <img src="{{ asset('uploads/users') }}/{{ $photoSource }}"
                                                alt="{{ $testimonial->name }}"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @endif
                                    @else
                                        {{-- Fallback to initials --}}
                                        {{ strtoupper(mb_substr($testimonial->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="testimonial-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span
                                            class="star {{ $i <= ($testimonial->rating ?? 0) ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <p class="testimonial-quote">
                                    "{{ $testimonial->comment }}"
                                </p>
                                <div class="testimonial-author">
                                    <p class="author-name">{{ $testimonial->name }}</p>
                                    <p class="author-location">{{ $testimonial->phone ?? 'Indonesia' }}</p>
                                </div>
                            </div>
                        @empty
                            {{-- Fallback: Display dummy testimonials if no approved testimonials exist --}}
                            {{-- Testimonial Card 1 --}}
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">BS</div>
                                <div class="testimonial-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                </div>
                                <p class="testimonial-quote">
                                    "Pengiriman cepat dan packing sangat rapi! Produknya benar-benar segar dan berkualitas.
                                    Saya
                                    sangat puas."
                                </p>
                                <div class="testimonial-author">
                                    <p class="author-name">Budi S.</p>
                                    <p class="author-location">Jakarta</p>
                                </div>
                            </div>

                            {{-- Testimonial Card 2 --}}
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">AW</div>
                                <div class="testimonial-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star">★</span>
                                </div>
                                <p class="testimonial-quote">
                                    "Produk organik berkualitas tinggi. Sangat membantu untuk gaya hidup sehat kami.
                                    Recommended!"
                                </p>
                                <div class="testimonial-author">
                                    <p class="author-name">Ani W.</p>
                                    <p class="author-location">Bandung</p>
                                </div>
                            </div>

                            {{-- Testimonial Card 3 --}}
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">DK</div>
                                <div class="testimonial-rating">
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                    <span class="star filled">★</span>
                                </div>
                                <p class="testimonial-quote">
                                    "Harga wajar, recommended! Pelayanan juga sangat ramah. Pasti akan belanja lagi di
                                    sini."
                                </p>
                                <div class="testimonial-author">
                                    <p class="author-name">Dedi K.</p>
                                    <p class="author-location">Surabaya</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="testimonial-cta">
                        <a href="{{ route('home.contact') }}" class="btn-testimonial">
                            Kirim Testimonial Anda →
                        </a>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="products-grid container">
                <div class="section-title-wrapper">
                    <div class="title-decoration">
                        <span class="section-title">Produk Unggulan</span>
                    </div>
                </div>

                <div class="row">
                    @include('shop.partials.products', [
                        'products' => $fproducts,
                        'itemClass' => 'col-6 col-md-4 col-lg-3',
                    ])
                </div>

                <div class="text-center mt-2">
                    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load
                        More</a>
                </div>
            </section>
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        {{-- ========================================
        FAQ SECTION
        ======================================== --}}
        <section class="faq-section">
            <div class="container">
                <div class="faq-header">
                    <h2 class="faq-title">Pertanyaan yang Sering Diajukan</h2>
                    <p class="faq-subtitle">Temukan jawaban untuk pertanyaan umum seputar SIPETA</p>
                </div>

                <div class="faq-accordion">
                    {{-- FAQ Item 1 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Apa itu SIPETA dan apa keunggulannya?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>SIPETA (Sistem Informasi Pemasaran Tanaman Organik) adalah platform e-commerce yang
                                menghubungkan petani lokal dengan konsumen untuk menjual produk pertanian organik
                                berkualitas tinggi. Keunggulan kami adalah produk langsung dari petani, harga terjangkau,
                                dan jaminan kualitas organik.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 2 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Apakah semua produk di SIPETA benar-benar organik?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Ya, semua produk yang ditandai dengan label "Organik" telah melalui proses verifikasi dan
                                berasal dari petani yang menerapkan metode pertanian organik tanpa pestisida kimia. Kami
                                memastikan kualitas produk melalui sistem sertifikasi yang ketat.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 3 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Bagaimana cara melakukan pemesanan?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Anda dapat melakukan pemesanan dengan mudah: 1) Pilih produk yang diinginkan, 2) Klik "Tambah
                                ke Keranjang", 3) Lihat keranjang belanja, 4) Isi data pengiriman, 5) Pilih metode
                                pembayaran, 6) Konfirmasi pesanan. Anda akan menerima notifikasi status pesanan via email.
                            </p>
                        </div>
                    </div>

                    {{-- FAQ Item 4 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Metode pembayaran apa saja yang tersedia?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Kami menerima berbagai metode pembayaran untuk kemudahan Anda: Transfer Bank (BCA, Mandiri,
                                BNI, BRI), E-Wallet (GoPay, OVO, DANA, ShopeePay), dan kartu kredit/debit. Semua transaksi
                                dijamin aman melalui sistem pembayaran terenkripsi.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 5 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Berapa lama waktu pengiriman?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Waktu pengiriman bervariasi tergantung lokasi Anda: Jakarta & sekitarnya (1-2 hari kerja),
                                Jawa (2-3 hari kerja), Luar Jawa (3-5 hari kerja). Untuk produk segar, kami prioritaskan
                                pengiriman kilat agar kualitas tetap terjaga.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 6 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Apakah ada biaya pengiriman?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Biaya pengiriman dihitung berdasarkan berat produk dan jarak pengiriman. Kami juga sering
                                mengadakan promo GRATIS ONGKIR untuk pembelian minimal tertentu. Cek halaman promo kami
                                untuk info terbaru!</p>
                        </div>
                    </div>

                    {{-- FAQ Item 7 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Bagaimana jika produk yang diterima tidak sesuai atau rusak?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Jika produk yang Anda terima tidak sesuai atau rusak, Anda dapat mengajukan pengembalian
                                dalam waktu 1x24 jam setelah penerimaan. Hubungi customer service kami dengan melampirkan
                                foto produk, dan kami akan proses penggantian atau refund sesuai kebijakan.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 8 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Apakah saya bisa menjadi mitra petani di SIPETA?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Tentu! Kami selalu terbuka untuk mitra petani baru. Silakan hubungi tim kami melalui halaman
                                kontak atau WhatsApp untuk informasi lebih lanjut tentang syarat dan prosedur kemitraan.
                                Kami akan membantu Anda me

                                masarkan produk organik Anda.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 9 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Apakah ada program loyalitas atau diskon member?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Ya! Kami memiliki program member dengan berbagai benefit seperti poin reward setiap
                                pembelian, akses early bird ke promo eksklusif, dan diskon khusus member. Daftar sekarang
                                dan nikmati keuntungannya!</p>
                        </div>
                    </div>

                    {{-- FAQ Item 10 --}}
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Bagaimana cara menghubungi customer service?</span>
                            <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Anda dapat menghubungi customer service kami melalui beberapa cara: WhatsApp (tombol hijau di
                                kanan bawah), email di halaman kontak, atau melalui form kontak di website. Tim kami siap
                                membantu Anda Senin-Sabtu, 08:00-17:00 WIB.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>

    {{-- Progress Bars Animation Script --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function to animate progress bars
                function animateProgressBars() {
                    const progressBars = document.querySelectorAll('.progress-bar-fill');

                    progressBars.forEach(bar => {
                        const targetProgress = bar.getAttribute('data-progress');
                        // Delay slightly for stagger effect
                        setTimeout(() => {
                            bar.style.width = targetProgress + '%';
                        }, 100);
                    });
                }

                // Intersection Observer for scroll animation
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Trigger animation when section comes into view
                            animateProgressBars();
                            // Unobserve after animating once
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.3 // Trigger when 30% of section is visible
                });

                // Observe the growing products section
                const section = document.querySelector('.growing-products-section');
                if (section) {
                    observer.observe(section);
                }
            });

            // ========================================
            // FAQ Accordion Functionality
            // ========================================
            document.querySelectorAll('.faq-question').forEach(button => {
                button.addEventListener('click', function() {
                    const faqItem = this.closest('.faq-item');
                    const isActive = faqItem.classList.contains('active');

                    // Close all FAQ items
                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Toggle current item (if it wasn't active)
                    if (!isActive) {
                        faqItem.classList.add('active');
                    }
                });
            });
        </script>
    @endpush
@endsection
