<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ProductController;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{



    public function index(){
        return Products::all();
    }
    public function show($slug){
        $product = Products::where('slug', $slug)->firstOrFail();
        $product->views_count++;
        $product->save();
        return view('Pages.product', ['product' => $product]);
    }
    public function productshow($slug)
    {
        $product = Products::with('category')->where('slug', $slug)->firstOrFail();
        $product->views_count++;
        $product->save();

        $category = $product->category()->first();
        $categories = [];

        while ($category) {
            $categories[] = $category;
            if (!$category->parent_id || $category->parent_id == 0) break;
            $category = Category::find($category->parent_id);
        }

       $related=$this->related($product);
        return Inertia::render('product', ['product' => $product,
            'categories' => array_reverse($categories),
            'siteUrl' => url('/'),
            'related' => $related]);
//        return view('Pages.romano.romanoProduct', ['product' => $product]);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Products::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->take(10)
            ->get(['id', 'name','slug', 'images', 'price','discount_price']);

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
        if ($count < $limit) {
            $priceRange = 0.2; // مثلا 20 درصد بالا و پایین
            $min = $product->price * (1 - $priceRange);
            $max = $product->price * (1 + $priceRange);

            $similarPrice = Products::whereBetween('price', [$min, $max])
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->latest()
                ->take($limit - $count)
                ->get();

            $related = $related->merge($similarPrice);
        }
//        return response()->json($related);
        return $related;
    }

}
