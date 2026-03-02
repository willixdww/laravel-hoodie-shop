<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 20, 200),
            'image_url' => 'https://via.placeholder.com/400x500/374151/FFFFFF?text=Premium+Product',
            'stock' => $this->faker->numberBetween(0, 100),
            'category_id' => Category::factory(),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->randomElement(['Black', 'White', 'Blue', 'Gray']),
        ];
    }
}
