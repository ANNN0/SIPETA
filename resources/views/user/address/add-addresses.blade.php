@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Tambah Alamat'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Tambah Alamat</h2>

            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 user-content">
                    <div class="page-content my-account__edit-address">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between align-items-end mb-3">
                                    <p class="notice mb-0">Tambah alamat pengiriman baru untuk pesanan Anda</p>
                                    @if (request('origin') == 'checkout')
                                        <a href="{{ route('cart.checkout') }}" class="btn-back btn-sm">
                                            <i class="fa fa-arrow-left"></i> Kembali ke Checkout
                                        </a>
                                    @else
                                        <a href="{{ route('user.addresses') }}" class="btn-back btn-sm">
                                            <i class="fa fa-arrow-left"></i> Kembali
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="address-form-card">
                                    <div class="address-form-header">
                                        <h5>
                                            <i class="fa fa-map-marker-alt me-2"></i>
                                            Informasi Alamat
                                        </h5>
                                    </div>
                                    <div class="address-form-body">
                                        <form action="{{ route('user.address.store') }}" method="POST">
                                            @csrf
                                            @if (request('origin'))
                                                <input type="hidden" name="origin" value="{{ request('origin') }}">
                                            @endif

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" id="name" value="{{ old('name') }}"
                                                            placeholder="Nama Lengkap" required>
                                                        <label for="name">Nama Lengkap *</label>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            name="phone" id="phone" value="{{ old('phone') }}"
                                                            placeholder="Nomor Telepon" required>
                                                        <label for="phone">Nomor Telepon *</label>
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            name="address" id="address" value="{{ old('address') }}"
                                                            placeholder="No. Rumah, Nama Bangunan" required>
                                                        <label for="address">No. Rumah, Nama Bangunan *</label>
                                                        @error('address')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('locality') is-invalid @enderror"
                                                            name="locality" id="locality" value="{{ old('locality') }}"
                                                            placeholder="Nama Jalan, Wilayah, Blok" required>
                                                        <label for="locality">Nama Jalan, Wilayah, Blok *</label>
                                                        @error('locality')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('city') is-invalid @enderror"
                                                            name="city" id="city" value="{{ old('city') }}"
                                                            placeholder="Kota / Kabupaten" required>
                                                        <label for="city">Kota / Kabupaten *</label>
                                                        @error('city')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('state') is-invalid @enderror"
                                                            name="state" id="state" value="{{ old('state') }}"
                                                            placeholder="Provinsi" required>
                                                        <label for="state">Provinsi *</label>
                                                        @error('state')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('zip') is-invalid @enderror"
                                                            name="zip" id="zip" value="{{ old('zip') }}"
                                                            placeholder="Kode Pos" required>
                                                        <label for="zip">Kode Pos *</label>
                                                        @error('zip')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control @error('landmark') is-invalid @enderror"
                                                            name="landmark" id="landmark" value="{{ old('landmark') }}"
                                                            placeholder="Patokan (Opsional)">
                                                        <label for="landmark">Patokan (Opsional)</label>
                                                        @error('landmark')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <label class="default-address-checkbox">
                                                        <input type="checkbox" name="isdefault" value="1"
                                                            {{ old('isdefault') ? 'checked' : '' }}>
                                                        <span class="checkbox-circle"></span>
                                                        <span class="checkbox-label">Jadikan sebagai Alamat Utama</span>
                                                    </label>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="address-form-actions">
                                                        <button type="submit" class="btn btn-primary btn-update">
                                                            <i class="fa fa-save me-2"></i>Simpan Alamat
                                                        </button>
                                                        @if (request('origin') == 'checkout')
                                                            <a href="{{ route('cart.checkout') }}"
                                                                class="btn btn-outline-secondary">
                                                                Batal
                                                            </a>
                                                        @else
                                                            <a href="{{ route('user.addresses') }}"
                                                                class="btn btn-outline-secondary">
                                                                Batal
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
