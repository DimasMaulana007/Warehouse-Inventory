<?php
$qy=mysqli_query($koneksi,"SELECT 
  kode_bahan.*, 
  supplier.nama_supplier,
  jenis_bahan.id_jenis_bahan,
  jenis_bahan.nama_jenis_bahan,
  jenis_bahan.jenis_bahan, 
  jenis_warna.nama_warna
FROM kode_bahan
LEFT JOIN bahan_baku_lapak ON bahan_baku_lapak.kode_bahan = kode_bahan.kode_bahan
LEFT JOIN supplier ON kode_bahan.id_supplier = supplier.id_supplier
LEFT JOIN jenis_bahan ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
LEFT JOIN jenis_warna ON kode_bahan.id_warna = jenis_warna.id_warna
WHERE kode_bahan.kode_bahan LIKE 'AL%'
GROUP BY 
  kode_bahan.kode_bahan, 
  supplier.nama_supplier,
  jenis_bahan.id_jenis_bahan,
  jenis_bahan.nama_jenis_bahan,
  jenis_warna.nama_warna
");
while($data=mysqli_fetch_array($qy)){
  $jj=number_format($data['jumlah'],0,',','.');
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>$jj Kg</td>
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
                    <th class='column-title'>Kode Bahan </th>
						        <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Total Bahan</th>
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