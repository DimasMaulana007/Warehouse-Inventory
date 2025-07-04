<?php
$qy=mysqli_query($koneksi,"SELECT 
  abj.*, 
  bj.*, 
  dk.*, 
  k.*, 
  t.type AS nama_t,
  IFNULL(SUM(abj.qty), 0) AS stok_masuk
FROM barang_jadi bj
JOIN TYPE t ON bj.type = t.id_type
JOIN komposisi k ON k.kode_barang_jadi = bj.kode_barang
JOIN detail_komposisi dk ON dk.id_komposisi = k.kode_komposisi
JOIN assembly_barang_jadi abj ON abj.id_detail_komposisi = dk.id_detail_komposisi
GROUP BY bj.kode_barang
");
while($data=mysqli_fetch_array($qy)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['nama_t']}-{$data['hanger']}</td>
			<td class=' '>{$data['merk']} Kg</td>
			<td class=' '>Susun {$data['kunci']} Kg</td>
      <td class=' '>Susun {$data['susun']} Kg</td>
      <td class=' '>Susun {$data['susun']} Kg</td>
			<td class=''>{$data['stok_awal']} Kg</td>
      <td class=''>{$data['stok_masuk']} Kg</td>
      <td class=''>{$data['stok_keluar']} Kg</td>
      <td class=''>{$data['jumlah']} Kg</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Stok Bahan Baku Lapak</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Stok Bahan Baku Lapak</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                  <th class='column-title'>Nama Produk</th>
                  <th class='column-title'>Merk</th>
                  <th class='column-title'>Susun</th>
                  <th class='column-title'>Key</th>
                  <th class='column-title'>Stok Awal</th>
                  <th class='column-title'>Stok Masuk</th>
                  <th class='column-title'>Stok Keluar</th>
                  <th class='column-title'>Total Stok</th>
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