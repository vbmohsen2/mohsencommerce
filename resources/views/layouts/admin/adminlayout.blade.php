<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>
        فروشگاه
    </title>


</head>
<body style="direction: rtl">


<main>
    {{--    header--}}
    <div class="flex justify-between items-center shadow-md h-20 px-4">
        @auth()
           <p>{{auth()->user()->name}}</p>
        @endauth
        <div>
            <img src="{{asset('images/logo.svg')}}" alt="">
        </div>
        <div>
           {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}
        </div>

    </div>
<div class="flex">
{{--    navbar--}}

   @include('admin.sidebar')

    <div class="mx-auto w-3/4 p-4">
    @yield('content')
    </div>

</div>

</main>
<footer>
    footer admin
</footer>
</body>
</html>

