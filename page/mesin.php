<?php
$qy=mysqli_query($koneksi,"select * from mesin");
while($data=mysqli_fetch_array($qy)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
      <td class=''>{$data['code_mesin']}</td>
			<td class=''>{$data['nama_mesin']}</td>
      <td class=''>{$data['merk']}</td>
      <td class=''>{$data['tahun_pembuatan']}</td>
      <td class=''>{$data['kapasitas']}</td>
			<td class=''><a class='btn btn-primary btn-sm' href='index.php?url=".encrypt_url('emesin')."&id={$data['code_mesin']}'><i class='fas fa-folder'></i>Detail</a>
      <a class='btn btn-info btn-sm' href='index.php?url=".encrypt_url('emesin')."&id={$data['code_mesin']}'><i class='fas fa-pencil-alt'></i>Edit</a>
		</tr>
	";
}

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Mesin</h1>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Mesin</h3>
                <a href='index.php?url=".encrypt_url('tambah_mesin')."' class='btn-sm btn-success float-right'>Tambah Mesin</a>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Mesin</th>
                    <th class='column-title'>Nama Mesin</th>
                    <th class='column-title'>Merk</th>
                    <th class='column-title'>Tahun Pembuatan</th>
                    <th class='column-title'>Lokasi</th>
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