<?php
$s=mysqli_query($koneksi,"SELECT * FROM kode_kendaraan");
if($id!=""){
    mysqli_query($koneksi,"delete from kode_bahan where kode_bahan='$id'");
    header("location:index.php?url=".encrypt_url('kode_bahan')."");
}
while($data=mysqli_fetch_array($s)){
	$no++;
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
            <td class=''>{$data['kode_kendaraan']}</td>
			<td class=''>{$data['nama_kendaraan']}</td>
			<td class=''>{$data['jenis_mobil']}</td>
			<td class=''>{$data['no_polisi']}</td>
			<td class=''><a href=''>View</a> <a href='index.php?url=".encrypt_url('ekendaraan')."&id={$data['kode_kendaraan']}'>Edit</a>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Kendaraan</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Kode Bahan Baku</h3>
                <a href='index.php?url=".encrypt_url('tambah_kendaraan')."' class='btn-sm btn-success float-right'>Tambah Kendaraan</a>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Kendaraan</th>
					          <th class='column-title'>Nama Kendaraan </th>
                    <th class='column-title'>Jenis Kendaraan</th>
                    <th class='column-title'>No Polisi</th>
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