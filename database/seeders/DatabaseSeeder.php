<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ProductsTableSeeder::class);
        $this->command->info('  >>> Таблица PRODUCTS загружена данными!');
        $this->command->info('');

        $this->call(UsersTableSeeder::class);
        $this->command->info('  >>> Таблица USERS загружена данными!');
        $this->command->info('');

        $this->call(ProductUserTableSeeder::class);
        $this->command->info('  >>> Таблица PRODUCT_USERS загружена данными!');
        $this->command->info('');

    }
}
