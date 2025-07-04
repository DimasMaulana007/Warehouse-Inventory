<?php
$supplier=$_POST['supplier'];
$alamat=$_POST['alamat'];
$tlp=$_POST['tlp'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM supplier WHERE nama_supplier = '$supplier' AND nama_supplier != '$supplier'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update supplier set nama_supplier='$supplier',alamat='$alamat',no_tlp='$tlp' where id_supplier='$id'");
		if($query)
		{
			header("location:index.php?url=supplier");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from supplier where id_supplier='$id'"));
$ip0=$qy['nama_supplier'];
$ip1=$qy['alamat'];
$ip2=$qy['no_tlp'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Edit Supplier</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Supplier</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Supplier</label>
                <div class='col-sm-3'>
                <input type='text' name='supplier' id='typeInput' class='form-control' value='$ip0' required>
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
                <a href='index.php?url=supplier' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
        $ket
	</form>
    </div>
</section>
";
?>          