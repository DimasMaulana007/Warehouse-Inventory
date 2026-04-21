<section class="content-header"><div class="container-fluid"><div class="col-sm-6"><h1>Edit Pelanggan</h1></div></div></section>
<section class="content"><div class="container-fluid">
    <div class="card card-default">
        <div class="card-header"><h3 class="card-title">Form Edit Pelanggan</h3><a href="?route=customers" class="btn btn-sm btn-danger float-right">Batal</a></div>
        <form action="?route=customers/update" method="post" class="form-horizontal">
            <input type="hidden" name="id" value="<?= $customer['id'] ?>">
            <div class="card-body">
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Nama Pelanggan</label><div class="col-sm-5"><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($customer['name']) ?>" required></div></div>
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">Alamat</label><div class="col-sm-5"><textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($customer['address']) ?></textarea></div></div>
                <div class="form-group row"><label class="col-sm-2 offset-sm-2 col-form-label">No Telepon</label><div class="col-sm-4"><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($customer['phone']) ?>"></div></div>
            </div>
            <div class="card-footer"><div class="row"><div class="col-sm-4 offset-sm-4"><button type="submit" class="btn btn-primary">Update Data</button></div></div></div>
        </form>
    </div>
</div></section>
