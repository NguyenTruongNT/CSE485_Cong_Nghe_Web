<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            MedicineSeeder::class, // Tạo thuốc trước
            SaleSeeder::class,     // Tạo đơn hàng sau
            ClassSeeder::class,
            StudentSeeder::class,
            LibrarySeeder::class,
            BookSeeder::class,
            RenterSeeder::class,
            LaptopSeeder::class,
        ]);
    }
}
