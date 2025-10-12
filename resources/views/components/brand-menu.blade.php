<a class="nav-link dropdown-toggle" id="navbarDropdownBrand" href="#" role="button" data-bs-toggle="dropdown"
    aria-expanded="false">Thương hiệu</a>
<ul class="dropdown-menu" aria-labelledby="navbarDropdownBrand">
    {{-- đọc biến $brands (truyền từ AppServiceProvider hoặc controller) --}}
    @foreach ($brands as $item)
        <li><a class="dropdown-item" href="{{ route('brand', ['id' => $item->id]) }}">{{ $item->brandname }}</a></li>
    @endforeach
</ul>
