<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Faker\Factory as Faker;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Tạo mảng 5 phòng ban mẫu
        // $departments = ['Phòng Nhân sự', 'Phòng Kỹ thuật', 'Phòng Kinh doanh', 'Phòng Marketing', 'Phòng Kế toán'];

        foreach (range(1, 5) as $index) {
            Department::create([
                'name' => $faker->company . ' Department', // Tên phòng ban 
                'location' => $faker->address,             // Vị trí 
                'manager' => $faker->name,               // Tên quản lý 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
