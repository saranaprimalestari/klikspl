<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Beranda', route('home'));
});

// Home > Product
Breadcrumbs::for('product', function ($trail) {
    $trail->parent('home');
    $trail->push('Produk', route('product'));
});

// Home > Product > [product]
Breadcrumbs::for('product.show', function ($trail, $product) {
    $trail->parent('product');
    $trail->push($product->name, route('product', $product->slug));
});

// // Home > Product > [product]
// Breadcrumbs::for('product.show.detail', function ($trail, $product) {
//     $trail->parent('product');
//     $trail->push($product->name, route('product', $product->slug));
// });

// Home > Category
Breadcrumbs::for('category', function ($trail) {
    $trail->parent('home');
    $trail->push('Kategori', route('category'));
});

// Home > Category > [product]
Breadcrumbs::for('category.show', function ($trail, $category) {
    $trail->parent('category');
    $trail->push($category->name, route('category.show', $category->slug));
});

// Home > Merk
Breadcrumbs::for('merk', function ($trail) {
    $trail->parent('home');
    $trail->push('Merk', route('merk'));
});

// Home > Merk > [product]
Breadcrumbs::for('merk.show', function ($trail, $merk) {
    $trail->parent('merk');
    $trail->push($merk->name, route('merk.show', $merk->slug));
});

// Home > Cart items
Breadcrumbs::for('cart', function ($trail) {
    $trail->parent('home');
    $trail->push('Keranjang', route('cart.index'));
});
Breadcrumbs::for('checkout', function ($trail) {
    $trail->parent('cart');
    $trail->push('Checkout', route('cart.checkout'));
});

// Home > User Notifications
Breadcrumbs::for('promo', function ($trail) {
    $trail->parent('home');
    $trail->push('Voucher Promo', route('promo.index'));
});

// Home > User promo > [promo]
Breadcrumbs::for('promo.show', function ($trail, $promo) {
    $trail->parent('promo');
    $trail->push($promo->name, route('promo.show', $promo->name));
});

// Home > User Notifications
Breadcrumbs::for('notification', function ($trail) {
    $trail->parent('home');
    $trail->push('Notifikasi', route('notifications.index'));
});

// Home > User Notifications > [notification]
Breadcrumbs::for('notification.show', function ($trail, $notification) {
    $trail->parent('notification');
    $trail->push($notification->slug, route('notifications.show', $notification->slug));
});

// Home > Beli Langsung
Breadcrumbs::for('buy.now', function ($trail) {
    $trail->parent('home');
    $trail->push('Beli Langsung', route('buy.now.view'));
});

// Home > User
Breadcrumbs::for('profile.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Akun saya', route('profile.index'));
});

// Home > User > Pesanan
Breadcrumbs::for('order.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Pesanan Saya',route('order.index'));
});

// Home > Pesanan > pembayaran
Breadcrumbs::for('order.payment', function ($trail) {
    $trail->parent('order.index');
    $trail->push('Pembayaran',route('payment.order'));
});

// Home > Pesanan > Detail
Breadcrumbs::for('order.detail', function ($trail) {
    $trail->parent('order.index');
    $trail->push('Detail Pesanan',route('order.detail'));
});