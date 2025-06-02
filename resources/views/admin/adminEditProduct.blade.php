@extends('layouts.admin.adminlayout')
@section('content')
<div class="flex flex-col w-full  pt-4 px-4">
    <h1>تغییر محصول</h1>






    <div id="app">

        <edit-product  :id='@json($id)'></edit-product>
    </div>




</div>
@endsection
