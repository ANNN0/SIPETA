@extends('layouts.auth')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container" id="auth-container">
            {{-- ============================================ --}}
            {{-- LEFT PANEL - IMAGE (Login) / FORM (Register) --}}
            {{-- ============================================ --}}
            <div class="auth-panel auth-panel-left">
                {{-- Image Overlay (Visible on Login) --}}
                <div class="auth-panel-overlay" id="left-overlay"
                    style="background-image: url('{{ asset('assets/images/login/farmland-min.jpg') }}');">
                    <div class="auth-panel-logo">
                        <img src="{{ asset('images/logo/sipeta-logo.svg') }}" alt="SIPETA Logo">
                        <span>SIPETA</span>
                    </div>
                    <div class="auth-panel-content">
                        <h2>Dari Petani, Untuk Indonesia</h2>
                        <p>Temukan produk pertanian segar berkualitas langsung dari petani lokal. SIPETA menghubungkan Anda
                            dengan hasil panen terbaik, mendukung pertanian berkelanjutan, dan memastikan kesejahteraan
                            petani Indonesia.</p>
                    </div>
                </div>

                {{-- Register Form (Hidden by default, slides in) --}}
                <div class="auth-form-wrapper" id="register-form-wrapper">
                    <div class="auth-form-container">
                        <div class="auth-header">
                            <p>Bergabunglah dengan SIPETA</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="auth-form">
                            @csrf

                            {{-- Name Input --}}
                            <div class="auth-input-group">
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.6667 17.5V15.8333C16.6667 14.9493 16.3155 14.1014 15.6904 13.4763C15.0652 12.8512 14.2174 12.5 13.3333 12.5H6.66667C5.78261 12.5 4.93477 12.8512 4.30964 13.4763C3.68452 14.1014 3.33333 14.9493 3.33333 15.8333V17.5"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M10 9.16667C11.8409 9.16667 13.3333 7.67428 13.3333 5.83333C13.3333 3.99238 11.8409 2.5 10 2.5C8.15905 2.5 6.66667 3.99238 6.66667 5.83333C6.66667 7.67428 8.15905 9.16667 10 9.16667Z"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <input type="text" id="reg-name" name="name" value="{{ old('name') }}"
                                        placeholder="Nama Lengkap" class="@error('name') is-invalid @enderror" required
                                        autocomplete="name">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Email Input --}}
                            <div class="auth-input-group">
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
                                    <input type="email" id="reg-email" name="email" value="{{ old('email') }}"
                                        placeholder="Alamat Email" class="@error('email') is-invalid @enderror" required
                                        autocomplete="email">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Mobile Input --}}
                            <div class="auth-input-group">
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.3333 1.66667H6.66667C5.74619 1.66667 5 2.41286 5 3.33334V16.6667C5 17.5871 5.74619 18.3333 6.66667 18.3333H13.3333C14.2538 18.3333 15 17.5871 15 16.6667V3.33334C15 2.41286 14.2538 1.66667 13.3333 1.66667Z"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M10 15H10.0083" stroke="#9CA3AF" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <input type="text" id="reg-mobile" name="mobile" value="{{ old('mobile') }}"
                                        placeholder="08xxxxxxxxxx" class="@error('mobile') is-invalid @enderror" required>
                                </div>
                                @error('mobile')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Password Input --}}
                            <div class="auth-input-group">
                                <div class="input-wrapper icon-left">
                                    <span class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M5.83333 9.16667V5.83333C5.83333 4.72826 6.27232 3.66846 7.05372 2.88706C7.83512 2.10565 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10565 12.9463 2.88706C13.7277 3.66846 14.1667 4.72826 14.1667 5.83333V9.16667"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <input type="password" id="reg-password" name="password" placeholder="Password"
                                        class="@error('password') is-invalid @enderror" required
                                        autocomplete="new-password">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('reg-password')">
                                        <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.833344 10C0.833344 10 4.16668 3.33334 10 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg class="eye-closed" style="display: none;" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.95 14.95C13.5255 16.0358 11.7909 16.6374 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10C1.87007 8.06825 3.30772 6.38051 5.05001 5.05M8.25001 3.53333C8.82297 3.39907 9.41013 3.33195 10 3.33333C15.8333 3.33333 19.1667 10 19.1667 10C18.6609 10.9463 18.0575 11.8373 17.3667 12.6583M11.7667 11.7667C11.5378 12.0123 11.2617 12.2093 10.9552 12.3459C10.6487 12.4826 10.3181 12.556 9.98249 12.562C9.64689 12.5679 9.31402 12.5061 9.00283 12.3804C8.69164 12.2547 8.40847 12.0675 8.17045 11.8295C7.93244 11.5914 7.74523 11.3083 7.61952 10.9971C7.49382 10.6859 7.43205 10.353 7.43798 10.0174C7.44391 9.68183 7.51741 9.35121 7.65407 9.04471C7.79072 8.73821 7.9877 8.46209 8.23334 8.23333"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="auth-input-group">
                                <div class="input-wrapper icon-left">
                                    <span class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M5.83333 9.16667V5.83333C5.83333 4.72826 6.27232 3.66846 7.05372 2.88706C7.83512 2.10565 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10565 12.9463 2.88706C13.7277 3.66846 14.1667 4.72826 14.1667 5.83333V9.16667"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <input type="password" id="reg-password-confirm" name="password_confirmation"
                                        placeholder="Konfirmasi Password" required autocomplete="new-password">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('reg-password-confirm')">
                                        <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.833344 10C0.833344 10 4.16668 3.33334 10 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg class="eye-closed" style="display: none;" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.95 14.95C13.5255 16.0358 11.7909 16.6374 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10C1.87007 8.06825 3.30772 6.38051 5.05001 5.05M8.25001 3.53333C8.82297 3.39907 9.41013 3.33195 10 3.33333C15.8333 3.33333 19.1667 10 19.1667 10C18.6609 10.9463 18.0575 11.8373 17.3667 12.6583M11.7667 11.7667C11.5378 12.0123 11.2617 12.2093 10.9552 12.3459C10.6487 12.4826 10.3181 12.556 9.98249 12.562C9.64689 12.5679 9.31402 12.5061 9.00283 12.3804C8.69164 12.2547 8.40847 12.0675 8.17045 11.8295C7.93244 11.5914 7.74523 11.3083 7.61952 10.9971C7.49382 10.6859 7.43205 10.353 7.43798 10.0174C7.44391 9.68183 7.51741 9.35121 7.65407 9.04471C7.79072 8.73821 7.9877 8.46209 8.23334 8.23333"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Privacy Notice --}}
                            <div
                                style="margin-bottom: 24px; padding: 12px; background-color: #f9fafb; border-radius: 8px; border-left: 3px solid #1a7a3e;">
                                <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                                    Data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di platform ini,
                                    mengelola
                                    akses ke akun Anda, dan tujuan lain yang dijelaskan dalam kebijakan privasi kami.
                                </p>
                            </div>

                            <button type="submit" class="auth-button">Daftar Sekarang</button>

                            <div class="auth-footer-text">
                                Sudah punya akun?
                                <a href="javascript:void(0)" class="auth-link" onclick="toggleAuthMode('login')">Login di
                                    sini</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Forgot Password Form --}}
                <div class="auth-form-wrapper" id="forgot-form-wrapper">
                    <div class="auth-form-container">
                        <div class="auth-header">
                            <h1>Lupa Password?</h1>
                            <p>Masukkan email Anda untuk mendapatkan link reset password</p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" class="auth-form"
                            id="forgot-password-form">
                            @csrf
                            <div class="auth-input-group">
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
                                    <input type="email" id="forgot-email" name="email" value="{{ old('email') }}"
                                        placeholder="Alamat Email" required autocomplete="email">
                                </div>
                                <span class="invalid-feedback" id="forgot-email-error" style="display: none;"></span>
                            </div>

                            <button type="submit" class="auth-button">Kirim Link Reset</button>

                            <div class="auth-footer-text">
                                Ingat password Anda?
                                <a href="javascript:void(0)" class="auth-link" onclick="toggleAuthMode('login')">Kembali
                                    ke Login</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Reset Password Form (Actual reset with token) --}}
                @if (isset($token))
                    <div class="auth-form-wrapper" id="reset-password-wrapper">
                        <div class="auth-form-container">
                            <div class="auth-header">
                                <h1>Reset Password</h1>
                                <p>Buat password baru untuk akun Anda</p>
                            </div>

                            <form method="POST" action="{{ route('password.update') }}" class="auth-form"
                                id="actual-reset-form">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="auth-input-group">
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3.33333 3.33334H16.6667C17.5833 3.33334 18.3333 4.08334 18.3333 5.00001V15C18.3333 15.9167 17.5833 16.6667 16.6667 16.6667H3.33333C2.41667 16.6667 1.66667 15.9167 1.66667 15V5.00001C1.66667 4.08334 2.41667 3.33334 3.33333 3.33334Z"
                                                    stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M18.3333 5L10 10.8333L1.66667 5" stroke="#9CA3AF"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <input type="email" id="reset-email" name="email"
                                            value="{{ $email ?? old('email') }}" placeholder="Alamat Email" required
                                            autocomplete="email">
                                    </div>
                                </div>

                                <div class="auth-input-group">
                                    <div class="input-wrapper icon-left">
                                        <span class="input-icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z"
                                                    stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M5.83333 9.16667V5.83333C5.83333 4.72826 6.27232 3.66846 7.05372 2.88706C7.83512 2.10565 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10565 12.9463 2.88706C13.7277 3.66846 14.1667 4.72826 14.1667 5.83333V9.16667"
                                                    stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <input type="password" id="reset-password" name="password"
                                            placeholder="Password Baru" required autocomplete="new-password">
                                        <button type="button" class="password-toggle"
                                            onclick="togglePassword('reset-password')">
                                            <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.833344 10C0.833344 10 4.16668 3.33334 10 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <svg class="eye-closed" style="display: none;" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.95 14.95C13.5255 16.0358 11.7909 16.6374 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10C1.87007 8.06825 3.30772 6.38051 5.05001 5.05M8.25001 3.53333C8.82297 3.39907 9.41013 3.33195 10 3.33333C15.8333 3.33333 19.1667 10 19.1667 10C18.6609 10.9463 18.0575 11.8373 17.3667 12.6583M11.7667 11.7667C11.5378 12.0123 11.2617 12.2093 10.9552 12.3459C10.6487 12.4826 10.3181 12.556 9.98249 12.562C9.64689 12.5679 9.31402 12.5061 9.00283 12.3804C8.69164 12.2547 8.40847 12.0675 8.17045 11.8295C7.93244 11.5914 7.74523 11.3083 7.61952 10.9971C7.49382 10.6859 7.43205 10.353 7.43798 10.0174C7.44391 9.68183 7.51741 9.35121 7.65407 9.04471C7.79072 8.73821 7.9877 8.46209 8.23334 8.23333"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="auth-input-group">
                                    <div class="input-wrapper icon-left">
                                        <span class="input-icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z"
                                                    stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M5.83333 9.16667V5.83333C5.83333 4.72826 6.27232 3.66846 7.05372 2.88706C7.83512 2.10565 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10565 12.9463 2.88706C13.7277 3.66846 14.1667 4.72826 14.1667 5.83333V9.16667"
                                                    stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <input type="password" id="reset-password-confirm" name="password_confirmation"
                                            placeholder="Konfirmasi Password Baru" required autocomplete="new-password">
                                        <button type="button" class="password-toggle"
                                            onclick="togglePassword('reset-password-confirm')">
                                            <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M0.833344 10C0.833344 10 4.16668 3.33334 10 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <svg class="eye-closed" style="display: none;" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.95 14.95C13.5255 16.0358 11.7909 16.6374 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10C1.87007 8.06825 3.30772 6.38051 5.05001 5.05M8.25001 3.53333C8.82297 3.39907 9.41013 3.33195 10 3.33333C15.8333 3.33333 19.1667 10 19.1667 10C18.6609 10.9463 18.0575 11.8373 17.3667 12.6583M11.7667 11.7667C11.5378 12.0123 11.2617 12.2093 10.9552 12.3459C10.6487 12.4826 10.3181 12.556 9.98249 12.562C9.64689 12.5679 9.31402 12.5061 9.00283 12.3804C8.69164 12.2547 8.40847 12.0675 8.17045 11.8295C7.93244 11.5914 7.74523 11.3083 7.61952 10.9971C7.49382 10.6859 7.43205 10.353 7.43798 10.0174C7.44391 9.68183 7.51741 9.35121 7.65407 9.04471C7.79072 8.73821 7.9877 8.46209 8.23334 8.23333"
                                                    stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="auth-button">Simpan Password</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ============================================ --}}
            {{-- RIGHT PANEL - FORM (Login) / IMAGE (Register) --}}
            {{-- ============================================ --}}
            <div class="auth-panel auth-panel-right">
                {{-- Login Form (Visible by default) --}}
                <div class="auth-form-wrapper" id="login-form-wrapper">
                    <div class="auth-form-container">
                        <div class="auth-header">
                            <h1>Selamat Datang di SIPETA!</h1>
                            <p>Masuk ke akun Anda</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="auth-form">
                            @csrf

                            {{-- Email Input --}}
                            <div class="auth-input-group">
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
                                    <input type="email" id="login-email" name="email" value="{{ old('email') }}"
                                        placeholder="Alamat Email" class="@error('email') is-invalid @enderror" required
                                        autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Password Input --}}
                            <div class="auth-input-group">
                                <div class="input-wrapper icon-left">
                                    <span class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.8333 9.16667H4.16667C3.24619 9.16667 2.5 9.91286 2.5 10.8333V16.6667C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6667V10.8333C17.5 9.91286 16.7538 9.16667 15.8333 9.16667Z"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M5.83333 9.16667V5.83333C5.83333 4.72826 6.27232 3.66846 7.05372 2.88706C7.83512 2.10565 8.89493 1.66667 10 1.66667C11.1051 1.66667 12.1649 2.10565 12.9463 2.88706C13.7277 3.66846 14.1667 4.72826 14.1667 5.83333V9.16667"
                                                stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <input type="password" id="login-password" name="password" placeholder="Password"
                                        class="@error('password') is-invalid @enderror" required
                                        autocomplete="current-password">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('login-password')">
                                        <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.833344 10C0.833344 10 4.16668 3.33334 10 3.33334C15.8333 3.33334 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg class="eye-closed" style="display: none;" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.95 14.95C13.5255 16.0358 11.7909 16.6374 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10C1.87007 8.06825 3.30772 6.38051 5.05001 5.05M8.25001 3.53333C8.82297 3.39907 9.41013 3.33195 10 3.33333C15.8333 3.33333 19.1667 10 19.1667 10C18.6609 10.9463 18.0575 11.8373 17.3667 12.6583M11.7667 11.7667C11.5378 12.0123 11.2617 12.2093 10.9552 12.3459C10.6487 12.4826 10.3181 12.556 9.98249 12.562C9.64689 12.5679 9.31402 12.5061 9.00283 12.3804C8.69164 12.2547 8.40847 12.0675 8.17045 11.8295C7.93244 11.5914 7.74523 11.3083 7.61952 10.9971C7.49382 10.6859 7.43205 10.353 7.43798 10.0174C7.44391 9.68183 7.51741 9.35121 7.65407 9.04471C7.79072 8.73821 7.9877 8.46209 8.23334 8.23333"
                                                stroke="#6B7280" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Remember Me & Forgot Password --}}
                            <div class="auth-form-options">
                                <div class="auth-checkbox">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="javascript:void(0)" class="auth-link"
                                        onclick="toggleAuthMode('forgot')">Lupa Password?</a>
                                @endif
                            </div>

                            <button type="submit" class="auth-button">Login</button>

                            {{-- Divider --}}
                            <div class="auth-divider">
                                <span>atau</span>
                            </div>

                            {{-- Google Login Button --}}
                            <a href="{{ route('auth.google') }}" class="auth-button-google">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.1711 8.36788H17.5V8.33329H10V11.6666H14.7096C14.0225 13.607 12.1762 15 10 15C7.23859 15 5.00001 12.7614 5.00001 9.99996C5.00001 7.23854 7.23859 4.99996 10 4.99996C11.2746 4.99996 12.4342 5.48079 13.3171 6.26621L15.6742 3.90913C14.1858 2.52204 12.1954 1.66663 10 1.66663C5.39792 1.66663 1.66667 5.39788 1.66667 9.99996C1.66667 14.602 5.39792 18.3333 10 18.3333C14.6021 18.3333 18.3333 14.602 18.3333 9.99996C18.3333 9.44121 18.2758 8.89579 18.1711 8.36788Z"
                                        fill="#FFC107" />
                                    <path
                                        d="M2.62749 6.12121L5.36541 8.12913C6.10624 6.29496 7.90041 4.99996 10 4.99996C11.2746 4.99996 12.4342 5.48079 13.3171 6.26621L15.6742 3.90913C14.1858 2.52204 12.1954 1.66663 10 1.66663C6.79916 1.66663 4.02332 3.47371 2.62749 6.12121Z"
                                        fill="#FF3D00" />
                                    <path
                                        d="M10 18.3334C12.1525 18.3334 14.1084 17.5096 15.5871 16.17L13.008 13.9875C12.1432 14.6452 11.0865 15.0009 10 15C7.83255 15 5.99213 13.618 5.29922 11.6892L2.5813 13.783C3.96047 16.4817 6.76172 18.3334 10 18.3334Z"
                                        fill="#4CAF50" />
                                    <path
                                        d="M18.1712 8.36796H17.5V8.33337H10V11.6667H14.7096C14.3809 12.5902 13.7889 13.3972 13.0067 13.988L13.008 13.9871L15.587 16.1696C15.4046 16.3355 18.3333 14.1667 18.3333 10C18.3333 9.44129 18.2758 8.89587 18.1712 8.36796Z"
                                        fill="#1976D2" />
                                </svg>
                                <span>Login dengan Google</span>
                            </a>

                            <div class="auth-footer-text">
                                Belum punya akun?
                                <a href="javascript:void(0)" class="auth-link"
                                    onclick="toggleAuthMode('register')">Daftar Sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Image Overlay (Hidden by default, slides in on Register) --}}
                <div class="auth-panel-overlay" id="right-overlay"
                    style="background-image: url('{{ asset('assets/images/login/farmland_2-min.jpg') }}');">
                    <div class="auth-panel-logo">
                        <img src="{{ asset('images/logo/sipeta-logo.svg') }}" alt="SIPETA Logo">
                        <span>SIPETA</span>
                    </div>
                    <div class="auth-panel-content">
                        <h2>Bergabunglah Bersama Kami</h2>
                        <p>Jadilah bagian dari komunitas petani Indonesia. Dapatkan akses ke ribuan produk pertanian segar
                            dan dukung pertanian lokal untuk masa depan yang lebih baik.</p>
                    </div>
                </div>

                {{-- Image Overlay (Hidden by default, slides in on Forgot/Reset) --}}
                <div class="auth-panel-overlay" id="forgot-overlay"
                    style="background-image: url('{{ asset('assets/images/login/farmland_3-min.jpg') }}');">
                    <div class="auth-panel-logo">
                        <img src="{{ asset('images/logo/sipeta-logo.svg') }}" alt="SIPETA Logo">
                        <span>SIPETA</span>
                    </div>
                    <div class="auth-panel-content">
                        <h2>Pulihkan Akses Anda</h2>
                        <p>Kami akan membantu Anda mendapatkan kembali akses ke akun SIPETA. Keamanan data Anda adalah
                            prioritas kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="auth-toast" class="auth-toast">
        <div class="toast-icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.6667 5L7.50001 14.1667L3.33334 10" stroke="white" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
        <span id="toast-message">Register berhasil!</span>
    </div>

    <script>
        // Get current mode from URL
        function getCurrentMode() {
            const path = window.location.pathname;
            return path.includes('register') ? 'register' : 'login';
        }

        // Toggle between login and register/forgot
        function toggleAuthMode(mode) {
            const container = document.getElementById('auth-container');

            // Remove previous classes
            container.classList.remove('register-mode', 'forgot-mode', 'reset-mode');

            if (mode === 'register') {
                container.classList.add('register-mode');
                history.pushState(null, '', '{{ route('register') }}');
                document.title = 'Daftar - SIPETA';
            } else if (mode === 'forgot') {
                container.classList.add('forgot-mode');
                history.pushState(null, '', '{{ route('password.request') }}');
                document.title = 'Reset Password - SIPETA';
            } else if (mode === 'reset') {
                container.classList.add('reset-mode');
                document.title = 'Set Password Baru - SIPETA';
            } else {
                history.pushState(null, '', '{{ route('login') }}');
                document.title = 'Login - SIPETA';
            }
        }

        // AJAX Handling for Forms
        document.addEventListener('DOMContentLoaded', function() {
            // Login AJAX
            const loginForm = document.querySelector('#login-form-wrapper form');
            if (loginForm) setupAjaxForm(loginForm, 'Login berhasil! Mengalihkan...', '/');

            // Register AJAX
            const registerForm = document.querySelector('#register-form-wrapper form');
            if (registerForm) setupAjaxForm(registerForm, 'Register berhasil!', 'login');

            // Forgot Password AJAX
            const forgotForm = document.querySelector('#forgot-form-wrapper form');
            if (forgotForm) setupAjaxForm(forgotForm, 'Buka email Anda untuk link reset!', 'login');

            // Actual Reset AJAX (if exists)
            const resetForm = document.querySelector('#reset-password-wrapper form');
            if (resetForm) setupAjaxForm(resetForm, 'Password berhasil diubah!', 'login');
        });

        function setupAjaxForm(form, successMsg, action) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerText;

                submitBtn.disabled = true;
                submitBtn.innerText = 'Memproses...';

                this.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        const contentType = response.headers.get('content-type');

                        // Handle 204 No Content (standard Laravel AJAX login response)
                        if (response.status === 204) {
                            return {
                                success: true
                            };
                        }

                        if (response.ok) {
                            return response.json();
                        }
                        if (contentType && contentType.includes('application/json')) {
                            return response.json().then(errorData => {
                                throw errorData;
                            });
                        }
                        throw {
                            message: 'Terjadi kesalahan sistem'
                        };
                    })
                    .then(data => {
                        form.reset();

                        // Update CSRF token if server sends a new one (after registration)
                        if (data.csrf_token) {
                            document.querySelectorAll('input[name="_token"]').forEach(input => {
                                input.value = data.csrf_token;
                            });
                            // Also update meta tag if exists
                            const metaToken = document.querySelector('meta[name="csrf-token"]');
                            if (metaToken) {
                                metaToken.setAttribute('content', data.csrf_token);
                            }
                        }

                        const toast = document.getElementById('auth-toast');
                        document.getElementById('toast-message').innerText = successMsg;
                        toast.classList.add('show');

                        setTimeout(() => {
                            if (action === '/' || action.startsWith('http')) {
                                window.location.href = action;
                            } else {
                                toggleAuthMode(action);
                                toast.classList.remove('show');
                            }
                        }, 1000);
                    })
                    .catch(errors => {
                        submitBtn.disabled = false;
                        submitBtn.innerText = originalBtnText;

                        if (errors.errors) {
                            Object.entries(errors.errors).forEach(([field, messages]) => {
                                // Find input within THIS form
                                const input = form.querySelector(`[name="${field}"]`) || document
                                    .getElementById('reg-' + field);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    const errorDiv = document.createElement('span');
                                    errorDiv.className = 'invalid-feedback';
                                    errorDiv.innerHTML = `<strong>${messages[0]}</strong>`;
                                    input.closest('.auth-input-group').appendChild(errorDiv);
                                }
                            });
                        } else if (errors.message) {
                            swal("Gagal", errors.message, "error");
                        }
                    });
            });
        }

        // Unified Password Toggle
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');

            if (field.type === 'password') {
                field.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                field.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }

        // Handle browser back/forward
        window.addEventListener('popstate', function() {
            const mode = getCurrentMode();
            const container = document.getElementById('auth-container');

            if (mode === 'register') {
                container.classList.add('register-mode');
            } else {
                container.classList.remove('register-mode');
            }
        });

        // Set initial mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            const path = window.location.pathname;

            if (path.includes('register')) {
                toggleAuthMode('register');
            } else if (path.includes('password/reset/')) {
                toggleAuthMode('reset');
            } else if (path.includes('password/reset')) {
                toggleAuthMode('forgot');
            } else if (@json($errors->hasAny(['name', 'mobile']) || old('mobile'))) {
                toggleAuthMode('register');
            }
        });
    </script>
@endsection
