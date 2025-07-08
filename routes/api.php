<?php

use App\Http\Controllers\admin\admin;
use App\Http\Controllers\admin\attributes;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\blogAdmin;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);



Route::get('/products', [admin::class, 'getProducts']);
Route::get('/productsAll', [admin::class, 'getproductswihoutpagination']);
Route::post('/addproduct', [admin::class, 'addProduct']);
Route::get('/product/{id}', [admin::class, 'fetchProduct']);
Route::delete('/product/{product}', [admin::class, 'destroy']);
Route::patch('/product/{product}/toggle-active', [admin::class, 'toggleActive']);


Route::get('/attributestemplate/{id}', [attributes::class, 'showAttributeTemplate'])->name('admin.attributes.getAttributeTemplate');
Route::get('/attributes/{id}', [attributes::class, 'showAttribute'])->name('admin.attributes.getAttribute');
Route::post('/attributes/reorder', [attributes::class, 'attributesreorder'])->name('admin.attributes.reorder');
Route::post('/attributes/delete', [attributes::class, 'deleteAttribute']);


Route::get('/categories', [admin::class, 'getCategories']);
Route::post('/categories/reorder', [admin::class, 'categoryReorder']);
Route::post('/categories/delete', [admin::class, 'deleteCategory']);
Route::post('/categories/attributes', [admin::class, 'attributesRet']);
Route::get('/categories/breadcrumb/{id}', [admin::class, 'breadcrumb']);


Route::get('/blog/categories', [blogAdmin::class, 'getBlogCategory']);
Route::get('/allposts', [blogAdmin::class, 'getallposts']);
Route::get('/allpostswithoutpaginate', [blogAdmin::class, 'getallpostswithoutpaginate']);
Route::post('/blogcategories/delete', [blogAdmin::class, 'deleteBlogCategory']);
Route::post('/blogcategories/save', [blogAdmin::class, 'categoryBlogSave']);


Route::get('/blog/postsvue', [blogAdmin::class, 'vueposts'])->name('admin.blog.postsvue');
Route::post('/blog/postsvue/edit', [blogAdmin::class, 'getPost'])->name('admin.blog.editpost');
Route::post('/blog/savepost', [blogAdmin::class, 'savePost'])->name('admin.blog.savePost');
Route::post('/blog/postimages', [blogAdmin::class, 'postImages'])->name('admin.blog.postimages');


Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
});
Route::post('/users/{user}/change-password', [UserController::class, 'changePassword']);



Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/', 'indexordersforvue');
    Route::get('{id}', 'showorder');
    Route::put('{id}', 'update');
    Route::put('{id}/status', 'updateStatus');
    Route::put('/{id}/address', [OrderController::class, 'updateAddress']);
    Route::delete('{id}', 'destroy');
});


//client side api's
Route::get('/categories/{category:slug}/products', [ProductController::class, 'index2']);
Route::get('/categories/{category:slug}/filters', [CategoryController::class, 'filters']);


