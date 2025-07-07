<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{





    public function index(){
        return Products::all();
    }
    public function show($slug){
        $product = Products::where('slug', $slug)->firstOrFail();
        $product->views_count++;
        $product->save();
        return view('pages.product', ['product' => $product]);
    }
    public function romanoShow($slug)
    {
        $product = Products::with('category')->where('slug', $slug)->firstOrFail();
        $product->views_count++;
        $product->save();

        return view('pages.romano.romanoProduct', ['product' => $product]);
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
