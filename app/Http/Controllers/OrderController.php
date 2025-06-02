<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {

        return view('pages.shipping');
    }

    public function selectAddress(Request $request)
    {
        $user = Auth::user();
        $addresses = json_decode($user->address, true);
        $selectedAddress = $addresses[$request->input('selected_address')] ?? null;

        if (!$selectedAddress) {
            return back()->withErrors(['آدرس انتخاب‌شده معتبر نیست.']);
        }

        // دریافت آیتم‌های سبد خرید از جدول carts
        $cartItems = Carts::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['سبد خرید شما خالی است.']);
        }

        // محاسبه جمع کل سفارش
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // ایجاد سفارش جدید
        $order = new Order();
        $order->user()->associate($user);
        $order->address= json_encode($selectedAddress, JSON_UNESCAPED_UNICODE);
        $order->shipping_method="";
        $order->total=$total;
        $order->save();

        // افزودن آیتم‌ها به order_items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'totalPrice' => $item->product->price * $item->quantity,
            ]);
        }

        // حذف آیتم‌های سبد خرید از جدول carts
        Carts::where('user_id', $user->id)->delete();

        return redirect()->route('home', $order->id)
            ->with('message', 'سفارش با موفقیت ثبت شد.');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = Auth::user();
        $addresses = json_decode($user->address ?? '[]', true);

        $newAddress = [
            'province' => $request->province,
            'city' => $request->city,
            'address' => $request->address,
        ];

        $addresses[] = $newAddress;
        $user->address = json_encode($addresses, JSON_UNESCAPED_UNICODE);
        $user->save();

        return response()->json([
            'success' => true,
            'address' => $newAddress,
            'index' => count($addresses) - 1
        ]);
    }
}
