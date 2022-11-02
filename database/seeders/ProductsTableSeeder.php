<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $faker->sentence(2, true),
                'image' => 'https://via.placeholder.com/150',
                'description' => $faker->sentence(4, true),
            ]);
        }
    }
}
