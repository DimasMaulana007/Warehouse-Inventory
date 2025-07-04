<?php
$awal=$_POST['tgl_awal'];
$akhir=$_POST['tgl_akhir'];
$entry=$_POST['entry'];
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Laporan Bulanan Produk Masuk</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' action='page/stok&laporan/export_produk.php' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Laporan Bulanan Produk Masuk</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Awal</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl_awal' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Akhir</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl_akhir' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='entry' class='btn btn-success' value='Download'>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>