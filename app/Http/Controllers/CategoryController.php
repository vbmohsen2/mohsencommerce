<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
//    public function show($slug){
//        $category = Category::where('slug', $slug)->where('is_active', 1)->firstOrFail();
//
//        $products = $category->products()->paginate(12); // یا هر تعداد دلخواه
//
//        return view('pages.category', compact('products', 'category'));
//    }


    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstorfail();
        return view('pages.category', compact('category'));
    }

    public function filters($category)
    {

        $category=Category::where('slug', $category)->firstorfail();
        $brands = Products::
            where('category_id', $category->id)
            ->select('brand')
            ->distinct()
            ->pluck('brand');

        $template = $category->attribute_template;

        $attributes = $template->attributes;



        return response()->json([
            'brands' => $brands,
            'attributes' => $attributes->map(function ($attr) {
                return [
                    'id' => $attr->id,
                    'name' => $attr->name,
                    'slug' => $attr->slug,
                    'options' =>  $attr->options,
                ];
            }),
        ]);
    }

}
