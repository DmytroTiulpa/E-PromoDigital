<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        // Fill relation table
        /*foreach ($users as $user) {
            $user->products()->attach($products->random(), ['quantity' => rand(1, 10)]);
        }*/

        // Fill relation table
        foreach ($products as $product) {
            // Вибір випадкової кількості користувачів для кожного товару
            $randomUserCount = rand(1, $users->count());

            // Вибір випадкових користувачів та збереження їх в проміжній таблиці
            $randomUsers = $users->random($randomUserCount);
            $product->users()->saveMany($randomUsers, ['quantity' => rand(1, 10)]);
        }
    }
}
