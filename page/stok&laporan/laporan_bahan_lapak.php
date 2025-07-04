<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$bulanList = [
          '01' => 'Januari',
          '02' => 'Februari',
          '03' => 'Maret',
          '04' => 'April',
          '05' => 'Mei',
          '06' => 'Juni',
          '07' => 'Juli',
          '08' => 'Agustus',
          '09' => 'September',
          '10' => 'Oktober',
          '11' => 'November',
          '12' => 'Desember',
        ];
        foreach ($bulanList as $key => $val) {
          $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $key) ? 'selected' : '';
          $ket1.="<option value='$key' $selected>$val</option>";
        }
        $tahunSekarang = date('Y');
        for ($i = $tahunSekarang; $i >= 2024; $i--) {
          $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : '';
          $ket2.="<option value='$i' $selected>$i</option>";
        }

// Jika tombol submit diklik dan tanggal sudah diisi
if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
    $download = "<a href='page/stok&laporan/export_bahan_lapak.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
    $s=mysqli_prepare($koneksi,"SELECT 
        bahan_baku_lapak.kode_bahan,
        bahan_baku_lapak.qty_lapak,
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
        WHERE MONTH(tanggal)= ? AND YEAR(tanggal)= ? ORDER BY tanggal ASC");
    mysqli_stmt_bind_param($s, "ss", $filterBulan, $filterTahun);
    mysqli_stmt_execute($s);
    $result = mysqli_stmt_get_result($s);
    while($data=mysqli_fetch_array($result)){
      $jj=number_format($data['qty_lapak'],0,',','.');
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
                <td class=''>$jj Kg</td>
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
            <input type='hidden' name='url' value='laporan_bahan_lapak'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan Bahan Lapak</h3>
                </div>
                <div class='card-body'>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                        <div class='col-sm-3'>
                            <select class='form-control' name='bulan' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Bulan</option>
                                $ket1
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tahun</label>
                        <div class='col-sm-3'>
                            <select class='form-control' name='tahun' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Bulan</option>
                                $ket2
                            </select>
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
                <h3 class='card-title'>Data Bahan Lapak</h3>
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