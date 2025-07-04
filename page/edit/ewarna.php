<?php
$warna=$_POST['warna'];
$id=$_GET['id'];
$masuk=$_POST['simpan'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_warna WHERE nama_warna = '$warna'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update jenis_warna set nama_warna='$warna' where id_warna='$id'");
		if($query)
		{
			header("location:index.php?url=jenis_warna");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from jenis_warna where id_warna='$id'"));
$ip0=$qy['nama_warna'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Jenis Warna</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Warna</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Warna</label>
                <div class='col-sm-3'>
                <input type='text' name='warna' class='form-control' value='$ip0' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=jenis_warna' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>

";
?>          