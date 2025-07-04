<?php
$produk=$_POST['nama_komponen'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM detail_bahan_utama WHERE nama_bahan = '$produk' AND nama_bahan != '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update detail_bahan_utama set nama_bahan='$produk' where id_detail_bahan_utama='$id'");
		if($query)
		{
			header("location:index.php?url=baku");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from detail_bahan_utama where id_detail_bahan_utama='$id'"));
$ip0=$qy['nama_bahan'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Jenis Bahan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Bahan </h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan Baku</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_komponen' class='form-control' value='$ip0' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=baku' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>

";
?>          