<?php
$kode=$_POST['kode'];
$merk=$_POST['merk'];
$type=$_POST['type'];
$susun=$_POST['susun'];
$karakter=$_POST['karakter'];
$kunci=$_POST['kunci'];
$hanger=$_POST['hanger'];
$warna=$_POST['warna'];
$masuk=$_POST['masuk'];
$id=$_GET['id'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM barang_jadi WHERE kode_barang = '$kode' AND kode_barang != '$id'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update barang_jadi set kode_barang='$kode',merk='$merk',type='$type',susun='$susun',karakter='$karakter',kunci='$kunci',hanger='$hanger',warna='$warna' 
        where kode_barang='$id'");
		if($query)
		{
			header("location:index.php?url=barang");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
  barang_jadi.*,
  jenis_warna.*,
  type.type AS type_nama
FROM 
  barang_jadi 
JOIN 
  TYPE ON type.id_type = barang_jadi.type
JOIN 
  jenis_warna ON jenis_warna.id_warna = barang_jadi.warna where kode_barang='$id'"));
$ip0=$qy['kode_barang'];
$ip1=$qy['merk'];
$ip2=$qy['type_nama'];
$ip3=$qy['susun'];
$ip4=$qy['karakter'];
$ip5=$qy['kunci'];
$ip6=$qy['hanger'];
$ip7=$qy['nama_warna'];
$ip8=$qy['type'];
$ip9=$qy['id_warna'];

$a=mysqli_query($koneksi,"select * from jenis_warna");
while($data=mysqli_fetch_array($a)){
	$pilih.="
		<option value='{$data['id_warna']}'>{$data['nama_warna']}</option>
	";
}
$b=mysqli_query($koneksi,"select * from type");
while($data=mysqli_fetch_array($b)){
	$type.="
		<option value='{$data['id_type']}'>{$data['type']}</option>
	";
}

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Barang Jadi</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Kode Barang Jadi</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' value='$ip0' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Merk</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='merk' style='width: 100%;' required>
                    <option>$ip1</option>
					<option>Bubblestar</option>
					<option>Yukari</option>
					<option>Lollipop</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Type Lemari</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='type' style='width: 100%;' required>
                    <option value='$ip8'>$ip2</option>
					$type
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Susun</label>
                <div class='col-sm-3'>
                <select class='form-control' name='susun' style='width: 100%;' required>
                    <option>$ip3</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Karakter</label>
                <div class='col-sm-3'>
                <input type='text' name='karakter' class='form-control' value='$ip4' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Warna</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='warna' style='width: 100%;' required>
                    <option value='$ip9'>$ip7</option>
					$pilih
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kunci</label>
                <div class='col-sm-3'>
                <select class='form-control' name='kunci' style='width: 100%;' required>
					<option>$ip5</option>	
					<option>Key</option>
					<option>Non Key</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Hanger</label>
                <div class='col-sm-3'>
                <select class='form-control' name='hanger' style='width: 100%;' required>
					<option>$ip6</option>
					<option>Hanger</option>
					<option>Non Hanger</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='masuk' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=barang' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>