@extends('layouts.admin.adminlayout')
@section('content')
    <div class="flex flex-col w-full  pt-4 px-4">





        {{--    --}}

        <div id="app">
{{--            @dd($categories)--}}
          <add-product-page  :categories='@json($categories)'
          ></add-product-page>
        </div>



        {{--    --}}
    </div>
@endsection
