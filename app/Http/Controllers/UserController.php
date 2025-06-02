<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
            return response()->json(['error' => 'نام کاربری یا رمز عبور اشتباه است'], 401);
        }
        return back()->withErrors(['email' => 'نام کاربری یا رمز عبور اشتباه است']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['success' => true, 'message' => 'شما با موفقیت خارج شدید']);
    }
}
