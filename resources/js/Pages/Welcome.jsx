import { Head, Link } from "@inertiajs/react";
import "../../scss/pages/welcome.scss";

export default function Welcome({ auth }) {
    return (
        <>
            <Head title="Welcome - SIPETA" />
            <div className="welcome-page">
                <div className="welcome-background">
                    <div className="overlay"></div>
                    <img
                        src="/images/BG-welcome1.jpg"
                        alt="Ilustrasi Sawah Petani"
                        className="bg-image"
                    />
                </div>

                <div className="welcome-content">
                    <header className="welcome-header">
                        <h1 className="logo">🌾 SIPETA</h1>
                        <nav>
                            {auth.user ? (
                                <Link
                                    href={route("dashboard")}
                                    className="nav-link"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route("login")}
                                        className="nav-link"
                                    >
                                        Login
                                    </Link>
                                    <Link
                                        href={route("register")}
                                        className="nav-link btn-register"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </header>

                    <main className="welcome-main">
                        <div className="hero-text">
                            <h2>
                                Selamat Datang di <span>SIPETA</span>
                            </h2>
                            <p>
                                Pasar Digital untuk Petani Lokal – belanja hasil
                                panen langsung tanpa perantara.
                            </p>
                            <div className="cta-buttons">
                                {auth.user ? (
                                    <Link
                                        href={route("landing")}
                                        className="btn-primary"
                                    >
                                        Lihat Produk
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="btn-primary"
                                        >
                                            Mulai Sekarang
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="btn-outline"
                                        >
                                            Daftar Gratis
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
