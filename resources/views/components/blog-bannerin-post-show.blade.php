
@php
    $banner = $bannerPostId->postmedia->first();
    $bannerPath = $banner ? $banner->file_path . $banner->extension : null;

//
@endphp

<div class="w-full md:w-{{$bannerwitdth}}/4 sm:w-1/2 flex flex-col h-[280px] rounded text-white bg-cover bg-center justify-between transition hover:brightness-75 duration-500 relative"
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.5)), url({{ asset('images/blog/posts/'.$bannerPath) }})">

    <a href="./blog/{{$bannerPostId->slug}}" class=" h-full flex flex-col justify-between ">
        <span class="rounded w-fit bg-red-300 text-sm font-thin">
            {{$bannerPostId->views_count}} بازدید
        </span>

        <div class="h-3/5 mx-2">
            <p class="rounded h-1/3 w-fit">
                <span class="bg-green-400 rounded px-3 py-1">
                    {{$bannerPostId->user->name}}
                </span>
            </p>

            <p class="mx-auto font-bold h-1/3 px-2">
                <span class=" text-white drop-shadow-lg text-right">
                    {{$bannerPostId->title}}
                </span>
            </p>

            @if($bannerwitdth >= 3)
                <div class="px-3">
                    <span class="font-semibold h-1/3">{{$bannerPostId->created_at_formatted}}</span>
                    <span class="px-3">{{$bannerPostId->postComments->count() > 0 ? $bannerPostId->postComments->count() . ' نظر' : 'بدون نظر'}}</span>
                </div>
            @endif
        </div>
    </a>

</div>


