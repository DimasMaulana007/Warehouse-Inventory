<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$polis=$_POST['polis'];
$tahun=$_POST['thn'];
$jbki=$_POST['jbki'];
$jbi=$_POST['jbi'];
$angkut=$_POST['angkut'];
$mobil_pabrik=$_POST['mobil_pabrik'];
$masuk=$_POST['masuk'];
$id=$_GET['id'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM kode_kendaraan WHERE kode_kendaraan = '$kode' AND kode_kendaraan != '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update kode_kendaraan set kode_kendaraan='$kode',nama_kendaraan='$nama',no_polisi='$polis',jenis_mobil='$jenis',tahun_pembuatan='$thn',
        jbki='$jbki',jbi='$jbi',daya_angkut='$angkut',atas_nama='$mobil_pabrik  ' 
        where kode_kendaraan='$id'");
		if($query)
		{
			header("location:index.php?url=kode_kendaraan");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kode_kendaraan where kode_kendaraan='$id'"));
$ip1=$qy['nama_kendaraan'];
$ip2=$qy['no_polisi'];
$ip3=$qy['jenis_mobil'];
$ip4=$qy['tahun_pembuatan'];
$ip5=$qy['jbki'];
$ip6=$qy['jbi'];
$ip7=$qy['daya_angkut'];
$ip8=$qy['atas_nama'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Edit Kendaraan</h1>
</section>
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Kendaraan</h3>
        </div>
        <div class='card-body'>
		<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Kendaraan</label>
                <div class='col-sm-2'>
                <input type='text' name='kode' class='form-control' id='typeInput' value='$id' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Mobil</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' value='$ip1' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Mobil</label>
                <div class='col-sm-3'>
                <input type='text' name='jenis' class='form-control' value='$ip2' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Polisi</label>
                <div class='col-sm-3'>
                <input type='text' name='polis' class='form-control' value='$ip3' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tahun Pembelian</label>
                <div class='col-sm-2'>
                <input type='text' name='thn' class='form-control' value='$ip4' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBKI</label>
                <div class='col-sm-2'>
                <input type='text' name='jbki' class='form-control' value='$ip5' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBI</label>
                <div class='col-sm-2'>
                <input type='text' name='jbi' class='form-control' value='$ip6' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Daya Angkut</label>
                <div class='col-sm-2'>
                <input type='text' name='angkut' class='form-control' value='$ip7' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Mobil Pabrik</label>
                <div class='col-sm-3'>
                <input type='text' name='mobil_pabrik' class='form-control' value='$ip8' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='masuk' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=kode_kendaraan' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>