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
        // Danh sách các cấp lớp theo đề bài
        $grades = ['Pre-K', 'Kindergarten'];

        foreach ($grades as $grade) {
            // Mỗi cấp lớp tạo khoảng 2 phòng học ngẫu nhiên
            foreach (range(1, 9) as $index) {
                ClassModel::create([
                    'grade_level' => $grade,
                    // Faker tạo số phòng dạng chữ và số, ví dụ: "VH 102" hoặc "VH-201"
                    'room_number' => $faker->bothify('VH 10#'),
                ]);
            }
        }
    }
}
