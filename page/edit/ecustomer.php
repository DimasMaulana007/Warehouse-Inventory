<?php
$customer=$_POST['customer'];
$alamat=$_POST['alamat'];
$tlp=$_POST['tlp'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM customer WHERE nama_customer = '$customer' AND nama_customer != '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update customer set nama_customer='$customer',alamat='$alamat',telepon='$tlp' where id_customer='$id'");
		if($query)
		{
			header("location:index.php?url=Tambah Customer");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from customer where id_customer='$id'"));
$ip0=$qy['nama_customer'];
$ip1=$qy['alamat'];
$ip2=$qy['telepon'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Customer</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Customer</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Customer</label>
                <div class='col-sm-3'>
                <input type='text' name='customer' class='form-control' id='typeInput' value='$ip0' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Alamat</label>
                <div class='col-sm-3'>
                <textarea class='form-control' rows='3' name='alamat'>$ip1</textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No. Tlp</label>
                <div class='col-sm-3'>
                <input type='text' name='tlp' class='form-control' value='$ip2' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=Tambah Customer' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    $ket
    </div>
</section>
";
?>          