<div class="flex flex-col">
    <span class="mb-4">پر بحث ترین ها </span>
        <hr class="border border-gray-600">
    <br>
    <div >
        <ul>
            @foreach($posts as $post)

                @php

                $file = $post->postmedia->where('type','thumb')->first();
                $PostFile = $file ? $file->file_path . $file->extension : null;

                @endphp
            <li >
                <a href="./blog/{{$post->slug}}" class="flex">
                    <img src="{{asset("images/blog/posts/".$PostFile)}}" class="w-14 rounded-md" alt="">
                    <span class="pr-2 text-wrap">{{  strip_tags( Str::limit($post->title, 50 )) }}

                    </span>
                </a>
            </li>

            @endforeach
        </ul>
    </div>
</div>
