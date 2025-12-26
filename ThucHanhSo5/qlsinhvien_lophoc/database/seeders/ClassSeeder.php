<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use Faker\Factory as Faker;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 3) as $index) {
            ClassModel::create([
                'class_code' => $faker->randomElement(['K65A', 'K65B', 'K65C']),
                'class_name' => $faker->randomElement(['Khoa hoc may tinh', 'Cong nghe thong tin', 'Ky thuat phan mem']),
                'semester' => $faker->randomElement(['1', '2']),
                'academic_year' => $faker->randomElement(['2023-2024', '2024-2025', '2022-2023']),
                'advisor' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
