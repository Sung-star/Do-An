<nav class="navbar navbar-expand-lg shadow-sm sticky-top custom-navbar" id="mainNavbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="HS Store Logo" style="height: 42px;" class="me-2">
            HS Store
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item mx-2">
                    <a class="nav-link text-white fw-semibold {{ request()->is('/') ? 'text-warning' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house-door"></i> Trang Chủ
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white fw-semibold {{ request()->is('about') ? 'text-warning' : '' }}" href="{{ route('about') }}">
                        Giới Thiệu
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white fw-semibold {{ request()->is('about/contact') ? 'text-warning' : '' }}" href="{{ route('about.contact') }}">
                        Liên Hệ
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-white fw-semibold {{ request()->is('about/team') ? 'text-warning' : '' }}" href="{{ route('about.team') }}">
                        Đội Ngũ
                    </a>
                </li>
            </ul>

            <!-- Dark mode toggle -->
            <button id="themeToggle" class="btn text-white ms-3 border-0 fs-5">
                <i id="themeIcon" class="bi bi-moon"></i>
            </button>
        </div>
    </div>
</nav>

<style>
/* 🌞 Light Mode */
.custom-navbar {
    background: linear-gradient(90deg, #1976d2 0%, #0d47a1 100%);
    transition: all 0.4s ease-in-out;
}
.custom-navbar .nav-link:hover {
    color: #FFD700 !important;
}
.custom-navbar.scrolled {
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.15);
    background: linear-gradient(90deg, #1565c0 0%, #0d47a1 100%);
}

/* 🌙 Dark Mode */
[data-theme="dark"] .custom-navbar {
    background: linear-gradient(90deg, #1a237e 0%, #0d47a1 100%) !important;
}
[data-theme="dark"] body {
    background-color: #0f172a;
    color: #e2e8f0;
}
[data-theme="dark"] .hero-about {
    background: linear-gradient(135deg, #1e3a8a 0%, #0d47a1 100%) !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const nav = document.querySelector(".custom-navbar");
    const body = document.body;
    const toggle = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");

    // Hiệu ứng scroll
    document.addEventListener("scroll", () => {
        if (window.scrollY > 30) nav.classList.add("scrolled");
        else nav.classList.remove("scrolled");
    });

    // Đọc theme đã lưu
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        body.setAttribute("data-theme", "dark");
        icon.classList.replace("bi-moon", "bi-sun");
    }

    // Toggle theme
    toggle.addEventListener("click", () => {
        const isDark = body.getAttribute("data-theme") === "dark";
        if (isDark) {
            body.removeAttribute("data-theme");
            icon.classList.replace("bi-sun", "bi-moon");
            localStorage.setItem("theme", "light");
        } else {
            body.setAttribute("data-theme", "dark");
            icon.classList.replace("bi-moon", "bi-sun");
            localStorage.setItem("theme", "dark");
        }
    });
});
</script>
