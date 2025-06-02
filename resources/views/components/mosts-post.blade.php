
<p class="text-gray-400 text-xl pt-8  px-4">{{$slot}}</p>
<section class="flex justify-between   flex-wrap pt-8">

{{--    @dd($posts)--}}
    @foreach($posts as $post)
    <br>
        @php
        $file = $post->postmedia->first();
        $PostFile = $file ? $file->file_path . $file->extension : null;

        @endphp

        <div class="flex flex-col group w-1/2 md:w-1/4 rounded-md hover:shadow-lg max-h- overflow-hidden p-2 transition-all duration-500">
            <div class="h-4/6 w-full group-hover:h-2/6 transition-all duration-500 overflow-hidden rounded-t-md">
                <a href="./blog/{{$post->slug}}"> <img src="{{ asset('images/blog/posts/'.$PostFile) }}"
                class="object-cover w-full h-full transition-all duration-500"
                     alt="">
                </a>
            </div>
            <div class="flex flex-col h-2/6 bg-white text-black justify-between items-center group-hover:h-4/6 py-4 px-2  transition-all duration-500">
                <a href="./blog/{{$post->slug}}" class="text-wrap ">{{$post->title}}</a>
                <div>
                <p class="opacity-0 group-hover:opacity-100 transition-all duration-500 ">{{$post->user->name}}</p>
                <p class="opacity-0 group-hover:opacity-100 transition-all duration-500 text-center text-xl">
                    <a href=""> <i class="fab fa-whatsapp"></i></a>
                    <a href=""> <i class="fab fa-telegram"></i></a>
                    <a href=""> <i class="fab fa-telegram"></i></a>
                    <a href=""> <i class="fab fa-telegram"></i></a>
                </p>
                </div>
            </div>
        </div>


            @endforeach
</section>
