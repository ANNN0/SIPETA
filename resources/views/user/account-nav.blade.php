<div class="user-sidebar">
    <ul class="user-sidebar__menu">
        <li class="user-sidebar__item {{ request()->routeIs('user.account.details') ? 'active' : '' }}">
            <a href="{{ route('user.account.details') }}" class="user-sidebar__link">
                Informasi Personal
            </a>
        </li>
        <li class="user-sidebar__item {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
            <a href="{{ route('user.orders') }}" class="user-sidebar__link">
                Pesanan
            </a>
        </li>
        <li class="user-sidebar__item {{ request()->routeIs('user.addresses*') ? 'active' : '' }}">
            <a href="{{ route('user.addresses') }}" class="user-sidebar__link">
                Alamat
            </a>
        </li>
        <li class="user-sidebar__item {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">
            <a href="{{ route('user.wishlist') }}" class="user-sidebar__link">
                Wishlist
            </a>
        </li>
        {{-- <li class="user-sidebar__item">
            <a href="#" class="user-sidebar__link user-sidebar__link--disabled" title="Fitur segera hadir">
                Lacak Pesanan
            </a>
        </li> --}}
        <li class="user-sidebar__item {{ request()->routeIs('user.account.settings') ? 'active' : '' }}">
            <a href="{{ route('user.account.settings') }}" class="user-sidebar__link">
                Pengaturan
            </a>
        </li>
        <li class="user-sidebar__item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                @csrf
                <button type="submit" class="user-sidebar__link user-sidebar__link--logout">
                    Keluar
                </button>
            </form>
        </li>
    </ul>
</div>
