<?php
$id=$_GET['id'];
$spbg=$_POST['spbg'];
$tgl=$_POST['tgl'];
$kode=$_POST['kode'];
$komponen=$_POST['komponen'];
$qty=$_POST['qty'];
$keterangan=$_POST['keterangan'];
$simpan=$_POST['simpan'];
if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah_ok,jumlah_ng FROM komponen WHERE code_komponen = '$kode'"));
  if ($komponen === 'OK') {
      $stokTersedia = $cekStok['jumlah_ok'];
  } elseif ($komponen === 'NG') {
      $stokTersedia = $cekStok['jumlah_ng'];
  } else {
    $stokTersedia = 0;
  }
  if ($qty <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $query=mysqli_query($koneksi,"insert into spbg_komponen(no_spbg,tanggal,kode_komponen,komponen,jumlah_ambil,keterangan)
        values('$spbg','$tgl','$kode','$komponen','$qty','$keterangan')");
      if ($query) {
          // Update stok di kode_bahan
          if ($komponen === 'OK') {
            mysqli_query($koneksi, "UPDATE komponen SET jumlah_ok = jumlah_ok - '$qty' WHERE code_komponen = '$kode'");
          }elseif ($komponen === 'NG') {
            mysqli_query($koneksi, "UPDATE komponen SET jumlah_ng = jumlah_ng - '$qty' WHERE code_komponen = '$kode'");
          }
          header("location:index.php?url=spbg_komponen&id=ada");
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Komponen yang diambil $qty  melebihi stok yang tersedia $stokTersedia</div>";
  }
}
$kd=mysqli_query($koneksi,"SELECT * FROM komponen
JOIN jenis_warna ON jenis_warna.id_warna=komponen.warna
");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['code_komponen']}'>{$data_kode['code_komponen']} | {$data_kode['nama_komponen']} | {$data_kode['nama_warna']}</option>";
}
$s=mysqli_query($koneksi,"SELECT * FROM spbg_komponen
JOIN komponen ON komponen.code_komponen=spbg_komponen.kode_komponen 
where spbg_komponen.ceklist='belum'");
while($data=mysqli_fetch_array($s)){
  $sdanb="<a href='index.php?url=spbg_komponen&id=ada' class='btn btn-success'>Simpan</a>";
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['no_spbg']}</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['bahan']}</td>
      <td class=''>{$data['komponen']}</td>
      <td class=''>{$data['jumlah_ambil']}</td>
      <td class=''>{$data['keterangan']}</td>
			<td class=''><a href='index.php?url=spbg_komponen&id=$id&delete={$data['id_spbg']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
if($_GET['id']!=""){
  mysqli_query($koneksi,"UPDATE spbg_komponen SET ceklist='sudah'");
  header("location:index.php?url=spbg_komponen");
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from spbg_komponen where id_spbg='$delete'"));
  if ($tata['komponen'] === 'OK') {
      $stokTersedia = $cekStok['jumlah_ok'];
      mysqli_query($koneksi, "UPDATE komponen SET jumlah_ok = jumlah_ok + {$tata['jumlah_ambil']} WHERE code_komponen = '{$tata['kode_komponen']}'");
  } elseif ($tata['komponen'] === 'NG') {
      mysqli_query($koneksi, "UPDATE komponen SET jumlah_ng = jumlah_ng + {$tata['jumlah_ambil']} WHERE code_komponen = '{$tata['kode_komponen']}'");
  }
  mysqli_query($koneksi,"delete from spbg_komponen where id_spbg='$delete'");
	header("location:index.php?url=spbg_komponen&id=ada");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Ambil Komponen</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Ambil Komponen</h3>
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
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Komponen</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Komponen</label>
                <div class='col-sm-2'>
                <select class='form-control' name='komponen' style='width: 100%;' required>
                    <option value='NG'>NG</option>
                    <option value='OK'>OK</option>
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
                <h3 class='card-title'>Data SPBG Komponen</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped' id='example2'>
                  <thead>
                  <tr class='text-center'>
                  <th class='column-title'>Tanggal</th>
                  <th class='column-title'>No SPBG</th>
                  <th class='column-title'>Nama Komponen</th>
                  <th class='column-title'>Jenis Bahan</th>
                  <th class='column-title'>Kondisi</th>
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