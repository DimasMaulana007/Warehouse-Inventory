<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
    $download = "<a href='page/stok&laporan/export_sortir.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
$qy=mysqli_query($koneksi,"SELECT 
  proses_crusher.*,
  tanggal_proses_crusher.tanggal,
  kb1.kode_bahan AS kode_bahan_asal,
  kb1.id_jenis_bahan,
  supplier.nama_supplier,
  jenis_bahan.nama_jenis_bahan,
  jenis_warna.nama_warna,
  kb2.kode_bahan AS kode_bahan_crusher,
  jb2.nama_jenis_bahan AS bahan_crusher
FROM proses_crusher
JOIN tanggal_proses_crusher ON proses_crusher.id_tanggal = tanggal_proses_crusher.id_tanggal_crusher
JOIN kode_bahan kb1 ON proses_crusher.code_bahan = kb1.kode_bahan
JOIN supplier ON kb1.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kb1.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna ON kb1.id_warna = jenis_warna.id_warna
LEFT JOIN kode_bahan kb2 ON proses_crusher.bahan_crusher = kb2.kode_bahan
LEFT JOIN jenis_bahan jb2 ON kb2.id_jenis_bahan = jb2.id_jenis_bahan
WHERE MONTH(tanggal_proses_crusher.tanggal) = '$filterBulan' AND YEAR(tanggal_proses_crusher.tanggal)='$filterTahun'
ORDER BY tanggal_proses_crusher.tanggal ASC");
while($data=mysqli_fetch_array($qy)){
    $pakai1=number_format($data['qty_pakai'], 0, '.', ',');
    $total1=number_format($data['total_hasil'], 0, '.', ',');
    $hasil_bahan_crsuher=
      $ket.="
          <tr class='even pointer text-center'>
              <td class=''>{$data['tanggal']}</td>
              <td class=''>{$data['code_bahan']}</td>
              <td class=''>{$data['nama_supplier']}</td>
              <td class=''>{$data['nama_jenis_bahan']}</td>
              <td class=''>{$data['nama_warna']}</td>
              <td class=''>{$data['operator']}</td>
              <td class=''>$pakai1 Kg</td>
              <td class=''>{$data['bahan_crusher']}</td>
              <td class=''>$total1 Kg</td>
          </tr>
      ";
}
}
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
        for ($i = $tahunSekarang; $i >= 2020; $i--) {
          $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : '';
          $ket2.="<option value='$i' $selected>$i</option>";
        }
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Hasil Crusher</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Hasil Crusher</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='data_hasil_crusher'>
            <div class='form-group row'>
                            <label for='inputEmail3' class='col-form-label'>Bulan </label>
                            <div class='col-sm-2'>
                            <select class='form-control' name='bulan' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Bulan</option>
                                $ket1
                            </select>
                            </div>
                            <label for='inputEmail3' class=' col-form-label'>Tahun </label>
                            <div class='col-sm-2'>
                            <select class='form-control' name='tahun' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Tahun</option>
                                $ket2
                            </select>
                            </div>
                            <div class='col-md-3'>
                  <button type='submit' class='btn btn-primary'>Tampilkan</button>
                  $download
                </div>
            </div>
            </form>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center' style='background-color: rgb(221, 252, 19);'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Operator</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>nama Hasil Sortir</th>
                    <th class='column-title'>Jumlah Sortir</th>
                  </tr>
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