<div class="card">
  <div class="card-header border-0">
    <h3 class="card-title">Status Sistem</h3>
  </div>
  <div class="card-body">
    <div class="alert alert-info">
        <h5><i class="icon fas fa-info"></i> Selamat Datang, <?= htmlspecialchars($user_id) ?>!</h5>
        Sistem mendeteksi Anda login dengan hak akses: <strong><?= htmlspecialchars($user_role) ?></strong>.
    </div>
    <p>Ini adalah tampilan dashboard versi terbaru dengan arsitektur MVC. Proses rendering HTML kini sepenuhnya terpisah dari core logic PHP, membuat halaman lebih cepat, aman, dan mudah dimaintenance.</p>
    
    <div class="row mt-4">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>MVC</h3>
            <p>Arsitektur Aktif</p>
          </div>
          <div class="icon">
            <i class="fas fa-check-circle"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
          <div class="inner">
            <h3>Fase 2</h3>
            <p>Migrasi UI Selesai</p>
          </div>
          <div class="icon">
            <i class="fas fa-layer-group"></i>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
