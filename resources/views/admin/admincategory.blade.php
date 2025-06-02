@extends('layouts.admin.adminlayout')
@section('content')
    <div class="flex flex-col w-full  pt-4 px-4">
        <h1>دسته بندی ها</h1>






        <div id="app">
            <category-tree-with-edit></category-tree-with-edit>

        </div>


    </div>
@endsection
