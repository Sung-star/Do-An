<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách file ảnh có sẵn trong storage/products
        $images = [
            'airpods_pro2.jpg',
            'apple_watch.jpg',
            'bose_qc45.jpg',
            'dell_xps13.jpg',
            'galaxy_s24.jpg',
            'hp_spectre_x360.jpg',
            'ipad_pro.jpg',
            'iphone15.jpg',
            'logitech_mouse.jpg',
            'macbook_pro.jpg',
            'mechanical_keyboard.jpg',
            'rog_phone8.jpg',
            'sony_headphones.jpg',
        ];

        // Danh mục & thương hiệu tương ứng
        $categories = [
            11 => ['name' => 'Điện thoại', 'brands' => ['Apple', 'Samsung', 'Xiaomi', 'OPPO', 'Vivo']],
            12 => ['name' => 'Laptop', 'brands' => ['ASUS', 'Acer', 'Dell', 'HP', 'Lenovo']],
            13 => ['name' => 'Tai nghe', 'brands' => ['Sony', 'JBL', 'Apple', 'Anker', 'Sennheiser']],
            14 => ['name' => 'Đồng hồ', 'brands' => ['Apple', 'Samsung', 'Garmin', 'Xiaomi', 'Huawei']],
            15 => ['name' => 'Tablet', 'brands' => ['Apple', 'Samsung', 'Lenovo', 'Xiaomi']],
            16 => ['name' => 'Phụ kiện', 'brands' => ['Logitech', 'Razer', 'Baseus', 'Ugreen', 'Anker']],
        ];

        // Mô tả mẫu
        $descriptions = [
            'Thiết kế tinh tế, hiệu năng mạnh mẽ, pin cực bền.',
            'Sản phẩm chính hãng, bảo hành 12 tháng toàn quốc.',
            'Trải nghiệm mượt mà, phù hợp học tập và làm việc.',
            'Sản phẩm bán chạy nhất, nhận ưu đãi giảm giá hôm nay!',
            'Mẫu mới ra mắt, công nghệ hiện đại, kiểu dáng thời thượng.',
        ];

        // Sinh ngẫu nhiên 1000 sản phẩm
        for ($i = 1; $i <= 1000; $i++) {
            $cateid = array_rand($categories);
            $brandList = $categories[$cateid]['brands'];
            $brand = $brandList[array_rand($brandList)];

            // Tên gốc theo danh mục
            $baseNames = [
                11 => ['iPhone 15', 'Galaxy S24', 'Redmi Note', 'OPPO Reno', 'Vivo Y100'],
                12 => ['ASUS TUF F15', 'Acer Nitro 5', 'Dell XPS 13', 'HP Spectre x360', 'MacBook Pro'],
                13 => ['Sony Headphones', 'JBL Tune 510BT', 'AirPods Pro 2', 'Bose QC45', 'Anker Soundcore'],
                14 => ['Apple Watch Series 9', 'Galaxy Watch 6', 'Garmin Venu 2', 'Xiaomi Watch S1', 'Huawei Watch Fit'],
                15 => ['iPad Pro', 'Galaxy Tab S9', 'Lenovo Tab M10', 'Xiaomi Pad 6'],
                16 => ['Logitech Mouse', 'Razer Keyboard', 'Baseus Cable', 'Ugreen Charger', 'Mechanical Keyboard'],
            ];

            $baseName = $baseNames[$cateid][array_rand($baseNames[$cateid])];

            // Chọn ảnh ngẫu nhiên trong thư mục thật
            $fileName = $images[array_rand($images)];

            DB::table('products')->insert([
                'proname' => "$baseName $brand",
                'price' => rand(500000, 50000000),
                'description' => $descriptions[array_rand($descriptions)],
                'cateid' => $cateid,
                'brandid' => rand(1, 10),
                'fileName' => $fileName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
