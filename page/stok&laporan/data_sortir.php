<?php

$qy=mysqli_query($koneksi,"SELECT 
    kode_bahan.kode_bahan,
    kode_bahan.jumlah,
    jenis_bahan.*,
    jenis_warna.nama_warna,
    supplier.nama_supplier
FROM kode_bahan
JOIN supplier ON supplier.id_supplier=kode_bahan.id_supplier
JOIN jenis_warna ON jenis_warna.id_warna=kode_bahan.id_warna
JOIN jenis_bahan ON jenis_bahan.id_jenis_bahan=kode_bahan.id_jenis_bahan
WHERE kode_bahan.kode_bahan LIKE 'AC%'
");
while($data=mysqli_fetch_array($qy)){
  $jj=number_format($data['jumlah'],0,',','.');
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>$jj Kg</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Crusher</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Crusher</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
					          <th class='column-title'>Jenis bahan</th>
                    <th class='column-title'>supplier</th>
                    <th class='column-title'>Warna</th>
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