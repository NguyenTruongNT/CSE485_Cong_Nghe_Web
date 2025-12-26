<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Faker\Factory as Faker;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            Medicine::create([
                'name' => $faker->word,
                'brand' => $faker->company,
                'dosage' => $faker->sentence(2),
                'form' => $faker->randomElement(['Viên nén', 'Viên nang', 'Siro']),
                'price' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(10, 100),
            ]);
        }
    }
}
