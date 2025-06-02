@extends('layouts.admin.adminlayout')
@section('content')
    <div class="flex flex-col w-full pt-4 px-4">
        <div class="space-x-2 w-full inline-flex    text-base ">
            <h2>دسته بندی ها</h2>
            <span class="px-2"><a href="" class="bg-gray-200 border px-2 rounded-md shadow-md ">پست جدید</a></span>
        </div>
        <div class="my-4  inline-flex justify-between">
            <div class="inline-flex justify-between space-x-2 items-center">

                <a href="" class="px-2" ><span class="text-blue-500">همه پست ها</span>({{$posts->count()}})</a>
            <a href="" class="px-2"><span class="text-blue-500">پست های منتشر شده</span>({{$posts->where('is_published',1)->count()}})</a>
            <a href=""><span class="text-blue-500">پست های منتشر نشده</span>({{$posts->where('is_published',0)->count()}})</a>
            </div>
            <div>
                <input class="rounded-md" id="searchposts" type="text">
                <button  class="bg-gray-300 px-4 py-2 rounded-md">جستجو</button>
            </div>

        </div>

        <!-- Header -->
        <div class="grid grid-cols-5 sm:gap-2 gap-16 space-y-2 font-bold bg-gray-200 p-4 items-center rounded-md shadow-md">
            <div>عنوان</div>
            <div>نویسنده</div>
            <div>دسته‌بندی</div>
            <div>تگ‌ها</div>
            <div>منتشر شده</div>
        </div>

        <!-- Rows -->
        @foreach($posts as $post)
            <div class="grid grid-cols-5 sm:gap-2 gap-16 space-y-1 px-4 border-b p-4 items-center">
                <div class="">{{ $post->title }}</div>
                <div>{{ $post->user->name }}</div>
                <div>{{ $post->category->name ?? '-' }}</div>
                <div>
                    @foreach($post->postTags as $tag)
                        <span class="bg-gray-100 text-sm rounded px-2">{{ $tag->name }}</span>
                        @if (!$loop->last)
                            <span class="text-gray-400 px-1">|</span>
                        @endif
                    @endforeach
                </div>
                <div>
                    <input type="checkbox" disabled {{ $post->is_published == 1 ? 'checked' : '' }}>
                </div>
            </div>
        @endforeach
        </div>
    {{ $posts->links('components.post-pagination') }}


@endsection
