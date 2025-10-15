@extends('layout.app')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
    <style>
        /* Căn chỉnh và làm đẹp cho trang liên hệ */
        .contact-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 25px;
            box-shadow: 
                0 25px 50px rgba(102, 126, 234, 0.15),
                0 10px 25px rgba(0, 0, 0, 0.08);
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .contact-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }

        .contact-container h1 {
            font-size: 2.8rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        .contact-container p {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .contact-container a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .contact-container a:hover {
            color: #764ba2;
            text-decoration: underline;
            transform: translateY(-1px);
        }

        .contact-info {
            margin-top: 40px;
            background: rgba(102, 126, 234, 0.05);
            padding: 30px;
            border-radius: 20px;
            border-left: 5px solid #667eea;
        }

        .contact-info h3 {
            font-size: 2rem;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .contact-info h3::before {
            content: '📞';
            margin-right: 12px;
            font-size: 1.5rem;
        }

        .contact-info p {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .contact-info p strong {
            color: #2d3748;
            min-width: 140px;
            display: inline-flex;
            align-items: center;
        }

        .contact-info p strong::before {
            content: '•';
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }

        .contact-info .working-hours {
            font-style: italic;
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            padding: 15px 20px;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        /* Google Maps Section */
        .map-section {
            margin-top: 40px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .map-section h3 {
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .map-section h3::before {
            content: '🗺️';
            margin-right: 10px;
        }

        .map-container {
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            border: 3px solid #667eea;
        }

        /* Contact form */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-top: 50px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .contact-form h3 {
            font-size: 2rem;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
        }

        .contact-form h3::before {
            content: '✉️';
            margin-right: 10px;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 15px 20px;
            font-size: 1rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            outline: none;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .contact-form button {
            padding: 18px 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .contact-form button:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-container {
                margin: 20px;
                padding: 20px;
            }
            
            .contact-container h1 {
                font-size: 2.2rem;
            }
            
            .contact-info {
                padding: 20px;
            }
            
            .contact-form {
                padding: 25px;
            }
            
            .map-container {
                height: 300px;
            }
        }
    </style>

    <div class="contact-container">
        <h1>Liên hệ với chúng tôi</h1>
        <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn. Hãy để lại thông tin của bạn bên dưới.</p>

        <div class="contact-info">
            <h3>Thông tin liên hệ</h3>
            <p><strong>Email:</strong> <a href="mailto:contact@HSStore.vn">contact@HSStore.vn</a></p>
            <p><strong>Số điện thoại:</strong> <a href="tel:+84123456789">+84 123 456 789</a></p>
            <p><strong>Địa chỉ:</strong> 123 Nguyễn Huệ, Quận 1, TP.HCM</p>
            <p class="working-hours"><strong>Giờ làm việc:</strong> Từ 9:00 AM đến 6:00 PM (Thứ Hai - Thứ Sáu)</p>
        </div>

        <div class="map-section">
            <h3>Vị trí văn phòng</h3>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4326002406546!2d106.69751731533507!3d10.776889992313094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3332db71%3A0x1a5722b97b6e0b0e!2zTmd1eeG7hW4gSHXhu4wsIFF1YW4gMSwgVGjDoG5oIHBob9GUIEjhu5cgQ2jDrSBNaW5oLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1642234567890!5m2!1sen!2s"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        <div class="contact-form">
            <h3>Gửi tin nhắn</h3>
            <input type="text" name="name" placeholder="Họ và tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="message" placeholder="Nội dung tin nhắn" rows="5" required></textarea>
            <button type="submit">Gửi tin nhắn</button>
        </div>
    </div>
@endsection