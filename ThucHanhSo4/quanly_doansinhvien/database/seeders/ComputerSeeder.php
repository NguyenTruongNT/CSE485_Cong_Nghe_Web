<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Computer;
use Faker\Factory as Faker;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            Computer::create([
                'computer_name' => 'LAB-PC' . str_pad($index, 2, '0', STR_PAD_LEFT),
                'model' => $faker->randomElement(['Dell Optiplex 7090', 'HP ProDesk 400', 'Lenovo ThinkCentre']),
                'operating_system' => $faker->randomElement(['Windows 10 Pro', 'Windows 11 Home', 'Ubuntu 22.04']),
                'processor' => $faker->randomElement(['Intel Core i5-11400', 'AMD Ryzen 5 5600G']),
                'memory' => $faker->randomElement([8, 16, 32]),
                'available' => $faker->boolean(80), // 80% là đang hoạt động
            ]);
        }
    }
}
