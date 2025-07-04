<?php
$awal = isset($_GET['awal']) ? $_GET['awal'] : '';
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';

// Jika tombol submit diklik dan tanggal sudah diisi
if ( $awal != '' && $akhir != '') {
    $download = "<a href='page/stok&laporan/export_bahan_baku.php?awal=$awal&akhir=$akhir' class='btn btn-success'>Download</a>";
    $s=mysqli_query($koneksi,"SELECT 
        bahan_baku_lapak.kode_bahan,
        bahan_baku_lapak.qty_pabrik,
        kode_bahan.*,
        supplier.nama_supplier,
        jenis_bahan.*,
        jenis_warna.nama_warna,
        tanggal_bahan_lapak.*
        FROM tanggal_bahan_lapak 
        JOIN bahan_baku_lapak ON bahan_baku_lapak.id_tanggal=tanggal_bahan_lapak.id_tanggal
        JOIN kode_bahan ON kode_bahan.kode_bahan=bahan_baku_lapak.kode_bahan
        JOIN supplier ON supplier.id_supplier=kode_bahan.id_supplier
        JOIN jenis_bahan ON jenis_bahan.id_jenis_bahan=kode_bahan.id_jenis_bahan
        JOIN jenis_warna ON jenis_warna.id_warna=kode_bahan.id_warna
        WHERE tanggal BETWEEN '$awal' AND '$akhir' ORDER BY tanggal ASC");
    while($data=mysqli_fetch_array($s)){
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>{$data['no_surat']}</td>
                <td class=''>{$data['plat']}</td>
                <td class=''>{$data['supir']}</td>
                <td class=''>{$data['kode_bahan']}</td>
                <td class=''>{$data['nama_supplier']}</td>
                <td class=''>{$data['jenis_bahan']}</td>
                <td class=''>{$data['nama_jenis_bahan']}</td>
                <td class=''>{$data['nama_warna']}</td>
                <td class=''>{$data['jumlah']}</td>
            </tr>
	";
}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan Bahan lapak </h1>
    </div>
</section>

<section class='content'>
    <div class='container-fluid'>
        <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_bahan_baku'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan Bahan Lapak</h3>
                </div>
                <div class='card-body'>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Awal</label>
                        <div class='col-sm-3'>
                            <input type='date' name='awal' class='form-control' required value='$awal'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Akhir</label>
                        <div class='col-sm-3'>
                            <input type='date' name='akhir' class='form-control' required value='$akhir'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-5 offset-sm-4'>
                            <button type='submit' class='btn btn-primary'>Tampilkan</button>
                            $download
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Recycle</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                        <th class='column-title'>Tanggal </th>
						<th class='column-title'>No surat Jalan</th>
						<th class='column-title'>No Polisi</th>
						<th class='column-title'>Supir</th>
						<th class='column-title'>Kode Bahan</th>
						<th class='column-title'>Supplier</th>
						<th class='column-title'>Jenis</th>
						<th class='column-title'>Nama Bahan</th>
						<th class='column-title'>Warna</th>
						<th class='column-title'>Jumlah</th>
				  </tr>
                  </thead>
                  <tbody>
                  $ket
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>