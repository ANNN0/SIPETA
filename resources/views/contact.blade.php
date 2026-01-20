@extends('layouts.app')

@section('content')
    <main class="pt-90">
        {{-- Hero Section --}}
        <section class="contact-hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Hubungi Kami</h1>
                    <p class="hero-subtitle">Kami siap membantu Anda. Silakan hubungi kami melalui formulir atau kontak di
                        bawah ini.</p>
                </div>
            </div>
        </section>

        {{-- Main Contact Section --}}
        <section class="contact-section">
            <div class="container">
                <div class="contact-grid">
                    {{-- Left Column: Contact Form --}}
                    <div class="contact-form-wrapper">
                        <div class="contact-form-card">
                            <h2 class="form-title">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16"
                                    class="form-icon">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                </svg>
                                Kirim Pesan
                            </h2>

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"
                                        class="me-2">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('home.contact.store') }}" method="POST" class="contact-form" novalidate>
                                @csrf

                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama lengkap Anda" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="nama@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="08xx-xxxx-xxxx" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tipe Pesan Dropdown (Premium Custom) --}}
                                <div class="form-group mb-4">
                                    <label for="message_type" class="form-label d-flex align-items-center">
                                        Tipe Pesan
                                        <span class="badge badge-new ms-2">Baru!</span>
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="custom-dropdown" id="contact-type-dropdown">
                                        <div class="custom-dropdown__selected">
                                            <span
                                                class="selected-text">{{ old('message_type') ? ucfirst(old('message_type')) : 'Pilih Tipe Pesan' }}</span>
                                            <span class="dropdown-icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="custom-dropdown__options">
                                            <div class="custom-dropdown__option {{ old('message_type') == 'pertanyaan' ? 'is-selected' : '' }}"
                                                data-value="pertanyaan">Pertanyaan Umum</div>
                                            <div class="custom-dropdown__option {{ old('message_type') == 'keluhan' ? 'is-selected' : '' }}"
                                                data-value="keluhan">Keluhan/Kritik</div>
                                            <div class="custom-dropdown__option {{ old('message_type') == 'testimonial' ? 'is-selected' : '' }}"
                                                data-value="testimonial">Testimonial/Review</div>
                                            <div class="custom-dropdown__option {{ old('message_type') == 'saran' ? 'is-selected' : '' }}"
                                                data-value="saran">Saran</div>
                                        </div>
                                        {{-- Hidden native select for validation & form submission --}}
                                        <select class="d-none @error('message_type') is-invalid @enderror" id="message_type"
                                            name="message_type" required>
                                            <option value="">Pilih Tipe Pesan</option>
                                            <option value="pertanyaan"
                                                {{ old('message_type') == 'pertanyaan' ? 'selected' : '' }}>pertanyaan
                                            </option>
                                            <option value="keluhan"
                                                {{ old('message_type') == 'keluhan' ? 'selected' : '' }}>keluhan</option>
                                            <option value="testimonial"
                                                {{ old('message_type') == 'testimonial' ? 'selected' : '' }}>testimonial
                                            </option>
                                            <option value="saran" {{ old('message_type') == 'saran' ? 'selected' : '' }}>
                                                saran</option>
                                        </select>
                                    </div>
                                    @error('message_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Rating Field (only for Testimonial) --}}
                                <div class="form-group" id="rating-field" style="display: none;">
                                    <label for="rating" class="form-label">Rating</label>
                                    <div class="star-rating-input">
                                        <input type="radio" name="rating" value="5" id="star5"
                                            {{ old('rating') == 5 ? 'checked' : '' }}>
                                        <label for="star5" title="5 bintang">★</label>
                                        <input type="radio" name="rating" value="4" id="star4"
                                            {{ old('rating') == 4 ? 'checked' : '' }}>
                                        <label for="star4" title="4 bintang">★</label>
                                        <input type="radio" name="rating" value="3" id="star3"
                                            {{ old('rating') == 3 ? 'checked' : '' }}>
                                        <label for="star3" title="3 bintang">★</label>
                                        <input type="radio" name="rating" value="2" id="star2"
                                            {{ old('rating') == 2 ? 'checked' : '' }}>
                                        <label for="star2" title="2 bintang">★</label>
                                        <input type="radio" name="rating" value="1" id="star1"
                                            {{ old('rating') == 1 ? 'checked' : '' }}>
                                        <label for="star1" title="1 bintang">★</label>
                                    </div>
                                    <small class="form-text text-muted">Berikan rating Anda (1-5 bintang)</small>
                                </div>

                                <div class="form-group">
                                    <label for="comment" class="form-label">Pesan <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="5"
                                        placeholder="Tulis pesan Anda di sini..." required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-submit">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                        class="me-2">
                                        <path
                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                    </svg>
                                    Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Right Column: Contact Info --}}
                    <div class="contact-info-wrapper">
                        {{-- Phone Card --}}
                        <div class="contact-card">
                            <div class="card-icon">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">Telepon</h3>
                                <p class="card-text">0813-5718-4394</p>
                                <p class="card-meta">Senin - Sabtu, 08.00 - 17.00 WIB</p>
                            </div>
                        </div>

                        {{-- Email Card --}}
                        <div class="contact-card">
                            <div class="card-icon">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                </svg>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">Email</h3>
                                <p class="card-text">support@sipeta.com</p>
                                <p class="card-meta">Respon dalam 1x24 jam</p>
                            </div>
                        </div>

                        {{-- Address Card --}}
                        <div class="contact-card">
                            <div class="card-icon">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">Alamat</h3>
                                <p class="card-text">Jl. Raya Pertanian No. 123</p>
                                <p class="card-meta">Jakarta Selatan, DKI Jakarta 12345</p>
                            </div>
                        </div>

                        {{-- WhatsApp Card --}}
                        <div class="contact-card whatsapp-card">
                            <div class="card-icon">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">WhatsApp</h3>
                                <p class="card-text">Chat Langsung dengan Admin</p>
                                <a href="https://wa.me/6281357184394?text={{ urlencode('Halo SIPETA, saya butuh bantuan...') }}"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                        class="me-2">
                                        <path
                                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @push('scripts')
        <script>
            $(document).ready(function() {
                const dropdown = $('#contact-type-dropdown');
                const selected = dropdown.find('.custom-dropdown__selected');
                const options = dropdown.find('.custom-dropdown__option');
                const hiddenSelect = $('#message_type');
                const ratingField = $('#rating-field');

                // Toggle dropdown open/close
                selected.on('click', function(e) {
                    e.stopPropagation();
                    dropdown.toggleClass('open');
                });

                // Close dropdown when clicking outside
                $(document).on('click', function() {
                    dropdown.removeClass('open');
                });

                // Handle option selection
                options.on('click', function() {
                    const value = $(this).data('value');
                    const text = $(this).text();

                    // Update visible text
                    dropdown.find('.selected-text').text(text);

                    // Update selection state in custom UI
                    options.removeClass('is-selected');
                    $(this).addClass('is-selected');

                    // Sync with hidden native select
                    hiddenSelect.val(value).trigger('change');

                    // Close dropdown
                    dropdown.removeClass('open');
                });

                // Handle rating field visibility (triggered by change on hidden select)
                hiddenSelect.on('change', function() {
                    if ($(this).val() === 'testimonial') {
                        ratingField.slideDown(400);
                    } else {
                        ratingField.slideUp(400);
                    }
                });

                // Initialize state if old value exists (after validation error)
                if (hiddenSelect.val() === 'testimonial') {
                    ratingField.show();
                }
            });
        </script>
    @endpush
@endsection
