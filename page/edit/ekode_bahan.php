<?php
$kode=$_POST['kode'];
$supplier=$_POST['supplier'];
$bahan=$_POST['bahan'];
$warna=$_POST['warna'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah ada kode_bahan lain yang sama, tapi bukan dari ID yang sedang diedit
    $cek = mysqli_query($koneksi, "SELECT * FROM kode_bahan WHERE kode_bahan = '$kode' AND kode_bahan != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan oleh entri lain. Silakan gunakan kode lain.</div>";
    } else {
        $query = mysqli_query($koneksi, "UPDATE kode_bahan SET 
            kode_bahan = '$kode', 
            id_supplier = '$supplier', 
            id_jenis_bahan = '$bahan', 
            id_warna = '$warna' 
            WHERE kode_bahan = '$id'");

        if ($query) {
            header("Location: index.php?url=kode_bahan");
        } else {
            $ket = "<div class='alert alert-danger'>Memasukkan data gagal.</div>";
        }
    }
}

$s1=mysqli_query($koneksi,"SELECT * FROM supplier");
while($data=mysqli_fetch_array($s1)){
	$pilih.="<option value='{$data['id_supplier']}'>{$data['nama_supplier']}</option>
	";
}
$s2=mysqli_query($koneksi,"SELECT * FROM jenis_bahan");
while($data=mysqli_fetch_array($s2)){
	$pilih2.="<option value='{$data['id_jenis_bahan']}'>{$data['nama_jenis_bahan']}</option>
	";
}
$s3=mysqli_query($koneksi,"SELECT * FROM jenis_warna");
while($data=mysqli_fetch_array($s3)){
	$pilih3.="<option value='{$data['id_warna']}'>{$data['nama_warna']}</option>
	";
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"SELECT *
FROM 
    kode_bahan kb
JOIN 
    supplier s ON s.id_supplier = kb.id_supplier
JOIN
    jenis_bahan jb ON jb.id_jenis_bahan=kb.id_jenis_bahan
JOIN 
    jenis_warna jw ON jw.id_warna = kb.id_warna where kode_bahan='$id'"));
$ip0=$qy['kode_bahan'];
$ip1=$qy['nama_supplier'];
$ip2=$qy['nama_jenis_bahan'];
$ip3=$qy['nama_warna'];
$ip4=$qy['id_supplier'];
$ip5=$qy['id_jenis_bahan'];
$ip6=$qy['id_warna'];
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Bahan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Edit Kode Bahan</h3>
        </div>
        <div class='card-body'>
		<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Bahan</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' id='typeInput' value='$ip0' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Supplier</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='supplier' style='width: 100%;' required>
                    <option value='$ip4'>$ip1</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='bahan' style='width: 100%;' required>
                    <option value='$ip5'>$ip2</option>
                    $pilih2
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Warna</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='warna' style='width: 100%;' required>
                    <option value='$ip6'>$ip3</option>
                    $pilih3
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                <a href='index.php?url=kode_bahan' class='btn btn-danger'>Keluar</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
";
?>          