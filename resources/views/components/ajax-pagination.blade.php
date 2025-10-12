<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#list').html(response);
            }
        });
    });

    $(document).on('change', '.page-perpage', function(event) {
        let page = $(this).val();
        $.ajax({
            url: page,
            type: "GET",
            success: function(response) {
                $('#list').html(response);
            }
        });
    });

    $('#confirmdelete').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let brandName = button.data('info');
        let action = button.data('action');

        let modal = $(this);
        modal.find('.info').text(`Bạn có chắc chắn muốn xóa thương hiệu "${brandName}" không?`);
        modal.find('form#deleteForm').attr('action', action);
    });
</script>
