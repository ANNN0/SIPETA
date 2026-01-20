@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Alamat'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Kelola Alamat</h2>
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 user-content">
                    <div class="page-content my-account__address">
                        <!-- Header Section -->
                        <div class="address-list-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p class="header-notice">
                                        <i class="fa fa-info-circle me-2"></i>
                                        Alamat berikut akan digunakan di halaman checkout secara default.
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('user.address.add') }}" class="btn-add-new">
                                        <i class="fa fa-plus me-2"></i>Tambah Baru
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address Label -->
                        <div class="section-title-wrapper">
                            <h4 class="section-title">
                                <i class="fa fa-map-marker-alt me-2"></i>Alamat Pengiriman
                            </h4>
                            <div class="title-underline"></div>
                        </div>

                        <!-- Address Cards Grid -->
                        <div class="address-cards-grid">
                            @forelse($addresses as $address)
                                <div class="address-card">
                                    <!-- Card Header -->
                                    <div class="address-card-header">
                                        <div class="address-name">
                                            <h5>{{ $address->name }}</h5>
                                            @if ($address->isdefault)
                                                <span class="badge-default">
                                                    <i class="fa fa-check-circle me-1"></i>Utama
                                                </span>
                                            @endif
                                        </div>
                                        <a href="{{ route('user.address.edit', $address->id) }}" class="btn-edit">
                                            <i class="fa fa-edit me-1"></i>Ubah
                                        </a>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="address-card-body">
                                        <div class="address-detail-item">
                                            <i class="fa fa-home detail-icon"></i>
                                            <div class="detail-content">
                                                <span class="detail-label">Alamat</span>
                                                <span class="detail-value">{{ $address->address }}</span>
                                            </div>
                                        </div>

                                        <div class="address-detail-item">
                                            <i class="fa fa-map-pin detail-icon"></i>
                                            <div class="detail-content">
                                                <span class="detail-label">Wilayah/Kelurahan</span>
                                                <span class="detail-value">{{ $address->locality }}</span>
                                            </div>
                                        </div>

                                        <div class="address-detail-item">
                                            <i class="fa fa-city detail-icon"></i>
                                            <div class="detail-content">
                                                <span class="detail-label">Kota, Provinsi</span>
                                                <span class="detail-value">{{ $address->city }},
                                                    {{ $address->state }}</span>
                                            </div>
                                        </div>

                                        @if ($address->landmark)
                                            <div class="address-detail-item">
                                                <i class="fa fa-location-arrow detail-icon"></i>
                                                <div class="detail-content">
                                                    <span class="detail-label">Patokan</span>
                                                    <span class="detail-value">{{ $address->landmark }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="address-detail-item">
                                            <i class="fa fa-mail-bulk detail-icon"></i>
                                            <div class="detail-content">
                                                <span class="detail-label">Kode Pos</span>
                                                <span class="detail-value">{{ $address->zip }}</span>
                                            </div>
                                        </div>

                                        <div class="address-detail-item">
                                            <i class="fa fa-phone detail-icon"></i>
                                            <div class="detail-content">
                                                <span class="detail-label">Telepon/HP</span>
                                                <span class="detail-value">{{ $address->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fa fa-map-marked-alt"></i>
                                    </div>
                                    <h5>Alamat Tidak Ditemukan</h5>
                                    <p>Anda belum menambahkan alamat pengiriman apapun.</p>
                                    <a href="{{ route('user.address.add') }}" class="btn-add-new">
                                        <i class="fa fa-plus me-2"></i>Tambah Alamat Pertama Anda
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
