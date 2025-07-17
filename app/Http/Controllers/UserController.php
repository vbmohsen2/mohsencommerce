<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductsLikes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        return response()->json(
            $query->orderBy('id', 'desc')->paginate($perPage)
        );
    }

    public function show($id)
    {
        $user = User::with('orders.orderItems.product')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'addresses']));
        return response()->json(['message' => 'User updated']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated']);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        // نمایش داده‌های اعتبارسنجی


        // اعتبارسنجی ورودی‌ها
        $credentials=$request->validate([
            'email' => 'required|email'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'ورود موفقیت‌آمیز بود'], 200);
            }
            return redirect()->intended('/')->with('success', 'ورود موفقیت‌آمیز بود');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'نام کاربری یا رمز عبور اشتباه است'], 401);
        }
        return back()->withErrors(['email' => 'نام کاربری یا رمز عبور اشتباه است']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'شما با موفقیت خارج شدید.');
    }
    public function updateUserSelf(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
//            'email' => 'required|email',
//            'phone' => 'nullable|string|max:15',
        ]);

        $user->update($validated);

        return response()->json(['message' => 'اطلاعات با موفقیت ذخیره شد.']);
    }
    public function updatephoneUserSelf(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => ['nullable', 'numeric', 'digits_between:10,15'], // فقط عدد بین 10 تا 15 رقم
        ]);

        $user->update($validated);

        return response()->json(['message' => 'اطلاعات با موفقیت ذخیره شد.']);
    }
    public function changePasswordUserSelf(Request $request)
    {
        $user = Auth::user();

        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // confirmed یعنی باید فیلد new_password_confirmation هم ارسال بشه
        ]);

        // چک کردن رمز فعلی
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'رمز فعلی اشتباه است.'
            ], 422);
        }

        // ذخیره رمز جدید (هش شده)
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'رمز عبور با موفقیت تغییر یافت.'
        ]);
    }
    public function getAddresses()
    {
        $user = Auth::user();

        // ستون addresses رو decode می‌کنیم اگر null بود خالی قرار میدیم
        $addresses = json_decode($user->address, true) ?? [];

        return response()->json([
            'addresses' => $addresses,
        ]);
    }
    public function updateAddresses(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'required|array',
            'address.*.city' => 'required|string|max:255',
            'address.*.province' => 'required|string|max:255',
            'address.*.address' => 'required|string|max:1000',
        ]);

        $addressesJson = json_encode($request->address);

        $user->address = $addressesJson;
        $user->save();

        return response()->json([
            'message' => 'آدرس‌ها با موفقیت ذخیره شدند.'
        ]);
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with(['orderItems.product'])->orderBy('created_at', 'desc')->paginate(5);;

        return response()->json($orders);
    }
    public function ordershow($id)
    {
        $order = Auth::user()->orders()->with(['orderItems.product'])->findOrFail($id);

        return response()->json([
            'order' => $order,
        ]);
    }

    public function getLikeStatus($id){
        $user = Auth::user();
        $product =Products::where('id', $id)->firstorfail();
        $like=ProductsLikes::where('products_id',$product->id)->where('users_id',$user->id)->first();
            return response()->json($like);

    }

    public function addlike(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['login_required' => true], 401);
        }
        $user = Auth::user();

        // اعتبارسنجی ورودی‌ها
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'like' => 'required|boolean',
        ]);

        $productId = $validated['product_id'];
        $likeValue = $validated['like'];

        // پیدا کردن یا ساختن ردیف لایک
        $like = ProductsLikes::firstOrNew([
            'products_id' => $productId,
            'users_id' => $user->id,
        ]);

        if ($likeValue === 1) {
            $like->like=1;
            $like->save(); // لایک ثبت شود
        } else {
            $like->delete(); // لایک حذف شود
        }

        return response()->json(['like' => $likeValue]);





    }
}
