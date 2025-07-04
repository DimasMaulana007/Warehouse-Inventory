<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$polis=$_POST['polis'];
$thn=$_POST['thn'];
$jbki=$_POST['jbki'];
$jbi=$_POST['jbi'];
$angkut=$_POST['angkut'];
$mobil_pabrik=$_POST['mobil_pabrik'];
$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM kode_kendaraan WHERE kode_kendaraan = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kode_kendaraan(kode_kendaraan,nama_kendaraan,no_polisi,jenis_mobil,tahun_pembuatan,jbki,jbi,daya_angkut,atas_nama)
        values('$kode','$nama','$polis','$jenis','$thn','$jbki','$jbi','$angkut','$mobil_pabrik')");
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
	<h1>Kode Kendaraan</h1>
</section>
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Kendaraan</h3>
        <a href='index.php?url=".encrypt_url('kode_kendaraan')."' class='btn-sm btn-danger float-right'>Keluar</a>
        </div>
        <div class='card-body'>
		<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Kendaraan</label>
                <div class='col-sm-2'>
                <input type='text' name='kode' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Mobil</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Mobil</label>
                <div class='col-sm-3'>
                <input type='text' name='jenis' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Polisi</label>
                <div class='col-sm-3'>
                <input type='text' name='polis' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tahun Pembelian</label>
                <div class='col-sm-2'>
                <input type='text' name='thn' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBKI</label>
                <div class='col-sm-2'>
                <input type='text' name='jbki' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>JBI</label>
                <div class='col-sm-2'>
                <input type='text' name='jbi' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Daya Angkut</label>
                <div class='col-sm-2'>
                <input type='text' name='angkut' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Mobil Pabrik</label>
                <div class='col-sm-3'>
                <input type='text' name='mobil_pabrik' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>