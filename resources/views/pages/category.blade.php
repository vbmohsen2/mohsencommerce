@extends('layouts.master')
@section('title',$category->name)
@section('description',$category->description)
@section('structured_data')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [
            {
              "@type": "ListItem",
              "position": 1,
              "name": "خانه",
              "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "{{ $category->name }}",
      "item": "{{ route('category.show', $category->slug) }}"
    }
  ]
}
    </script>

@endsection
@section('content')

    <div id="app" class="w-full container mx-auto my-16  ">

{{--        for future should send category object into the component--}}
        <category-products
{{--            :category-id="{{ $category->id}}"--}}
            category-slug="{{ $category->slug }}"
        ></category-products>

    </div>
@endsection
