@extends('layouts.master')
{{--بعدا حل شود--}}
@section('title',$product->name)
@section('description', $product->seo_description)

@section('ogdescription')
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $product->title }}" />
    <meta property="og:description" content="{{ $product->seo_description }}" />
    @php
        $images = json_decode($product->images, true);
        $productmainImage = $images['main'];

    @endphp
    <meta property="og:image" content="{{ asset('storage/images/products/' . $productmainImage) }}" />


    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ $product->title }}" />
    <meta property="twitter:description" content="{{$product->seo_description }}" />
    <meta property="twitter:image" content="{{ asset('storage/images/products/' . $productmainImage) }}" />
@endsection


@section('structured_data')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Product",
          "name": "{{ $product->name }}",
  "image": ["{{ asset('storage/images/products/' . $productmainImage) }}"],
  "description": {!! json_encode(strip_tags($product->seo_description)) !!},
  "offers": {
    "@type": "Offer",
    "price": "{{ $product->discount_price > 0 ? $product->discount_price * 10 : $product->price * 10 }}",
    "priceCurrency": "IRR",
    "availability": "https://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}"
  }
}
    </script>
@endsection



{{--بعدا حل شود--}}
@section('content')

    <div id="app" class=" container max-w-screen-lg mx-auto mt-2 px-4 ">


       <romano-product-page :product='@json($product)'>
       </romano-product-page>


    </div>
@endsection
