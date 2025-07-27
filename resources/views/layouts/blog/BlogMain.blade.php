@extends( 'layouts.blog.blog')
@section('description','مجله ایترنتی رومانو اردبیل')
@section('ogdescription')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content='{{ config("app.name") }}' />
    <meta property="og:description" content= "مجله اینترنی رومانواردبیل سعی دارد با مقاله های خود شما را در انتخاب استایل کمک کند" />

    <meta property="og:image" content="{{ asset('images/romanologo.jpg') }}" />


    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ config('app.name')}}" />
    <meta property="twitter:description" content="مجله اینترنی رومانواردبیل سعی دارد با مقاله های خود شما را در انتخاب استایل کمک کند" />
    <meta property="twitter:image" content="{{ asset('images/romanologo.jpg') }}" />
@endsection
@section('content')
<main class=" container  mt-36  my-10 z-5  mx-auto max-w-screen-xl ">
   <section class="flex flex-col   sm:flex-row  flex-wrap rounded-md">

       @foreach($PostsInBanners as $p)
                    @php
                    $width=$p->Width;
                    $p=$p->post;
                     @endphp

                  <x-blogpostbanner :bannerPostId="$p" :bannerwitdth="$width" />

       @endforeach


   </section>

   <x-showposts :posts="$Posts">

   </x-showposts>
    <br>
    <br>
    <x-post-categoreis-in-main-page>
    </x-post-categoreis-in-main-page>

    <x-mosts-post :posts="$Posts" :type="'comments'">
        پر بازدیدها
    </x-mosts-post>
    <x-mosts-post :posts="$Posts" :type="'viewed'">
        مهم ترین ها
    </x-mosts-post>

</main>
@endsection


