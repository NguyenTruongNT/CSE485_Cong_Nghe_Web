<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy danh sách tất cả ID phòng ban đang có (đã tạo từ DepartmentSeeder)
        $departmentIds = Department::pluck('id')->toArray();

        // Duyệt qua từng ID phòng ban để đảm bảo phòng nào cũng có nhân viên 
        foreach ($departmentIds as $deptId) {

            // Với mỗi phòng ban, sinh ngẫu nhiên từ 5 đến 8 nhân viên 
            foreach (range(1, rand(5, 8)) as $index) {
                Employee::create([
                    'department_id' => $deptId, // Khóa ngoài liên kết chính xác 
                    'name'          => $faker->name,      // Tên nhân viên (không được rỗng) 
                    'email'         => $faker->unique()->safeEmail, // Email duy nhất 
                    'phone'         => $faker->phoneNumber,
                    'position'      => $faker->randomElement(['VP', 'Manager', 'Staff']), // Đúng enum yêu cầu 
                    'salary'        => $faker->randomFloat(2, 1000, 5000), // Kiểu DECIMAL(10,2) 
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
