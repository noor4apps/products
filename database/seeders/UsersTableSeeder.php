<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@gmail.com',
            'phone_number' => $faker->e164PhoneNumber,
            'is_admin' => '1',
            'password' => bcrypt('12345678'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone_number' => $faker->e164PhoneNumber,
                'is_admin' => '0',
                'password' => bcrypt('12345678'),
            ]);
        }
    }
}
