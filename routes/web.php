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
use App\Livewire\Mainpage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;




// گروه مسیرهای ادمین با middleware
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {

    // داشبورد
    Route::get('/', [admin::class, 'index'])->name('home');

    // محصولات
    Route::get('/products', [admin::class, 'ProductsIndex'])->name('products');
    Route::get('/addproduct', [admin::class, 'addProductPage'])->name('addProduct');
    Route::get('/products/{id}', [admin::class, 'editproduct'])->name('editProduct');

    // دسته‌بندی‌ها
    Route::get('/categories', [admin::class, 'CategoriesIndex'])->name('categories');
    Route::get('/categoriestree', [admin::class, 'categoriesIndexTree'])->name('categoriestree');

    // ویژگی‌ها (attributes)
    Route::get('/attributes/templates', [attributes::class, 'index'])->name('attributes.templates');
    Route::get('/attributes/storeTemplate', [attributes::class, 'store'])->name('attributes.storeTemplate');
    Route::post('/attributes/deletetemplate', [attributes::class, 'deletetemplate'])->name('attributes.deleteTemplate');
    Route::get('/attributes/{id}', [attributes::class, 'edit'])->name('attributes.showAttribute');

    // سفارشات
    Route::get('/orders', [OrderController::class, 'show'])->name('orders');
    Route::get('/orders/{any}', function () {
        return view('admin.orders.ordersvue');
    })->where('any', '.*');

    // بلاگ
    Route::get('/blog/categories', [blogAdmin::class, 'indexCategoreis'])->name('blog.categories');
    Route::get('/blog/posts', [blogAdmin::class, 'indexPosts'])->name('blog.posts');
    Route::get('/blog/posts/{any}', function () {
        return view('admin.blog.blogPostsvue');
    })->where('any', '.*');

    // ابزارها
    Route::post('/slugify', [admin::class, 'slugify']);
});




//user

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/admin/users', function () {
    return view('admin.users.users'); // یا هر نامی که صفحه blade شما داره
})->name('admin.users');




//commerce
Route::get('/', [Mainpage::class, 'index'])->name('home');
//route::get('/product/{slug}', ProductsController::class . '@show');
route::get('/product/{slug}', ProductsController::class . '@romanoShow');


route::get('/category/{slug}', CategoryController::class . '@show');
Route::get('/products/search', [ProductsController::class, 'search']);


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
route::get('/addtocart/{productId}', [CartController::class , 'addToCart'])->name('cart.addToCart');

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


Route::middleware('auth')->group(function () {
    Route::get('/api/user', function() {
        return auth()->user();
    });

    Route::post('/user/update', [UserController::class, 'updateUserSelf']);
    Route::post('/user/updatephone', [UserController::class, 'updatephoneUserSelf']);
    Route::post('/user/change-password', [UserController::class, 'changePasswordUserSelf']);
    Route::middleware('auth')->group(function () {
        Route::get('/api/user/addresses', [UserController::class, 'getAddresses']);
        Route::post('/user/addresses/update', [UserController::class, 'updateAddresses']);
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/api/user/orders', [userController::class, 'orders']);
    Route::get('/api/user/orders/{id}', [userController::class, 'ordershow']);
});


Route::view('/user/{any?}', 'pages.user')->where('any', '.*');

//api
//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__ . '/auth.php';
