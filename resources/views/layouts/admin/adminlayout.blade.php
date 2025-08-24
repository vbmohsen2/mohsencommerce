<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/admin.js')
    <title>
        فروشگاه
    </title>


</head>
<body style="direction: rtl">



    {{--    header--}}
    <div class="flex-col fixed top-0 w-full   bg-white justify-between items-center shadow-md h-20 ">
       <div class="w-full flex justify-between items-center mx-auto py-2 px-4">
           @auth()
               <p>{{auth()->user()->name}}</p>
           @endauth
           <div class="h-fit">
               <img src="{{asset('images/romanologo.jpg')}}" width="50" height="50" alt="">
           </div>
           <div>
               {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}
           </div>
       </div>
            @include('admin.sidebar')
    </div>
<main class="flex-col mt-16">
{{--    navbar--}}

    <div class="mx-auto p-4">
    @yield('content')
    </div>

</main>

<footer>
    footer admin
</footer>
</body>
</html>

