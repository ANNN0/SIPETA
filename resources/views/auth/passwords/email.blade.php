@extends('layouts.auth')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">
            {{-- Left Panel - Branding --}}
            <div class="auth-left-panel">
                <div class="auth-logo-container">
                    <img src="{{ asset('images/logo/sipeta-logo.svg') }}" alt="SIPETA Logo" class="auth-logo-image">
                    <div class="auth-brand-text">
                        <h2>SIPETA</h2>
                        <p>Sistem Informasi Penjualan Tani</p>
                        <p style="margin-top: 8px; font-size: 13px;">Lupa password? Jangan khawatir, kami akan mengirimkan
                            link reset ke email Anda</p>
                    </div>
                </div>
            </div>

            {{-- Right Panel - Forgot Password Form --}}
            <div class="auth-right-panel">
                <div class="auth-form-container">
                    {{-- Header --}}
                    <div class="auth-header">
                        <h1>LUPA PASSWORD</h1>
                        <p>Masukkan email Anda untuk Reset Password</p>
                    </div>

                    {{-- Success Message --}}
                    @if (session('status'))
                        <div
                            style="padding: 12px 16px; background-color: #d1fae5; border-left: 4px solid #10b981; border-radius: 8px; margin-bottom: 24px;">
                            <p style="margin: 0; color: #065f46; font-size: 14px;">
                                <strong>✓ Berhasil!</strong> {{ session('status') }}
                            </p>
                        </div>
                    @endif

                    {{-- Forgot Password Form --}}
                    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                        @csrf

                        {{-- Email Input --}}
                        <div class="auth-input-group">
                            <label for="email">
                                Email Address <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <span class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.33333 3.33334H16.6667C17.5833 3.33334 18.3333 4.08334 18.3333 5.00001V15C18.3333 15.9167 17.5833 16.6667 16.6667 16.6667H3.33333C2.41667 16.6667 1.66667 15.9167 1.66667 15V5.00001C1.66667 4.08334 2.41667 3.33334 3.33333 3.33334Z"
                                            stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M18.3333 5L10 10.8333L1.66667 5" stroke="#9CA3AF" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="user@sipeta.com" class="@error('email') is-invalid @enderror" required
                                    autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Send Reset Link Button --}}
                        <button type="submit" class="auth-button">
                            Kirim Link Reset Password
                        </button>

                        {{-- Back to Login Link --}}
                        <div class="auth-footer-text">
                            Ingat password Anda?
                            <a href="{{ route('login') }}" class="auth-link">Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
