<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$kode=$_POST['kode'];
$jml=$_POST['jml'];
$keterangan=$_POST['ket'];
$hapus=$_GET['hapus'];
$simpan=$_POST['simpan'];
if($hapus != ""){
  $tata = mysqli_query($koneksi, "SELECT * FROM surat_jalan_detail WHERE id_detail = '$id'");
  while($at = mysqli_fetch_array($tata)){
    $ambil1 = $at['jumlah'];
    $ambil2 = $at['kode_barang'];
    // Kembalikan stok bahan awal
    mysqli_query($koneksi, "UPDATE barang_jadi SET jumlah = jumlah + $ambil1 WHERE kode_barang = '$ambil2'");
  }
  // Hapus data proses
  mysqli_query($koneksi, "DELETE FROM surat_jalan_detail WHERE id_surat = '$id'");
  mysqli_query($koneksi, "DELETE FROM surat_jalan WHERE id_surat = '$id'");
  header("Location: index.php?url=kirim_barang");
}

if ($simpan) {
  // Ambil stok dari tabel kode_bahan
  $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM barang_jadi WHERE kode_barang = '$kode'"));
  $stokTersedia = $cekStok['jumlah'];
  // Cek apakah bahan_dipakai melebihi stok
  if ($jml <= $stokTersedia) {
      // Lanjut insert ke proses_crusher
      $query=mysqli_query($koneksi,"insert into surat_jalan_detail(id_surat,kode_barang,jumlah,keterangan)
        values('$id','$kode','$jml','$keterangan')");
      if ($query) {
          // Update stok di kode_bahan
          mysqli_query($koneksi, "UPDATE barang_jadi SET jumlah = jumlah - '$jml' WHERE kode_barang = '$kode'");
          $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
      } else {
          $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
      }
  } else {
      $ket = "<div class='alert alert-danger'>Gagal: Bahan diambil $jml Pcs melebihi stok yang tersedia $stokTersedia Pcs</div>";
  }
}
$kd=mysqli_query($koneksi,"SELECT 
    t.type AS nama,
    bj.*
 FROM barang_jadi bj
JOIN TYPE t ON t.id_type=bj.type
");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['kode_barang']}'>{$data_kode['kode_barang']} | {$data_kode['merk']}-{$data_kode['nama']} | 
    SSN{$data_kode['susun']} | {$data_kode['karakter']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT 
    sjd.id_surat,
    sjd.kode_barang,
    sjd.keterangan,
    sjd.jumlah AS ambil,
    t.type AS nama,
    bj.*
 FROM surat_jalan_detail sjd
JOIN surat_jalan sj ON sj.id_surat=sjd.id_surat
JOIN barang_jadi bj ON bj.kode_barang=sjd.kode_barang
JOIN TYPE t ON t.id_type=bj.type
WHERE sjd.id_surat='$id'");
while($data=mysqli_fetch_array($s)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['no_surat']}</td>
			<td class=''>{$data['karakter']}</td>
			<td class=''>{$data['merk']}-{$data['nama']}</td>
			<td class=''>SSN{$data['susun']}</td>
			<td class=''>{$data['ambil']}</td>
			<td class=''>{$data['keterangan']}</td>
			<td class=' last'><a href='index.php?url=detail_kiri_barangm&id=$id&delete={$data['id_detail']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from surat_jalan_detail where id_detail='$delete'"));
    $ambil1=$tata['jumlah'];
    $ambil2=$tata['kode_barang'];
    mysqli_query($koneksi,"update barang_jadi set jumlah=jumlah+'$ambil1' where kode_barang='$ambil2'");
	mysqli_query($koneksi,"delete from surat_jalan_detail where id_detail='$delete'");
	header("location:index.php?url=detail_kirim_barang&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kirim Produk</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kirim Produk</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Produk</label>
                <div class='col-sm-5'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jumlah</label>
                <div class='col-sm-2'>
                <input type='text' name='jml' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Keterangan</label>
                <div class='col-sm-3'>
                <textarea class='form-control' name='ket' required></textarea>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
                <input type='submit' name='simpan' class='btn btn-success' value='Kirim'>
                <a href='index.php?url=kirim_barang' type='button' class='btn btn-primary'>Selesai</a>
                <a href='index.php?url=detail_kirim_barang&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                    <th class='column-title'>No SJ</th>
                    <th class='column-title'>Nama Produk</th>
                    <th class='column-title'>Merk</th>
                    <th class='column-title'>Susun</th>
                    <th class='column-title'>Jumlah</th>
                    <th class='column-title'>Keterangan</th>
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