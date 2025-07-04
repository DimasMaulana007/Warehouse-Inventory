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
     $download = "<a href='page/stok&laporan/export_komponen_sas.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
    $s=mysqli_prepare($koneksi,"SELECT 
        proses_komponen.*,
        komponen.nama_komponen,
        mesin.nama_mesin,
        tanggal_komponen.tanggal
        FROM tanggal_komponen 
        JOIN proses_komponen ON proses_komponen.tgl=tanggal_komponen.id_tgl
        JOIN komponen ON komponen.code_komponen=proses_komponen.code_komponen
        JOIN mesin ON mesin.code_mesin=proses_komponen.kode_mesin
        WHERE MONTH(tanggal_komponen.tanggal)= ? AND YEAR(tanggal_komponen.tanggal)= ?
        ORDER BY tanggal_komponen.tanggal ASC");
    mysqli_stmt_bind_param($s, "ss", $filterBulan, $filterTahun);
    mysqli_stmt_execute($s);
    $result = mysqli_stmt_get_result($s);
    while($data=mysqli_fetch_array($result)){
        $star = substr(str_replace('.', ':', $data['jam_mulai']), 0, 5);
        $end = substr(str_replace('.', ':', $data['jam_selesai']), 0, 5);
        if ($end < $start) {
            $end += 24 * 60 * 60;
        }
        $mulai = DateTime::createFromFormat('H:i', $star);
        $selesai = DateTime::createFromFormat('H:i', $end);
        
        // Validasi hasil parsing
        if ($mulai === false || $selesai === false) {
            // Tangani error, bisa logging atau echo
            echo "Format jam salah: mulai = {$data['jam_mulai']}, selesai = {$data['jam_selesai']}";
        } else {
            // Cek dan tambah hari jika jam selesai lebih kecil dari jam mulai
            if ($selesai <= $mulai) {
                $selesai->modify('+1 day');
            }
        }        
    // Hitung selisih menit
    $interval = $mulai->diff($selesai);
    $total = ($interval->h * 60) + $interval->i;
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>{$data['regu']}</td>
                <td class=''>{$data['shift']}</td>
                <td class=''>$star</td>
                <td class=''>$end</td>
                <td class=''>$total</td>
                <td class=''>{$data['nama_operator']}</td>
                <td class=''>{$data['nama_mesin']}</td>
                <td class=''>{$data['nama_komponen']}</td>
                <td class=''>{$data['produksi_ok']}</td>
                <td class=''>{$data['produksi_ng']}</td>
            </tr>
	";
}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan Proses Komponen</h1>
    </div>
</section>

<section class='content'>
    <div class='container-fluid'>
        <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_proses_komponen'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan Proses Komponen</h3>
                </div>
                <div class='card-body'>
                    <div class='form-group row'>
                        <label class='col-sm-1 offset-sm-2 col-form-label'>Bulan</label>
                        <div class='col-sm-2'>
                            <select class='form-control' name='bulan' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Bulan</option>
                                $ket1
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label class='col-sm-1 offset-sm-2 col-form-label'>Tahun</label>
                        <div class='col-sm-2'>
                            <select class='form-control' name='tahun' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Bulan</option>
                                $ket2
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-5 offset-sm-3'>
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
                <h3 class='card-title'>Data Proses Komponen</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                        <th class='column-title'>Tanggal </th>
						<th class='column-title'>Regu</th>
						<th class='column-title'>Shift</th>
                        <th class='column-title'>Star</th>
                        <th class='column-title'>Stop</th>
						<th class='column-title'>Total Menit</th>
						<th class='column-title'>Nama Operator</th>
						<th class='column-title'>Mesin</th>
						<th class='column-title'>Komponen</th>
						<th class='column-title'>Produk OK</th>
						<th class='column-title'>Produk NG</th>
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