import { useState } from "react";
import Checkbox from "@/Components/Checkbox";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import "../../../scss/pages/Auth/login.scss";

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);

    const submit = (e) => {
        e.preventDefault();
        post(route("login"), {
            onFinish: () => reset("password"),
        });
    };

    return (
        <GuestLayout>
            <Head title="Login - SIPETA" />

            <div className="login-container">
                <div className="login-background">
                    <div className="overlay"></div>
                    <img
                        src="/images/BG-Login.jpg"
                        alt="Ilustrasi Sawah Petani"
                        className="bg-image"
                    />
                </div>

                <div className="login-card">
                    <div className="login-header">
                        <span className="logo-icon">🌾</span>
                        <h1>SIPETA</h1>
                        <p>Pasar Digital untuk Petani Lokal</p>
                    </div>

                    {status && <div className="status-message">{status}</div>}

                    <form onSubmit={submit} className="login-form">
                        {/* Email */}
                        <div className="form-group">
                            <InputLabel htmlFor="email" value="Email" />
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                className="form-input"
                                autoComplete="username"
                                autoFocus
                            />
                            <InputError message={errors.email} />
                        </div>

                        {/* Password */}
                        <div className="form-group">
                            <InputLabel htmlFor="password" value="Password" />
                            <div className="password-wrapper">
                                <input
                                    id="password"
                                    type={showPassword ? "text" : "password"}
                                    name="password"
                                    value={data.password}
                                    onChange={(e) =>
                                        setData("password", e.target.value)
                                    }
                                    className="form-input"
                                    autoComplete="current-password"
                                />

                                <button
                                    type="button"
                                    className="toggle-password"
                                    onClick={() =>
                                        setShowPassword(!showPassword)
                                    }
                                >
                                    {showPassword ? (
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                            />
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                            />
                                        </svg>
                                    ) : (
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                            />
                                            <line
                                                x1="1"
                                                y1="1"
                                                x2="23"
                                                y2="23"
                                                stroke="currentColor"
                                                strokeWidth="2"
                                            />
                                        </svg>
                                    )}
                                </button>
                            </div>
                            <InputError message={errors.password} />
                        </div>

                        {/* Remember Me */}
                        <div className="form-remember">
                            <label>
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData("remember", e.target.checked)
                                    }
                                />
                                <span>Ingat saya</span>
                            </label>
                        </div>

                        {/* Actions */}
                        <div className="form-actions">
                            {canResetPassword && (
                                <Link
                                    href={route("password.request")}
                                    className="forgot-link"
                                >
                                    Lupa password?
                                </Link>
                            )}
                            <PrimaryButton
                                className="btn-login"
                                disabled={processing}
                            >
                                Masuk
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
