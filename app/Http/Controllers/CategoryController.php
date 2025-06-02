<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug){
        $category = Category::where('slug', $slug)->where('is_active', 1)->firstOrFail();

        $products = $category->products()->paginate(12); // یا هر تعداد دلخواه

        return view('pages.category', compact('products', 'category'));
    }
}
