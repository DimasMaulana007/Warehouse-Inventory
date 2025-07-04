<?php
$tgl=$_POST['tgl'];
$bahan=$_POST['bahan'];
$ambil=$_POST['ambil'];
$simpan=$_POST['simpan'];

if($simpan) {
    $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM detail_bahan_utama WHERE id_detail_bahan_utama = '$bahan'"));
    $stokTersedia = $cekStok['jumlah'];
    // Cek apakah bahan_dipakai melebihi stok
    if ($ambil <= $stokTersedia) {
        // Lanjut insert ke proses_crusher
          $query = mysqli_query($koneksi,"INSERT INTO bahan_utama_keluar(id_detail_bahan_utama,keluar,tanggal)
            VALUES('$bahan','$ambil','$tgl')");
          if ($query) {
            // Update stok di kode_bahan
            mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - '$ambil' WHERE id_detail_bahan_utama = '$bahan'");
            $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
        } else {
            $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
        }
    } else {
        $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $ambil Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
    }
    
}
$kd=mysqli_query($koneksi,"select * from detail_bahan_utama");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_detail_bahan_utama']}'> {$data_kode['nama_bahan']}</option>
	";
}

$isi="
           <section class='content-header'>
    <div class='container-fluid'>
	<h1>Form Pengambilan Bahan Baku</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Form Pengambilan Bahan Baku</h3>
        </div>
        <div class='card-body'>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='bahan' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Ambil Bahan</label>
                <div class='col-sm-3'>
                <input type='text' name='ambil' class='form-control' required>
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
    $ket
    </div>
</section>
";
?>