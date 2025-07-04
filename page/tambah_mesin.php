<?php
$kode=$_POST['kode'];
$mesin=$_POST['mesin'];
$merk=$_POST['merk'];
$thn=$_POST['thn'];
$kapasitas=$_POST['kapasitas'];
$lokasi=$_POST['lokasi'];
$type=$_POST['type'];
$pn=$_POST['p/n'];
$sn=$_POST['s/n'];
$refrigent=$_POST['refrigent'];
$phase=$_POST['phase'];
$volt=$_POST['volt'];
$arus=$_POST['arus'];
$hp=$_POST['hp'];
$daya=$_POST['daya'];
$berat=$_POST['berat'];
$temperatur=$_POST['temperatur'];
$hz=$_POST['hz'];
$nomfg=$_POST['mfg'];
$rpm=$_POST['rpm'];
$oli=$_POST['oli'];
$pole=$_POST['pole'];
$masuk=$_POST['masuk'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM mesin WHERE code_mesin = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into mesin(code_mesin,nama_mesin,merk,tahun_pembuatan,kapasitas,lokasi,
         type,pn_model,sn,refrigent,phase,volt,arus,hp,daya,berat,temperatur,hz,rpm,no_mfg,isi_oli,pole)
        values('$kode','$mesin','$merk','$thn','$kapasitas','$lokasi','$type','$pn','$sn','$refrigent','$phase','$volt','$arus',
        '$hp','$daya','$berat','$temperatur','$hz','$rpm','$nomfg','$oli','$pole')");
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
$ket
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Mesin</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Mesin</h3>
        <a href='index.php?url=".encrypt_url('mesin')."' class='btn-sm btn-danger float-right'>Keluar</a>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Mesin</label>
                <div class='col-sm-2'>
                <input type='text' name='kode' class='form-control' id='typeInput' value='$ip0' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Mesin</label>
                <div class='col-sm-4'>
                <input type='text' name='mesin' class='form-control' value='$ip1' required>
                </div>
            </div>
      <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Merk</label>
                <div class='col-sm-4'>
                <input type='text' name='merk' class='form-control' value='$ip2' required>
                </div>
            </div>
      <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tahun Pembuatan</label>
                <div class='col-sm-2'>
                <input type='text' name='thn' class='form-control' value='$ip3' required>
                </div>
            </div>
      <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kapasitas</label>
                <div class='col-sm-2'>
                <input type='text' name='kapasitas' class='form-control' value='$ip4' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Lokasi</label>
                <div class='col-sm-4'>
                <input type='text' name='lokasi' class='form-control' value='$ip5' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>type</label>
                <div class='col-sm-2'>
                <input type='text' name='type' class='form-control' value='$ip6' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>P/N Model</label>
                <div class='col-sm-2'>
                <input type='text' name='p/n' class='form-control' value='$ip7' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>S/N</label>
                <div class='col-sm-2'>
                <input type='text' name='s/n' class='form-control' value='$ip8' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Refrigent</label>
                <div class='col-sm-2'>
                <input type='text' name='refrigent' class='form-control' value='$ip9' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Phase</label>
                <div class='col-sm-2'>
                <input type='text' name='phase' class='form-control' value='$ip10' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Volt</label>
                <div class='col-sm-2'>
                <input type='text' name='volt' class='form-control' value='$ip11' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Arus</label>
                <div class='col-sm-2'>
                <input type='text' name='arus' class='form-control' value='$ip12' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>HP</label>
                <div class='col-sm-2'>
                <input type='text' name='hp' class='form-control' value='$ip13' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Daya</label>
                <div class='col-sm-2'>
                <input type='text' name='daya' class='form-control' value='$ip14' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Berat</label>
                <div class='col-sm-2'>
                <input type='text' name='berat' class='form-control' value='$ip15' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Temperatur</label>
                <div class='col-sm-2'>
                <input type='text' name='temperatur' class='form-control' value='$ip16' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Hz</label>
                <div class='col-sm-2'>
                <input type='text' name='hz' class='form-control' value='$ip17' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Rpm</label>
                <div class='col-sm-2'>
                <input type='text' name='rpm' class='form-control' value='$ip18' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>NO. MFG</label>
                <div class='col-sm-2'>
                <input type='text' name='mfg' class='form-control' value='$ip19' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Isi Oli</label>
                <div class='col-sm-2'>
                <input type='text' name='oli' class='form-control' value='$ip20' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Pole</label>
                <div class='col-sm-2'>
                <input type='text' name='pole' class='form-control' value='$ip21' required>
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