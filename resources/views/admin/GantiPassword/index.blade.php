<!-- modal-ganti-password.php -->
<div class="modal fade" id="modalGantiPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ganti Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="proses-ganti-password.php" method="POST">
          <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" class="form-control" name="old_password" required>
          </div>
          <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" class="form-control" name="new_password" required>
          </div>
          <div class="mb-3">
            <label>Ulangi Password Baru</label>
            <input type="password" class="form-control" name="confirm_password" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
