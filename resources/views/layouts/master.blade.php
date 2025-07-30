<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('faveicon.png') }}" type="image/png">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

        <title>@yield('title',config('app.name'))</title>
    <meta name="description" content="{{ $__env->yieldContent('description',  config('app.name')) }}">

    @yield('ogdescription')
    @if (request()->has('page') && request()->input('page') > 1)
        <link rel="canonical" href="{{ url()->current() . '?page=' . request()->input('page') }}">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif


    @if (!View::hasSection('structured_data'))
        {!! View::make('components.schema.default')->render() !!}
    @else
        @yield('structured_data')
    @endif
</head>
<body style="direction: rtl;font-weight: 300">

<x-header/>
<main  class="mt-44">
    @yield('content')

</main>
</body>
@include('layouts.footer')
</html>

