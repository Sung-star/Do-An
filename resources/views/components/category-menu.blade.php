<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
    aria-expanded="false">Danh mục</a>
<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    {{-- đọc biến $categories (trong component) --}}
    @foreach ($categories as $item)
        <li><a class="dropdown-item" href="{{ route('category', ['id' => $item->cateid]) }}">{{ $item->catename }}</a>
        </li>
    @endforeach
</ul>
