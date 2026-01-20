@php
    // Helper function to check if menu is active based on route patterns
    function isMenuActive($patterns)
    {
        $currentRoute = Route::currentRouteName();
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }
        foreach ($patterns as $pattern) {
            if (str_starts_with($currentRoute, $pattern)) {
                return true;
            }
        }
        return false;
    }
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <style>
        /* CRITICAL: Admin Dropdown Fix - Must be first! */
        ul.dropdown-menu.dropdown-menu-end,
        ul.dropdown-menu,
        .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: auto !important;
            right: 0 !important;
            min-width: 160px !important;
            padding: 0.5rem !important;
            margin: 0.25rem 0 0 !important;
            font-size: 1rem !important;
            transform: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .dropdown-item,
        a.dropdown-item,
        button.dropdown-item {
            display: block !important;
            width: 100% !important;
            padding: 0.65rem 1rem !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
        }

        /* Admin Header Logo Size and Alignment */
        .header-dashboard .wrap .header-grid {
            gap: 0px !important;
        }

        .header-user.wg-user {
            display: flex !important;
            align-items: center !important;
            margin-left: 20px !important;
            gap: 10px !important;
        }

        .header-user.wg-user .image {
            width: auto !important;
            height: auto !important;
            max-width: 80px !important;
        }

        .header-user.wg-user .image img {
            width: 100% !important;
            height: auto !important;
            object-fit: contain !important;
            vertical-align: middle !important;
            margin-top: 0 !important;
        }

        /* Sidebar Box Logo Styling */
        .box-logo #site-logo-inner {
            display: flex !important;
            align-items: center !important;
            gap: 0px !important;
            text-decoration: none !important;
        }

        .box-logo #site-logo-inner img,
        .section-menu-left .box-logo img#logo_header_1 {
            width: 100% !important;
            height: auto !important;
            min-width: 60px !important;
            object-fit: contain !important;
        }

        .box-logo .logo-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a7a3e;
            letter-spacing: 1px;
            margin-bottom: 10px !important;
            margin-right: 15px !important;
        }

        /* Admin Logo Size - Smaller for admin panel */
        img.admin-logo {
            max-width: 35px !important;
            max-height: 35px !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
        }

        /* Mobile header admin logo */
        .header-dashboard img.admin-logo {
            max-width: 36px !important;
            max-height: 36px !important;
        }
    </style>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo/logo-sipeta-2.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/logo-sipeta-2.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

    <style>
        /* Active Sub-Menu Indicator */
        .sub-menu-item.active>a {
            color: #2377FC !important;
            font-weight: 500 !important;
            position: relative;
        }

        .sub-menu-item.active>a::before {
            content: '';
            position: absolute;
            left: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background-color: #2377FC;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .sub-menu-item:not(.active)>a:hover {
            color: #2377FC !important;
        }

        /* Active Single Menu Item (no children) */
        .menu-item:not(.has-children).active>a {
            border-radius: 12px;
            background: rgba(35, 119, 252, 0.1);
            color: #2377FC !important;
            font-weight: 500 !important;
        }

        .menu-item:not(.has-children).active>a .icon {
            color: #2377FC !important;
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>


<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <!-- <div id="preload" class="preload-container">
    <div class="preloading">
        <span></span>
    </div>
</div> -->

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('admin.admin') }}" id="site-logo-inner">
                            <img class="admin-logo" id="logo_header_1" alt="SIPETA"
                                src="{{ asset('images/logo/logo-sipeta-2.png') }}"
                                data-light="{{ asset('images/logo/logo-sipeta-2.png') }}"
                                data-dark="{{ asset('images/logo/logo-sipeta-2.png') }}">
                            <span class="logo-text">SIPETA</span>
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item {{ Request::routeIs('admin.admin') ? 'active' : '' }}">
                                    <a href="{{ route('admin.admin') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.analytics') ? 'active' : '' }}">
                                    <a href="{{ route('admin.analytics') }}" class="">
                                        <div class="icon"><i class="icon-bar-chart"></i></div>
                                        <div class="text">Analytics</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children {{ isMenuActive('admin.product') ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Produk</div>
                                    </a>
                                    <ul class="sub-menu {{ isMenuActive('admin.product') ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.product.add') ? 'active' : '' }}">
                                            <a href="{{ route('admin.product.add') }}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.products', 'admin.product.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.products') }}" class="">
                                                <div class="text">Produk</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="menu-item has-children {{ isMenuActive(['admin.category', 'admin.categories']) ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Category</div>
                                    </a>
                                    <ul
                                        class="sub-menu {{ isMenuActive(['admin.category', 'admin.categories']) ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.category.add') ? 'active' : '' }}">
                                            <a href="{{ route('admin.category.add') }}" class="">
                                                <div class="text">New Category</div>
                                            </a>
                                        </li>
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.categories', 'admin.category.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.categories') }}" class="">
                                                <div class="text">Kategori</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children {{ isMenuActive('admin.region') ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-map-pin"></i></div>
                                        <div class="text">Daerah</div>
                                    </a>
                                    <ul class="sub-menu {{ isMenuActive('admin.region') ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.region.add') ? 'active' : '' }}">
                                            <a href="{{ route('admin.region.add') }}" class="">
                                                <div class="text">New Region</div>
                                            </a>
                                        </li>
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.regions', 'admin.region.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.regions') }}" class="">
                                                <div class="text">Daerah</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children {{ isMenuActive('admin.farmer') ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-users"></i></div>
                                        <div class="text">Petani</div>
                                    </a>
                                    <ul class="sub-menu {{ isMenuActive('admin.farmer') ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.farmer.add') ? 'active' : '' }}">
                                            <a href="{{ route('admin.farmer.add') }}" class="">
                                                <div class="text">New Farmer</div>
                                            </a>
                                        </li>
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.farmers', 'admin.farmer.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.farmers') }}" class="">
                                                <div class="text">Petani</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children {{ isMenuActive('admin.order') ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Order</div>
                                    </a>
                                    <ul class="sub-menu {{ isMenuActive('admin.order') ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.orders', 'admin.order.details') ? 'active' : '' }}">
                                            <a href="{{ route('admin.orders') }}" class="">
                                                <div class="text">Pesanan</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="order-tracking.html" class="">
                                                <div class="text">Order tracking</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children {{ isMenuActive('admin.slide') ? 'active' : '' }}">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Sliders</div>
                                    </a>
                                    <ul class="sub-menu {{ isMenuActive('admin.slide') ? 'show' : '' }}">
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.slides', 'admin.slide.add', 'admin.slide.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.slides') }}" class="">
                                                <div class="text">Slide</div>
                                            </a>
                                        </li>
                                        <li
                                            class="sub-menu-item {{ Request::routeIs('admin.slide.splits', 'admin.slide.split.add', 'admin.slide.split.edit') ? 'active' : '' }}">
                                            <a href="{{ route('admin.slide.splits') }}" class="">
                                                <div class="text">Slide Split</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="menu-item {{ Request::routeIs('admin.coupons', 'admin.coupon.add', 'admin.coupon.edit') ? 'active' : '' }}">
                                    <a href="{{ route('admin.coupons') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Kupon</div>
                                    </a>
                                </li>

                                <li class="menu-item {{ Request::routeIs('admin.reviews') ? 'active' : '' }}">
                                    <a href="{{ route('admin.reviews') }}" class="">
                                        <div class="icon"><i class="icon-message-square"></i></div>
                                        <div class="text">Ulasan</div>
                                    </a>
                                </li>

                                <li class="menu-item {{ Request::routeIs('admin.contacts') ? 'active' : '' }}">
                                    <a href="{{ route('admin.contacts') }}" class="">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Pesan</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('admin.testimonials') ? 'active' : '' }}">
                                    <a href="{{ route('admin.testimonials') }}" class="">
                                        <div class="icon"><i class="icon-star"></i></div>
                                        <div class="text">Testimonial</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ isMenuActive('admin.user') ? 'active' : '' }}">
                                    <a href="{{ route('admin.users') }}" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">User</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ isMenuActive('admin.return') ? 'active' : '' }}">
                                    <a href="{{ route('admin.returns') }}" class="">
                                        <div class="icon"><i class="icon-rotate-ccw"></i></div>
                                        <div class="text">Pengembalian</div>
                                    </a>
                                </li>

                                {{-- <li class="menu-item">
                                    <a href="{{ route('admin.reviews') }}" class="">
                                        <div class="icon"><i class="icon-message-square"></i></div>
                                        <div class="text">Ulasan</div>
                                    </a>
                                </li> --}}

                                <li class="menu-item">
                                    <a href="javascript:void(0)" onclick="ModalUtils.open('logout-modal')">
                                        <div class="icon"><i class="icon-log-out"></i></div>
                                        <div class="text">Keluar</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="index-2.html">
                                    <img class="admin-logo" id="logo_header_mobile" alt="SIPETA"
                                        src="{{ asset('images/logo/logo-sipeta-2.png') }}"
                                        data-light="{{ asset('images/logo/logo-sipeta-2.png') }}"
                                        data-dark="{{ asset('images/logo/logo-sipeta-2.png') }}" data-width="154px"
                                        data-height="50px"
                                        data-retina="{{ asset('images/logo/logo-sipeta-2.png') }}">

                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." class="show-search"
                                            name="name" id="search-input" tabindex="2" value=""
                                            aria-required="true" required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">
                                        <ul id="box-content-search"></ul>
                                    </div>
                                </form>

                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                            at, ullamcorper nec diam</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                            et</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-3">
                                                    <div class="image">
                                                        <i class="icon-noti-3"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order shipped successfully</div>
                                                        <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                            sollicitudin</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-4">
                                                    <div class="image">
                                                        <i class="icon-noti-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                        </div>
                                                        <div class="text-tiny">Ultricies at rhoncus at ullamcorper
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
                                        </ul>
                                    </div>
                                </div>




                                <div class="popup-wrap user type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img class="admin-logo"
                                                        src="{{ asset('images/logo/logo-sipeta-2.png') }}"
                                                        alt="">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">Admin</span>

                                                </span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="body-title-2">Account</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-mail"></i>
                                                    </div>
                                                    <div class="body-title-2">Inbox</div>
                                                    <div class="number">27</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-file-text"></i>
                                                    </div>
                                                    <div class="body-title-2">Taskboard</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-headphones"></i>
                                                    </div>
                                                    <div class="body-title-2">Support</div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="ModalUtils.open('logout-modal')"
                                                    class="user-item">
                                                    <div class="icon">
                                                        <i class="icon-log-out"></i>
                                                    </div>
                                                    <div class="body-title-2">Log out</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                        @yield('content')

                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>

        <script>
            // Manual dropdown toggle for table actions (No Popper.js)
            document.addEventListener('DOMContentLoaded', function() {
                // Close all dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.dropdown')) {
                        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                            menu.classList.remove('show');
                            // Remove inline transform from Popper
                            menu.style.transform = '';
                            menu.style.top = '';
                            menu.style.left = '';
                            menu.style.right = '';

                            const button = menu.closest('.dropdown').querySelector(
                                '[data-bs-toggle="dropdown"]');
                            if (button) {
                                button.classList.remove('show');
                                button.setAttribute('aria-expanded', 'false');
                            }
                        });
                    }
                });

                // Toggle dropdown on button click
                document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Find the dropdown menu within the same dropdown container
                        const dropdown = this.closest('.dropdown');
                        const menu = dropdown ? dropdown.querySelector('.dropdown-menu') : null;

                        if (!menu) {
                            console.error('Dropdown menu not found');
                            return;
                        }

                        const isExpanded = this.getAttribute('aria-expanded') === 'true';

                        // Close all other dropdowns first
                        document.querySelectorAll('.dropdown-menu.show').forEach(function(otherMenu) {
                            if (otherMenu !== menu) {
                                otherMenu.classList.remove('show');
                                // Remove Popper inline styles
                                otherMenu.style.transform = '';
                                otherMenu.style.top = '';
                                otherMenu.style.left = '';
                                otherMenu.style.right = '';

                                const otherButton = otherMenu.closest('.dropdown')
                                    .querySelector('[data-bs-toggle="dropdown"]');
                                if (otherButton) {
                                    otherButton.classList.remove('show');
                                    otherButton.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });

                        // Toggle current dropdown
                        if (isExpanded) {
                            menu.classList.remove('show');
                            // Remove Popper inline styles
                            menu.style.transform = '';
                            menu.style.top = '';
                            menu.style.left = '';
                            menu.style.right = '';

                            this.classList.remove('show');
                            this.setAttribute('aria-expanded', 'false');
                        } else {
                            menu.classList.add('show');
                            // Remove Popper inline styles to use CSS positioning
                            menu.style.transform = '';
                            menu.style.top = '';
                            menu.style.left = '';
                            menu.style.right = '';

                            this.classList.remove('show');
                            this.setAttribute('aria-expanded', 'true');
                        }
                    });
                });
            });
        </script>

        <script>
            $(function() {
                $("#search-input").on("keyup", function() {
                    var searchQuery = $(this).val();

                    if (searchQuery.length > 2) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.search') }}",
                            data: {
                                query: searchQuery
                            },
                            dataType: "json",
                            success: function(data) {
                                $("#box-content-search").html('');
                                $.each(data, function(index, item) {
                                    var url =
                                        "{{ route('admin.product.edit', ['id' => 'product_id']) }}";
                                    var link = url.replace('product_id', item.id);
                                    var imageUrl = item.image;
                                    if (!imageUrl.startsWith('http')) {
                                        imageUrl =
                                            "{{ asset('uploads/products/thumbnails') }}/" +
                                            imageUrl;
                                    }

                                    $("#box-content-search").append(`
                                <ul>
                                    <li class="product-item gap14 mb-10">
                                        <div class="image no-bg">
                                            <img src="${imageUrl}" alt="${item.name}">
                                        </div>
                                        <div class="flex items-center justify-between gap20 flex-grow">
                                            <div class="name">
                                                <a href="${link}" class="body-text">${item.name}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-10">
                                        <div class="divider"></div>
                                    </li>
                                </ul>
                            `);
                                });
                            }
                        });
                    }
                });
            });
        </script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/admin-search.js') }}"></script>
        @stack('scripts')

        {{-- Centralized Modals System --}}
        @include('partials.modals')
</body>

</html>
