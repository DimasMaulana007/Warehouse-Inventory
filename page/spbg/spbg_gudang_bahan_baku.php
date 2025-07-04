<?php
$tes = $_POST['tes'] ?? [];
$simpan = $_POST['simpan'] ?? '';

if ($simpan && !empty($tes)) {
    foreach ($tes as $id) {
        $id = intval($id);
        mysqli_query($koneksi, "UPDATE bahan_baku_utama SET ceklist='sudah' WHERE id_bahan_utama=$id");
    }
}
$qy=mysqli_query($koneksi,"SELECT
  tpr.tanggal,
  pr.*,
  dbu.nama_bahan,
  kb.kode_bahan,
  jw.nama_warna,
  jb.*,
  s.nama_supplier
  FROM proses_recycle pr
  JOIN tanggal_proses_recycle tpr ON tpr.id_proses=pr.id_tanggal_proses
  JOIN detail_bahan_utama dbu ON dbu.id_detail_bahan_utama=pr.id_detail_bahan_utama
  JOIN kode_bahan kb ON kb.kode_bahan=pr.kode_bahan
  JOIN jenis_warna jw ON jw.id_warna=kb.id_warna
  JOIN jenis_bahan jb ON jb.id_jenis_bahan=kb.id_jenis_bahan
  JOIN supplier s ON s.id_supplier=kb.id_supplier
 WHERE pr.ceklist='belum'
");
while($data=mysqli_fetch_array($qy)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''></td>
			<td class=''>{$data['kode_bahan']}</td>
            <td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>{$data['nama_bahan']}</td>
            <td class=''>{$data['hasil']} Kg</td>
            <td class=''><input type='checkbox' name='tes[]' value='{$data['id_bahan_baku']}'></td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>SPBG</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>SPBG Masuk</h3>
              </div>
              <!-- /.card-header -->
              <form method='post'>
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal</th>
					          <th class='column-title'>NO SPBG</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Hasil Recycle</th>
                    <th class='column-title'>Jumlah</th>
                    <th class='column-title'>Checklist</th>
                  </tr>
                  </thead>
                  <tbody>
                  $ket
                  </tfoot>
                 </table>
                <input type='submit' name='simpan' class='btn btn-lg btn-primary' value='Simpan'>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>
";
?>