
<?php
$tanggal=$_POST['tgl'];
$test=$_POST['tes'];

if($test)
{
		$rand=rand(0,1000000000);
		header("location:index.php?url=".encrypt_url('komponen')."&id=$rand");
		$query=mysqli_query($koneksi,"insert into tanggal_komponen(id_tgl,tanggal)values('$rand','$tanggal')");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Injection Komponen</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Injection Komponen</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Pembuatan</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='tes' class='btn btn-success' value='Inject Komponen'>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>