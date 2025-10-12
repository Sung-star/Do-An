<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">Hoài Sung Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item mx-2">
          <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Trang Chủ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="{{ route('about') }}">Về Chúng Tôi</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="{{ route('about.contact') }}">Liên Hệ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="{{ route('about.team') }}">Đội Ngũ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
