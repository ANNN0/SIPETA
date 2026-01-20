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
                        <p style="margin-top: 8px; font-size: 13px;">Bergabunglah dengan platform terpercaya untuk transaksi
                            hasil pertanian</p>
                    </div>
                </div>
            </div>

            {{-- Right Panel - Register Form --}}
            <div class="auth-right-panel">
                <div class="auth-form-container">
                    {{-- Header --}}
                    <div class="auth-header">
                        <h1>Daftar</h1>
                        <p>Buat akun baru untuk memulai</p>
                    </div>

                    {{-- Register Form --}}
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
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Full Name" class="@error('name') is-invalid @enderror" required
                                    autocomplete="name" autofocus>
                            </div>
                            @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
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
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Email Address" class="@error('email') is-invalid @enderror" required
                                    autocomplete="email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
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
                                        <path d="M10 15H10.0083" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="08xxxxxxxxxx" class="@error('mobile') is-invalid @enderror" required
                                    autocomplete="mobile">
                            </div>
                            @error('mobile')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
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
                                <input type="password" id="password" name="password" placeholder="Password"
                                    class="@error('password') is-invalid @enderror" required autocomplete="new-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
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
                                        <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password Input --}}
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
                                <input type="password" id="password-confirm" name="password_confirmation"
                                    placeholder="Konfirmasi Password" required autocomplete="new-password">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password-confirm')">
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
                                        <path d="M0.833344 0.833336L19.1667 19.1667" stroke="#6B7280" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Privacy Notice --}}
                        <div
                            style="margin-bottom: 24px; padding: 12px; background-color: #f9fafb; border-radius: 8px; border-left: 3px solid #1a7a3e;">
                            <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                                Data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di platform ini, mengelola
                                akses ke akun Anda, dan tujuan lain yang dijelaskan dalam kebijakan privasi kami.
                            </p>
                        </div>

                        {{-- Register Button --}}
                        <button type="submit" class="auth-button">
                            Daftar Sekarang
                        </button>

                        {{-- Login Link --}}
                        <div class="auth-footer-text">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection
