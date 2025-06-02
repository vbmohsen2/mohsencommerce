@props(['post'])
<section>
    <p class="text-center">
        دسته بندی مقاله ها
    </p>
    <br>
    <div class="flex  @if($categories->count()>4) md:justify-between @endif justify-evenly flex-wrap ">
        @foreach($categories as $category)
            <a href="./blog/category/{{$category->slug}}" class="flex flex-col text-center text-gray-500  p-4 w-1/2 sm:w-1/4 md:w-fit">
                <i class="{{$category->icon}} text-5xl px-4  text-center"> </i>
                <p class="text-center pt-2 text-sm">{{$category->name}}</p>
                <p class="text-center pt-2 text-sm">{{$category->posts->count()}}</p>
            </a>
        @endforeach ()


    </div>
</section>
