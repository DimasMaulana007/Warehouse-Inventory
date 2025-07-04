<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
$download = "<a href='page/stok&laporan/export_komponen.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
$qy=mysqli_query($koneksi,"SELECT 
        proses_komponen.*,
        komponen.*,
        mesin.nama_mesin,
        tanggal_komponen.tanggal
        FROM proses_komponen 
        JOIN tanggal_komponen ON tanggal_komponen.id_tgl=proses_komponen.tgl
        JOIN komponen ON komponen.code_komponen=proses_komponen.code_komponen
        JOIN mesin ON mesin.code_mesin=proses_komponen.kode_mesin
        WHERE MONTH(tanggal_komponen.tanggal) = '$filterBulan' AND YEAR(tanggal_komponen.tanggal)='$filterTahun'");
while($data=mysqli_fetch_array($qy)){
    $bahan_pakai=number_format($data['bahan_pakai'], 0, ',', '.');
    $star = substr(str_replace('.', ':', $data['jam_mulai']), 0, 5);
    $end = substr(str_replace('.', ':', $data['jam_selesai']), 0, 5);
    if ($end < $start) {
        $end += 24 * 60 * 60;
    }
    $mulai = DateTime::createFromFormat('H:i', $star);
    $selesai = DateTime::createFromFormat('H:i', $end);

    // Cek dan tambah hari jika jam selesai lebih kecil dari jam mulai
    if ($selesai <= $mulai) {
        $selesai->modify('+1 day');
    }
    // Hitung selisih menit
    $interval = $mulai->diff($selesai);
    $menit = ($interval->h * 60) + $interval->i;
    if ($data['cycle_time'] > 0) {
      $target_produksi = (3600 / $data['cycle_time']) * ($menit / 60);
      $target_produksi = round($target_produksi); // jika ingin dibulatkan
  } else {
      $target_produksi = 0;
  }

    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>$star</td>
                <td class=''>$end</td>
                <td class=''>$menit</td>
                <td class=''>{$data['nama_operator']}</td>
                <td class=''>{$data['nama_mesin']}</td>
                <td class=''>{$data['nama_komponen']}</td>
                <td class=''>$bahan_pakai Kg</td>
                <td class=''>{$data['produksi_ok']}</td>
                <td class=''>{$data['produksi_ng']}</td>
                <td class=''>{$data['cycle_time']}</td>
                <td class=''>$target_produksi</td>
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
	<h1>Produksi Komponen</h1>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Produksi Komponen</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='data_injection'>
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
                    <th class='column-title'>Star</th>
                    <th class='column-title'>Stop</th>
                    <th class='column-title'>Time</th>
                    <th class='column-title'>Nama Operator</th>
                    <th class='column-title'>Nama Mesin</th>
                    <th class='column-title'>Nama Komponen</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Produksi OK</th>
                    <th class='column-title'>Produksi NG</th>
                    <th class='column-title'>Cycle Time</th>
                    <th class='column-title'>Target Produksi</th>
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