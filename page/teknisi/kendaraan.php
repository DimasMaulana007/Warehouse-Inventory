<?php
$qy=mysqli_query($koneksi,"SELECT * FROM kode_kendaraan");
while($data=mysqli_fetch_array($qy)){
    $ton=number_format($data['daya_angkut'],0,',','.');
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['nama_kendaraan']}</td>
			<td class=''>{$data['no_polisi']}</td>
			<td class=''>{$data['jenis_mobil']}</td>
			<td class=''>{$data['tahun_pembuatan']}</td>
			<td class=''>$ton Kg</td>
			<td class=''><a href='index.php?url=".encrypt_url('upkendaraan')."&id={$data['kode_kendaraan']}'>Update</a></td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kendaraan</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Kendaraan</h3>
                <a href='index.php?url=".encrypt_url('tkendaraan')."' class='btn btn-sm btn-success float-right'>Tambah Kendaraan</a>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
					          <th class='column-title'>Nama Mobil</th>
                    <th class='column-title'>No Polisi</th>
                    <th class='column-title'>Jenis Mobil</th>
                    <th class='column-title'>Tahun Pembuatan</th>
                    <th class='column-title'>Daya Angkut</th>
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