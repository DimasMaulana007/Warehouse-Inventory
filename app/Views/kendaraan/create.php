<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Kendaraan</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i>
                <?= htmlspecialchars($_SESSION['flash_error']) ?>
                <?php unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Form Kode Kendaraan</h3>
                <a href="?route=kendaraan" class="btn btn-sm btn-danger float-right">Keluar</a>
            </div>
            
            <form action="?route=kendaraan/store" method="post" class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Kode Kendaraan</label>
                        <div class="col-sm-3">
                            <input type="text" name="kode" class="form-control" required placeholder="Contoh: K001">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Nama Mobil</label>
                        <div class="col-sm-4">
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Jenis Mobil</label>
                        <div class="col-sm-4">
                            <input type="text" name="jenis" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">No Polisi</label>
                        <div class="col-sm-4">
                            <input type="text" name="polis" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Tahun Pembuatan</label>
                        <div class="col-sm-3">
                            <input type="number" name="thn" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">JBKI</label>
                        <div class="col-sm-3">
                            <input type="text" name="jbki" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">JBI</label>
                        <div class="col-sm-3">
                            <input type="text" name="jbi" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Daya Angkut</label>
                        <div class="col-sm-3">
                            <input type="text" name="angkut" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 offset-sm-2 col-form-label">Mobil Pabrik</label>
                        <div class="col-sm-4">
                            <input type="text" name="mobil_pabrik" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 offset-sm-4">
                            <button type="submit" class="btn btn-success">Masukan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
