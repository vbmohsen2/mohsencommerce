<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Carts;

class Header extends Component
{
    /**
     * Create a new component instance.
     */

    public $cartCount;
    public function __construct()
    {
        if (Auth::check()) {
            $this->cartCount = Carts::where('user_id', Auth::id())->count();
        } else {
            $carts = Session::get('cart', []);
            $this->cartCount = count($carts);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cartItems = [];

        if (Auth::check()) {
            $items = Carts::where('user_id', Auth::id())->get();
            foreach ($items as $item) {
                $cartItems[] = [
                    'id' => $item->product_id,
                    'name' => optional($item->product)->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'code' => $item->code,
                ];
            }
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $productId => $item) {
                $cartItems[] = [
                    'id' => $productId,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'code'=>$item['code'],
                ];
            }
        }

        return view('components.header', compact('cartItems'));
    }
}
