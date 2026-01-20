{{-- Cart Drawer Component --}}
<div id="cartDrawer" class="cart-drawer">
    <div class="cart-drawer-backdrop"></div>
    <div class="cart-drawer-content">
        <div class="cart-drawer-header">
            <button class="cart-drawer-close" aria-label="Close cart">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <h3 class="cart-drawer-title">Keranjang Pesanan</h3>
        </div>

        @include('components.cart-drawer-content')
    </div>
</div>
