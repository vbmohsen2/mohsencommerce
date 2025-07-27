<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('faveicon.png') }}" type="image/png">
    <title>@yield('title', 'مجله اینترنتی '.config('app.name'))</title>
    <meta name="description" content="{{ $__env->yieldContent('description', 'مجله اینترنتی ' . config('app.name')) }}">
    @if (request()->has('page') && request()->input('page') > 1)
        <link rel="canonical" href="{{ url()->current() . '?page=' . request()->input('page') }}">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif


    @yield('ogdescription')

</head>
<body style="direction: rtl">

    @include('layouts.blog.header')
    @yield('content')
    @include('layouts.blog.BlogFooter')
    @include('layouts.blog.StickyToolbox')

</body>
</html>
