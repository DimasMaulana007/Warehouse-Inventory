<?php
$qy=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama
JOIN jenis_warna on jenis_warna.id_warna=detail_bahan_utama.warna
WHERE kode_bahan LIKE 'B%' 
   OR kode_bahan LIKE 'M%' 
   OR kode_bahan LIKE 'P%'");
while($data=mysqli_fetch_array($qy)){
	$total=number_format($data['jumlah'],0,',','.');
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
      <td class=''>{$data['nama_warna']}</td>
      <td class=''>$total Kg</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Recycle</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Recycle</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama bahan</th>
                    <th class='column-title'>Jenis Bahan</th>
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