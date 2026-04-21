<section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Tambah Pengguna</h1></div></div></div></section>
<section class="content"><div class="container-fluid">
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['flash_error']) ?><?php unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <div class="card card-default">
        <div class="card-header"><h3 class="card-title">Form Data Pengguna</h3><a href="?route=users" class="btn btn-sm btn-danger float-right">Batal</a></div>
        <form action="?route=users/store" method="post" class="form-horizontal">
            <div class="card-body">
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Nama Lengkap</label><div class="col-sm-5"><input type="text" name="name" class="form-control" required></div></div>
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Username</label><div class="col-sm-4"><input type="text" name="username" class="form-control" required></div></div>
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Password</label><div class="col-sm-4"><input type="password" name="password" class="form-control" required></div></div>
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Hak Akses</label><div class="col-sm-3">
                    <select name="role" class="form-control" required>
                        <option value="warehouse">Warehouse</option>
                        <option value="ppic">PPIC</option>
                        <option value="admin">Admin</option>
                        <option value="teknisi">Teknisi</option>
                        <option value="Bahan_lapak">Bahan Lapak</option>
                    </select>
                </div></div>
                <div class="form-group row"><div class="offset-sm-4 col-sm-8"><div class="form-check"><input type="checkbox" class="form-check-input" name="is_active" id="chkActive" checked><label class="form-check-label" for="chkActive">Akun Aktif</label></div></div></div>
            </div>
            <div class="card-footer"><div class="row"><div class="col-sm-4 offset-sm-4"><button type="submit" class="btn btn-success">Simpan Pengguna</button></div></div></div>
        </form>
    </div>
</div></section>
