<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return Products::with('category')->paginate(10);
    }

    public function index2(Request $request, Category $category)
    {
        $query = Products::query()->where('category_id', $category->id);


        // -------------------------------
        // فیلتر بر اساس برند


        if ($request->has('brand')) {
            $brands = (array) $request->input('brand');
            $query->whereIn('brand', $brands);
        }
        Log::info($request->input('brand'));
        // -------------------------------
        // فیلتر بر اساس ویژگی‌ها (attributes)
        if ($request->has('filters')) {
            foreach ($request->input('filters') as $filterName => $values) {
                $query->where(function ($q) use ($filterName, $values) {
                    foreach ((array) $values as $value) {
                        $q->orWhereJsonContains('attributes', [
                            'name' => $filterName,
                            'value' => $value,
                        ]);
                    }
                });
            }
        }

        // -------------------------------
        // مرتب‌سازی
        switch ($request->input('sort_by')) {
            case 'expensive':
                $query->orderByDesc('price');
                break;
            case 'cheap':
                $query->orderBy('price');
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
                $query->orderByDesc('created_at');
            default:
                $query->latest(); // جدیدترین
                break;
        }

        // -------------------------------
        // صفحه‌بندی
        $products = $query->paginate(10);
        Log::info(['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        return response()->json($products);
    }

    public function related(Products $product)
    {
        $limit = 10;

        // 1. بر اساس دسته‌بندی مشابه
        $related = Products::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take($limit)
            ->get();

        $count = $related->count();

        if ($count < $limit) {
            // 2. اگر کم بود، محصولات از همان برند هم بیار
            $more = Products::where('brand', $product->brand)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->latest()
                ->take($limit - $count)
                ->get();

            $related = $related->merge($more);
            $count = $related->count();
        }

        if ($count < $limit) {
            // 3. اگر باز هم کم بود، محصولات تصادفی پر کن
            $random = Products::where('id', '!=', $product->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->inRandomOrder()
                ->take($limit - $count)
                ->get();

            $related = $related->merge($random);
        }

        return response()->json($related);
    }



}
