<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>@yield('title', ' صفحه اصلی بلاگ')</title>
    <meta name="description" content=@yield('description','بلاگ')>

</head>
<body style="direction: rtl">

    @include('layouts.blog.header')
    @yield('content')
    @include('layouts.blog.BlogFooter')
    @include('layouts.blog.StickyToolbox')

</body>
</html>
