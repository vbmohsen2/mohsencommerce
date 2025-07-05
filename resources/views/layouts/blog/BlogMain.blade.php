@extends( 'layouts.blog.blog')

@section('content')
<main class=" container mx-auto mt-36  my-10 ">
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


