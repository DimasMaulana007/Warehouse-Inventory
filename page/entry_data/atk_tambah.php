<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$uraian=$_POST['uraian'];
$masuk=$_POST['masuk'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM kode_atk WHERE kode_atk = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kode_atk(kode_atk,nama_barang,uraian)values('$kode','$nama','$uraian')");
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
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Tambah Barang Jadi</h1>
</section>
    <section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Barang Jadi</h3>
        <a href='index.php?url=stok_atk' class='btn-sm btn-danger float-right'>Keluar</a>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' id='typeInput' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Uraian</label>
                <div class='col-sm-3'>
                <select class='form-control' name='uraian' style='width: 100%;' required>
					<option>Atk Kantor</option>
					<option>Atk Kebersihan</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='masuk' class='btn btn-success' value='Masukan'>
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