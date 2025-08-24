@section('title',$mainpost->title)
@section('description',$mainpost->seo_description)
@section('ogdescription')
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content='{{ config("app.name") }}' />
    <meta property="og:description" content= "{{$mainpost->seo_description}}" />
    @php
        $bannerimage = optional($mainpost->postmedia->where('type', 'banner')->first());
        $imagePath = $bannerimage->file_path ? $bannerimage->file_path . $bannerimage->extension : 'default.jpg';
    @endphp
    <meta property="og:image" content={{asset('/storage/images/blog/'.'/'. $mainpost->slug .'/'. $imagePath )}} />


    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ config('app.name')}}" />
    <meta property="twitter:description" content="{{$mainpost->seo_description}}" />
    <meta property="twitter:image" content={{asset('/storage/images/blog/'.'/'. $mainpost->slug .'/'. $imagePath )}}  />
@endsection

@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            "@context" => "https://schema.org",
            "@type" => "BlogPosting",
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => url()->current()
            ],
            "headline" => $mainpost->title,
            "image" => asset('/storage/images/blog/'.'/'. $mainpost->slug .'/'. $imagePath ),
            "author" => [
                "@type" => "Person",
                "name" => $mainpost->user->name ?? 'Romano'
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "Romano",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('faveicon.png')
                ]
            ],
            "datePublished" => $mainpost->created_at->toW3cString(),
            "dateModified" => $mainpost->updated_at->toW3cString()
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection
@extends( 'layouts.blog.blog')
@section('content')
    <main class="container mx-auto mt-36 w-full my-10 ">

        {{--        @dd($relatedposts)--}}
        <section class="flex flex-col   sm:flex-row  flex-wrap rounded-md">
            @foreach($relatedposts as $index => $p)
                @php
                    $bannerWidth = ($index == 0) ? 2  : 1;
                @endphp

                <x-blogpostbanner :bannerPostId="$p" :bannerwitdth="$bannerWidth"/>
            @endforeach
        </section>


        <section class="flex mt-10 mx-4">
            <article class="flex w-full flex-col">
                {{--                article header--}}
                <div class="flex  w-full justify-between">

                    <ul class=" inline-flex">
                        <li class="px-2">
                            <a class="border-gray-400 border rounded-md px-2 py-1" href="/blog">
                                <i class="fa fa-home text-gray-600" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </li>
                        <li class="px-2">
                            <a class="border-gray-400 border rounded-md px-2 py-1" href="/blog/{{$mainpost->category->slug}}">
                                {{$mainpost->category->name}}
                            </a>
                        </li>
                    </ul>

                    <div class="bg-black text-white px-2 py-1 rounded-md">
                        {{$mainpost->views_count}}
                    </div>

                </div>
                <div class="py-4">
                    <h1 class="text-2xl">{{$mainpost->title}}</h1>
                </div>
                <div>
                    <p class="text-red-400 text-sm">نویسنده: {{$mainpost->user->name}}</p>
                    <p>{{$mainpost->time_ago}}</p>
                </div>

                {{--                end article header--}}

                <section>
                    <div class="pt-4">
                        @php
                            $bannerimage = optional($mainpost->postmedia->where('type', 'banner')->first());
                            $imagePath = $bannerimage->file_path ? $bannerimage->file_path . $bannerimage->extension : 'default.jpg';
                        @endphp
{{--                        @dd($imagePath)--}}

                        <div class="w-full h-[25vh] sm:h-[40vh] md:h-[45vh] overflow-hidden rounded-xl shadow mb-6">
                            <img
                                src="/storage/images/blog/{{ $mainpost->slug }}/{{ $imagePath }}"
                                alt="{{ $mainpost->title }}"
                                class="w-full h-full object-cover"
                            >
                        </div>                    </div>

                    {{--                    share post--}}

                    <div class="py-4 mx-4 ">
                        <ul class="text-white inline-flex font-light text-center text-xs ">
{{--                            <li class="bg-black mx-1 p-1">--}}
{{--                                <a href="/blog/{{$mainpost->slug}}" class="text-white flex items-center gap-1">--}}
{{--                                    <i class="fa fa-instagram"></i> اینستاگرام--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            @php
                                $postUrl = urlencode(route('blog.show', $mainpost->slug));
                                $postTitle = urlencode($mainpost->title);
                            @endphp

                            <li class="bg-green-600 mx-1 p-1 rounded">
                                <a href="https://wa.me/?text={{ $postTitle }}%0A{{ $postUrl }}"
                                   target="_blank"
                                   class="text-white flex items-center gap-1">
                                    <i class="fab fa-whatsapp"></i> واتساپ
                                </a>
                            </li>

                            <li class="bg-blue-500 mx-1 p-1 rounded">
                                <a href="https://t.me/share/url?url={{ $postUrl }}&text={{ $postTitle }}"
                                   target="_blank"
                                   class="text-white flex items-center gap-1">
                                    <i class="fab fa-telegram"></i>     تلگرام
                                </a>
                            </li>


                            <li onclick="copyLink(this)"
                                class="text-gray-600 border border-gray-300 px-2 mx-2 cursor-pointer">
                                <i class="fa fa-copy"></i>
                                <span>کپی لینک</span>
                            </li>

                            <script>
                                function copyLink(element) {
                                    const link = window.location.href; // لینک صفحه فعلی
                                    navigator.clipboard.writeText(link).then(() => {
                                        const span = element.querySelector("span");
                                        const originalText = span.innerText;

                                        span.innerText = "کپی شد!";
                                        setTimeout(() => {
                                            span.innerText = originalText;
                                        }, 1500);
                                    }).catch(err => {
                                        console.error("خطا در کپی کردن: ", err);
                                    });
                                }
                            </script>

                        </ul>
                    </div>
                    <br>
{{--                    main content--}}
                    <div class="rounded-lg shadow-inner border border-gray-200 text-justify font-light">
                       <div class="ql-editor">
                           {!! $mainpost->content !!}
                       </div>
                        <p class="py-4"><i class="fas fa-tags"></i> برچسب ها :
                            @foreach($mainpost->postTags as $index=>$tags)
                                @if($mainpost->postTags->count()==1)
                                    {{$tags->name}}
                                @else
                                    {{$tags->name}}
                                    @if(!$loop->last), @endif

                                @endif

                            @endforeach
                        </p>
                    </div>
{{--                    advertising inside post--}}
                    <div class="w-full md:hidden">
                        <img src="storage\images\blog\adv\ad1w-full.gif" alt="">
                    </div>
                </section>
            </article>

        </section>


        {{--        <h3>تگ‌های این پست:</h3>--}}
        {{--        <ul>--}}
        {{--            @foreach($mainpost->postTags as $tag)--}}
        {{--                <li>{{ $tag->name }}</li>--}}
        {{--            @endforeach--}}
        {{--        </ul>--}}
    </main>
@endsection
