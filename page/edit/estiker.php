<?php
$stiker=$_POST['kode'];
$nama=$_POST['nama'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_gambar_stiker WHERE kode_stiker = '$stiker' AND kode_stiker != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update jenis_gambar_stiker set kode_stiker='$stiker',nama_stiker='$nama' where kode_stiker='$id'");
		if($query)
		{
			header("location:index.php?url=jenis_stiker");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from jenis_gambar_stiker where kode_stiker='$id'"));
$ip0=$qy['kode_stiker'];
$ip1=$qy['nama_stiker'];
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
                <input type='text' name='kode' class='form-control' id='typeInput' value='$ip0' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Stiker</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' value='$ip1' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=jenis_stiker' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>          