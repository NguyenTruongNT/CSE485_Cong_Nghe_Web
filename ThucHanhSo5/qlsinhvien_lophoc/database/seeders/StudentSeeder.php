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
            foreach (range(1, rand(10, 13)) as $index) {
                Student::create([
                    'class_id'      => $class->id, // Gán ID của lớp hiện tại trong vòng lặp
                    'student_code' => $faker->numerify('20#######'),
                    'name'    => $faker->name,
                    'email'     => $faker->email,
                    'phone'  => $faker->numerify('0#########'),
                    'date_of_birth' => $faker->date('Y-m-d', '2018-12-31'), // Phù hợp độ tuổi tiểu học
                    'address' => $faker->address,
                    'gender' => $faker->randomElement(['Nam', 'Nữ', 'Khác']),
                    'status' => $faker->randomElement(['Đang học', 'Nghỉ học', 'Tốt nghiệp']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
