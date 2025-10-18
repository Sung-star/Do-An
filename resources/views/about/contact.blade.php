@extends('layout.app')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
<style>
/* 🌈 TOÀN TRANG LIÊN HỆ */
.contact-container {
    max-width: 950px;
    margin: 50px auto;
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    border-radius: 25px;
    padding: 50px 40px;
    box-shadow: 0 25px 50px rgba(102, 126, 234, 0.15), 0 10px 25px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s ease-out;
}
.contact-container::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(102,126,234,0.08), rgba(118,75,162,0.08));
    z-index: 0;
}
.contact-container > * {
    position: relative;
    z-index: 1;
}

.contact-container h1 {
    text-align: center;
    font-size: 2.8rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
    font-weight: 700;
}
.contact-container p {
    text-align: center;
    color: #64748b;
    font-size: 1.15rem;
    margin-bottom: 2rem;
}

/* 🔹 Thông tin liên hệ */
.contact-info {
    background: rgba(102,126,234,0.05);
    padding: 25px 30px;
    border-radius: 20px;
    border-left: 5px solid #667eea;
    margin-bottom: 40px;
}
.contact-info h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #2d3748;
    display: flex;
    align-items: center;
}
.contact-info h3::before {
    content: '📞';
    margin-right: 12px;
}
.contact-info p {
    font-size: 1.05rem;
    color: #4a5568;
    margin-bottom: 8px;
}
.contact-info a {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
}
.contact-info a:hover {
    color: #764ba2;
    text-decoration: underline;
}

/* 🕐 Giờ làm việc */
.contact-info .working-hours {
    background: rgba(102,126,234,0.08);
    border: 1px solid rgba(102,126,234,0.2);
    color: #667eea;
    font-style: italic;
    padding: 12px 18px;
    border-radius: 12px;
    margin-top: 12px;
}

/* 🗺️ Google Map */
.map-section {
    margin-top: 40px;
}
.map-section h3 {
    font-size: 1.6rem;
    margin-bottom: 15px;
    color: #2d3748;
}
.map-container {
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border: 3px solid #667eea;
    transition: all 0.3s ease;
}
.map-container:hover {
    transform: scale(1.01);
    box-shadow: 0 15px 35px rgba(102,126,234,0.3);
}

/* ✉️ Form liên hệ */
.contact-form {
    margin-top: 50px;
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 25px;
    transition: all 0.3s ease;
}
.contact-form:hover {
    transform: translateY(-5px);
}
.contact-form h3 {
    text-align: center;
    font-size: 2rem;
    color: #2d3748;
    margin-bottom: 10px;
}
.contact-form input,
.contact-form textarea {
    padding: 15px 20px;
    font-size: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: #f8fafc;
    transition: all 0.3s ease;
}
.contact-form input:focus,
.contact-form textarea:focus {
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
}

/* Nút gửi */
.contact-form button {
    align-self: center;
    padding: 16px 45px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 50px;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(102,126,234,0.3);
    transition: all 0.3s ease;
}
.contact-form button:hover {
    background: linear-gradient(135deg, #764ba2, #667eea);
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102,126,234,0.4);
}

/* 🌙 DARK MODE */
body[data-theme="dark"] .contact-container {
    background: linear-gradient(145deg, #1e293b, #0f172a);
    color: #e2e8f0;
}
body[data-theme="dark"] .contact-info {
    background: rgba(255,255,255,0.05);
    border-left: 5px solid #60a5fa;
}
body[data-theme="dark"] .contact-form {
    background: #1e293b;
}
body[data-theme="dark"] .contact-form input,
body[data-theme="dark"] .contact-form textarea {
    background: #0f172a;
    color: #f1f5f9;
    border-color: #334155;
}
body[data-theme="dark"] .contact-form input:focus,
body[data-theme="dark"] .contact-form textarea:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(96,165,250,0.3);
}
body[data-theme="dark"] .contact-form button {
    background: linear-gradient(135deg, #2563eb, #1e40af);
}
body[data-theme="dark"] .map-container {
    border-color: #2563eb;
}

/* ✨ Animation */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* 📱 Responsive */
@media (max-width: 768px) {
    .contact-container { padding: 25px; }
    .contact-form { padding: 25px; }
    .map-container { height: 300px; }
}
</style>

<div class="contact-container" data-aos="fade-up">
    <h1>Liên hệ với chúng tôi</h1>
    <p>HS Store luôn sẵn sàng lắng nghe và hỗ trợ bạn mọi lúc mọi nơi 💬</p>

    <div class="contact-info">
        <h3>Thông tin liên hệ</h3>
        <p><strong>Email:</strong> <a href="mailto:contact@HSStore.vn">contact@HSStore.vn</a></p>
        <p><strong>Điện thoại:</strong> <a href="tel:+84123456789">+84 123 456 789</a></p>
        <p><strong>Địa chỉ:</strong> 123 Nguyễn Huệ, Quận 1, TP.HCM</p>
        <p class="working-hours">⏰ Giờ làm việc: 9:00 - 18:00 (Thứ Hai - Thứ Sáu)</p>
    </div>

    <div class="map-section">
        <h3>🗺️ Vị trí văn phòng</h3>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4326002406546!2d106.69751731533507!3d10.776889992313094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3332db71%3A0x1a5722b97b6e0b0e!2zMTIzIE5ndXnhu4VuIEh14buNLCBRMSwgUFAuIEhDTQ!5e0!3m2!1svi!2s!4v1642234567890!5m2!1svi!2s"
                width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy">
            </iframe>
        </div>
    </div>

    <form class="contact-form" method="POST" action="#">
        <h3>✉️ Gửi tin nhắn cho HS Store</h3>
        <input type="text" name="name" placeholder="Họ và tên" required>
        <input type="email" name="email" placeholder="Email của bạn" required>
        <textarea name="message" rows="5" placeholder="Nhập nội dung tin nhắn..." required></textarea>
        <button type="submit">Gửi tin nhắn</button>
    </form>
</div>
@endsection
