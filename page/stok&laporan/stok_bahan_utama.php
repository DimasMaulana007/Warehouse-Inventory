<?php
$qy = mysqli_query($koneksi, "
  SELECT 
    dbu.id_detail_bahan_utama,
    dbu.nama_bahan,
    dbu.kode_bahan,
    IFNULL(pr_sub.total_masuk, 0) AS total_masuk,
    IFNULL(buk.total_keluar, 0) AS total_keluar,
    IFNULL(dbu.jumlah, 0) AS stok_sekarang,
    (IFNULL(dbu.jumlah, 0) + IFNULL(buk.total_keluar, 0) - IFNULL(pr_sub.total_masuk, 0)) AS stok_awal
  FROM detail_bahan_utama dbu
  LEFT JOIN (
      SELECT id_detail_bahan_utama, SUM(hasil) AS total_masuk
      FROM proses_recycle
      GROUP BY id_detail_bahan_utama
  ) pr_sub ON pr_sub.id_detail_bahan_utama = dbu.id_detail_bahan_utama
  LEFT JOIN (
      SELECT id_detail_bahan_utama, SUM(keluar) AS total_keluar
      FROM bahan_utama_keluar
      GROUP BY id_detail_bahan_utama
  ) buk ON buk.id_detail_bahan_utama = dbu.id_detail_bahan_utama
  GROUP BY dbu.id_detail_bahan_utama, dbu.nama_bahan
");

while($data=mysqli_fetch_array($qy)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['kode_bahan']}</td>
      <td class=' '>{$data['nama_bahan']}</td>
			<td class=' '>{$data['stok_awal']} Kg</td>
      <td class=' '>{$data['total_masuk']} Kg</td>
			<td class=' '>{$data['total_keluar']} Kg</td>
			<td class=''>{$data['total_stok']} Kg</td>
			<td class=''><a href='#'>View</a></td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Stok Bahan Baku</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Stok Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama bahan</th>
                    <th class='column-title'>Stok Awal</th>
                    <th class='column-title'>Total Masuk</th>
                    <th class='column-title'>Total Keluar</th>
                    <th class='column-title'>Total</th>
                    <th class='column-title'>Opsi</th>
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