@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>

        {{-- Section 1: Hero with Card Stack --}}
        <section class="about-page__section-1">
            <div class="about-page__container">
                <div class="about-page__row">
                    {{-- Left Column: Content --}}
                    <div class="about-page__content">
                        <h1 class="about-page__title">Menghubungkan Petani dengan Konsumen</h1>
                        <p class="about-page__subtitle">Platform Digital untuk Produk Pertanian Segar dan Berkualitas</p>

                        <p class="about-page__description">
                            SIPETA (Sistem Informasi Penjualan Tanaman) adalah platform digital yang menghubungkan petani
                            lokal langsung dengan konsumen. Kami berkomitmen untuk menyediakan produk pertanian segar,
                            berkualitas tinggi, dan organik dari tangan petani ke meja makan Anda.
                        </p>
                        {{-- 
                        <p class="about-page__description">
                            Dengan SIPETA, setiap pembelian yang Anda lakukan tidak hanya mendukung kesehatan keluarga,
                            tetapi juga memberdayakan petani lokal dan mendorong praktik pertanian yang berkelanjutan. Kami
                            percaya bahwa makanan segar dan sehat adalah hak setiap orang, dan kami hadir untuk
                            mewujudkannya.
                        </p>

                        <p class="about-page__description">
                            Bergabunglah dengan ribuan keluarga yang telah mempercayai SIPETA sebagai mitra terbaik untuk
                            memenuhi kebutuhan produk pertanian berkualitas. Mari bersama membangun ekosistem pertanian yang
                            lebih sehat dan berkelanjutan.
                        </p> --}}
                    </div>

                    {{-- Right Column: Swiper Card Stack --}}
                    <div class="about-page__swiper-wrapper">
                        <div class="swiper about-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="SIPETA - Produk Segar">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="SIPETA - Petani Lokal">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="SIPETA - Organik">
                                </div>
                            </div>

                            {{-- Navigation --}}
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            {{-- Pagination --}}
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: Story with Figure-8 Image and Accordion --}}
        <section class="about-page__section-2">
            <div class="about-page__container">
                <div class="about-page__row-reverse">
                    {{-- Left: Figure-8 Image --}}
                    <div class="about-page__image-wrapper">
                        <div class="about-page__figure8-image">
                            <img src="{{ asset('uploads/farmers/Farmers - 1.jpg') }}" alt="SIPETA - Petani Indonesia">
                        </div>
                    </div>

                    {{-- Right: Accordion Content --}}
                    <div class="about-page__story-content">
                        <h2 class="about-page__section-title">
                            Cerita Dibalik <span class="d-md-inline d-block">Platform SIPETA</span>
                        </h2>

                        <div class="about-page__accordion">
                            {{-- Accordion Item 1 --}}
                            <div class="about-page__accordion-item">
                                <button class="about-page__accordion-header" data-accordion="item-1">
                                    <div class="about-page__accordion-left">
                                        <span class="about-page__story-number">01</span>
                                        <h3 class="about-page__story-heading">Kualitas Terjamin</h3>
                                    </div>
                                    <svg class="about-page__accordion-arrow" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="about-page__accordion-content" id="item-1">
                                    <p class="about-page__story-description">
                                        Produk organik langsung dari petani terpercaya yang telah terverifikasi kualitasnya.
                                        Setiap produk melewati proses seleksi ketat untuk memastikan hanya hasil terbaik
                                        yang sampai ke tangan Anda.
                                    </p>
                                </div>
                            </div>

                            {{-- Dashed Border --}}
                            <div class="about-page__dashed-border"></div>

                            {{-- Accordion Item 2 --}}
                            <div class="about-page__accordion-item">
                                <button class="about-page__accordion-header" data-accordion="item-2">
                                    <div class="about-page__accordion-left">
                                        <span class="about-page__story-number">02</span>
                                        <h3 class="about-page__story-heading">Transparansi</h3>
                                    </div>
                                    <svg class="about-page__accordion-arrow" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="about-page__accordion-content" id="item-2">
                                    <p class="about-page__story-description">
                                        Sistem tracking lengkap dari kebun hingga konsumen untuk memastikan keaslian produk.
                                        Anda dapat melacak perjalanan setiap produk dan mengetahui asal-usulnya dengan
                                        jelas.
                                    </p>
                                </div>
                            </div>

                            {{-- Dashed Border --}}
                            <div class="about-page__dashed-border"></div>

                            {{-- Accordion Item 3 --}}
                            <div class="about-page__accordion-item">
                                <button class="about-page__accordion-header" data-accordion="item-3">
                                    <div class="about-page__accordion-left">
                                        <span class="about-page__story-number">03</span>
                                        <h3 class="about-page__story-heading">Keberlanjutan</h3>
                                    </div>
                                    <svg class="about-page__accordion-arrow" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="about-page__accordion-content" id="item-3">
                                    <p class="about-page__story-description">
                                        Mendukung pertanian berkelanjutan dan memberdayakan petani lokal Indonesia.
                                        Setiap pembelian Anda berkontribusi langsung pada kesejahteraan petani dan
                                        kelestarian lingkungan.
                                    </p>
                                </div>
                            </div>

                            {{-- Dashed Border --}}
                            <div class="about-page__dashed-border"></div>

                            {{-- Accordion Item 4 --}}
                            <div class="about-page__accordion-item">
                                <button class="about-page__accordion-header" data-accordion="item-4">
                                    <div class="about-page__accordion-left">
                                        <span class="about-page__story-number">04</span>
                                        <h3 class="about-page__story-heading">Berbagai Metode Pembayaran</h3>
                                    </div>
                                    <svg class="about-page__accordion-arrow" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="about-page__accordion-content" id="item-4">
                                    <p class="about-page__story-description">
                                        Kami menyediakan berbagai pilihan metode pembayaran yang aman dan terpercaya untuk
                                        kemudahan transaksi Anda. Mulai dari transfer bank, e-wallet populer seperti GoPay,
                                        OVO, dan DANA, hingga pembayaran melalui gerai retail terdekat. Semua proses
                                        pembayaran dilindungi dengan sistem keamanan terkini untuk menjamin kenyamanan
                                        berbelanja Anda di SIPETA.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper with Coverflow Effect (card-stack style)
            const aboutSwiper = new Swiper('.about-swiper', {
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: 'auto',
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                speed: 800,
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 100,
                    modifier: 1.2,
                    slideShadows: false, // NO SHADOWS as requested
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
            });

            // Accordion functionality
            const accordionHeaders = document.querySelectorAll('.about-page__accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-accordion');
                    const content = document.getElementById(targetId);
                    const isActive = this.classList.contains('active');

                    // Close all accordions
                    accordionHeaders.forEach(h => h.classList.remove('active'));
                    document.querySelectorAll('.about-page__accordion-content').forEach(c => {
                        c.classList.remove('active');
                    });

                    // Open clicked accordion if it wasn't active
                    if (!isActive) {
                        this.classList.add('active');
                        content.classList.add('active');
                    }
                });
            });
        });
    </script>
@endpush
