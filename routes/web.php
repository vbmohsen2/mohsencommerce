<?php

use App\Http\Controllers\admin\admin;
use App\Http\Controllers\admin\attributes;
use App\Http\Controllers\Api\ProductController;
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


use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;




Auth::routes(['verify' => true]);


 Route::middleware(['auth', 'isAdmin'])->get('/api/products', [admin::class, 'getProducts']);
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

});


Route::post('/slugify', [admin::class, 'slugify']);

//user

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/admin/users', function () {
    return view('admin.users.users'); // یا هر نامی که صفحه blade شما داره
})->name('admin.users');




//commerce
Route::get('/', [Mainpage::class, 'index'])->name('home');
//route::get('/product/{slug}', ProductsController::class . '@show');
route::get('/product/{slug}', ProductsController::class . '@productshow');


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
Route::get('/blog/{post}', PostsController::class . '@show')->name('blog.show');
Route::get('/blog/category/{category}', PostsController::class . '@categoryshow');

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


Route::view('/user/{any?}', 'Pages.user')->where('any', '.*');






Route::middleware(['auth', 'isAdmin'])->prefix('api')->group(function () {

    // 🔸 محصولات
    Route::get('/products', [admin::class, 'getProducts']);
    Route::get('/productsAll', [admin::class, 'getproductswihoutpagination']);
    Route::post('/addproduct', [admin::class, 'addProduct']);
    Route::get('/product/{id}', [admin::class, 'fetchProduct']);
    Route::delete('/product/{product}', [admin::class, 'destroy']);
    Route::patch('/product/{product}/toggle-active', [admin::class, 'toggleActive']);

    // 🔸 ویژگی‌ها
    Route::get('/attributestemplate/{id}', [attributes::class, 'showAttributeTemplate'])->name('admin.attributes.getAttributeTemplate');
    Route::get('/attributes/{id}', [attributes::class, 'showAttribute'])->name('admin.attributes.getAttribute');
    Route::post('/attributes/reorder', [attributes::class, 'attributesreorder'])->name('admin.attributes.reorder');
    Route::post('/attributes/delete', [attributes::class, 'deleteAttribute']);

    // 🔸 دسته‌بندی‌ها
    Route::get('/categories', [admin::class, 'getCategories']);
    Route::post('/categories/reorder', [admin::class, 'categoryReorder']);
    Route::post('/categories/delete', [admin::class, 'deleteCategory']);
    Route::post('/categories/attributes', [admin::class, 'attributesRet']);


    // 🔸 بلاگ
    Route::get('/blog/categories', [blogAdmin::class, 'getBlogCategory']);
    Route::get('/blog/allposts', [blogAdmin::class, 'getallposts']);
    Route::get('allpostswithoutpaginate', [blogAdmin::class, 'getallpostswithoutpaginate']);
    Route::post('/blogcategories/delete', [blogAdmin::class, 'deleteBlogCategory']);
    Route::post('/blogcategories/save', [blogAdmin::class, 'categoryBlogSave']);
    Route::get('/blog/postsvue', [blogAdmin::class, 'vueposts'])->name('admin.blog.postsvue');
    Route::get('/blog/tags', [blogAdmin::class, 'tags'])->name('admin.blog.tags');
    Route::delete('/blog/deletepost/{id}', [blogAdmin::class, 'deletepost'])->name('admin.blog.deletepost');
    Route::post('/blog/postsvue/edit', [blogAdmin::class, 'getPost'])->name('admin.blog.editpost');
    Route::post('/blog/savepost', [blogAdmin::class, 'savePost'])->name('admin.blog.savePost');
    Route::post('/blog/postimages', [blogAdmin::class, 'postImages'])->name('admin.blog.postimages');
    Route::get('/blog/search/', [PostsController::class, 'search']);
    // 🔸 کاربران
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });
    Route::post('/users/{user}/change-password', [UserController::class, 'changePassword']);

    // 🔸 سفارشات
    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'indexordersforvue');
        Route::get('/ordercount', 'userOrdercount');
        Route::get('{id}', 'showorder');
        Route::put('{id}', 'update');
        Route::put('{id}/status', 'updateStatus');
        Route::put('{id}/address', 'updateAddress');
        Route::delete('{id}', 'destroy');
    });
});


// Route::get('/api/products', [ProductController::class, 'index']);
// Route::get('/api/products/{id}', [ProductController::class, 'show']);
 Route::get('/api/categories/{category:slug}/products', [ProductController::class, 'index2']);
Route::get('/api/categories/{category:slug}/filters', [CategoryController::class, 'filters']);

Route::get('/api/categories/breadcrumb/{id}', [admin::class, 'breadcrumb']);
Route::post('/api/changelike',[UserController::class, 'addlike']);
Route::get('/api/getlikestatus/{id}', [UserController::class, 'getLikeStatus']);


Route::get('/api/products/{product}/related', [ProductController::class, 'related']);


// دریافت اطلاعات کاربر لاگین‌شده (اگر کاربر معمولی هست)
Route::get('/api/user', function (Request $request) {
    return $request->user();
})->middleware('auth');



//sitemap

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create(config('app.url'));

    // محصولات
    \App\Models\Products::all()->each(function ($product) use ($sitemap) {
        $sitemap->add(
            Url::create("/product/{$product->slug}")
                ->setLastModificationDate($product->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                ->setPriority(0.9)
        );
    });

    // پست‌های وبلاگ
    \App\Models\Posts::all()->each(function ($post) use ($sitemap) {
        $sitemap->add(
            Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                ->setPriority(0.8)
        );
    });

    \App\Models\Category::all()->each(function ($category) use ($sitemap) {
        $sitemap->add(
            Url::create("/category/{$category->slug}")
                ->setLastModificationDate($category->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                ->setPriority(0.8)
        );
    });
    \App\Models\PostCategory::all()->each(function ($category) use ($sitemap) {
        $sitemap->add(
            Url::create("blog/category/{$category->slug}")
                ->setLastModificationDate($category->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                ->setPriority(0.5)
        );
    });

    return $sitemap->toResponse(request());
});

//api
//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__ . '/auth.php';
