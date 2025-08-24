<?php

namespace App\Providers;

use App\services\CartService;
use App\services\CategoryService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Carts;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $listen = [
        // رویداد ورود کاربر
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\TransferCartToDatabaseListener::class,
        ],
    ];
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Inertia::share('cart', fn () => CartService::getCartData());
        Inertia::share('navbarcategories', fn () => CategoryService::getActiveCategories());

        Inertia::share(['auth' => function ()
        {return ['user' => Auth::user(),];}
        ]);
//        Inertia::share('appName' , config('app.name'));







//        View::composer('Layouts.header', function ($view) {
//            if (Auth::check()) {
//
//                $carts = Carts::where('user_id', Auth::id())->sum('quantity');
//            } else {
//                // مهمان - سبد خرید از سشن
//                $carts = Session::get('cart', []);
//                $carts = array_sum(array_column($carts, 'quantity'));
//            }
//
//            $view->with('cartCount', $carts);
//        });
    }
}
