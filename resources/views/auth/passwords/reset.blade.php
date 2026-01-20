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
                        <p style="margin-top: 8px; font-size: 13px;">Buat password baru yang aman untuk akun Anda</p>
                    </div>
                </div>
            </div>

            {{-- Right Panel - Reset Password Form --}}
            <div class="auth-right-panel">
                <div class="auth-form-container">
                    {{-- Header --}}
                    <div class="auth-header">
                        <h1>RESET PASSWORD</h1>
                        <p>Masukkan password baru Anda</p>
                    </div>

                    {{-- Reset Password Form --}}
                    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

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
                                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}"
                                    placeholder="user@sipeta.com" class="@error('email') is-invalid @enderror" required
                                    autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password Input --}}
                        <div class="auth-input-group">
                            <label for="password">
                                Password Baru <span class="required">*</span>
                            </label>
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
                                <input type="password" id="password" name="password" placeholder="••••••••"
                                    class="@error('password') is-invalid @enderror" required autocomplete="new-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
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

                        {{-- Confirm Password Input --}}
                        <div class="auth-input-group">
                            <label for="password-confirm">
                                Konfirmasi Password <span class="required">*</span>
                            </label>
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
                                    placeholder="••••••••" required autocomplete="new-password">
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

                        {{-- Reset Password Button --}}
                        <button type="submit" class="auth-button">
                            Reset Password
                        </button>

                        {{-- Back to Login Link --}}
                        <div class="auth-footer-text">
                            Kembali ke
                            <a href="{{ route('login') }}" class="auth-link">Login</a>
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
