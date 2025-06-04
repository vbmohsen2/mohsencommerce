<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{


    public function addToCart(Request $request, $productId)
    {

        // دریافت محصول از دیتابیس
        $product = Products::findOrFail($productId);

        // بررسی اینکه آیا سبد خرید در سشن وجود دارد یا خیر
        $cart = session()->get('cart', []);
        $images = json_decode($product->images);

        // اگر محصول قبلاً در سبد خرید هست، تعداد آن را افزایش بده
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // اگر محصول جدید است، آن را به سبد خرید اضافه کن
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image'=>$images->thumb
            ];
        }

        // ذخیره‌سازی سبد خرید در سشن
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function index(){
        return Products::all();
    }
    public function show($slug){
        $product = Products::where('slug', $slug)->firstOrFail();
        $product->views_count++;
        $product->save();
        return view('product', ['product' => $product]);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Products::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->take(10)
            ->get(['id', 'name','slug', 'images', 'price']);

        return response()->json($products);
    }


}
