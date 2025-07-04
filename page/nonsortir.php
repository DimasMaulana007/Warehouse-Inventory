<?php
$id=$_GET['id'];
$shift=$_POST['shift'];
$jamm=$_POST['jam_m'];
$jams=$_POST['jam_s'];
$kode=$_POST['kode'];
$pakai=$_POST['pakai'];
$hasil=$_POST['hasil'];
$qty=$_POST['qty'];
$delete=$_GET['delete'];
$hapus=$_GET['hapus'];
$simpan=$_POST['simpan'];

if($hapus!=""){
	mysqli_query($koneksi,"delete from proses_crusher where id_tanggal='$id'");
	mysqli_query($koneksi,"delete from tanggal_proses_crusher where id_tanggal_crusher='$id'");
	header("location:index.php?url=proses_recycle");
}
if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM kode_bahan WHERE kode_bahan = '$kode'"));
  $stokTersedia = floatval($cekStok['jumlah']); // Gunakan floatval untuk memastikan angka
  // Cek apakah bahan_dipakai melebihi stok
  if ($pakai <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $query=mysqli_query($koneksi,"insert into proses_recycle(id_tanggal_proses,shift,jam_mulai,jam_selesai,code_bahan,nama_hasil_sortir,sortir,hasil)
      values('$id','$shift','$jamm','$jams','$kode','$pakai','$hasil','$qty')");
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
$kd=mysqli_query($koneksi,"SELECT
jenis_warna.nama_warna,
jenis_bahan.*,
supplier.nama_supplier,
kode_bahan.kode_bahan
FROM kode_bahan
JOIN jenis_bahan ON jenis_bahan.id_jenis_bahan=kode_bahan.id_jenis_bahan
JOIN jenis_warna ON jenis_warna.id_warna=kode_bahan.id_warna
JOIN supplier ON supplier.id_supplier=kode_bahan.id_supplier");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['kode_bahan']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_supplier']} | {$data_kode['nama_jenis_bahan']}</option>
	";
}
$kdm=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama");
while($data_kode=mysqli_fetch_array($kdm)){
	//$tes_kode=['kode_bahan'];
	$pilih1.="
		<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['nama_bahan']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT *
FROM proses_crusher
JOIN tanggal_proses_crusher 
  ON proses_crusher.id_tanggal = tanggal_proses_crusher.id_tanggal_crusher
JOIN kode_bahan 
  ON proses_crusher.code_bahan = kode_bahan.kode_bahan
JOIN supplier 
  ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan 
  ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna 
  ON kode_bahan.id_warna = jenis_warna.id_warna");
while($data=mysqli_fetch_array($s)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['code_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['operator']}</td>
			<td class=''>{$data['bahan_dipakai']} Kg</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['total_hasil']} Kg</td>
			<td class=' last'><a href='index.php?url=proses_sortir&id=$id&delete={$data['id_proses_crusher']}'><i class='fa-solid fa-trash btn'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
	mysqli_query($koneksi,"delete from proses_sortir where id_proses_sortir='$delete'");
	header("location:index.php?url=proses_bahan&id=$id");
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
                <div class='col-sm-3'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Bahan Pakai</label>
                <div class='col-sm-3'>
                <input type='text' name='pakai' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>hasil Recycle</label>
                <div class='col-sm-3'>
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
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=proses_bahan' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=proses_sortir&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
                </div>
            </div>
            $ket	
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
						<th class='column-title'>Kode Bahan</th>
						<th class='column-title'>Supplier</th>
						<th class='column-title'>Jenis Bahan</th>
						<th class='column-title'>Warna</th>
						<th class='column-title'>Operator</th>
						<th class='column-title'>Pakai Bahan(Kg)</th>
						<th class='column-title'>Hasil Sortir</th>
						<th class='column-title'>Jumlah Sortir</th>
						<th class='column-title'>Opsi</th>
				  </tr>
                  </thead>
                  <tbody>
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