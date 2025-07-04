<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$bahan=$_POST['bahan'];
$berat=$_POST['berat'];
$hapus=$_GET['hapus'];
$simpan=$_POST['simpan'];
if($hapus != ""){
  $tata = mysqli_query($koneksi, "SELECT * FROM detail_pengiriman_bahan WHERE id_kirim = '$id'");
  while($at = mysqli_fetch_array($tata)){
    $ambil1 = $at['berat_kg'];
    $ambil2 = $at['bahan'];
    // Kembalikan stok bahan awal
    mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah + $ambil1 WHERE id_detail_bahan_utama = '$ambil2'");
  }
  // Hapus data proses
  mysqli_query($koneksi, "DELETE FROM detail_pengiriman_bahan WHERE id_kirim = '$id'");
  mysqli_query($koneksi, "DELETE FROM pengiriman_bahan_recycle WHERE id_kirim = '$id'");
  header("Location: index.php?url=kirim_bahan");
}

if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM detail_bahan_utama WHERE id_detail_bahan_utama = '$bahan'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($berat <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $query=mysqli_query($koneksi,"insert into detail_pengiriman_bahan(id_kirim,bahan,berat_kg)
        values('$id','$bahan','$berat')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - '$berat' WHERE id_detail_bahan_utama = '$bahan'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $berat Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
  }
}
$kd=mysqli_query($koneksi,"SELECT dbu.*,
    w.nama_warna
 FROM detail_bahan_utama dbu
JOIN jenis_warna w ON w.id_warna=dbu.warna
");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_detail_bahan_utama']}'> {$data_kode['kode_bahan']} | {$data_kode['nama_bahan']} | {$data_kode['nama_warna']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT
 pbr.*,
 dpb.*,
 c.nama_customer
FROM pengiriman_bahan_recycle pbr
JOIN detail_pengiriman_bahan dpb ON dpb.id_kirim=pbr.id_kirim
JOIN customer c ON c.id_customer=pbr.customer
WHERE pbr.id_kirim='$id'");
while($data=mysqli_fetch_array($s)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
            <td class=''>{$data['nama_customer']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['berat_kg']}</td>
			<td class=' last'><a href='index.php?url=detail_kirim&id=$id&delete={$data['id_detail']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from detail_pengiriman_bahan where id_detail='$delete'"));
    $ambil1=floatval($tata['berat_kg']);
    $ambil2=$tata['bahan'];
    mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah+'$ambil1' where id_detail_bahan_utama='$ambil2'");
	mysqli_query($koneksi,"delete from detail_pengiriman_bahan where id_detail='$delete'");
	header("location:index.php?url=detail_kirim&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kirim Bahan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kirim Bahan</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Bahan</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Berat Kg</label>
                <div class='col-sm-2'>
                <input type='text' name='pakai' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Kirim'>
				<a href='index.php?url=proses_recycle' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=recycle&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Kirim Bahan</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Customer</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Kirim Berat(Kg)</th>
                    <th class='column-title'>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                  $ket
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>