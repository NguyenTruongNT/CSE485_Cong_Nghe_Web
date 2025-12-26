<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library; // Đảm bảo bạn đã tạo Model Library
use Faker\Factory as Faker;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Tạo 10 thư viện mẫu
        foreach (range(1, 10) as $index) {
            Library::create([
                'name' => $faker->company . ' Library',
                'address' => $faker->address,
                'contact_number' => $faker->numerify('0#########'),
            ]);
        }
    }
}
