<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WhishlistController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthAdmin;
use App\Models\Product;

Auth::routes();

// Google OAuth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/', [HomeController::class, 'index'])
    ->middleware('redirect.if.admin')
    ->name('home.index');

//Search Routes
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

//Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

//About Routes
Route::get('/about-us', [HomeController::class, 'about'])->name('home.about');

//Contact Routes
Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact-store', [HomeController::class, 'contact_store'])->name('home.contact.store');

//Review Routes
Route::post('/review/submit', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

//Farmer Profile Routes
Route::get('/farmer/{slug}', [App\Http\Controllers\FarmerController::class, 'show'])->name('farmer.profile');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/drawer-content', [CartController::class, 'getDrawerContent'])->name('cart.drawer.content');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

// Apply Coupon Routes
Route::post('/cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('/cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');


//Whistlist Routes
Route::post('/wishlist/add', [App\Http\Controllers\WhishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [App\Http\Controllers\WhishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [WhishlistController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WhishlistController::class, 'empty_wishlist'])->name('wishlist.items.clear');
Route::post('/wishlist/move-to-cart/{rowId}', [WhishlistController::class, 'move_to_cart'])->name('wishlist.move.to.cart');


// Checkout Routes
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');
Route::get('/order/{order}/status', [CartController::class, 'order_status'])->name('order.status');

// Midtrans Payment Routes
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/finish', [App\Http\Controllers\PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [App\Http\Controllers\PaymentController::class, 'unfinish'])->name('payment.unfinish');
Route::get('/payment/error', [App\Http\Controllers\PaymentController::class, 'error'])->name('payment.error');



// User Routes
Route::middleware(['auth', 'redirect.if.user', 'check.blocked'])->group(function () {
    // User Dashboard - Redirect to Account Details
    Route::redirect('/user', '/account-details')->name('user.user');
    Route::get('/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/order/{order_id}/details', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/order/{order_id}/cancel', [UserController::class, 'order_cancel'])->name('user.order.cancel');
    Route::delete('/order/{order_id}/delete', [UserController::class, 'order_delete'])->name('user.order.delete');
    Route::get('/order/{order_id}/invoice', [UserController::class, 'getInvoiceData'])->name('user.order.invoice');
    Route::get('/order/{order_id}/invoice/pdf', [UserController::class, 'downloadInvoicePdf'])->name('user.order.invoice.pdf');
    Route::get('/order/{order_id}/return', [UserController::class, 'returnRequest'])->name('user.order.return');
    Route::post('/order/{order_id}/return', [UserController::class, 'submitReturnRequest'])->name('user.order.return.submit');

    //User Address Routes
    Route::get('/address', [UserController::class, 'address'])->name('user.addresses');
    Route::get('/address/add', [UserController::class, 'address_add'])->name('user.address.add');
    Route::post('/address/store', [UserController::class, 'address_store'])->name('user.address.store');
    Route::get('/address/edit/{id}', [UserController::class, 'address_edit'])->name('user.address.edit');
    Route::put('/address/update', [UserController::class, 'address_update'])->name('user.address.update');
    Route::delete('/address/{id}/delete', [UserController::class, 'address_delete'])->name('user.address.delete');

    //User Account Details Routes
    Route::get('/account-details', [UserController::class, 'account_details'])->name('user.account.details');
    Route::put('/account-update', [UserController::class, 'account_update'])->name('user.account.update');
    Route::get('/account-settings', [UserController::class, 'account_settings'])->name('user.account.settings');
    Route::put('/account-settings-update', [UserController::class, 'account_settings_update'])->name('user.account.settings.update');

    //User Wishlist Routes
    Route::get('/user/wishlist', [UserController::class, 'wishlist'])->name('user.wishlist');
});


// Admin Routes
Route::middleware(['auth', AuthAdmin::class, 'check.blocked'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('/admin/dashboard/export', [AdminController::class, 'exportDashboardPdf'])->name('admin.dashboard.export');

    // Notifications
    Route::put('/admin/notification/{id}/read', [AdminController::class, 'markNotificationAsRead'])->name('admin.notification.read');
    Route::delete('/admin/notification/{id}/delete', [AdminController::class, 'deleteNotification'])->name('admin.notification.delete');

    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    //Region Routes
    Route::get('/admin/regions', [AdminController::class, 'regions'])->name('admin.regions');
    Route::get('/admin/region/add', [AdminController::class, 'region_add'])->name('admin.region.add');
    Route::post('/admin/region/store', [AdminController::class, 'region_store'])->name('admin.region.store');
    Route::get('/admin/region/edit/{id}', [AdminController::class, 'region_edit'])->name('admin.region.edit');
    Route::put('/admin/region/update', [AdminController::class, 'region_update'])->name('admin.region.update');
    Route::delete('/admin/region/{id}/delete', [AdminController::class, 'region_delete'])->name('admin.region.delete');

    //Farmer Routes
    Route::get('/admin/farmers', [AdminController::class, 'farmers'])->name('admin.farmers');
    Route::get('/admin/farmer/add', [AdminController::class, 'farmer_add'])->name('admin.farmer.add');
    Route::post('/admin/farmer/store', [AdminController::class, 'farmer_store'])->name('admin.farmer.store');
    Route::get('/admin/farmer/edit/{id}', [AdminController::class, 'farmer_edit'])->name('admin.farmer.edit');
    Route::put('/admin/farmer/update', [AdminController::class, 'farmer_update'])->name('admin.farmer.update');
    Route::delete('/admin/farmer/{id}/delete', [AdminController::class, 'farmer_delete'])->name('admin.farmer.delete');


    //Category Routes
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    //Product Routes
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

    //Coupon Routes
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupon/add', [AdminController::class, 'coupon_add'])->name('admin.coupon.add');
    Route::post('/admin/coupon/store', [AdminController::class, 'coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/{id}/edit', [AdminController::class, 'coupon_edit'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update', [AdminController::class, 'coupon_update'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/{id}/delete', [AdminController::class, 'coupon_delete'])->name('admin.coupon.delete');

    //Order Routes
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/{order_id}/details', [AdminController::class, 'order_details'])->name('admin.order.details');
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
    Route::delete('/admin/order/{id}/delete', [AdminController::class, 'order_delete'])->name('admin.order.delete');

    //Slide Routes
    Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
    Route::get('/admin/slide/add', [AdminController::class, 'slide_add'])->name('admin.slide.add');
    Route::post('/admin/slide/store', [AdminController::class, 'slide_store'])->name('admin.slide.store');
    Route::get('/admin/slide/{id}/edit', [AdminController::class, 'slide_edit'])->name('admin.slide.edit');
    Route::put('/admin/slide/update', [AdminController::class, 'slide_update'])->name('admin.slide.update');
    Route::delete('/admin/slide/{id}/delete', [AdminController::class, 'slide_delete'])->name('admin.slide.delete');

    //Slide Split Routes (Shop Page Banners)
    Route::get('/admin/slide-splits', [AdminController::class, 'slide_splits'])->name('admin.slide.splits');
    Route::get('/admin/slide-split/add', [AdminController::class, 'slide_split_add'])->name('admin.slide.split.add');
    Route::post('/admin/slide-split/store', [AdminController::class, 'slide_split_store'])->name('admin.slide.split.store');
    Route::get('/admin/slide-split/{id}/edit', [AdminController::class, 'slide_split_edit'])->name('admin.slide.split.edit');
    Route::put('/admin/slide-split/update', [AdminController::class, 'slide_split_update'])->name('admin.slide.split.update');
    Route::delete('/admin/slide-split/{id}/delete', [AdminController::class, 'slide_split_delete'])->name('admin.slide.split.delete');

    //Contact Routes
    Route::get('/admin/contact', [AdminController::class, 'contact'])->name('admin.contacts');
    Route::delete('/admin/contact/{id}/delete', [AdminController::class, 'contact_delete'])->name('admin.contact.delete');

    //Testimonial Routes
    Route::get('/admin/testimonials', [AdminController::class, 'testimonials'])->name('admin.testimonials');
    Route::post('/admin/testimonial/{id}/toggle-approval', [AdminController::class, 'testimonial_toggle_approval'])->name('admin.testimonial.toggle');
    Route::delete('/admin/testimonial/{id}/delete', [AdminController::class, 'testimonial_delete'])->name('admin.testimonial.delete');

    //Search Routes
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

    //Analytics Dashboard
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');

    //Review Management Routes
    Route::get('/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::delete('/admin/reviews/{id}/delete', [AdminController::class, 'deleteReview'])->name('admin.reviews.delete');

    //User Management Routes
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/user/{id}/details', [AdminController::class, 'user_details'])->name('admin.user.details');
    Route::put('/admin/user/{id}/block', [AdminController::class, 'user_block'])->name('admin.user.block');
    Route::put('/admin/user/{id}/unblock', [AdminController::class, 'user_unblock'])->name('admin.user.unblock');

    //Return Requests Routes
    Route::get('/admin/returns', [AdminController::class, 'returns'])->name('admin.returns');
    Route::get('/admin/return/{id}/details', [AdminController::class, 'return_details'])->name('admin.return.details');
    Route::put('/admin/return/update-status', [AdminController::class, 'update_return_status'])->name('admin.return.status.update');
});
