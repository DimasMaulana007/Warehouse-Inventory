<?php
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

if ( $_GET['bulan'] != '' && $_GET['tahun'] != '') {
     if (!preg_match('/^(0[1-9]|1[0-2])$/', $filterBulan) || !preg_match('/^\d{4}$/', $filterTahun)) {
        die("Format bulan atau tahun tidak valid.");
    }
$download = "<a href='page/stok&laporan/export_bahan_lapak.php?bulan=$filterBulan&tahun=$filterTahun' class='btn btn-success'>Download</a>";
$qy=mysqli_query($koneksi,"SELECT
 tbl.*,
 kb.*,
 jw.nama_warna,
 jb.*,
 s.nama_supplier,
 bbl.*
FROM bahan_baku_lapak bbl
JOIN tanggal_bahan_lapak tbl ON tbl.id_tanggal = bbl.id_tanggal
JOIN kode_bahan kb ON kb.kode_bahan = bbl.kode_bahan
JOIN jenis_warna jw ON jw.id_warna = kb.id_warna
JOIN jenis_bahan jb ON jb.id_jenis_bahan = kb.id_jenis_bahan
JOIN supplier s ON s.id_supplier = kb.id_supplier
WHERE MONTH(tbl.tanggal) = '$filterBulan' AND YEAR(tbl.tanggal) = '$filterTahun'
ORDER BY tbl.tanggal ASC
");
while($data=mysqli_fetch_array($qy)){
    $qty_sj=number_format($data['qty_lapak'], 0, ',', '.');
    $qty_act=number_format($data['qty_pabrik'], 0, ',', '.');
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
      <td class=''>$qty_sj Kg</td>
      <td class=''>$qty_act Kg</td>
		</tr>
	";}
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
	<h1>Data Bahan Baku Lapak Masuk</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Bahan Baku Lapak Masuk</h3>
                
              </div>
              <!-- /.card-header -->
              
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='data_bahan_lapak'>
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
                    <th class='column-title'>Tanggal</th>
					          <th class='column-title'>No Surat</th>
                    <th class='column-title'>No Polisi</th>
                    <th class='column-title'>Supir</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Qty Surat Jalan</th>
                    <th class='column-title'>Qty Actual</th>
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