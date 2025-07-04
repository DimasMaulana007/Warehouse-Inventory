<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('M');
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
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
if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
    $bulan_awal = $filterBulan - 1;
    $tahun_awal = $filterTahun;
  if ($bulan_awal == 0) {
      $bulan_awal = 12;
      $tahun_awal -= 1;
  }
  $startDate = "$filterTahun-$filterBulan-01";
  $endDate = date('Y-m-d', strtotime("$startDate +1 month"));  
    $qy=mysqli_query($koneksi,"SELECT 
      bj.*,
      COALESCE(SUM(CASE WHEN abj.tanggal >= '$startDate' AND abj.tanggal < '$endDate' THEN abj.qty ELSE 0 END), 0) AS total_masuk,

      -- Total keluar hingga bulan ini
      COALESCE(SUM(CASE WHEN sj.tanggal >= '$startDate' AND sj.tanggal < '$endDate' THEN sjd.jumlah ELSE 0 END), 0) AS total_keluar,

      -- Saldo awal = masuk - keluar sampai akhir bulan sebelumnya
      COALESCE(SUM(CASE WHEN abj.tanggal <= '$tahun_awal-$bulan_awal-31' THEN abj.qty ELSE 0 END), 0)
      - COALESCE(SUM(CASE WHEN sj.tanggal <= '$tahun_awal-$bulan_awal-31' THEN sjd.jumlah ELSE 0 END), 0) AS saldo_awal,
      jw.nama_warna
    FROM
    barang_jadi bj
    LEFT JOIN assembly_barang_jadi abj ON abj.kode_barang=bj.kode_barang
    LEFT JOIN surat_jalan_detail sjd ON sjd.kode_barang=bj.kode_barang
    LEFT JOIN surat_jalan sj ON sj.id_surat=sjd.id_surat
    LEFT JOIN jenis_warna jw ON jw.id_warna=bj.warna
    GROUP BY bj.kode_barang");
    while($data=mysqli_fetch_array($qy)){
      $total=$data['saldo_awal']+$data['total_masuk']-$data['total_keluar'];
      $ket.="
        <tr class='even pointer text-center'>
          <td class=''>{$data['karakter']}</td>
          <td class=''>{$data['merk']}</td>
          <td class=''>{$data['susun']}</td>
          <td class=''>{$data['kunci']}-{$data['hanger']}</td>
          <td class=''>{$data['nama_warna']}</td>
          <td class=''>{$data['saldo_awal']}</td>
          <td class=''>{$data['total_masuk']}</td>
          <td class=''>{$data['total_keluar']}</td>
          <td class=''>$total</td>
        </tr>";}
}else{
  $bln=date('m');
  $qy=mysqli_query($koneksi,"SELECT 
      bj.*,
      COALESCE(SUM(CASE WHEN MONTH(abj.tanggal) >= '$bln' THEN abj.qty ELSE 0 END), 0) AS total_masuk,

      -- Total keluar hingga bulan ini
      COALESCE(SUM(CASE WHEN MONTH(sj.tanggal) >= '$bln' THEN sjd.jumlah ELSE 0 END), 0) AS total_keluar,

      -- Saldo awal = masuk - keluar sampai akhir bulan sebelumnya
      COALESCE(SUM(CASE WHEN MONTH(abj.tanggal) <= '$bln' THEN abj.qty ELSE 0 END), 0)
      - COALESCE(SUM(CASE WHEN MONTH(sj.tanggal) <= '$bln' THEN sjd.jumlah ELSE 0 END), 0) AS saldo_awal,
      jw.nama_warna
    FROM
    barang_jadi bj
    LEFT JOIN assembly_barang_jadi abj ON abj.kode_barang=bj.kode_barang
    LEFT JOIN surat_jalan_detail sjd ON sjd.kode_barang=bj.kode_barang
    LEFT JOIN surat_jalan sj ON sj.id_surat=sjd.id_surat
    LEFT JOIN jenis_warna jw ON jw.id_warna=bj.warna
    GROUP BY bj.kode_barang");
    while($data=mysqli_fetch_array($qy)){
      $total=$data['saldo_awal']+$data['total_masuk']-$data['total_keluar'];
      $ket.="
        <tr class='even pointer text-center'>
          <td class=''>{$data['karakter']}</td>
          <td class=''>{$data['merk']}</td>
          <td class=''>{$data['susun']}</td>
          <td class=''>{$data['kunci']}-{$data['hanger']}</td>
          <td class=''>{$data['nama_warna']}</td>
          <td class=''>{$data['saldo_awal']}</td>
          <td class=''>{$data['total_masuk']}</td>
          <td class=''>{$data['total_keluar']}</td>
          <td class=''>$total</td>
        </tr>";}
}
  
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Stok Barang Jadi</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Stok Barang Jadi</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='stok_produk_jadi'>
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
                </div>
            </div>
            </form>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Nama Barang </th>
					          <th class='column-title'>Merk</th>
                    <th class='column-title'>Susun</th>
                    <th class='column-title'>Kunci & Hanger</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Saldo Awal</th>
                    <th class='column-title'>Barang Masuk</th>
                    <th class='column-title'>Barang Keluar</th>
                    <th class='column-title'>Total Barang</th>
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