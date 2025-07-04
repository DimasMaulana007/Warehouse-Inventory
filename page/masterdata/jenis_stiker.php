<?php
$kode = $_POST['kode'];
$nama = $_POST['nama_stiker'];
$masuk = $_POST['entry'];

if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_gambar_stiker WHERE kode_stiker = '$kode' AND nama_stiker='$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO jenis_gambar_stiker(kode_stiker, nama_stiker) VALUES('$kode', '$nama')");
        if ($query) {
            $ket = "<div class='alert alert-success'>Data Tersimpan</div>";
        } else {
            $ket = "<div class='alert alert-danger'>Memasukan Data Gagal</div>";
        }
    }
}

$qy=mysqli_query($koneksi,"select * from jenis_gambar_stiker");
while($data=mysqli_fetch_array($qy)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
			<td class=' '>$no</td>
      <td class=' '>{$data['kode_stiker']}</td>
			<td class=' '>{$data['nama_stiker']}</td>
            <td class=' '><a href='index.php?url=estiker&id={$data['kode_stiker']}'>Edit</a></td>
			</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Jenis Gambar Stiker</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Jenis Stiker</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Stiker</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' id='typeInput' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Stiker</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_stiker' class='form-control' required>
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
                <h3 class='card-title'>Data Jenis Stiker</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Stiker</th>
                    <th class='column-title'>Nama Stiker</th>
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