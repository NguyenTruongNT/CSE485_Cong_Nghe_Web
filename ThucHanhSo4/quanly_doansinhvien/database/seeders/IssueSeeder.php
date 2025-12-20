<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Computer;
use App\Models\Issue;
use Faker\Factory as Faker;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Lấy danh sách tất cả ID máy tính đang có
        $computerIds = Computer::pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            Issue::create([
                'computer_id' => $faker->randomElement($computerIds),
                'reported_by' => $faker->name,
                'reported_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'description' => $faker->sentence(10),
                'urgency' => $faker->randomElement(['Low', 'Medium', 'High']),
                'status' => $faker->randomElement(['Open', 'In Progress', 'Resolved']),
            ]);
        }
    }
}
