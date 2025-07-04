<?php
$nama=$_POST['nama_bahan'];
$masuk=$_POST['entry'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_bahan WHERE nama_jenis_bahan = '$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into jenis_bahan(nama_jenis_bahan)values('$nama')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_query($koneksi,"select * from jenis_bahan");
while($data=mysqli_fetch_array($qy)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
            <td class=' '>$no</td>
            <td class=' '>{$data['id_jenis_bahan']}</td>
            <td class=' '>{$data['nama_jenis_bahan']}</td>
            <td class=''><a href='index.php?url=ebahan&id={$data['id_jenis_bahan']}'>Edit</a></td>
			</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Bahan Baku</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Data Bahan Baku</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan Baku</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_bahan' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='entry' class='btn btn-success' value='Masukan'>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>ID Bahan</th>
                    <th class='column-title'>Nama bahan Baku </th>
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