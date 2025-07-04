<?php
$id=$_GET['id'];
$spbg=$_POST['spbg'];
$tgl=$_POST['tgl'];
$nama=$_POST['nama'];
$qty=$_POST['qty'];
$keterangan=$_POST['keterangan'];
$simpan=$_POST['simpan'];
if($id!=""){
  $sdanb="<a href='index.php?url=spbg_bahan_baku' class='btn btn-success'>Simpan</a>";
}else{
  mysqli_query($koneksi,"update spbg_bahan_baku set cek='sudah'");
}
if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM detail_bahan_utama WHERE id_detail_bahan_utama = '$nama'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($qty <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $sisa=$stokTersedia-$qty;
      $query=mysqli_query($koneksi,"insert into spbg_bahan_baku(no_spbg,tanggal,kode_bahan,jumlah,sisa,keterangan)
        values('$spbg','$tgl','$nama','$qty','$sisa','$keterangan')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE detail_bahan_utama SET jumlah = jumlah - '$qty' WHERE id_detail_bahan_utama = '$nama'");
          header("location:index.php?url=spbg_bahan_baku&id=ada");
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $qty Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
  }
}
$kd=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama
");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_bahan']} | {$data_kode['jenis_bahan']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT 
 detail_bahan_utama.kode_bahan AS id,
 detail_bahan_utama.nama_bahan,
 detail_bahan_utama.jenis_bahan,
 jenis_warna.nama_warna,
 spbg_bahan_baku.*
FROM spbg_bahan_baku
JOIN detail_bahan_utama ON detail_bahan_utama.id_detail_bahan_utama=spbg_bahan_baku.kode_bahan
JOIN jenis_warna ON jenis_warna.id_warna=detail_bahan_utama.warna
WHERE spbg_bahan_baku.cek='belum'");
while($data=mysqli_fetch_array($s)){
	$ambil=floatval($data['qty_ambil']);
  $hasil1=floatval($data['hasil']);
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['no_spbg']}</td>
			<td class=''>{$data['id']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
      <td class=''>{$data['jumlah']}</td>
      <td class=''>{$data['keterangan']}</td>
			<td class=' last'><a href='index.php?url=recycle&id=$id&delete={$data['id_spbg']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from spbg_bahan_baku where id_spbg='$delete'"));
    $ambil1=floatval($tata['jumlah']);
    $ambil2=$tata['kode_bahan'];
    mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah+'$ambil1' where kode_bahan='$ambil2'");
	mysqli_query($koneksi,"delete from proses_recycle where id_proses='$delete'");
	header("location:index.php?url=spbg_bahan_baku&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Ambil Bahan Hasil Recycle</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Ambil Bahan Hasil Recycle</h3>
        </div>
        <div class='card-body'>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No SPBG</label>
                <div class='col-sm-3'>
                <input type='text' name='spbg' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='nama' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jumlah Ambil</label>
                <div class='col-sm-2'>
                <input type='text' name='qty' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Keterangan</label>
                <div class='col-sm-2'>
                <input type='text' name='keterangan' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Ambil'>
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
                <h3 class='card-title'>Data </h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped' id='example2'>
                  <thead>
                  <tr class='text-center'>
                  <th class='column-title'>Tanggal</th>
                  <th class='column-title'>No SPBG</th>
                  <th class='column-title'>Kode Bahan</th>
                  <th class='column-title'>Nama Bahan</th>
                  <th class='column-title'>Jenis Bahan</th>
                  <th class='column-title'>Jumlah Ambil</th>
                  <th class='column-title'>Keterangan</th>
                  <th class='column-title'>Opsi</th>
                </tr>
                  </thead>
                  <tbody>
                  $ket
                  </tfoot>
                </table><br>
                $sdanb
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>