<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$kode=$_POST['kode'];
$pakai=$_POST['pakai'];
$delete=$_GET['delete'];
$hapus=$_GET['hapus'];
$simpan=$_POST['simpan'];
if($hapus != ""){
  $tata = mysqli_query($koneksi, "SELECT * FROM mixing_detail WHERE id_mixing='$id'");
  while($at = mysqli_fetch_assoc($tata)){
    $ambil1 = $at['berat'];
    $ambil2 = $at['bahan'];
    // Kembalikan stok bahan awal
    mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - $ambil2 WHERE id_detail_bahan_utama = '$ambil1'");
  }
  $tata1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mixing_master WHERE id_mixing='$id'"));
  $ambi3 = $tata1['hasil'];
  $ambi4 = $tata1['kode_bahan'];
  mysqli_query($koneksi,"UPDATE detail_bahan_utama SET jumlah=jumlah-$ambi3 WHERE id_detail_bahan_utama='$ambi4'");
  // Hapus data proses
  mysqli_query($koneksi, "DELETE FROM mixing_detail WHERE id_mixing = '$id'");
  mysqli_query($koneksi, "DELETE FROM mixing_master WHERE id_mixing = '$id'");
  header("Location: index.php?url=b");
}

if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM detail_bahan_utama WHERE id_detail_bahan_utama = '$kode'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($pakai <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $blod = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mixing_master WHERE id_mixing='$id'"));
      $percent=$pakai/$blod['hasil']*100;
      $query=mysqli_query($koneksi,"insert into mixing_detail(id_mixing,bahan,berat,percent)
        values('$id','$kode','$pakai','$percent')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah - '$pakai' WHERE kode_bahan = '$kode'");
          mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah + '$qty' WHERE id_detail_bahan_utama = '$hasil'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $pakai Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
  }
}
$kd=mysqli_query($koneksi,"SELECT * 
FROM detail_bahan_utama dbu
JOIN jenis_warna jw ON jw.id_warna = dbu.warna
");
while($data_kode=mysqli_fetch_array($kd)){
	$pilih.="
	<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_bahan']} | {$data_kode['nama_warna']}</option>";
}
$s=mysqli_query($koneksi,"SELECT
 mm.*,
 md.*,
 dbu.*,
 jw.nama_warna
FROM mixing_master mm
JOIN mixing_detail md
  ON md.id_mixing = mm.id_mixing
JOIN detail_bahan_utama dbu 
  ON dbu.id_detail_bahan_utama = md.bahan
JOIN jenis_warna jw ON jw.id_warna = dbu.warna
WHERE mm.id_mixing='$id'");
while($data=mysqli_fetch_array($s)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
            <td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>{$data['berat']}</td>
			<td class=''>{$data['percent']}</td>
			<td class=''><a href='index.php?url=detail_mixing&id=$id&delete={$data['id_detail']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from mixing_detail where id_detail='$delete'"));
    $ambil1=$tata['berat'];
    $ambil2=$tata['bahan'];
    mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah+'$ambil1' where kode_bahan='$ambil2'");
	mysqli_query($koneksi,"delete from detail_mixing where id_detail='$delete'");
	header("location:index.php?url=detail_mixing&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Proses Mixing</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Proses Mixing</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Pilih Bahan</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Bahan Dipakai</label>
                <div class='col-sm-3'>
                <input type='text' name='pakai' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=proses_recycle' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=detail_mixing&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                <h3 class='card-title'>Data Bahan Mixing</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Percent</th>
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