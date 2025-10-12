<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Xoá dữ liệu cũ (chỉ dùng khi phát triển)
        Review::truncate();

        $faker = \Faker\Factory::create('vi_VN');

        // Lặp qua các sản phẩm hiện có
        $products = Product::all();

        foreach ($products as $product) {
            // Tạo 5–10 đánh giá cho mỗi sản phẩm
            $count = rand(5, 10);

            for ($i = 0; $i < $count; $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id'    => null, // hoặc có thể gán user_id nếu bạn có bảng users
                    'rating'     => rand(1, 5),
                    'comment'    => $faker->sentence(rand(5, 12)),
                    'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                ]);
            }
        }

        $this->command->info('✅ Đã tạo dữ liệu đánh giá sao mẫu!');
    }
}
