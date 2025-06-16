<?php

use App\Http\Controllers\admin\admin;
use App\Http\Controllers\admin\attributes;
use App\Http\Controllers\blogAdmin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


//admin

Route::get('/admin', [admin::class, 'index'])->name('adminhome');
Route::get('/admin/products', [admin::class, 'ProductsIndex'])->name('admin.products');
Route::get('/admin/addproduct', [admin::class, 'addProductPage'])->name('admin.addProduct');
Route::get('/admin/products/{id}', [admin::class, 'editproduct'])->name('admin.editProduct');


Route::get('/admin/categories', [admin::class, 'CategoriesIndex'])->name('admin.categories');
Route::get('/admin/categoriestree', [admin::class, 'categoriesIndexTree'])->name('admin.categoriestree');


Route::get('/admin/attributes/templates', [attributes::class, 'index'])->name('admin.attributes.templates');
Route::get('/admin/attributes/storeTemplate', [attributes::class, 'store'])->name('admin.attributes.storeTemplate');
Route::post('/admin/attributes/deletetemplate', [attributes::class, 'deletetemplate'])->name('admin.attributes.deleteTemplate');
Route::get('/admin/attributes/{id}', [attributes::class, 'edit'])->name('admin.attributes.showAttribute');

//vue orders route

Route::get('/admin/orders/', [OrderController::class, 'show'])->name('admin.orders');

Route::get('/admin/orders/{any}', function () {
    return view('admin.orders/ordersvue'); // این فایل Blade هست که Vue app رو لود می‌کنه
})->where('any', '.*');



Route::post('/slugify', [admin::class, 'slugify']);




Route::get('/admin/blog/categories', [blogAdmin::class, 'indexCategoreis'])->name('admin.blog.categories');

Route::get('/admin/blog/posts', [blogAdmin::class, 'indexPosts'])->name('admin.blog.posts');


Route::get('/admin/blog/posts/{any}', function () {
    return view('admin.blog.blogPostsvue'); // این فایل Blade هست که Vue app رو لود می‌کنه
})->where('any', '.*');



//user

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/admin/users', function () {
    return view('admin.users.users'); // یا هر نامی که صفحه blade شما داره
})->name('admin.users');




//commerce
Route::get('/', [\App\Livewire\Mainpage::class, 'index'])->name('home');
route::get('/product/{slug}', ProductsController::class . '@show');
route::get('/addtocart/{productId}', ProductsController::class . '@addToCart');
route::get('/category/{slug}', CategoryController::class . '@show');
Route::get('/products/search', [ProductsController::class, 'search']);


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/shipping', [OrderController::class, 'index'])->name('shipping')->middleware('auth');


Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');





//user


Route::middleware('auth')->group(function () {
    Route::post('/select-address', [OrderController::class, 'selectAddress'])->name('address.select');
    Route::post('/add-address', [OrderController::class, 'addAddress'])->name('address.add');
});


//blog
route::get('/blog', PostsController::class . '@index');
Route::get('/blog/{post}', PostsController::class . '@show');


//api
//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__ . '/auth.php';
