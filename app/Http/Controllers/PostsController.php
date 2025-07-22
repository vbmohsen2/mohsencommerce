<?php

namespace App\Http\Controllers;

use App\Models\PostBigbanner;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PostsController extends Controller

{
    public function index(){
        $PostsInBanners=PostBigbanner::orderBy('position', 'asc')->get();
//        $BigBanners= Posts::whereIn('id', $PostsInBanners->pluck('Post_id'))->get();

        $Posts=Posts::where('is_published',true)
        ->orderby('created_at','desc')->paginate(15);


        return view('layouts.blog.BlogMain',compact('Posts','PostsInBanners'));
    }
    public function show(Request $request,$slug){
//        $Posts=Posts::where('is_published',true)->with(['postmedia' => function ($query) {
//            $query->where('type', 'banner');
//        }],
//        )->orderby('created_at','desc')->paginate(15);
        $mainpost = Posts::where('slug', $slug)->first();

        $relatedposts = Posts::whereHas('postTags', function ($query) use ($mainpost) {
            $query->whereIn('post_tags.id', $mainpost->postTags->pluck('id')); // شناسه‌های تگ‌های پست اصلی
        })
            ->where('id', '!=', $mainpost->id)
            ->with('postTags')
            ->take(3)
            ->get();


//        post view increament
        $cookieName = 'viewed_post_' . $mainpost->id;

        // بررسی اینکه آیا کوکی برای این پست وجود دارد یا نه
        if (!$request->cookie($cookieName)) {
            // افزایش تعداد بازدید
            $mainpost->increment('views_count');

            // تنظیم کوکی برای جلوگیری از ثبت دوباره بازدید توسط همین کاربر
            Cookie::queue($cookieName, true, 60 );
        }
        return view('layouts.blog.ShowPost',['mainpost'=>$mainpost,'relatedposts'=>$relatedposts]);
    }
}
