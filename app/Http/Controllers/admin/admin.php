<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class admin extends Controller
{
    public function index()
    {
        return view('admin.adminproduct');
    }

    public function ProductsIndex()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.adminproduct', compact('categories'));
    }

    public function addProductPage()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();
        return view('admin.adminAddProduct', compact('categories'));
    }
    public function editproduct($id)
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();

        return view('admin.adminEditProduct', compact('categories', 'id'));
    }

    public function fetchProduct($id){


        if (!$id) {
            return response()->json(['message' => 'id is required'], 400);
        }

        $product = Products::where('id', $id)->firstOrFail();

        return response()->json($product);
    }

    public function CategoriesIndex()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.admincategory', compact('categories'));
    }

    public function categoriesIndexTree()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.admincategorytree', compact('categories'));
    }

    public function getProducts(Request $request)
        //get product to product admin page with filter
    {
        $categoryIds = $request->input('categories', []);
        $searchTerm = $request->input('search', '');
        $perPage = 10;

        $query = Products::query();

        // فیلتر دسته‌بندی‌ها
        if (!empty($categoryIds)) {
            $query->whereHas('category', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        // فیلتر جستجو بر اساس نام محصول
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // گرفتن محصولات با استفاده از paginate
        $products = $query->paginate($perPage);

        // اضافه کردن مسیر تصویر به محصولات
        $products->getCollection()->transform(function ($product) {

            $images = json_decode($product->images, true);
            $product->image = isset($images['thumb']) ? asset('../images/products/thumb/' . $images['thumb']) : 'https://via.placeholder.com/300x200?text=No+Image';

            return $product;
        });

        return response()->json($products);
    }

    public function addProduct(Request $request){

        DB::beginTransaction();
        try {
            $uploadedMain = null;
            $uploadedThumb = null;
            $uploadedGallery = [];




            if ($request->hasFile('mainimage')) {
                $mainFilename = 'main_' . $request->slug . '-' . uniqid() . '.' . $request->file('mainimage')->extension();
                $request->file('mainimage')->storeAs('images/products', $mainFilename, 'public');
                $uploadedMain = $mainFilename;
            }

            if ($request->hasFile('thumbimage')) {
                $thumbFilename = 'thumb_' . $request->slug . '-' . uniqid() . '.' . $request->file('thumbimage')->extension();
                $request->file('thumbimage')->storeAs('images/products/thumb', $thumbFilename, 'public');
                $uploadedThumb = $thumbFilename;
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryFilename = $request->slug . '-' . uniqid() . '.' . $file->extension();
                    $file->storeAs('images/products/gallery', $galleryFilename, 'public');
                    $uploadedGallery[] = $galleryFilename;
                }
            }
//            log::info($request->all());
            // ذخیره در دیتابیس



            if($request->id){
                $product=Products::where('id',request('id'))->first();
            }
            else{
            // بررسی تکراری بودن slug
            if (Products::where('slug', $request->slug)->exists()) {
                return response()->json([
                    'field' => 'slug',
                    'message' => 'مقدار slug قبلاً استفاده شده است.'
                ], 421);
            }

            // بررسی تکراری بودن sku
            if (Products::where('sku', $request->sku)->exists()) {
                return response()->json([
                    'field' => 'sku',
                    'message' => 'مقدار sku قبلاً استفاده شده است.'
                ], 422);
            }
            $product = new Products();
            }

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->code = $request->code;
            $product->description = $request->description ;
            $product->seo_description=$request->seodescription;
            if($request->is_active=="true"){
                $product->is_active = 1;
            }
            if($request->is_active=="false"){
                $product->is_active = 0;
            }

            $product->category_id = $request->categoryid;
            $product->sku=$request->sku;
            $product->stock=$request->stock;
            $product->attributes = json_decode($request->input('attributes', []),true);
            $product->images = json_encode([
                'main' => $uploadedMain,
                'thumb' => $uploadedThumb,
                'gallery' => $uploadedGallery
            ]);
            $product->price = $request->price;
            if($request->input('discount', 0)!="undefined") {
                $product->discount_price = $request->input('discount', 0);
            }

            $product->brand=$request->brand;
            $product->weight=$request->weight;
            $product->save();

            DB::commit();

            return response()->json([
                'message' => 'محصول با موفقیت ذخیره شد.',
                'status' => 312,
                'product' => $product->id
            ],200);

        } catch (\Exception $e) {
            DB::rollBack();

            // حذف فایل‌ها در صورت خطا
            if ($uploadedMain) Storage::disk('public')->delete($uploadedMain);
            if ($uploadedThumb) Storage::disk('public')->delete($uploadedThumb);
            foreach ($uploadedGallery as $img) {
                Storage::disk('public')->delete($img);
            }

            return response()->json(['message' => 'خطا در ذخیره‌سازی: '.$e->getMessage() , 500]);
        }
//        return response()->json([
//            'message' => 'Product created successfully',
//            'product' => $mainImagePath
//        ]);
    }

    public function destroy(Products $product)
    {
        $images = json_decode($product->images, true);

        if (is_array($images)) {
            // انتقال تصویر اصلی
            if (!empty($images['main'])) {
                $from = 'images/products/' . $images['main'];
                $to = 'deleted_images/products/' . $images['main'];

                if (Storage::disk('public')->exists($from)) {
                    Storage::disk('public')->move($from, $to);
                    Log::info("تصویر اصلی منتقل شد: $from -> $to");
                } else {
                    Log::warning("تصویر اصلی پیدا نشد: $from");
                }
            }

            // انتقال تصویر بندانگشتی
            if (!empty($images['thumb'])) {
                $from = 'images/products/thumb/' . $images['thumb'];
                $to = 'deleted_images/products/thumb/' . $images['thumb'];

                if (Storage::disk('public')->exists($from)) {
                    Storage::disk('public')->move($from, $to);
                    Log::info("تصویر بندانگشتی منتقل شد: $from -> $to");
                } else {
                    Log::warning("تصویر بندانگشتی پیدا نشد: $from");
                }
            }

            // انتقال تصاویر گالری
            if (!empty($images['gallery']) && is_array($images['gallery'])) {
                foreach ($images['gallery'] as $galleryImage) {
                    $from = 'images/products/gallery/' . $galleryImage;
                    $to = 'deleted_images/products/gallery/' . $galleryImage;

                    if (Storage::disk('public')->exists($from)) {
                        Storage::disk('public')->move($from, $to);
                        Log::info("تصویر گالری منتقل شد: $from -> $to");
                    } else {
                        Log::warning("تصویر گالری پیدا نشد: $from");
                    }
                }
            }
        }

        // حذف محصول از دیتابیس
        $product->delete();

        return response()->json(['message' => 'محصول و تصاویر آن با موفقیت به سطل زباله منتقل شدند.']);


    }

    public function toggleActive(Products $product)
    {
        $product->is_active = request('is_active');
        $product->save();

        return response()->json(['message' => $product->save()]);
    }
    public function getCategories()
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->orderBy('order')->get();
        return response()->json($categories);
    }
    public function getproductswihoutpagination()
    {
        $product = Products::all();
        return response()->json($product);
    }

    public function categoryReorder(Request $request){
        // دریافت داده‌های ارسالی
        $data = $request->input('data');
//        Log::info('Parsed data:', $data);


        if (!$data || !is_array($data)) {
            return response()->json(['message' => $data], 400);
        }

        try {
            // برای هر دسته‌بندی در داده‌ها، ترتیب جدید را ذخیره می‌کنیم
            foreach ($data as $index => $category) {

//                return response()->json(['message' => Category::find($category['id'])]);
                // برای هر دسته‌بندی، ترتیب جدیدش رو ذخیره می‌کنیم
                $categoryModel = Category::find($category['id']);
//                              return response()->json(['message' => $categoryModel]);
                // اگر دسته‌بندی پیدا نشد، به خطا می‌خوریم
                if (!$categoryModel) {
                    $categoryModel = new Category();
                    $categoryModel->id=$category['id'];
//                    return response()->json(['message' => 'دسته‌بندی یافت نشد: ' . $category['id']], 404);
                }

                // بروزرسانی ترتیب (index)
                $categoryModel->order = $index;
                $categoryModel->name = $category['name'];
                $categoryModel->parent_id = $category['parent_id'];
                $categoryModel->slug = $category['slug'];
                $categoryModel->is_active = $category['is_active'];
                $categoryModel->description = $category['description'];
//                return response()->json(['message' => $categoryModel]);


                // ذخیره تغییرات در دیتابیس
               $result= $categoryModel->save();
//                return response()->json(['message' => $result]);

                // اگر دسته‌بندی فرزند دارد، ترتیب فرزندها رو نیز به‌روزرسانی می‌کنیم
                if (isset($category['children']) && is_array($category['children'])) {
                    foreach ($category['children'] as $childIndex => $child) {
                        $childCategoryModel = Category::find($child['id']);
                        if ($childCategoryModel) {
                            $childCategoryModel->order = $childIndex;
                            $childCategoryModel->save();
                        }
                    }
                }
            }

            return response()->json(['message' => 'ترتیب دسته‌بندی‌ها با موفقیت ذخیره شد']);
        } catch (\Exception $e) {
            // اگر خطایی اتفاق افتاد، پیام خطا برمی‌گردانیم
            return response()->json(['message' => 'خطا در ذخیره ترتیب', 'error' => $e->getMessage()], 500);
        }
    }
//    public function categoriesIndex()
//    {
//        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
//        return response()->json($categories);
//    }


    public function deleteCategory(Request $request){
        $data = $request->input('data');
//            log::info($data);
//        if (!$data || !is_array($data)) {
//            return response()->json(['message' => $data], 400);
//        }
        try {


        $category=Category::find($data);
            log::info($category);
        if (!$category) {
            return response()->json(['message' => "دسته بندی پیدا نشد"]);
        }
            log::alert($category);
        $checkChildren=Category::where('parent_id',$data)->count();
            log::info($checkChildren);
        if($checkChildren>0){
            log::info("dakhel checkchildren");
            return response()->json(['message' => "این دسته بندی دارای زیر دسته بندی است و نمی شود آن را حذف کرد"]);
        }

        if(!$category->delete($data)){
            return response()->json(['message' => 'این دسته بندی دارای محصول میباشد']);
        }
            return response()->json(['message' => 'دسته بندی حذف شد']);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'این دسته بندی داری محصول میباشد قابل حذف شدن نیست
            ', 'error' => $e->getMessage()], 303);
        }

    }
    function slugify(Request $request)
    {

         return response()->json(['slug' => \Illuminate\Support\Str::slug($request->input('data'),'-',null)]);

    }

    public function attributesRet(Request $request)
    {
        $data = $request->input('data');
        $category=Category::find($data);
        $category=$category->attribute_template;
        $attributes=$category->attributes;
        return response()->json(['attribute' => $attributes]);

    }
    public function breadcrumb($id)
    {
        $category = \App\Models\Category::find($id);
        $categories = [];

        while ($category) {
            $categories[] = $category;
            if (!$category->parent_id || $category->parent_id == 0) break;
            $category = \App\Models\Category::find($category->parent_id);
        }

        return response()->json(array_reverse($categories));
    }


}


