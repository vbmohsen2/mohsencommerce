<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Products::with('category')->paginate(10);
    }

    public function showinapi($id)
    {
        return Products::with('category')->findOrFail($id);
    }

}
