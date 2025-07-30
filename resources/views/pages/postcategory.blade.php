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
@section('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            "@context" => "https://schema.org",
            "@type" => "CollectionPage",
            "name" => $category->name,
            "description" => $category->description ?? "مطالب مرتبط با {$category->name}",
            "mainEntity" => [
                "@type" => "Blog",
                "name" => $category->name,
                "url" => url()->current(),
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "Romano",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => asset('logo.png')
                    ]
                ]
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection



@section('content')
    <main class=" container  mt-36  my-10  mx-auto max-w-screen-xl ">
        <h1>{{$category->name}}</h1>
        <h2>{{$category->description}}</h2>
        <x-showposts :posts="$Posts">

        </x-showposts>
    </main>

@endsection
