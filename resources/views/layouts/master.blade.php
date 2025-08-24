<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', config('app.name'))">

    @vite('resources/js/app.js')
    @vite('resources/css/app.css')

    @inertiaHead
</head>
<body style="font-weight: 300">

@inertia

</body>
</html>
