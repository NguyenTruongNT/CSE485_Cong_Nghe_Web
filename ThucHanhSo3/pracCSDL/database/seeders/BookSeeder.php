<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;    // Đảm bảo bạn đã tạo Model Book
use App\Models\Library;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách ID của tất cả thư viện đang có
        $libraryIds = Library::all()->pluck('id')->toArray();

        // Tạo 50 cuốn sách mẫu
        foreach (range(1, 50) as $index) {
            Book::create([
                'title' => $faker->sentence(3),
                'author' => $faker->name,
                // Do Migration dùng kiểu date nên Faker cần tạo định dạng Y-m-d
                'publication_year' => $faker->date('Y-m-d', 'now'),
                'genre' => $faker->randomElement(['Lập trình', 'Khoa học', 'Văn học', 'Lịch sử']),
                'library_id' => $faker->randomElement($libraryIds), // Chọn ngẫu nhiên 1 thư viện
            ]);
        }
    }
}
