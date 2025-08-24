<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ProductController;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use function App\View\Components\render;

class CategoryController extends Controller
{
//    public function show($slug){
//        $category = Category::where('slug', $slug)->where('is_active', 1)->firstOrFail();
//
//        $products = $category->products()->paginate(12); // یا هر تعداد دلخواه
//
//        return view('Pages.category', compact('products', 'category'));
//    }


    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Products::where('category_id', $category->id)->orderByDesc('created_at')->paginate(10);
        $brands = Products::
        where('category_id', $category->id)
            ->select('brand')
            ->distinct()
            ->pluck('brand');

        $template = $category->attribute_template;
        $attributes = $template->attributes;
        $breadcrumb = [];

        while ($category) {
            $breadcrumb[] = $category;
            if (!$category->parent_id || $category->parent_id == 0) break;
            $category = \App\Models\Category::find($category->parent_id);
        }

        return Inertia::render('category', ['products' => $products, 'category' => $category, 'brands' => $brands, 'attributes' => $attributes, 'breadcrumb' => $breadcrumb]);
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
    public function indexAll(){
        return response()->json([Category::all()]);
    }

}
