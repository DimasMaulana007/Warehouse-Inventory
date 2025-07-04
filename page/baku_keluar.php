<?php
$tgl=$_POST['tgl'];
$nama=$_POST['nama'];
$qty=$_POST['qty'];
$simpan=$_POST['simpan'];
$kkd=mysqli_query($koneksi,"select * from detail_bahan_utama");
while($data_kode=mysqli_fetch_array($kkd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['nama_bahan']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT 
 bahan_utama_keluar.*,
 detail_bahan_utama.nama_bahan,
 detail_bahan_utama.jumlah
FROM
 bahan_utama_keluar
JOIN detail_bahan_utama ON detail_bahan_utama.id_detail_bahan_utama=bahan_utama_keluar.id_detail_bahan_utama");
while($data=mysqli_fetch_array($s)){
    $no++;
	$ket1.="
	<tr class='text-center'>
        <td class=''>$no</td>
		<td class=''>{$data['tanggal']}</td>
		<td class=''>{$data['nama_bahan']}</td>
		<td class=''>{$data['keluar']} Kg</td>
		<td class=' '><a href='index.php?url=".encrypt_url('baku_keluar')."&id={$data['id_detail_bahan_utama']}'>Edit</a></td>
    </tr>
	";
}
if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM detail_bahan_utama WHERE id_detail_bahan_utama = '$nama'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($qty <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $query=mysqli_query($koneksi,"insert into bahan_utama_keluar(id_detail_bahan_utama,keluar,tanggal)
        values('$nama','$qty','$tgl')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - '$qty' WHERE id_detail_bahan_utama = '$nama'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $qty Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
  }
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Bahan Baku Keluar</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Bahan Baku Keluar</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-2'>
                <input type='date' name='tgl' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan Baku</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='nama' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jumlah Ambil</label>
                <div class='col-sm-3'>
                <input type='text' name='qty' class='form-control' required>
                </div>
            </div>
			
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
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
                <h3 class='card-title'>Bahan Lapak Masuk</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No </th>
					<th class='column-title'>Tanggal</th>
					<th class='column-title'>Nama Bahan</th>
					<th class='column-title'>Jumlah yang diambil</th>
                    <th class='column-title'>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                  $ket1
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