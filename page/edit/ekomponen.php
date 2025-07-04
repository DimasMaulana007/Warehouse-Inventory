<?php
$kode=$_POST['code_komponen'];
$nama=$_POST['nama_komponen'];
$material=$_POST['material'];
$berat=$_POST['berat'];
$cycle=$_POST['cycle'];
$warna=$_POST['warna'];
$type=$_POST['type'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM komponen WHERE code_komponen = '$kode' AND nama_komponen='$nama' AND
     code_komponen != '$id' AND nama_komponen !='$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update komponen set code_komponen='$kode',nama_komponen='$nama',detail_bahan_utama='$material',
        berat_komponen='$berat',cycle_time='$cycle',warna='$warna',id_type='$type' where code_komponen='$id'");
		if($query)
		{
			header("location:index.php?url=komponen_detail");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$jj=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama");
while($d=mysqli_fetch_array($jj)){
	$pilih.="
        <option value='{$d['id_detail_bahan_utama']}'>{$d['nama_bahan']}</option>
	";
}
$j=mysqli_query($koneksi,"SELECT * FROM jenis_warna");
while($d=mysqli_fetch_array($j)){
	$pilih1.="
        <option value='{$d['id_warna']}'>{$d['nama_warna']}</option>
	";
}
$c=mysqli_query($koneksi,"SELECT * FROM type");
while($d=mysqli_fetch_array($c)){
	$pilih2.="
        <option value='{$d['id_type']}'>{$d['type']}</option>
	";
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"SELECT *
FROM 
    komponen k
JOIN 
    detail_bahan_utama dbu ON dbu.id_detail_bahan_utama = k.detail_bahan_utama
JOIN
    type t ON t.id_type=k.id_type
JOIN 
    jenis_warna jw ON jw.id_warna = k.warna where code_komponen='$id'"));
$ip0=$qy['code_komponen'];
$ip1=$qy['nama_komponen'];
$ip2=$qy['nama_bahan'];
$ip3=$qy['berat_komponen'];
$ip4=$qy['cycle_time'];
$ip5=$qy['nama_warna'];
$ip6=$qy['type'];
$ip7=$qy['id_detail_bahan_utama'];
$ip8=$qy['id_warna'];
$ip9=$qy['id_type'];
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Komponen</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Kode Komponen</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='code_komponen' class='form-control' value='$ip0' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_komponen' class='form-control' value='$ip1' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Type Lemari</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='type' style='width: 100%;' required>
                    <option value='$ip9'>$ip6</option>
                    $pilih2
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='material' style='width: 100%;' required>
                    <option value='$ip7'>$ip2</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Berat Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='berat' class='form-control' value='$ip3' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Cycle Time</label>
                <div class='col-sm-3'>
                <input type='text' name='cycle' class='form-control' value='$ip4' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Warna</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='warna' style='width: 100%;' required>
                    <option value='$ip8'>$ip5</option>
                    $pilih1
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=komponen_detail' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
        $ket
	</form>
    </div>
</section>
";
?>          