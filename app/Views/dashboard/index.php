<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= isset($total_users) ? htmlspecialchars($total_users) : 0 ?></h3>
                <p>Pengguna Sistem</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="?route=users" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= isset($total_vehicles) ? htmlspecialchars($total_vehicles) : 0 ?></h3>
                <p>Kendaraan Terdaftar</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <a href="?route=kendaraan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= isset($total_suppliers) ? htmlspecialchars($total_suppliers) : 0 ?></h3>
                <p>Pemasok Material</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
            <a href="?route=suppliers" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= isset($total_customers) ? htmlspecialchars($total_customers) : 0 ?></h3>
                <p>Pelanggan Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <a href="?route=customers" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="card card-outline card-primary mt-3">
    <div class="card-header">
        <h3 class="card-title">Informasi Sistem MVC V2</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Selamat Datang, <?= htmlspecialchars($user_id) ?>!</h5>
            Sistem mendeteksi Anda login dengan hak akses: <strong><?= htmlspecialchars($user_role) ?></strong>.
        </div>
        <p class="lead">
            Sistem informasi ini didukung oleh basis data modern relasional terpusat dengan integritas tinggi (Phase 4).
        </p>
        <p>Anda dapat mengelola master data pada panel navigasi sebelah kiri Anda. Modul baru sedang dalam masa penyempurnaan secara bertahap.</p>
    </div>
</div>
