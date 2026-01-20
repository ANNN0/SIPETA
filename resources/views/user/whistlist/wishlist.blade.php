@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            @include('user.components.breadcrumb', ['currentPage' => 'Wishlist'])

            {{-- Page Title --}}
            <h2 class="title-user__page">Wishlist Saya</h2>

            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 user-content">
                    <div class="page-content my-account__wishlist">
                        @if ($items->count() > 0)
                            <!-- Wishlist Header -->
                            <div class="wishlist-header mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-1">
                                            Wishlist Saya
                                        </h4>
                                        <p class="text-muted mb-0">
                                            Anda memiliki {{ $items->count() }}
                                            {{ $items->count() > 1 ? 'produk' : 'produk' }} di
                                            wishlist Anda
                                        </p>
                                    </div>
                                    <form action="{{ route('wishlist.items.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-clear">
                                            <i class="fa fa-trash me-2"></i>Hapus Semua
                                        </button>
                                    </form>
                                </div>
                                <hr class="mt-3">
                            </div>

                            <!-- Products Grid -->
                            <div class="wishlist-products" id="wishlist-products">
                                @if ($products->count() > 0)
                                    @include('user.whistlist.partials.wishlist-product-card', [
                                        'products' => $products,
                                    ])
                                @endif
                            </div>
                    </div>
                @else
                    <div class="empty-wishlist text-center py-5">
                        <div class="empty-icon mb-4">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    fill="none" />
                            </svg>
                        </div>
                        <h3 class="mb-3">Wishlist Anda Kosong</h3>
                        <p class="text-muted mb-4">
                            Anda belum menambahkan produk apa pun ke wishlist Anda.<br>
                            Jelajahi koleksi kami dan simpan produk favorit Anda!
                        </p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="fa fa-shopping-bag me-2"></i>Lanjutkan Belanja
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
