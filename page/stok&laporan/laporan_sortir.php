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
     $download = "<a href='page/stok&laporan/export_sortir.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
  $s=mysqli_prepare($koneksi,"SELECT 
  pc.*,  -- ganti pv.* menjadi pc.* karena tidak ada alias pv
  tpc.tanggal,
  kb1.kode_bahan AS kode_bahan_asal,
  kb1.id_jenis_bahan,
  s.nama_supplier,
  jb.nama_jenis_bahan,
  jb.jenis_bahan,
  jw.nama_warna,
  kb2.kode_bahan AS kode_bahan_crusher,
  jb2.nama_jenis_bahan AS bahan_crusher
FROM proses_crusher pc
JOIN tanggal_proses_crusher tpc ON pc.id_tanggal = tpc.id_tanggal_crusher
JOIN kode_bahan kb1 ON pc.code_bahan = kb1.kode_bahan
JOIN supplier s ON kb1.id_supplier = s.id_supplier
JOIN jenis_bahan jb ON kb1.id_jenis_bahan = jb.id_jenis_bahan
JOIN jenis_warna jw ON kb1.id_warna = jw.id_warna
LEFT JOIN kode_bahan kb2 ON pc.bahan_crusher = kb2.kode_bahan
LEFT JOIN jenis_bahan jb2 ON kb2.id_jenis_bahan = jb2.id_jenis_bahan
WHERE MONTH(tpc.tanggal)= ? AND YEAR(tpc.tanggal)= ?
ORDER BY tpc.tanggal ASC
");
mysqli_stmt_bind_param($s, "ss", $filterBulan, $filterTahun);
mysqli_stmt_execute($s);
$result = mysqli_stmt_get_result($s);
    while($data=mysqli_fetch_array($result)){
    $bahan=number_format($data['qty_pakai'],0,',','.');
    $total=number_format($data['total_hasil'],0,',','.');
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>{$data['kode_bahan_asal']}</td>
                <td class=''>{$data['nama_supplier']}</td>
                <td class=''>{$data['jenis_bahan']}</td>
                <td class=''>{$data['nama_jenis_bahan']}</td>
                <td class=''>{$data['nama_warna']}</td>
                <td class=''>{$data['operator']}</td>
                <td class=''>$bahan Kg</td>
                <td class=''>{$data['bahan_crusher']}</td>
                <td class=''>$total Kg</td>
            </tr>
	";
}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan Sortir/Crusher</h1>
    </div>
</section>

<section class='content'>
    <div class='container-fluid'>
        <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_sortir'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan Sortir/Crusher</h3>
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
                <h3 class='card-title'>Data Sortir/Crusher</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis</th>
                    <th class='column-title'>Nama Jenis Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Operator</th>
                    <th class='column-title'>Bahan Pakai</th>
                    <th class='column-title'>Hasil Sortir</th>
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