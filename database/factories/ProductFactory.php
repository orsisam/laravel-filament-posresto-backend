<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'category_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 100),
            'image' => fake()->imageUrl(),
            'stock' => fake()->numberBetween(1, 100),
            'status' => fake()->boolean(),
            'is_favorite' => fake()->boolean(),
        ];
    }
}
