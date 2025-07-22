

<section class="mt-10 mx-4">


    <div class="mb-8">آخرین مطالب</div>
    <div  class="flex">
        <div class="w-full lg:w-9/12 overflow-y-auto h-auto">

            @foreach($posts as $post)
            <x-postinposts :post='$post'></x-postinposts>
            @endforeach
                <div class="mt-4">
                    {{ $posts->links('components.post-pagination') }}
                </div>
        </div>

        <div class="lg:flex flex-col hidden w-3/12 lg:sticky top-20 h-fit">
            {{--        تبلیغ--}}
{{--            <div class="rounded-md py-2">--}}
{{--                <img src="images\blog\adv\1.gif" alt="">--}}
{{--            </div>--}}
{{--            <div class="rounded-md py-2">--}}
{{--                <img src="images\blog\adv\1.gif" alt="">--}}
{{--            </div>--}}
{{--            پایان تبلیغ--}}
<x-postthumb_mosts :posts="$posts" :type="'comments'"/>


        </div>
    </div>

</section>
{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function () {--}}
{{--        function limitText(selector, maxLength) {--}}
{{--            let elements = document.querySelectorAll(selector);--}}
{{--            elements.forEach((element) => {--}}
{{--                let text = element.textContent.trim();--}}
{{--                if (text.length > maxLength) {--}}
{{--                    element.textContent = text.substring(0, maxLength) + "";--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        let maxLength = window.innerWidth < 640 ? 50 : 200; // تغییر تعداد کاراکتر در موبایل و دسکتاپ--}}
{{--        limitText(".limited-text", maxLength);--}}
{{--    });--}}
{{--</script>--}}
