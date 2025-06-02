<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();

        User::create([
            'name' => 'admin', // نام یوزر
            'email' => 'admin@1.com', // ایمیل یوزر
            'password' => Hash::make('password123'), // رمز عبور یوزر
            'address'=>'asdasd',
            'email_verified_at' => now(), // تایید ایمیل (اختیاری)
            'remember_token' => Str::random(10), // توکن به خاطر سپاری
        ]);
    }
}
