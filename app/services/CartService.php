<?php


namespace App\Services;

use App\Models\Carts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
public static function getCartData()
{
if (Auth::check()) {
$items = Carts::where('user_id', Auth::id())->get();
$cartItems = $items->map(function ($item) {
return [
'id' => $item->product_id,
'name' => optional($item->product)->name,
    'images'=>$item->product->images,
'quantity' => $item->quantity,
'price' => $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price,
'code' => $item->code,
];
});

return [
'count' => $items->count(),
'items' => $cartItems,
];
} else {
$sessionCart = Session::get('cart', []);
$cartItems = [];

foreach ($sessionCart as $productId => $item) {
$cartItems[] = [
'id' => $productId,
'name' => $item['name'],
'images'=>$item['images'],
'quantity' => $item['quantity'],
'price' => $item['price'],
'code' => $item['code'],
];
}

return [
'count' => count($sessionCart),
'items' => $cartItems,
];
}
}
}
