import { Head, Link } from "@inertiajs/react";
import React, { useState, useEffect } from "react";
import {
    ResponsiveContainer,
    LineChart,
    Line,
    CartesianGrid,
    XAxis,
    YAxis,
    Tooltip,
    Legend,
} from "recharts";

import "../../scss/pages/landing.scss";

export default function Landing() {
    const [isScrolled, setIsScrolled] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 50);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    const chartData = [
        { year: 2020, hasil: 45 },
        { year: 2021, hasil: 52 },
        { year: 2022, hasil: 68 },
        { year: 2023, hasil: 82 },
        { year: 2024, hasil: 95 },
        { year: 2025, hasil: 110 },
    ];

    const panduan = [
        {
            step: 1,
            title: "Pilih Produk",
            desc: "Jelajahi berbagai produk hasil tani segar dari petani lokal pilihan kami.",
            icon: "🛍️",
        },
        {
            step: 2,
            title: "Tambah ke Keranjang",
            desc: "Pilih jumlah yang Anda inginkan dan tambahkan ke keranjang belanja Anda.",
            icon: "🛒",
        },
        {
            step: 3,
            title: "Checkout",
            desc: "Isi data pengiriman dan pilih metode pembayaran yang tersedia.",
            icon: "💳",
        },
        {
            step: 4,
            title: "Terima Pesanan",
            desc: "Produk akan dikirim langsung ke rumah Anda dalam kondisi segar.",
            icon: "📦",
        },
    ];

    const reviews = [
        {
            name: "Siti Nurhaliza",
            rating: 5,
            comment:
                "Produk sangat segar dan berkualitas! Pengiriman cepat dan packaging rapi. Pasti akan order lagi!",
            avatar: "👩‍🦰",
            location: "Jakarta",
        },
        {
            name: "Budi Hartono",
            rating: 5,
            comment:
                "Harga lebih murah dari pasar tradisional dan kualitasnya lebih terjamin. Sangat puas dengan layanannya.",
            avatar: "👨‍💼",
            location: "Bandung",
        },
        {
            name: "Rina Wijaya",
            rating: 4,
            comment:
                "Sayuran organik yang benar-benar organik. Rasanya lebih nikmat dan sehat untuk keluarga saya.",
            avatar: "👩‍🌾",
            location: "Surabaya",
        },
        {
            name: "Ahmad Suryanto",
            rating: 5,
            comment:
                "Mendukung petani lokal sambil mendapatkan produk berkualitas. Win-win solution yang sempurna!",
            avatar: "👨‍🌾",
            location: "Yogyakarta",
        },
    ];

    const products = [
        {
            id: 1,
            name: "Beras Organik Premium",
            price: "Rp 50.000",
            unit: "/ 5kg",
            rating: 5,
            reviews: 128,
            badge: "🔥 Hot",
            badgeType: "hot",
            image: "/beras-organik-premium.jpg",
        },
        {
            id: 2,
            name: "Paket Sayur Segar",
            price: "Rp 20.000",
            unit: "/ pack",
            rating: 5,
            reviews: 95,
            badge: "✨ New",
            badgeType: "new",
            image: "/sayur-segar-organik.jpg",
        },
        {
            id: 3,
            name: "Buah Lokal Segar",
            price: "Rp 25.000",
            unit: "/ kg",
            rating: 5,
            reviews: 73,
            badge: "🌿 Organik",
            badgeType: "organic",
            image: "/buah-lokal-segar.jpg",
        },
        {
            id: 4,
            name: "Telur Ayam Kampung",
            price: "Rp 35.000",
            unit: "/ 10 butir",
            rating: 5,
            reviews: 156,
            badge: "🌟 Best",
            badgeType: "best",
            image: "/telur-ayam-kampung-segar.jpg",
        },
    ];

    return (
        <>
            <Head title="Landing" />
            <div className="home-container">
                {/* Navbar */}
                <nav className={`navbar ${isScrolled ? "scrolled" : ""}`}>
                    <div className="navbar-container">
                        <div className="navbar-logo">
                            <span className="logo-icon">🌾</span>
                            <span className="logo-text">SIPETA</span>
                        </div>
                        <ul className="navbar-links">
                            <li>
                                <a href="#produk">Produk</a>
                            </li>
                            <li>
                                <a href="#review">Review</a>
                            </li>
                            <li>
                                <a href="#statistik">Statistik</a>
                            </li>
                            <li>
                                <a href="#panduan">Panduan</a>
                            </li>
                        </ul>
                        <button className="navbar-btn">
                            <span>Gabung</span>
                            <div className="btn-glow"></div>
                        </button>
                    </div>
                </nav>

                {/* Section 1: Hero Section */}
                <section className="hero">
                    <div className="hero-background">
                        <div className="hero-gradient"></div>
                        <div className="floating-elements">
                            <div className="float-element float-1">🌱</div>
                            <div className="float-element float-2">🥕</div>
                            <div className="float-element float-3">🌽</div>
                            <div className="float-element float-4">🍅</div>
                        </div>
                    </div>
                    <div className="hero-content">
                        <h1 className="hero-title">
                            <span className="title-gradient">
                                Pasar Digital
                            </span>
                            <span className="title-highlight">
                                untuk Petani Lokal
                            </span>
                        </h1>
                        <p className="hero-subtitle">
                            Menghubungkan petani langsung dengan konsumen tanpa
                            perantara. Hasil tani segar, harga adil, dan
                            kualitas terjamin.
                        </p>

                        <div className="hero-buttons">
                            <button className="btn-primary pulse">
                                <span>Mulai Belanja</span>
                                <div className="btn-shine"></div>
                            </button>
                            <button className="btn-secondary">
                                <span>Lihat Produk</span>
                                <svg className="btn-icon" viewBox="0 0 24 24">
                                    <path
                                        d="M5 12h14M12 5l7 7-7 7"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                        fill="none"
                                    />
                                </svg>
                            </button>
                        </div>

                        <div className="features">
                            <div className="feature-card">
                                <div className="feature-icon">💼</div>
                                <h3>Tanpa Tengkulak</h3>
                                <p>Jual langsung tanpa perantara</p>
                            </div>
                            <div className="feature-card">
                                <div className="feature-icon">📈</div>
                                <h3>Harga Pasar Aktual</h3>
                                <p>Harga terbaru dan transparan</p>
                            </div>
                            <div className="feature-card">
                                <div className="feature-icon">🤝</div>
                                <h3>Koneksi Langsung</h3>
                                <p>Komunikasi real-time dengan pembeli</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Section 2: Products Section */}
                <section className="products" id="produk">
                    <div className="section-header">
                        <h2 className="section-title">Produk Unggulan</h2>
                        <p className="section-subtitle">
                            Langsung dari petani ke meja makanmu
                        </p>
                    </div>

                    <div className="product-grid">
                        {products.map((product) => (
                            <div key={product.id} className="product-card">
                                <div
                                    className={`product-badge badge-${product.badgeType}`}
                                >
                                    {product.badge}
                                </div>
                                <div className="product-image-container">
                                    <img
                                        src={
                                            product.image || "/placeholder.svg"
                                        }
                                        alt={product.name}
                                        className="product-img"
                                    />
                                    <div className="product-overlay">
                                        <button className="quick-view">
                                            👁️ Quick View
                                        </button>
                                    </div>
                                </div>
                                <div className="product-info">
                                    <h3 className="product-name">
                                        {product.name}
                                    </h3>
                                    <div className="product-rating">
                                        <span className="stars">
                                            ⭐⭐⭐⭐⭐
                                        </span>
                                        <span className="rating-count">
                                            ({product.reviews})
                                        </span>
                                    </div>
                                    <div className="product-price">
                                        <span className="current-price">
                                            {product.price}
                                        </span>
                                        <span className="price-unit">
                                            {product.unit}
                                        </span>
                                    </div>
                                    <button className="btn-cart">
                                        <span>🛒 Tambah ke Keranjang</span>
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                </section>

                {/* Section 3: Customer Reviews */}
                <section className="reviews-section" id="review">
                    <div className="section-header">
                        <h2 className="section-title">Testimoni Pelanggan</h2>
                        <p className="section-subtitle">
                            Kepuasan pelanggan adalah prioritas kami
                        </p>
                    </div>

                    <div className="reviews-grid">
                        {reviews.map((review, index) => (
                            <div key={index} className="review-card">
                                <div className="review-header">
                                    <div className="reviewer-info">
                                        <span className="reviewer-avatar">
                                            {review.avatar}
                                        </span>
                                        <div>
                                            <h4 className="reviewer-name">
                                                {review.name}
                                            </h4>
                                            <p className="reviewer-location">
                                                {review.location}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="review-rating">
                                        {"⭐".repeat(review.rating)}
                                    </div>
                                </div>
                                <p className="review-comment">
                                    "{review.comment}"
                                </p>
                            </div>
                        ))}
                    </div>
                </section>

                {/* Section 4: Statistics Chart */}
                <section className="statistics-section" id="statistik">
                    <div className="section-header">
                        <h2 className="section-title">
                            Pertumbuhan Hasil Panen
                        </h2>
                        <p className="section-subtitle">
                            Statistik hasil panen dari tahun 2020-2025
                        </p>
                    </div>

                    <div className="chart-container">
                        <ResponsiveContainer width="100%" height={400}>
                            <LineChart
                                data={chartData}
                                margin={{
                                    top: 5,
                                    right: 30,
                                    left: 0,
                                    bottom: 5,
                                }}
                            >
                                <CartesianGrid
                                    strokeDasharray="3 3"
                                    stroke="#e0e0e0"
                                />
                                <XAxis dataKey="year" stroke="#666" />
                                <YAxis stroke="#666" />
                                <Tooltip
                                    contentStyle={{
                                        backgroundColor: "#fff",
                                        border: "2px solid #27ae60",
                                        borderRadius: "10px",
                                    }}
                                    formatter={(value) => [
                                        `${value} ton`,
                                        "Hasil Panen",
                                    ]}
                                />
                                <Legend />
                                <Line
                                    type="monotone"
                                    dataKey="hasil"
                                    stroke="#27ae60"
                                    strokeWidth={3}
                                    dot={{ fill: "#27ae60", r: 6 }}
                                    activeDot={{ r: 8 }}
                                    name="Hasil Panen (ton)"
                                />
                            </LineChart>
                        </ResponsiveContainer>
                    </div>
                </section>

                {/* Section 5: Panduan Membeli */}
                <section className="panduan-section" id="panduan">
                    <div className="section-header">
                        <h2 className="section-title">Panduan Membeli</h2>
                        <p className="section-subtitle">
                            Langkah mudah untuk mendapatkan produk segar
                        </p>
                    </div>

                    <div className="panduan-grid">
                        {panduan.map((item, index) => (
                            <div key={index} className="panduan-card">
                                <div className="panduan-number">
                                    {item.step}
                                </div>
                                <div className="panduan-icon">{item.icon}</div>
                                <h3 className="panduan-title">{item.title}</h3>
                                <p className="panduan-desc">{item.desc}</p>
                                {index < panduan.length - 1 && (
                                    <div className="panduan-arrow">→</div>
                                )}
                            </div>
                        ))}
                    </div>
                </section>

                {/* Footer */}
                <footer className="footer">
                    <div className="footer-container">
                        <div className="footer-main">
                            <div className="footer-logo">
                                <span className="logo-icon">🌾</span>
                                <span className="logo-text">SIPETA</span>
                            </div>
                            <p className="footer-desc">
                                Platform digital terdepan yang menghubungkan
                                petani lokal dengan konsumen secara langsung.
                            </p>
                            <div className="social-links">
                                <a href="#" className="social-link">
                                    📘
                                </a>
                                <a href="#" className="social-link">
                                    📷
                                </a>
                                <a href="#" className="social-link">
                                    🐦
                                </a>
                                <a href="#" className="social-link">
                                    📺
                                </a>
                            </div>
                        </div>
                        <div className="footer-links">
                            <div className="link-column">
                                <h4>Perusahaan</h4>
                                <a href="#">Tentang Kami</a>
                                <a href="#">Karir</a>
                                <a href="#">Berita</a>
                            </div>
                            <div className="link-column">
                                <h4>Bantuan</h4>
                                <a href="#">FAQ</a>
                                <a href="#">Kontak</a>
                                <a href="#">Support</a>
                            </div>
                            <div className="link-column">
                                <h4>Legal</h4>
                                <a href="#">Kebijakan Privasi</a>
                                <a href="#">Syarat & Ketentuan</a>
                                <a href="#">Cookie Policy</a>
                            </div>
                        </div>
                    </div>
                    <div className="footer-bottom">
                        <p>
                            © {new Date().getFullYear()} SIPETA. Semua Hak
                            Dilindungi.
                        </p>
                        <p>Made with ❤️ for Indonesian Farmers</p>
                    </div>
                </footer>
            </div>
        </>
    );
}
