<?php

namespace App\Http\Controllers;

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
        return response()->json(['success' => true, 'message' => 'شما با موفقیت خارج شدید']);
    }

}
