<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
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
  k.code_komponen,
  k.nama_komponen,
  jw.nama_warna,
  -- Total masuk hingga bulan ini
  COALESCE(SUM(CASE WHEN tgl.tanggal >= '$startDate' AND tgl.tanggal < '$endDate' THEN pk.produksi_ok ELSE 0 END), 0) AS total_masuk,

  -- Total keluar hingga bulan ini
  COALESCE(SUM(CASE WHEN tk.tanggal >= '$startDate' AND tk.tanggal < '$endDate' THEN tk.jumlah ELSE 0 END), 0) AS total_keluar,

  -- Saldo awal = masuk - keluar sampai akhir bulan sebelumnya
  COALESCE(SUM(CASE WHEN tgl.tanggal <= '$tahun_awal-$bulan_awal-31' THEN pk.produksi_ok ELSE 0 END), 0)
  - COALESCE(SUM(CASE WHEN tk.tanggal <= '$tahun_awal-$bulan_awal-31' THEN tk.jumlah ELSE 0 END), 0) AS saldo_awal
FROM komponen k
LEFT JOIN proses_komponen pk ON pk.code_komponen = k.code_komponen
LEFT JOIN tanggal_komponen tgl ON tgl.id_tgl = pk.tgl
LEFT JOIN transaksi_komponen tk ON tk.kode_komponen = k.code_komponen
LEFT JOIN jenis_warna jw ON k.warna = jw.id_warna
GROUP BY 
  k.code_komponen,
  k.nama_komponen,
  jw.nama_warna,
  k.jumlah_ok;

");
}else{
  $bln=date('m');
  $qy=mysqli_query($koneksi,"SELECT 
  k.code_komponen,
  k.nama_komponen,
  t.type,
  jw.nama_warna,
  -- Total masuk hingga bulan ini
  COALESCE(SUM(CASE WHEN MONTH(tgl.tanggal) <= '$bln' THEN pk.produksi_ok ELSE 0 END), 0) AS total_masuk,

  -- Total keluar hingga bulan ini
  COALESCE(SUM(CASE WHEN MONTH(tgl.tanggal) <= '$bln' THEN tk.jumlah ELSE 0 END), 0) AS total_keluar,

  -- Saldo awal = masuk - keluar sampai akhir bulan sebelumnya
  COALESCE(SUM(CASE WHEN MONTH(tgl.tanggal) <= '$bln' THEN pk.produksi_ok ELSE 0 END), 0)
  - COALESCE(SUM(CASE WHEN MONTH(tgl.tanggal) <= '$bln' THEN tk.jumlah ELSE 0 END), 0) AS saldo_awal
FROM komponen k
LEFT JOIN proses_komponen pk ON pk.code_komponen = k.code_komponen
LEFT JOIN tanggal_komponen tgl ON tgl.id_tgl = pk.tgl
LEFT JOIN transaksi_komponen tk ON tk.kode_komponen = k.code_komponen
LEFT JOIN jenis_warna jw ON k.warna = jw.id_warna
LEFT JOIN type t ON t.id_type = k.id_type
GROUP BY 
  k.code_komponen,
  k.nama_komponen,
  t.type,
  jw.nama_warna,
  k.jumlah_ok;
");
}
while($data=mysqli_fetch_array($qy)){
    $no++;
    $saldo_akhir=$data['saldo_awal']+$data['total_masuk']-$data['total_keluar'];
    $ket.="
      <tr class='text-center'>
        <td class=''>$no</td>
        <td class=''>{$data['code_komponen']}</td>
        <td class=''>{$data['nama_komponen']}</td>
        <td class=''>{$data['nama_warna']}</td>
        <td class=''>{$data['type']}</td>
        <td class=''>{$data['saldo_awal']} Pcs</td>
        <td class=''>{$data['total_masuk']} Pcs</td>
        <td class=''>{$data['total_keluar']} Pcs</td>
        <td class=''>$saldo_akhir Pcs</td>
      </tr>";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Stok Komponen</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Stok Komponen</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='stok_komponen'>
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
						        <th class=''>No</th>
                    <th class=''>Kode Komponen</th>
                    <th class=''>Nama Komponen</th>
                    <th class=''>Warna</th>
                    <th class=''>Produk</th>
                    <th class=''>Saldo</th>
                    <th class=''>In</th>
                    <th class=''>Out</th>
                    <th class=''>Total Barang</th>
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