@extends('layout.admin')

@section('title', 'Sản phẩm')

@section('content')
    <div id="list">
        @include('admin.products.pro-list')
    </div>
    <x-modal></x-modal>
    <x-ajax-pagination></x-ajax-pagination>
@endsection

{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href');
        $.ajax({
            url: page,
            type: "GET",
            success: function(response) {
                $('#pro-list').html($(response).find('#pro-list').html());
            }
        });
    });

    $(document).on('change', '.page-perpage', function(event) {
        event.preventDefault();
        let page = $(this).val();
        $.ajax({
            url: page,
            type: "GET",
            success: function(response) {
                $('#pro-list').html($(response).find('#pro-list').html());
            }
        });
    });
</script> --}}
