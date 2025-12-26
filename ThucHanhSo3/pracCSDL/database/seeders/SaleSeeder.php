<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\Sale;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy tất cả ID của thuốc đang có trong bảng medicines
        $medicineIds = Medicine::pluck('medicine_id')->toArray();

        foreach (range(1, 50) as $index) {
            Sale::create([
                'medicine_id' => $faker->randomElement($medicineIds),
                'quantity' => $faker->numberBetween(1, 10),
                'sale_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'customer_phone' => $faker->numerify('0#########'),
            ]);
        }
    }
}
