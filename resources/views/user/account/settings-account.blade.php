@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Pengaturan'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Pengaturan Akun</h2>

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
                        <form name="account_settings_form" action="{{ route('user.account.settings.update') }}"
                            method="POST" class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="personal-info__card p-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h5 class="personal-form__title">Ubah Password</h5>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="personal-form__group">
                                            <label for="old_password" class="personal-form__label">Password Lama</label>
                                            <input id="old_password" type="password"
                                                class="form-control personal-form__input" name="old_password" required>
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="personal-form__group">
                                            <label for="new_password" class="personal-form__label">Password Baru</label>
                                            <input id="new_password" type="password"
                                                class="form-control personal-form__input" name="new_password" required>
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="personal-form__group">
                                            <label for="new_password_confirmation" class="personal-form__label">Konfirmasi
                                                Password Baru</label>
                                            <input id="new_password_confirmation" type="password"
                                                class="form-control personal-form__input" name="new_password_confirmation"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn personal-form__submit w-auto px-5">Ubah
                                            Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
