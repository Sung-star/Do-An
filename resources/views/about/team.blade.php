@extends('layout.app')

@section('title', 'Đội ngũ của chúng tôi')

@section('content')
 <style>
    /* CSS cho trang đội ngũ với thiết kế hiện đại và đẹp mắt */
    .team-members {
        display: grid;
       grid-template-columns: repeat(4, 1fr); 
        gap: 40px;
        margin-top: 50px;
        justify-items: center;
        padding: 20px;
    }

    .team-member {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 25px;
        box-shadow: 
            0 20px 40px rgba(102, 126, 234, 0.15),
            0 8px 16px rgba(0, 0, 0, 0.08);
        padding: 35px 25px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: none;
        height: 480px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        max-width: 350px;
        width: 100%;
    }

    /* Gradient border effect */
    .team-member::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #667eea, #764ba2, #f093fb, #f5576c);
        border-radius: 25px;
        padding: 3px;
        z-index: -1;
    }

    .team-member::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        right: 3px;
        bottom: 3px;
        background: inherit;
        border-radius: 22px;
        z-index: -1;
    }

    /* Floating animation on hover */
    .team-member:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 
            0 30px 60px rgba(102, 126, 234, 0.25),
            0 15px 30px rgba(0, 0, 0, 0.12);
    }

    /* Animated background pattern */
    .team-member:hover::before {
        animation: borderGlow 2s ease-in-out infinite alternate;
    }

    @keyframes borderGlow {
        0% { opacity: 0.8; }
        100% { opacity: 1; }
    }

    /* Profile image styling */
    .team-member img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 50%;
        margin: 0 auto 20px;
        border: 4px solid transparent;
        background: linear-gradient(135deg, #667eea, #764ba2) border-box;
        background-clip: padding-box;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    /* Image hover effect */
    .team-member:hover img {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    /* Name styling */
    h3 {
        font-size: 1.9rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    /* Position/Role styling */
    .team-member .position {
        font-size: 1.1rem;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
    }

    .team-member .position::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 1px;
    }

    /* Description text */
    .team-member p {
        font-size: 1rem;
        color: #64748b;
        margin-bottom: 20px;
        line-height: 1.6;
        flex-grow: 1;
        display: flex;
        align-items: center;
    }

    /* Contact info container */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: auto;
    }

    /* Email link styling */
    .email-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .email-link::before {
        content: '✉️';
        margin-right: 8px;
        font-size: 1rem;
    }

    .email-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #764ba2, #667eea);
    }

    /* LinkedIn link */
    .linkedin-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        background: #0077b5;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .linkedin-link::before {
        content: '💼';
        margin-right: 6px;
    }

    .linkedin-link:hover {
        background: #005885;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 119, 181, 0.4);
    }

    /* Experience badge */
    .experience-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
    }

    /* Specialty tag */
    .specialty-tag {
        display: inline-block;
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        margin: 10px 0;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .team-members {
            gap: 30px;
        }
        
        .team-member {
            height: 450px;
            padding: 30px 20px;
        }
    }

    @media (max-width: 768px) {
        .team-members {
            grid-template-columns: 1fr;
            gap: 25px;
            padding: 15px;
        }
        
        .team-member {
            height: auto;
            min-height: 420px;
            max-width: 100%;
        }
        
        .team-member img {
            width: 140px;
            height: 140px;
        }
        
        h3 {
            font-size: 1.7rem;
        }
        
        .team-member p {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .team-member {
            padding: 25px 15px;
            border-radius: 20px;
        }
        
        .team-member img {
            width: 120px;
            height: 120px;
        }
        
        h3 {
            font-size: 1.5rem;
        }
        
        .email-link, .linkedin-link {
            padding: 10px 16px;
            font-size: 0.85rem;
        }
    }

    /* Animations for loading */
    .team-member {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .team-member:nth-child(1) { animation-delay: 0.1s; }
    .team-member:nth-child(2) { animation-delay: 0.2s; }
    .team-member:nth-child(3) { animation-delay: 0.3s; }
    .team-member:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hover ripple effect */
    .team-member {
        position: relative;
        overflow: hidden;
    }

    .team-member::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        transition: all 0.5s ease;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        z-index: 0;
    }

    .team-member:hover::after {
        width: 300px;
        height: 300px;
    }

    /* Ensure content stays above ripple effect */
    .team-member > * {
        position: relative;
        z-index: 1;
    }
</style>

 <h1>Đội ngũ chuyên gia</h1>

    <div class="team-members">
        @foreach ($teamMembers as $member)
            <div class="team-member">
                <!-- Đảm bảo sử dụng đường dẫn chính xác tới ảnh -->
             <img src="{{ asset('storage/team/' . $member['image']) }}" alt="{{ $member['name'] }}" width="150">

                <h3>{{ $member['name'] }}</h3>
                <p><strong>Chức vụ:</strong> {{ $member['position'] }}</p>
                <p>{{ $member['bio'] }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a></p>
                <p><strong>Kinh nghiệm:</strong> {{ $member['experience'] }}</p>
                <p><strong>Chuyên môn:</strong> {{ $member['speciality'] }}</p>
                <p><a href="{{ $member['linkedin'] }}" target="_blank">LinkedIn</a></p>
            </div>
        @endforeach
    </div>
@endsection
