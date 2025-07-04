<?php
$tgl=$_POST['tgl'];
$sj=$_POST['sj'];
$kode=$_POST['kode'];
$qty=$_POST['qty'];
$simpan=$_POST['simpan'];

if ($simpan) {
 
      $query=mysqli_query($koneksi,"insert into pendukung_masuk(surat_jalan,tanggal,id_pendukung,qty)
        values('$sj','$tgl','$kode','$qty')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE kode_komponen_pendukung SET jumlah = jumlah + '$qty' WHERE id_pendukung = '$kode'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
}
$kd=mysqli_query($koneksi,"SELECT * 
FROM kode_komponen_pendukung");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_pendukung']}'>{$data_kode['id_pendukung']} | {$data_kode['nama_barang']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT kkp.*,pm.*
FROM pendukung_masuk pm
JOIN kode_komponen_pendukung kkp ON kkp.id_pendukung=pm.id_pendukung
WHERE pm.cek='belum'");
while($data=mysqli_fetch_array($s)){
    $simpan="<a href='index.php?url=komponen_pendukung&cek=ada' class='btn-sm btn-success float-right'>Simpan</a>";
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['id_pendukung']}</td>
			<td class=''>{$data['nama_barang']}</td>
			<td class=''>{$data['qty']}</td>
			<td class=' last'><a href='index.php?url=komponen_pendukung&delete={$data['id_masuk']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$cek=$_GET['cek'];
if($_GET['cek']!=""){
    mysqli_query($koneksi,"UPDATE pendukung_masuk SET cek='sudah'");
    header("location:index.php?url=komponen_pendukung");
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from pendukung_masuk where id_masuk='$delete'"));
    $ambil1=$tata['qty'];
    $ambil2=$tata['id_pendukung'];
    mysqli_query($koneksi,"update kode_komponen_pendukung set jumlah=jumlah-'$ambil1' where id_pendukung='$ambil2'");
	mysqli_query($koneksi,"delete from pendukung_masuk where id_masuk='$delete'");
	header("location:index.php?url=komponen_pendukung");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Komponen Pendukung Masuk</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Komponen Pendukung Masuk</h3>
        </div>
        <div class='card-body'>
        <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-2'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Surat Jalan</label>
                <div class='col-sm-2'>
                <input type='text' name='sj' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
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
                <h3 class='card-title'>Data</h3>
                $simpan
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Kode Barang</th>
                    <th class='column-title'>Nama Barang</th>
                    <th class='column-title'>Qty</th>
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