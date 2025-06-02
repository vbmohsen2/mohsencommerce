<?php

use App\Http\Controllers\admin\admin;
use App\Http\Controllers\admin\attributes;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\blogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);


