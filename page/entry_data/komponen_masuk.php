<?php
$tgl=$_POST['tgl'];
$sj=$_POST['sj'];
$s=$_POST['s'];
$kode=$_POST['kode'];
$qty=$_POST['qty'];
$simpan=$_POST['simpan'];
if ($simpan) {
 
      $query=mysqli_query($koneksi,"insert into pendukung_masuk(surat_jalan,tanggal,supplier,code_komponen,qty)
        values('$sj','$tgl','$s','$kode','$qty')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE komponen SET jumlah_ok = jumlah_ok + '$qty' WHERE code_komponen = '$kode'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
}
$kd=mysqli_query($koneksi,"SELECT k.*, jw.nama_warna
FROM komponen k
JOIN jenis_warna jw ON jw.id_warna=k.warna");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['code_komponen']}'>{$data_kode['code_komponen']} | {$data_kode['nama_komponen']} | {$data_kode['nama_warna']}</option>
	"; 
}
$s=mysqli_query($koneksi,"SELECT km.*,k.nama_komponen,jw.nama_warna
FROM komponen_masuk km
JOIN komponen k ON k.code_komponen=km.code_komponen
JOIN jenis_warna jw ON jw.id_warna=k.warna
WHERE km.cek='belum'");
while($data=mysqli_fetch_array($s)){
    $simpan="<a href='index.php?url=komponen_masuk&cek=ada' class='btn-sm btn-success float-right'>Simpan</a>";
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['surat_jalan']}</td>
			<td class=''>{$data['supplier']}</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>{$data['qty']}</td>
			<td class=' last'><a href='index.php?url=komponen_masuk&delete={$data['id_masuk']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$cek=$_GET['cek'];
if($_GET['cek']!=""){
    mysqli_query($koneksi,"UPDATE komponen_masuk SET cek='sudah'");
    header("location:index.php?url=komponen_masuk");
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from komponen_masuk where id_masuk='$delete'"));
    $ambil1=$tata['qty'];
    $ambil2=$tata['code_komponen'];
    mysqli_query($koneksi,"update komponen set jumlah_ok=jumlah_ok-'$ambil1' where code_komponen='$ambil2'");
	mysqli_query($koneksi,"delete from komponen_masuk where id_masuk='$delete'");
	header("location:index.php?url=komponen_masuk");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Komponen Masuk</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Komponen Masuk</h3>
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
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Supplier</label>
                <div class='col-sm-2'>
                <input type='text' name='s' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Komponen</label>
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
                    <th class='column-title'>Tanggal</th>
                    <th class='column-title'>Surat Jalan</th>
                    <th class='column-title'>Nama Komponen</th>
                    <th class='column-title'>Warna</th>
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
