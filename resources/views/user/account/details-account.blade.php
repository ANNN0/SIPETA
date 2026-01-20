@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Akun Saya'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Akun Saya</h2>

            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 user-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="page-content details-personal">
                        <form name="account_edit_form" action="{{ route('user.account.update') }}" method="POST"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="personal-info__card">
                                <div class="row">
                                    {{-- Profile Photo Column --}}
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <div class="personal-photo-wrapper">
                                            <div class="personal-photo__container">
                                                @if (Auth::user()->image)
                                                    <img id="profile-img-preview" src="@cloudinary(Auth::user()->image, 200, 200, 'fill')"
                                                        alt="{{ Auth::user()->name }}" class="personal-photo__img">
                                                @else
                                                    <div id="profile-img-placeholder" class="personal-photo__placeholder">
                                                        <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <label for="account_image" class="personal-photo__edit-btn">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11 2L14 5L5 14H2V11L11 2Z" stroke="white"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </label>
                                                <input type="file" id="account_image" name="image" class="d-none"
                                                    accept="image/*" onchange="previewImage(this)">
                                            </div>
                                        </div>
                                        @error('image')
                                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Form Fields Column --}}
                                    <div class="col-md-8">
                                        <div class="personal-form__group mb-4">
                                            <label for="account_name" class="personal-form__label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input id="account_name" type="text"
                                                class="form-control personal-form__input" name="name"
                                                value="{{ Auth::user()->name }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="personal-form__group mb-4">
                                            <label for="account_email" class="personal-form__label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input id="account_email" type="email"
                                                class="form-control personal-form__input input-disabled"
                                                value="{{ Auth::user()->email }}" disabled>
                                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                            <small class="text-muted" style="font-size: 0.75rem;">Email tidak dapat
                                                diubah</small>
                                        </div>

                                        <div class="personal-form__group mb-4">
                                            <label for="account_mobile" class="personal-form__label">Telepon <span
                                                    class="text-danger">*</span></label>
                                            <input id="account_mobile" type="text"
                                                class="form-control personal-form__input" name="mobile"
                                                value="{{ Auth::user()->mobile }}" required>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <button type="submit" class="btn personal-form__submit">Perbarui
                                                Perubahan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @push('scripts')
                        <script>
                            function previewImage(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        var preview = document.getElementById('profile-img-preview');
                                        var placeholder = document.getElementById('profile-img-placeholder');

                                        if (preview) {
                                            preview.src = e.target.result;
                                        } else if (placeholder) {
                                            // Create img if placeholder exists
                                            var img = document.createElement('img');
                                            img.id = 'profile-img-preview';
                                            img.src = e.target.result;
                                            img.className = 'personal-photo__img';
                                            placeholder.parentNode.insertBefore(img, placeholder);
                                            placeholder.remove();
                                        }
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>
                    @endpush
                </div>
            </div>
        </section>
    </main>
@endsection
