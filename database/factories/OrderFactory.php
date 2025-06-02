<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // استفاده از فاکتوری User برای ایجاد کاربر به طور خودکار
            'status' => $this->faker->randomElement(['معلق','در حال پردازش','ارسال شده','تحویل داده شده','کنسل']), // وضعیت سفارش
            'address' => $this->faker->address, // آدرس ارسال
            'shipping_method' => $this->faker->randomElement(['Standard', 'Express']), // روش ارسال
            'tracking_number' => $this->faker->optional()->word, // شماره پیگیری (اختیاری)
            'coupon_code' => $this->faker->optional()->word, // کد تخفیف (اختیاری)
            'totalDiscount'=>$this->faker->numberBetween(10,50),
            'total' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
