<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassModel;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        // Lấy tất cả các lớp vừa tạo từ ClassSeeder
        $classes = ClassModel::all();

        foreach ($classes as $class) {
            // Với mỗi lớp, tạo ngẫu nhiên từ 5 đến 10 sinh viên
            foreach (range(1, rand(5, 10)) as $index) {
                Student::create([
                    'first_name'    => $faker->firstName,
                    'last_name'     => $faker->lastName,
                    'date_of_birth' => $faker->date('Y-m-d', '2018-12-31'), // Phù hợp độ tuổi tiểu học
                    'parent_phone'  => $faker->numerify('0#########'),
                    'class_id'      => $class->id, // Gán ID của lớp hiện tại trong vòng lặp
                ]);
            }
        }
    }
}
