@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            {{-- Breadcrumb --}}
            <div class="user-breadcrumb">
                <a href="{{ route('home.index') }}">Beranda</a>
                <span class="separator">/</span>
                <span class="current">Akun Saya</span>
            </div>

            {{-- Page Title --}}
            <h2 class="title-user__page">Akun Saya</h2>

            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 user-content">
                    <div class="page-content my-account__dashboard">
                        <p>Hello <strong>User</strong></p>
                        <p>From your account dashboard you can view your <a class="unerline-link"
                                href="account_orders.html">recent
                                orders</a>, manage your <a class="unerline-link" href="account_edit_address.html">shipping
                                addresses</a>, and <a class="unerline-link" href="account_edit.html">edit your password and
                                account
                                details.</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
