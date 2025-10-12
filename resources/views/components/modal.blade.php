<div class="modal fade" id="confirmdelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Xác nhận xóa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="#" method="POST" id="deleteForm">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                  <div class="info text-danger fw-bold">Bạn có chắc chắn muốn xóa thương hiệu này?</div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                  <button type="submit" class="btn btn-danger">Đồng ý</button>
              </div>
          </form>
      </div>
  </div>
</div>
