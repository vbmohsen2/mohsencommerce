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



Route::post('/slugify', [admin::class, 'slugify'] );


Route::get('/admin/blog/categories', [blogAdmin::class, 'indexCategoreis'])->name('admin.blog.categories');

Route::get('/admin/blog/posts', [blogAdmin::class, 'indexPosts'])->name('admin.blog.posts');


Route::get('/admin/blog/posts/{any}', function () {
    return view('admin.blog.blogPostsvue'); // این فایل Blade هست که Vue app رو لود می‌کنه
})->where('any', '.*');



//user

    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');



//commerce
Route::get('/', [\App\Livewire\Mainpage::class, 'index'])->name('home');
route::get('/product/{slug}',ProductsController::class.'@show');
route::get('/addtocart/{productId}',ProductsController::class.'@addToCart');
route::get('/category/{slug}',CategoryController::class.'@show');
Route::get('/products/search', [ProductsController::class, 'search']);


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/shipping', [OrderController::class, 'index'])->name('shipping')->middleware('auth');



//user


Route::middleware('auth')->group(function () {
    Route::post('/select-address', [OrderController::class, 'selectAddress'])->name('address.select');
    Route::post('/add-address', [OrderController::class, 'addAddress'])->name('address.add');
});


//blog
route::get('/blog',PostsController::class.'@index');
Route::get('/blog/{post}',PostsController::class.'@show');



//api


Route::get('/api/products', [admin::class, 'getProducts']);
Route::get('/api/productsAll', [admin::class, 'getproductswihoutpagination']);
Route::post('/api/addproduct', [admin::class, 'addProduct']);
Route::get('/api/product/{id}', [admin::class, 'fetchProduct']);


Route::get('/api/attributestemplate/{id}', [attributes::class, 'showAttributeTemplate'])->name('admin.attributes.getAttributeTemplate');
Route::get('/api/attributes/{id}', [attributes::class, 'showAttribute'])->name('admin.attributes.getAttribute');
Route::post('/api/attributes/reorder', [attributes::class, 'attributesreorder'])->name('admin.attributes.reorder');
Route::post('/api/attributes/delete', [attributes::class, 'deleteAttribute']);


Route::get('/api/categories', [admin::class, 'getCategories']);
Route::post('/api/categories/reorder', [admin::class, 'categoryReorder']);
Route::post('/api/categories/delete', [admin::class, 'deleteCategory']);
Route::post('/api/categories/attributes', [admin::class, 'attributesRet']);


Route::get('/api/blog/categories', [blogAdmin::class, 'getBlogCategory']);
Route::get('/api/allposts', [blogAdmin::class, 'getallposts']);
Route::post('/api/blogcategories/delete', [blogAdmin::class, 'deleteBlogCategory']);
Route::post('/api/blogcategories/save', [blogAdmin::class, 'categoryBlogSave']);


Route::get('/api/blog/postsvue', [blogAdmin::class, 'vueposts'])->name('admin.blog.postsvue');
Route::post('/api/blog/postsvue/edit', [blogAdmin::class, 'getPost'])->name('admin.blog.editpost');
Route::post('/api/blog/savepost', [blogAdmin::class, 'savePost'])->name('admin.blog.savePost');
Route::post('/api/blog/postimages', [blogAdmin::class, 'postImages'])->name('admin.blog.postimages');



//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__.'/auth.php';
