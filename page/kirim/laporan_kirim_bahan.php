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
    $download = "<a href='page/stok&laporan/export_kirim_bahan.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
    $s=mysqli_prepare($koneksi,"SELECT 
        pbr.*,
        dpb.*,
        dbu.*,
        c.nama_customer
        FROM pengiriman_bahan_recycle pbr
        JOIN detail_pengiriman_bahan dpb ON dpb.id_kirim=pbr.id_kirim
        JOIN detail_bahan_utama dbu ON dbu.id_detail_bahan_utama=dpb.bahan
        JOIN customer c ON c.id_customer=pbr.customer
        WHERE MONTH(tanggal_kirim)= ? AND YEAR(tanggal_kirim)= ? ORDER BY tanggal_kirim ASC");
    mysqli_stmt_bind_param($s, "ss", $filterBulan, $filterTahun);
    mysqli_stmt_execute($s);
    $result = mysqli_stmt_get_result($s);
    while($data=mysqli_fetch_array($result)){
      $jj=number_format($data['berat_kg'],0,',','.');
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal_kirim']}</td>
                <td class=''>{$data['nama_customer']}</td>
                <td class=''>{$data['plat']}</td>
                <td class=''>{$data['nama_supir']}</td>
                <td class=''>{$data['nama_bahan']}</td>
                <td class=''>{$data['jenis_bahan']}</td>
                <td class=''>$jj Kg</td>
            </tr>
	";
}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan Pengiriman Bahan</h1>
    </div>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Pengriman Bahan</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_kirim_bahan'> <!-- supaya routing tetap -->
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
                            <select class='form-control' name='tahun' style='width: 100%;' required>
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
                  <tr class='text-center'>
                        <th class='column-title'>Tanggal </th>
						<th class='column-title'>Nama Customer</th>
						<th class='column-title'>No Polisi</th>
						<th class='column-title'>Supir</th>
						<th class='column-title'>Nama Bahan</th>
						<th class='column-title'>Jenis Bahan</th>
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