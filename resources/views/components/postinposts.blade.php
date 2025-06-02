@props(['post'])
@php
    $file = $post->postmedia->where('type',"banner")->first();

    $PostFile = $file ? $file->file_path  : null;

@endphp
<div class="flex   items-center space-x-2 mb-2 ">
{{--    بخش ساعت--}}

    <div class="md:flex  flex-col  hidden items-center w-1/12">
        <div class="h-20 w-[1px] bg-gray-300 "></div>
        <div class="p-2 bg-gray-200 rounded-full mt-2">
            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="text-xs text-gray-500 mt-1 pb-2">{{ $post->time_ago }}</span>
        <div class="h-20 w-0.5 bg-gray-300 "></div>
    </div>
{{--        بخش پست--}}
    <div class="bg-white   p-4 shadow-md rounded-lg w-full flex flex-col md:flex-row items-stretch space-x-3 h-fit group transition-all duration-300 hover:shadow-xl">
        <!-- تصویر پست  -->
        <div class="md:w-[18rem] w-full flex-shrink-0 ml-4">
            <a href="/blog/{{$post->slug}}">
                <div class="w-full h-[250px] relative rounded-lg overflow-hidden">
                    <img src="{{ asset("storage/images/blog/$post->slug/$PostFile") }}"
                         alt="{{ $file?->alt }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
            </a>
        </div>

        <!-- محتوای پست -->
        <div class="md:flex-1 md:flex md:flex-col w-full  md:static z-10 -mt-28 md:-mt-0 rounded-lg bg-white justify-between px-4 py-2">
            <div class="flex justify-between">
             <span class="text-gray-400 md:hidden"> {{ $post->time_ago }}</span>
            <span class="text-gray-400">{{$post->category->name}}</span>
            </div>
            <a href="/blog/{{$post->slug}}">
            <h2 class="text-lg font-semibold">{{$post->title}}</h2>
            </a>
            <p  class="text-gray-600 text-md leading-8  limited-text">

                {!!  strip_tags( Str::limit($post->content, 180 )) !!}
                <a href="/blog/{{$post->slug}}" class="text-blue-600 border-b-[1px] border-dashed  border-blue-300 pb-2"> ادامه مطلب</a>
            </p>

        </div>
    </div>
</div>





