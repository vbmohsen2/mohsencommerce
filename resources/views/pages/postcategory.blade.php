@extends( 'layouts.blog.blog')
@section('title',$category->name)
@section('description',$category->description)
@section('ogdescription')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content='{{ config("app.name") }}' />
    <meta property="og:description" content={{$category->description}} />

    <meta property="og:image" content="{{ asset('images/romanologo.jpg') }}" />


    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ config('app.name')}}" />
    <meta property="twitter:description" content={{$category->description}} />
    <meta property="twitter:image" content="{{ asset('images/romanologo.jpg') }}" />
@endsection
@section('content')
    <main class=" container  mt-36  my-10  mx-auto max-w-screen-xl ">
        <h1>{{$category->name}}</h1>
        <h2>{{$category->description}}</h2>
        <x-showposts :posts="$Posts">

        </x-showposts>
    </main>

@endsection
