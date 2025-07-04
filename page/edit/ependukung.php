<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$kategori=$_POST['kategori'];
$ud=$_POST['ud'];
$ul=$_POST['ul'];
$spek=$_POST['spek'];
$simpan=$_POST['simpan'];
$id=$_GET['id'];
if($simpan)
{
    $cek = mysqli_query($koneksi, "SELECT * FROM kode_komponen_pendukung WHERE id_pendukung = '$kode' AND id_pendukung != '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update kode_komponen_pendukung set nama_barang='$nama',jenis_bahan='$jenis',kategori='$kategori',ukuran_dalam='$ud',
        ukuran_luar='$ul',spek='$spek' where id_pendukung='$id'");
		if($query)
		{
			header("location:index.php?url=mesin");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
		
		if($query)
		{
			header("location:index.php?url=kode_pendukung");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}

$qy=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kode_komponen_pendukung where id_pendukung='$id'"));
$ip1=$qy['nama_barang'];
$ip2=$qy['jenis_bahan'];
$ip3=$qy['kategori'];
$ip4=$qy['ukuran_dalam'];
$ip5=$qy['ukuran_luar'];
$ip6=$qy['spek'];

$isi="
$ket
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Edit Komponen Pendukung</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Komponen Pendukung</h3>
        </div>
        <div class='card-body'>
		
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' value='$id' required readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' value='$ip1' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control' name='jenis' style='width: 100%;' required>
                    <option>$ip2</option>
					<option>KARTON</option>
                    <option>STICKER</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kategori</label>
                <div class='col-sm-3'>
                <select class='form-control' name='kategori' style='width: 100%;' required>
                    <option>$ip3</option>
					<option>Master Box</option>
                    <option>Inner Box</option>
                    <option>Sticker</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Ukuran Dalam</label>
                <div class='col-sm-2'>
                <input type='text' name='ud' class='form-control' value='$ip4' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Ukuran Luar</label>
                <div class='col-sm-2'>
                <input type='text' name='ul' class='form-control' value='$ip5' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Spek</label>
                <div class='col-sm-2'>
                <input type='text' name='spek' class='form-control' value='$ip6' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=kode_pendukung' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>