<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AboutController extends Controller

{
    /**
     * Afficher la page About principale
     */
    public function index()
    {
        // Données de l'entreprise
        $companyData = [
            'name' => 'Shop E-Commerce Vietnam',
            'founded' => 2020,
            'employees' => 2,
            'customers' => 50000,
            'products' => 10000,
            'satisfaction' => 99,
            'description' => 'Chúng tôi là một trong những cửa hàng thương mại điện tử hàng đầu tại Việt Nam, chuyên cung cấp các sản phẩm chất lượng cao với dịch vụ khách hàng tuyệt vời.',
            'mission' => 'Mang đến trải nghiệm mua sắm tốt nhất cho khách hàng Việt Nam',
            'vision' => 'Trở thành nền tảng thương mại điện tử số 1 Đông Nam Á vào năm 2030'
        ];

        // Thống kê
        $stats = [
            [
                'number' => '50,000+',
                'label' => 'Khách hàng hạnh phúc',
                'icon' => 'bi-people-fill',
                'color' => 'primary'
            ],
            [
                'number' => '10,000+',
                'label' => 'Sản phẩm chất lượng',
                'icon' => 'bi-box-seam',
                'color' => 'success'
            ],
            [
                'number' => '99%',
                'label' => 'Tỷ lệ hài lòng',
                'icon' => 'bi-star-fill',
                'color' => 'warning'
            ],
            [
                'number' => '24/7',
                'label' => 'Hỗ trợ khách hàng',
                'icon' => 'bi-headset',
                'color' => 'info'
            ]
        ];

        // Giá trị cốt lõi
        $values = [
            [
                'title' => 'Chất Lượng Hàng Đầu',
                'description' => 'Cam kết cung cấp sản phẩm chất lượng cao nhất, được kiểm tra kỹ lưỡng trước khi đến tay khách hàng.',
                'icon' => 'bi-award-fill'
            ],
            [
                'title' => 'Dịch Vụ Tận Tâm',
                'description' => 'Đội ngũ tư vấn chuyên nghiệp, hỗ trợ khách hàng 24/7 với thái độ nhiệt tình và chu đáo.',
                'icon' => 'bi-heart-fill'
            ],
            [
                'title' => 'Giao Hàng Nhanh Chóng',
                'description' => 'Hệ thống logistics hiện đại, đảm bảo giao hàng nhanh chóng trong vòng 24h tại TP.HCM.',
                'icon' => 'bi-lightning-fill'
            ],
            [
                'title' => 'Giá Cả Hợp Lý',
                'description' => 'Cam kết mang đến sản phẩm chất lượng với mức giá cạnh tranh nhất thị trường.',
                'icon' => 'bi-currency-dollar'
            ],
            [
                'title' => 'Bảo Hành Uy Tín',
                'description' => 'Chính sách bảo hành rõ ràng, hỗ trợ đổi trả trong vòng 30 ngày không cần lý do.',
                'icon' => 'bi-shield-check'
            ],
            [
                'title' => 'Công Nghệ Hiện Đại',
                'description' => 'Ứng dụng công nghệ mới nhất để mang đến trải nghiệm mua sắm trực tuyến tuyệt vời.',
                'icon' => 'bi-cpu-fill'
            ]
        ];

        return view('about.index', compact('companyData', 'stats', 'values'));
    }

    // /**
    //  * Afficher page đội ngũ
    //  */
    public function team()
    {
        $teamMembers = [
            [
                'name' => 'Hoàng Đình Bảo',
                'position' => 'CEO & Founder',
                'bio' => 'Với hơn 15 năm kinh nghiệm trong lĩnh vực thương mại điện tử, anh An đã dẫn dắt ModernShop trở thành một trong những thương hiệu uy tín nhất Việt Nam.',
                'image' => 'bao.jpg',
                'email' => 'BaoHoang@Minhhoashop.vn',
                'linkedin' => 'https://linkedin.com/in/BaoHoang',
                'experience' => '15+ năm',
                'speciality' => 'Chiến lược kinh doanh'
            ],
            [
                'name' => 'Nguyễn Tuấn Vũ',
                'position' => 'Marketing Director',
                'bio' => 'Chuyên gia marketing digital hàng đầu với nhiều chiến dịch thành công, đã giúp ModernShop tăng trưởng 300% trong 3 năm qua.',
                'image' => 'vu.jpg',
                'email' => 'TuanVu@Minhhoashop.vn',
                'linkedin' => 'https://linkedin.com/in/TuanVu',
                'experience' => '10+ năm',
                'speciality' => 'Digital Marketing'
            ],
            [
                'name' => 'Vũ Hoàng Huy',
                'position' => 'Technical Director',
                'bio' => 'Kỹ sư phần mềm tài năng, chuyên về công nghệ web hiện đại. Đã xây dựng hệ thống công nghệ vững chắc cho ModernShop.',
                'image' => 'huyh.jpg',
                'email' => 'HuyHoang@Minhhoashop.vn',
                'linkedin' => 'https://linkedin.com/in/HuyHoang',
                'experience' => '12+ năm',
                'speciality' => 'Full-stack Development'
            ],
            [
                'name' => 'Nguyễn Đức Huy',
                'position' => 'Customer Success Manager',
                'bio' => 'Chuyên gia chăm sóc khách hàng với tỷ lệ hài lòng 99%. Luôn đặt trải nghiệm khách hàng lên hàng đầu.',
                'image' => 'huy.jpg',
                'email' => 'NguyenHuy@Minhhoashop.vn',
                'linkedin' => 'https://linkedin.com/in/huyguyen',
                'experience' => '8+ năm',
                'speciality' => 'Customer Experience'
            ]
        ];

        return view('about.team', compact('teamMembers'));
    }

    /**
     * Afficher page liên hệ
     */
    public function contact()
    {
        $contactInfo = [
            'company' => 'ModernShop Vietnam',
            'address' => '123 Nguyễn Văn Linh, Quận 7, TP. Hồ Chí Minh',
            'address_en' => '123 Nguyen Van Linh St., District 7, Ho Chi Minh City',
            'phone' => '+84 28 1234 5678',
            'email' => 'info@modernshop.vn',
            'website' => 'https://modernshop.vn',
            'working_hours' => [
                'monday_friday' => '8:00 - 22:00',
                'saturday' => '8:00 - 22:00',
                'sunday' => '9:00 - 21:00'
            ],
            'social_media' => [
                'facebook' => 'https://facebook.com/modernshopvn',
                'instagram' => 'https://instagram.com/modernshopvn',
                'youtube' => 'https://youtube.com/modernshopvn',
                'tiktok' => 'https://tiktok.com/@modernshopvn'
            ],
            'map_coordinates' => [
                'lat' => 10.7321,
                'lng' => 106.7218
            ]
        ];

        $offices = [
            [
                'name' => 'Văn phông chính',
                'address' => '123 Nguyễn Văn Linh, Quận 7, TP.HCM',
                'phone' => '+84 28 1234 5678',
                'type' => 'Headquarters'
            ],
            [
                'name' => 'Chi nhánh Hà Nội',
                'address' => '456 Hoàng Quốc Việt, Cầu Giấy, Hà Nội',
                'phone' => '+84 24 1234 5678',
                'type' => 'Branch'
            ],
            [
                'name' => 'Chi nhánh Đà Nẵng',
                'address' => '789 Lê Duẩn, Hải Châu, Đà Nẵng',
                'phone' => '+84 236 1234 567',
                'type' => 'Branch'
            ]
        ];

        return view('about.contact', compact('contactInfo', 'offices'));
    }
}



?>
