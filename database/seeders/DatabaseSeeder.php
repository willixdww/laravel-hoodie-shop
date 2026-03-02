<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create categories
        $hoodieCategory = Category::factory()->create(['name' => 'Hoodies', 'slug' => 'hoodies']);
        $jeansCategory = Category::factory()->create(['name' => 'Jeans', 'slug' => 'jeans']);

        // Create 6 Hoodies
        for ($i = 0; $i < 6; $i++) {
            Product::create([
                'category_id' => $hoodieCategory->id,
                'name' => $faker->words(2, true),
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 49, 120),
                'image_url' => 'https://via.placeholder.com/400x500/374151/FFFFFF?text=Premium+Hoodie',
                'stock' => $faker->numberBetween(10, 50),
                'size' => $faker->randomElement(['S', 'M', 'L', 'XL']),
                'color' => $faker->randomElement(['Black', 'Gray', 'Navy', 'Green']),
            ]);
        }

        // Create 6 Jeans
        for ($i = 0; $i < 6; $i++) {
            Product::create([
                'category_id' => $jeansCategory->id,
                'name' => $faker->words(2, true),
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 39, 99),
                'image_url' => 'https://via.placeholder.com/400x500/1e3a8a/FFFFFF?text=Premium+Jeans',
                'stock' => $faker->numberBetween(15, 60),
                'size' => $faker->randomElement(['30', '32', '34', '36', '38']),
                'color' => $faker->randomElement(['Blue', 'Black', 'Dark Blue', 'Indigo']),
            ]);
        }
    }
}
