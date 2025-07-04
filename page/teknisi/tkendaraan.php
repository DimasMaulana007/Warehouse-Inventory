<?php
$nama=$_POST['nama'];
$plat=$_POST['plat'];
$jenis_mobil=$_POST['jenis_mobil'];
$thn=$_POST['thn'];
$jbki=$_POST['jbki'];
$jbi=$_POST['jbi'];
$daya=$_POST['daya_angkut'];
$milik=$_POST['milik'];
$nama=$_POST['nama'];
$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM kode_kendaraan WHERE kode_kendaraan = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan Kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kode_kendaraan(kode_kendaraan,nama_kendaraan,no_polisi,jenis_mobil,tahun_pembuatan,jbki,jbi,daya_angkut,atas_nama)
        values('$plat','$nama','$plat','$jenis_mobil','$thn','$jbki','$jbi','$daya','$milik')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Memasukan Data Berhasil Disimpan</div>";
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
	<h1>Tambah kendaraan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Kendaraan</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Kendaraan</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Polisi</label>
                <div class='col-sm-3'>
                <input type='text' name='plat' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Mobil</label>
                <div class='col-sm-3'>
                <input type='text' name='jenis_mobil' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tahun Pembuatan</label>
                <div class='col-sm-3'>
                <input type='text' name='thn' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBKI</label>
                <div class='col-sm-3'>
                <input type='text' name='jbki' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBI</label>
                <div class='col-sm-3'>
                <input type='text' name='jbi' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Daya Angkut</label>
                <div class='col-sm-3'>
                <input type='text' name='daya_angkut' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Atas Nama</label>
                <div class='col-sm-3'>
                <input type='text' name='milik' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				        <input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                        <a href='index.php?url=".encrypt_url('kendaraan')."' class='btn btn-danger'>Kembali</a>
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