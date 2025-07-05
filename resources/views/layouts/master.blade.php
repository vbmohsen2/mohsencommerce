<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

        <title>@yield('title', 'صفحه اصلی')</title>
         <meta name="description" content=@yield('description','بهترین فروشگاه برای خرید انواع لپ‌تاپ، گوشی موبایل، تجهیزات کامپیوتری و لوازم جانبی با قیمت مناسب. تحویل سریع در سراسر کشور.')>



</head>
<body style="direction: rtl;font-weight: 300">

<x-header/>
<main  class="mt-44">
    @yield('content')

</main>
</body>
@include('layouts.footer')
</html>

