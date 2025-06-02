<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function index(){

        $cartCount = "" ;

        if (Auth::check()) {
            $cartCount = Carts::where('user_id', Auth::id())->sum('quantity');
        } else {
            $carts = Session::get('cart', []);
            $cartCount = array_sum(array_column($carts, 'quantity'));
        }
        $cartItems = [];

        if (Auth::check()) {
            $items = Carts::where('user_id', Auth::id())->get();
            foreach ($items as $item) {
                $cartItems[] = [
                    'id' => $item->product_id,
                    'name' => optional($item->product)->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,

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
                ];
            }
        }

        return view('pages.cart',compact('cartItems'));
    }
    public function increase($id)
    {
        if (Auth::check()) {
            $cart = Carts::where('user_id', Auth::id())->where('product_id', $id)->first();
            if ($cart) {
                $cart->quantity += 1;
                $cart->save();
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
                Session::put('cart', $cart);
            }
        }

        return back();
    }
    public function decrease($id)
    {
        if (Auth::check()) {
            $cart = Carts::where('user_id', Auth::id())->where('product_id', $id)->first();
            if ($cart) {
                $cart->quantity -= 1;
                $cart->save();
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] -= 1;
                Session::put('cart', $cart);
            }
        }

        return back();
    }


    public function remove($id)
    {
        if (Auth::check()) {
            // اگر کاربر لاگین کرده باشد، حذف از دیتابیس
            Carts::where('user_id', Auth::id())->where('product_id', $id)->delete();
        } else {
            // اگر مهمان است، حذف از سشن
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }

        return back();
    }
    public function clear()
    {
        if (Auth::check()) {
            Carts::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('cart');
        }

        return back();
    }

}
