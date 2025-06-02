<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(), // استفاده از فاکتوری Order برای ایجاد سفارش به طور خودکار
            'product_id' => Products::query()->inRandomOrder()->value('id'),
            'quantity' => $this->faker->numberBetween(1, 5), // تعداد محصول
            'price' => $this->faker->randomFloat(2, 5, 100), // قیمت واحد
            'totalغثسprice' => $this->faker->randomFloat(2, 10, 500), // مبلغ کل
            'discount' => $this->faker->optional()->numberBetween(2, 20, 20), // تخفیف (اختیاری)
        ];
    }
}
