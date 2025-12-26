<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Renter;

class RenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            Renter::create([
                'name'         => $faker->name,
                'phone_number' => $faker->numerify('0#########'),
                'email'        => $faker->unique()->safeEmail,
            ]);
        }
    }
}
