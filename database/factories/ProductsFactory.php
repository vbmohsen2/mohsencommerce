<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 999999),
            'stock' => $this->faker->numberBetween(0, 100),
           // 'images' => $this->faker->imageUrl(640,480,'product',true),
            'is_active' => $this->faker->boolean(90)
        ];
    }
}
