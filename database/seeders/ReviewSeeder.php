<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // 🧹 Xoá dữ liệu cũ
        Review::truncate();

        $faker = \Faker\Factory::create('vi_VN');

        // Bình luận theo nhóm cảm xúc
        $positiveComments = [
            'Sản phẩm rất tốt, đúng mô tả, đáng tiền mua.',
            'Chất lượng tuyệt vời, giao hàng nhanh chóng.',
            'Hài lòng với dịch vụ và sản phẩm của shop.',
            'Đóng gói cẩn thận, nhân viên nhiệt tình.',
            'Sản phẩm hoạt động ổn định, pin bền và đẹp.',
            'Shop phản hồi nhanh, tư vấn tận tâm.',
            'Mua lần thứ hai rồi, vẫn rất hài lòng!',
            'Giá hợp lý, hàng chính hãng, rất yên tâm.',
            'Màu sắc đẹp, giống hình, chất liệu tốt.',
        ];

        $neutralComments = [
            'Sản phẩm tạm ổn, dùng được, nhưng chưa thật sự nổi bật.',
            'Chất lượng ở mức chấp nhận được so với giá tiền.',
            'Giao hàng hơi chậm một chút nhưng vẫn ổn.',
            'Cần cải thiện thêm phần đóng gói cho chắc chắn hơn.',
            'Thiết kế đẹp nhưng hiệu năng chưa thật sự như kỳ vọng.',
        ];

        $negativeComments = [
            'Sản phẩm không giống mô tả, hơi thất vọng.',
            'Giao hàng trễ, đóng gói sơ sài, chưa hài lòng.',
            'Chất lượng kém, dùng vài ngày đã gặp lỗi.',
            'Phản hồi từ shop chậm, cần cải thiện.',
            'Sản phẩm hoạt động không ổn định, mong được đổi trả.',
            'Pin yếu, máy chạy chậm hơn mong đợi.',
        ];

        // Lấy danh sách sản phẩm hiện có
        $products = Product::all();

        foreach ($products as $product) {
            $count = rand(5, 10); // mỗi sản phẩm có 5–10 đánh giá

            for ($i = 0; $i < $count; $i++) {
                $rating = rand(1, 5);

                // 🔍 Chọn bình luận theo rating
                if ($rating >= 4) {
                    $comment = $faker->randomElement($positiveComments);
                } elseif ($rating == 3) {
                    $comment = $faker->randomElement($neutralComments);
                } else {
                    $comment = $faker->randomElement($negativeComments);
                }

                Review::create([
                    'product_id' => $product->id,
                    'user_id'    => null,
                    'rating'     => $rating,
                    'comment'    => $comment,
                    'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                ]);
            }
        }

        $this->command->info('✅ Đã tạo dữ liệu đánh giá tiếng Việt có cảm xúc logic theo sao!');
    }
}
