<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
    $download = "<a href='page/stok&laporan/export_recycle.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
$qy=mysqli_query($koneksi,"SELECT
 proses_recycle.*,
 tanggal_proses_recycle.tanggal,
 kode_bahan.kode_bahan as kod,
 supplier.nama_supplier,
 jenis_bahan.*,
 jenis_warna.nama_warna,
 detail_bahan_utama.*
FROM proses_recycle
JOIN tanggal_proses_recycle 
  ON proses_recycle.id_tanggal_proses = tanggal_proses_recycle.id_proses
JOIN kode_bahan 
  ON proses_recycle.kode_bahan = kode_bahan.kode_bahan
JOIN supplier 
  ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan 
  ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna 
  ON kode_bahan.id_warna = jenis_warna.id_warna
JOIN detail_bahan_utama
  ON detail_bahan_utama.id_detail_bahan_utama=proses_recycle.id_detail_bahan_utama
WHERE MONTH(tanggal_proses_recycle.tanggal) = '$filterBulan' AND YEAR(tanggal_proses_recycle.tanggal)='$filterTahun'
ORDER BY tanggal_proses_recycle.tanggal ASC");
while($data=mysqli_fetch_array($qy)){
  $ambil=number_format($data['qty_ambil'], 0, ',', '.');
  $hasil1=number_format($data['hasil'], 0, ',', '.');
  $jam_mulai = substr(str_replace('.', ':', $data['jam_mulai']), 0, 5);
  $jam_selesai = substr(str_replace('.', ':', $data['jam_selesai']), 0, 5);

    // Buat objek DateTime
    $mulai = DateTime::createFromFormat('H:i', $jam_mulai);
    $selesai = DateTime::createFromFormat('H:i', $jam_selesai);

    // Cek dan tambah hari jika jam selesai lebih kecil dari jam mulai
    if ($selesai <= $mulai) {
        $selesai->modify('+1 day');
    }

    // Hitung selisih menit
    $interval = $mulai->diff($selesai);
    $menit = ($interval->h * 60) + $interval->i;

  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['line']}</td>
      <td class=''>{$data['shift']}</td>
      <td class=''>$jam_mulai</td>
      <td class=''>$jam_selesai</td>
      <td class=''>$menit</td>
			<td class=''>{$data['kod']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>$ambil Kg</td>
			<td class=''>{$data['nama_bahan']}</td>
      <td class=''>$hasil1 Kg</td>
      <td class=''>{$data['bekuan']}</td>
      <td class=''>{$data['saringan']}</td>
      <td class=''>{$data['susut']}</td>
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
	<h1>Data Hasil Recycle</h1>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Hasil Recycle</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='data_hasil_recycle'>
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
                    <th class='column-title'>Regu</th>
                    <th class='column-title'>Shift</th>
                    <th class='column-title'>Star</th>
                    <th class='column-title'>Stop</th>
                    <th class='column-title'>Menit</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Hasil Bahan</th>
                    <th class='column-title'>Hasil Recycle</th>
                    <th class='column-title'>Bekuan</th>
                    <th class='column-title'>Saringan</th>
                    <th class='column-title'>Susut</th>
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