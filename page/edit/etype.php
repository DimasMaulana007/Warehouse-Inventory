<?php
$nama=$_POST['type'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM type WHERE type = '$nama' AND type != '$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update type set type='$nama' where id_type='$id'");
		if($query)
		{
			header("location:index.php?url=type");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from type where id_type='$id'"));
$ip0=$qy['type'];
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Type Lemari</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Type Lemari</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Type Lemari</label>
                <div class='col-sm-3'>
                <input type='text' name='type' class='form-control' value='$ip0' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-3'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=type' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>          