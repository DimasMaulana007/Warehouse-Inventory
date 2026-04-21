<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Pengguna</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i><?= htmlspecialchars($_SESSION['flash_success']) ?><?php unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i><?= htmlspecialchars($_SESSION['flash_error']) ?><?php unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Akun Sistem</h3>
                <a href="?route=users/create" class="btn btn-sm btn-success float-right">Buat Pengguna Baru</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Hak Akses (Role)</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><span class="badge badge-info"><?= htmlspecialchars(strtoupper($row['role'])) ?></span></td>
                            <td>
                                <?php if ($row['is_active']): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?route=users/edit&id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?route=users/delete&id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus <?= htmlspecialchars($row['username']) ?>?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
