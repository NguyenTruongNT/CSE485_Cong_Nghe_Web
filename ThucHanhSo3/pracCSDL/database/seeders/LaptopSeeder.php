<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Laptop;
use App\Models\Renter;
use Faker\Factory as Faker;

class LaptopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách ID của người thuê để gán khóa ngoại
        $renterIds = Renter::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            $status = $faker->boolean(); // Ngẫu nhiên true hoặc false

            Laptop::create([
                'brand'          => $faker->randomElement(['Dell', 'HP', 'MacBook', 'Asus', 'Lenovo']),
                'model'          => $faker->bothify('Laptop-####??'),
                'specifications' => $faker->randomElement(['i5, 8GB RAM, 256GB SSD', 'i7, 16GB RAM, 512GB SSD']),
                'rental_status'  => $status,
                // Nếu status là true (đang thuê) thì gán 1 renter_id, nếu false thì để null
                'renter_id'      => $status ? $faker->randomElement($renterIds) : null, // Trả về null nếu chưa thuê
            ]);
        }
    }
}
