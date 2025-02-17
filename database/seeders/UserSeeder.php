<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $users = [
        //     ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Bob Williams', 'email' => 'bob@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'David Lee', 'email' => 'david@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Emma Wilson', 'email' => 'emma@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Franklin Harris', 'email' => 'franklin@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Grace Martin', 'email' => 'grace@example.com', 'password' => Hash::make('password123')],
        //     ['name' => 'Henry Taylor', 'email' => 'henry@example.com', 'password' => Hash::make('password123')],
        // ];

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
            ]);
        }

        // Insert users into the database
        // foreach ($users as $user) {
        //     User::create($user);
        // }
    }
}
