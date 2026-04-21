<section class="content-header"><div class="container-fluid"><h1>Data Pemasok (Suppliers)</h1></div></section>
<section class="content"><div class="container-fluid">
    <?php if (isset($_SESSION['flash_success'])): ?><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?= htmlspecialchars($_SESSION['flash_success']) ?><?php unset($_SESSION['flash_success']); ?></div><?php endif; ?>
    <?php if (isset($_SESSION['flash_error'])): ?><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?= htmlspecialchars($_SESSION['flash_error']) ?><?php unset($_SESSION['flash_error']); ?></div><?php endif; ?>
    <div class="card">
        <div class="card-header"><a href="?route=suppliers/create" class="btn btn-sm btn-success float-right">Tambah Pemasok</a></div>
        <div class="card-body">
            <table class="table table-bordered table-striped text-center datatable">
                <thead><tr><th>No</th><th>Nama Pemasok</th><th>Alamat</th><th>No Telepon</th><th>Opsi</th></tr></thead>
                <tbody>
                    <?php $no=1; foreach ($suppliers as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td><td><?= htmlspecialchars($row['name']) ?></td><td><?= htmlspecialchars($row['address']) ?></td><td><?= htmlspecialchars($row['phone']) ?></td>
                        <td>
                            <a href="?route=suppliers/edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="?route=suppliers/delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div></section>
