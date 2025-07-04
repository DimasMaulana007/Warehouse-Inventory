<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$regu=$_POST['regu'];
$shift=$_POST['shift'];
$jamm=$_POST['jam_m'];
$jams=$_POST['jam_s'];
$kode=$_POST['kode'];
$pakai=$_POST['pakai'];
$hasil=$_POST['hasil'];
$sortir=$_POST['sortir'];
$bekuan=$_POST['bekuan'];
$saringan=$_POST['saringan'];
$qty=$_POST['qty'];
$susut=$pakai-$qty-$bekuan-$saringan;
$delete=$_GET['delete'];
$hapus=$_GET['hapus'];
$simpan=$_POST['simpan'];
if($hapus != ""){
  $tata = mysqli_query($koneksi, "SELECT * FROM proses_recycle WHERE id_tanggal_proses = '$id'");
  while($at = mysqli_fetch_array($tata)){
    $ambil1 = floatval($at['qty_ambil']);
    $ambil2 = $at['kode_bahan'];
    $ambil3 = floatval($at['hasil']);
    $ambil4 = $at['id_detail_bahan_utama'];

    // Kembalikan stok bahan awal
    mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah + $ambil1 WHERE kode_bahan = '$ambil2'");
    mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - $ambil3 WHERE id_detail_bahan_utama = '$ambil4'");
  }
  // Hapus data proses
  mysqli_query($koneksi, "DELETE FROM proses_recycle WHERE id_tanggal_proses = '$id'");
  mysqli_query($koneksi, "DELETE FROM tanggal_proses_recycle WHERE id_proses = '$id'");
  header("Location: index.php?url=".encrypt_url('proses_recycle')."");
}

if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM kode_bahan WHERE kode_bahan = '$kode'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($pakai <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      
      $query=mysqli_query($koneksi,"insert into proses_recycle(id_tanggal_proses,line,shift,sortir,jam_mulai,jam_selesai,kode_bahan,qty_ambil,id_detail_bahan_utama,hasil,bekuan,saringan,susut)
        values('$id','$regu','$shift','$sortir','$jamm','$jams','$kode','$pakai','$hasil','$qty','$bekuan','$saringan','$susut')");
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
FROM kode_bahan
JOIN supplier ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna ON jenis_warna.id_warna = kode_bahan.id_warna");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['kode_bahan']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_supplier']} | {$data_kode['nama_jenis_bahan']} | {$data_kode['nama_warna']} </option>
	";
}
$kd=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama
");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih1.="
		<option value='{$data_kode['id_detail_bahan_utama']}'> {$data_kode['kode_bahan']} | {$data_kode['nama_bahan']} | {$data_kode['jenis_bahan']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT
 proses_recycle.*,
 tanggal_proses_recycle.tanggal,
 kode_bahan.kode_bahan,
 supplier.nama_supplier,
 jenis_bahan.*,
 jenis_warna.nama_warna,
 detail_bahan_utama.*
FROM proses_recycle
JOIN tanggal_proses_recycle 
  ON proses_recycle.id_tanggal_proses = tanggal_proses_recycle.id_proses
JOIN kode_bahan 
  ON proses_recycle.kode_bahan = kode_bahan.kode_bahan
JOIN supplier 
  ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan 
  ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna 
  ON kode_bahan.id_warna = jenis_warna.id_warna
JOIN detail_bahan_utama
  ON detail_bahan_utama.id_detail_bahan_utama=proses_recycle.id_detail_bahan_utama
WHERE proses_recycle.id_tanggal_proses='$id'");
while($data=mysqli_fetch_array($s)){
	$ambil=floatval($data['qty_ambil']);
  $hasil1=floatval($data['hasil']);
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['line']}</td>
			<td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>$ambil Kg</td>
			<td class=''>{$data['nama_bahan']}</td>
      <td class=''>$hasil1 Kg</td>
			<td class=' last'><a href='index.php?url=".encrypt_url('recycle')."&id=$id&delete={$data['id_proses']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from proses_recycle where id_proses='$delete'"));
    $ambil1=floatval($tata['qty_ambil']);
    $ambil2=$tata['kode_bahan'];
    $ambil3=floatval($tata['hasil']);
    $ambil4=$tata['id_detail_bahan_utama'];
    mysqli_query($koneksi,"update kode_bahan set jumlah=jumlah+'$ambil1' where kode_bahan='$ambil2'");
    mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah-'$ambil3' where id_detail_bahan_utama='$ambil4'");
	mysqli_query($koneksi,"delete from proses_recycle where id_proses='$delete'");
	header("location:index.php?url=".encrypt_url('recycle')."&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Proses Recycle</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Proses Recycle</h3>
        </div>
        <div class='card-body'>
        <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Regu</label>
                <div class='col-sm-2'>
                <select class='form-control' name='regu' style='width: 100%;' id='typeInput' required>
                    <option>A</option>
                    <option>B</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Shift</label>
                <div class='col-sm-2'>
                <select class='form-control' name='shift' style='width: 100%;' id='typeInput' required>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
                </div>
            </div>
            
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Sortir</label>
                <div class='col-sm-2'>
                <select class='form-control' name='sortir' style='width: 100%;' required>
                    <option>Sortir</option>
                    <option>Non-Sortir</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Mulai</label>
            <div class='col-sm-3 input-group date' id='jamPicker' data-target-input='nearest'>
              <input type='text' name='jam_m' class='form-control datetimepicker-input' data-target='#jamPicker'/>
              <div class='input-group-append' data-target='#jamPicker' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Selesai</label>
            <div class='col-sm-3 input-group date' id='jamPicker1' data-target-input='nearest'>
              <input type='text' name='jam_s' class='form-control datetimepicker-input' data-target='#jamPicker1'/>
              <div class='input-group-append' data-target='#jamPicker1' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Bahan</label>
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
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>hasil Recycle</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='hasil' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih1
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Qty</label>
                <div class='col-sm-2'>
                <input type='text' name='qty' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Bekuan</label>
                <div class='col-sm-2'>
                <input type='text' name='bekuan' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Saringan</label>
                <div class='col-sm-2'>
                <input type='text' name='saringan' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=".encrypt_url('proses_recycle')."' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=".encrypt_url('recycle')."&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                <h3 class='card-title'>Data Recycle</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Regu</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Hasil Recycle</th>
                    <th class='column-title'>Hasil Hasil</th>
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