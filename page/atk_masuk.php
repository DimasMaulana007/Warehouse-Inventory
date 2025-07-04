<?php
$kode=$_POST['kode'];
$jml=$_POST['jml'];
$masuk=$_POST['masuk'];
if ($masuk) {

		$query=mysqli_query($koneksi,"insert into atk_masuk(kode_atk,masuk)values('$kode','$jml')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}
$a=mysqli_query($koneksi,"select * from kode_atk");
while($data=mysqli_fetch_array($a)){
	$pilih.="
		<option value='{$data['kode_atk']}'>{$data['nama_barang']}</option>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Barang Masuk</h1>
</section>
    <section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Barang Masuk</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Atk</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
					<option>--pilih--</option>
					$pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jumlah</label>
                <div class='col-sm-2'>
                <input type='text' name='jml' class='form-control'required>
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
    </div>
</section>
";
?>