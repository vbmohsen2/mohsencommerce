<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return view('pages.shipping');
    }
    public function indexordersforvue(Request $request){
        $perPage = $request->input('per_page', 10);
        $query = Order::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('user_name')) {
            $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['معلق', 'در حال پردازش', 'ارسال شده', 'تحویل داده شده', 'کنسل'])],
        ]);
        $order = Order::findOrFail($request->id);

        $order->status=$validated['status'];
        Log::info($order);
        $order->save();
        return response()->json([
            'message' => 'وضعیت با موفقیت بروزرسانی شد.',
            'order' => $order,
        ]);
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
            $total += $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price * $item->quantity;
        }

        // ایجاد سفارش جدید
        $order = new Order();
        $order->user()->associate($user);
        $order->address= json_encode($selectedAddress, JSON_UNESCAPED_UNICODE);
        $order->shipping_method="";
        $order->total=$total;
        $order->user_name=$user->name;
        $order->save();

        // افزودن آیتم‌ها به order_items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price,
                'totalPrice' => $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price * $item->quantity,
                'code' => $item->code,
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
    public function show(){
        return view('admin.orders.ordersvue');
    }
    public function showorder($id)
    {
        $order = Order::with(['orderItems.product'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'سفارش یافت نشد'], 404);
        }

        return response()->json(['order' => $order]);
    }
    public function updateAddress(Request $request, $id)
    {

        Log::info($request);
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'سفارش یافت نشد'], 404);
        }

        $validated = $request->validate([
            'city' => ['required', 'string'],
            'province' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $addressJson = json_encode([
            'city' => $validated['city'],
            'province' => $validated['province'],
            'address' => $validated['address'],
        ]);

        $order->update(['address' => $addressJson]);

        return response()->json(['message' => 'آدرس با موفقیت بروزرسانی شد']);
    }
}
