<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Inertia\Ssr\Response as InertiaResponse;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
//    protected $rootView = 'app';



    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'csrfToken' => csrf_token(),
            'description'=>env('APP_DESCRIPTION'),
            // می‌تونی سایر مقادیر مثل route name یا user یا ... رو هم اضافه کنی
        ]);
    }
    public function handle(Request $request, Closure $next)
    {
       // فایل blade اصلی

        return parent::handle($request, $next);
    }
    public function rootView(Request $request)
    {
        return 'app'; // نام فایل blade اصلی
    }
}
