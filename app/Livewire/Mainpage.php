<?php

namespace App\Livewire;

use App\Models\Carts;
use App\Models\Products;
use Livewire\Component;

class Mainpage extends Component
{


    public function index()
    {
//        if (auth()->check()) {
//            $carts = Carts::where('user_id', auth()->id())->get();
//            return view('livewire.mainpage', compact('carts'));
//        }
        $topDiscountedProducts = Products::select('*')
            ->selectRaw('(price - discount_price) AS discount_amount')
            ->orderByDesc('discount_amount')
            ->take(10)
            ->get();
        $topseller=Products::orderby('views_count','DESC')->take(10)->get();
        return view('livewire.mainpage', compact('topDiscountedProducts','topseller'));
    }

    public function render()
    {
        return view('livewire.mainpage');
    }
}
