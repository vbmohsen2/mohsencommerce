<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use App\Models\PostMedias;
use App\Models\Posts;
use App\Models\PostTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class blogAdmin extends Controller
{
    public function indexCategoreis()
    {
        return view('admin.blog.blogCategory');
    }

    public function getBlogCategory()
    {
        $categories = PostCategory::all();
        return response()->json($categories);
    }

    public function getallposts()
    {
        $posts = Posts::select(['id', 'title', 'slug', 'is_published', 'post_category_id', 'user_id', 'created_at'])
            ->with([
                'user:id,name',
                'postTags:id,name',
                'category:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }
    public function tags()
    {
        $tags = PostTags::all();
        return response()->json($tags);
    }
    public function getallpostswithoutpaginate()
    {
        $posts = Posts::select(['id', 'title', 'slug', 'is_published', 'post_category_id', 'user_id', 'created_at'])
            ->with([
                'user:id,name',
                'postTags:id,name',
                'category:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return response()->json($posts);
    }


    public function deleteBlogCategory(Request $request)
    {
        $data = $request->input('data');

        try {


            $category = PostCategory::find($data);

            if (!$category) {
                return response()->json(['message' => "دسته بندی پیدا نشد"]);
            }

            $postsCount = Posts::where('post_category_id', $category->id)->count();
            if ($postsCount > 0) {

                return response()->json(['message' => "این دسته بندی دارای پست میباشد  و نمی شود آن را حذف کرد"]);
            }

            if (!$category->delete()) {
                return response()->json(['message' => 'این دسته بندی دارای پست میباشد']);
            }
            return response()->json(['message' => 'دسته بندی حذف شد']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'این دسته بندی داری محصول میباشد قابل حذف شدن نیست
            ', 'error' => $e->getMessage()], 303);
        }

    }

    public function categoryBlogSave(Request $request){
        // دریافت داده‌های ارسالی
        $data = $request->input('data');



        if (!$data || !is_array($data)) {
            return response()->json(['message' => $data], 400);
        }

        try {
            // برای هر دسته‌بندی در داده‌ها، ترتیب جدید را ذخیره می‌کنیم
            foreach ($data as $index => $category) {

//                return response()->json(['message' => Category::find($category['id'])]);
                // برای هر دسته‌بندی، ترتیب جدیدش رو ذخیره می‌کنیم
                $categoryModel = PostCategory::find($category['id']);
//                              return response()->json(['message' => $categoryModel]);
                // اگر دسته‌بندی پیدا نشد، به خطا می‌خوریم
                if (!$categoryModel) {
                    $categoryModel = new PostCategory();

//                    return response()->json(['message' => 'دسته‌بندی یافت نشد: ' . $category['id']], 404);
                }

                $categoryModel->name = $category['name'];
                $categoryModel->slug = $category['slug'];

                $categoryModel->icon = $category['icon'];

//                return response()->json(['message' => $categoryModel]);


                // ذخیره تغییرات در دیتابیس
                $result = $categoryModel->save();
//                return response()->json(['message' => $result]);

                // اگر دسته‌بندی فرزند دارد، ترتیب فرزندها رو نیز به‌روزرسانی می‌کنیم
            }

            return response()->json(['message' => ' دسته‌بندی‌ها با موفقیت ذخیره شد']);
        } catch (\Exception $e) {
            // اگر خطایی اتفاق افتاد، پیام خطا برمی‌گردانیم
            return response()->json(['message' => 'خطا در ذخیره ', 'error' => $e->getMessage()], 500);
        }
    }

    public function indexPosts(){
//    $posts = Posts::paginate(10);
//    return view('admin.blog.blogPosts', ['posts' => $posts]);
        return view('admin.blog.blogPostsvue');


}
    public function vueposts(Request $request){
        $categoryIds = $request->input('categories','');

        $searchTerm = $request->input('search', '');
        $perPage = 10;

        $query = Posts::query()->select(['id', 'title', 'slug', 'is_published', 'post_category_id', 'user_id', 'created_at'])->orderBy('created_at');
        $query->with(['user:id,name', 'postTags:id,name','category:id,name']);
        // فیلتر دسته‌بندی‌ها
        if (!empty($categoryIds)) {
            $query->where('post_category_id', $categoryIds);
        }

        // فیلتر جستجو بر اساس نام محصول
        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        // گرفتن محصولات با استفاده از paginate
        $posts = $query->paginate($perPage);

        // اضافه کردن مسیر تصویر به محصولات


        return response()->json($posts);
    }

    public function getPost(Request $request){
        $slug = $request->input('slug');

        if (!$slug) {
            return response()->json(['message' => 'Slug is required'], 400);
        }

        $post = Posts::where('slug', $slug)->firstOrFail();

//        $tags = PostTags::all();
        $selectedTags = $post->postTags()->pluck('id');


        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'post_category_id' => $post->post_category_id,
            'is_published' => $post->is_published,
            'selected_tags' => $selectedTags,
        ]);

    }


    public function savePost(Request $request){
        DB::beginTransaction();
        try {
            $uploadedMain = null;
            $uploadedThumb = null;


            $post=Posts::where('id',$request->input('id'))->first();

            if(!$post){
                $post = new Posts();
            }

            if($request->ispublished){
                $post->is_published = 1;
            }
            if(!$request->ispublished){
                $post->is_published = 0;
            }

            $post->title = $request->title;


            $existingSlug = Posts::where('slug', $request->slug)
                ->where('id', '!=', $request->input('id')) // یعنی اسلاگی که برای پست فعلی نیست
                ->exists();

            if ($existingSlug) {
                return response()->json([
                    'message' => 'این اسلاگ قبلا استفاده شده است',
                    'status' => 421
                ],200);
            }


            $post->slug = $request->slug;
            $post->content = $request->contentt ;
            $post->user_id='7';
            $post->post_category_id = $request->categoryid;
            $post->save();
            $image=new PostMedias();

            if ($request->hasFile('mainimage')) {
//                Log::info("mainimage");
                // حذف همه عکس‌های بنر قبلی این پست
                PostMedias::where('post_id', $post->id)
                    ->where('type', 'banner')
                    ->delete();

                $image = new PostMedias();
                $image->post_id = $post->id;
                $image->type = "banner";
                $image->alt = $post->title;

                $mainFilename = 'main_' . $request->slug  . '.' . $request->file('mainimage')->extension();
                $request->file('mainimage')->storeAs('images/blog/' . $post->slug . "/", $mainFilename, 'public');
                $image->file_path = $mainFilename;
                $image->post_id = $post->id;
                $uploadedMain=$mainFilename;
                $image->save();
            }
            Log::info($request);
            if ($request->hasFile('thumbimage')) {

                // حذف همه عکس‌های تامبنیل قبلی این پست
                PostMedias::where('post_id', $post->id)
                    ->where('type', 'thumb')
                    ->delete();

                $thumbImage = new PostMedias();
                $thumbImage->post_id = $post->id;
                $thumbImage->type = "thumb";
                $thumbImage->alt = $post->title;

                $thumbFilename = 'thumb_' . $request->slug . '.' . $request->file('thumbimage')->extension();
                $request->file('thumbimage')->storeAs('images/blog/' . $post->slug . "/", $thumbFilename, 'public');
                $thumbImage->file_path = $thumbFilename;
                $uploadedThumb=$thumbFilename;
                $thumbImage->save();
//                Log::info($thumbImage);
            }








            $tagIds = [];

            if ($request->has('tags')) {
                foreach ($request->tags as $tagName) {
                    $tag = PostTags::firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }

                $post->postTags()->sync($tagIds); // بروزرسانی رابطه‌ها
            }

            DB::commit();

            return response()->json([
                'message' => 'محصول با موفقیت ذخیره شد.',
                'status' => 312
            ],200);

        } catch (\Exception $e) {
            DB::rollBack();

            // حذف فایل‌ها در صورت خطا
            if ($uploadedMain) Storage::disk('public')->delete($uploadedMain);
            if ($uploadedThumb) Storage::disk('public')->delete($uploadedThumb);
//            foreach ($uploadedGallery as $img) {
//                Storage::disk('public')->delete($img);
//            }

            return response()->json(['message' => 'خطا در ذخیره‌سازی: '.$e->getMessage() , 500]);
        }

    }
    public function deletepost($id)
    {
        $post = Posts::find($id);

        if (!$post) {
            return response()->json(['message' => 'پست پیدا نشد'], 404);
        }

        try {
            // اگر عکس یا فایل خاصی هم داره اینجا حذف کن
            // Storage::delete($post->image);

            $post->delete();
            $postmedias=PostMedias::where('post_id', $post->id)->get();
            foreach ($postmedias as $postmedia) {
                // مسیر فعلی در دیسک public (بدون public_path)
                $currentPath = 'images/blog/' . $post->slug . '/' . $postmedia->file_path;

                // مسیر جدید (بایگانی در deleted)
                $newPath = 'images/blog/deleted/' . $post->slug . '/' . $postmedia->file_path;

                // اگر فایل وجود دارد، انتقال بده
                if (Storage::disk('public')->exists($currentPath)) {
                    // اگر پوشه مقصد وجود ندارد، بساز
                    $deletedFolder = 'images/blog/deleted/' . $post->slug;
                    if (!Storage::disk('public')->exists($deletedFolder)) {
                        Storage::disk('public')->makeDirectory($deletedFolder);
                    }
                    Log::info( Storage::disk('public')->move($currentPath, $newPath));
                    // انتقال فایل
//                    Storage::disk('public')->move($currentPath, $newPath);
                }

                // حذف رکورد از دیتابیس
                $postmedia->delete();
            }
            return response()->json(['message' => 'پست با موفقیت حذف شد'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطا در حذف پست'], 500);
        }
    }

    public function postImages(Request $request){
        $postId = $request->input('postid');

        if (!$postId) {
            return response()->json(['message' => 'id is required'], 400);
        }
        $images=PostMedias::where('post_id', $postId)->get();

        return response()->json($images);
    }
}
