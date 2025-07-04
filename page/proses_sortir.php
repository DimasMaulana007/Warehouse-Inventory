<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$kode=$_POST['kode'];
$opt=$_POST['opt'];
$pakai=$_POST['pakai'];
$nama=$_POST['nama'];
$total=$_POST['total'];
$test=$_POST['tes'];
$delete=$_GET['delete'];
$hapus=$_GET['hapus'];
if($hapus!=""){
  $tata1 = mysqli_query($koneksi, "SELECT * FROM proses_crusher WHERE id_tanggal = '$id'");
  while($at = mysqli_fetch_array($tata1)){
    $ambil1 = floatval($at['total_hasil']);
    $ambil2 = $at['bahan_crusher'];
    $ambil3 = floatval($at['qty_pakai']);
    $ambil4 = $at['code_bahan'];

    // Kembalikan stok bahan awal
  mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah + $ambil1 WHERE kode_bahan = '$ambil2'");
  mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah - $ambil3 WHERE kode_bahan = '$ambil4'");
  }
	mysqli_query($koneksi,"delete from proses_crusher where id_tanggal='$id'");
	mysqli_query($koneksi,"delete from tanggal_proses_crusher where id_tanggal_crusher='$id'");
	header("location:index.php?url=".encrypt_url('proses_bahan')."");
}
if ($test) {
    // Ambil stok dari tabel kode_bahan
    $cekStok = mysqli_fetch_array(mysqli_query($koneksi, "SELECT jumlah FROM kode_bahan WHERE kode_bahan = '$kode'"));
    $stokTersedia = floatval($cekStok['jumlah']); // Gunakan floatval untuk memastikan angka
    // Cek apakah bahan_dipakai melebihi stok
    if ($pakai <= $stokTersedia) {
        // Lanjut insert ke proses_crusher
        $query = mysqli_query($koneksi, "INSERT INTO proses_crusher(id_tanggal,code_bahan,operator,qty_pakai,bahan_crusher,total_hasil)
        VALUES('$id', '$kode', '$opt', '$pakai', '$nama', '$total')");
        if ($query) {
            // Update stok di kode_bahan
            mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah - '$pakai' WHERE kode_bahan = '$kode'");
            mysqli_query($koneksi, "UPDATE kode_bahan SET jumlah = jumlah + '$total' WHERE kode_bahan = '$nama'");
            $ket = "<div class='alert alert-success'>Data berhasil disimpan dan stok telah diperbarui</div>";
        } else {
            $ket = "<div class='alert alert-danger'>Gagal menyimpan data: </div>". mysqli_error($koneksi);
        }
    } else {
        $ket = "<div class='alert alert-danger'>Gagal: Bahan dipakai $pakai Kg melebihi stok yang tersedia $stokTersedia Kg</div>";
    }
}
$kkd=mysqli_query($koneksi,"SELECT * 
FROM kode_bahan
JOIN supplier ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna ON jenis_warna.id_warna=kode_bahan.id_warna
WHERE kode_bahan.kode_bahan LIKE 'AC%'");
while($data_kode=mysqli_fetch_array($kkd)){
	//$tes_kode=['kode_bahan'];
	$pilih1.="
		<option value='{$data_kode['kode_bahan']}'>{$data_kode['kode_bahan']}|{$data_kode['nama_supplier']}|{$data_kode['nama_jenis_bahan']}|{$data_kode['nama_warna']}</option>
	";
}
$kk=mysqli_query($koneksi,"SELECT * 
FROM kode_bahan
JOIN supplier ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna ON jenis_warna.id_warna=kode_bahan.id_warna
WHERE kode_bahan.kode_bahan LIKE 'AL%';
");
while($data_kode=mysqli_fetch_array($kk)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['kode_bahan']}'>{$data_kode['kode_bahan']}|{$data_kode['nama_supplier']}|{$data_kode['nama_jenis_bahan']}|{$data_kode['nama_warna']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT 
  proses_crusher.*,
  tanggal_proses_crusher.tanggal,
  kb1.kode_bahan AS kode_bahan_asal,
  kb1.id_jenis_bahan,
  supplier.nama_supplier,
  jenis_bahan.nama_jenis_bahan,
  jenis_warna.nama_warna,
  kb2.kode_bahan AS kode_bahan_crusher,
  jb2.nama_jenis_bahan AS bahan_crusher
FROM proses_crusher
JOIN tanggal_proses_crusher ON proses_crusher.id_tanggal = tanggal_proses_crusher.id_tanggal_crusher
JOIN kode_bahan kb1 ON proses_crusher.code_bahan = kb1.kode_bahan
JOIN supplier ON kb1.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kb1.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna ON kb1.id_warna = jenis_warna.id_warna
LEFT JOIN kode_bahan kb2 ON proses_crusher.bahan_crusher = kb2.kode_bahan
LEFT JOIN jenis_bahan jb2 ON kb2.id_jenis_bahan = jb2.id_jenis_bahan
WHERE proses_crusher.id_tanggal='$id'");
while($data=mysqli_fetch_array($s)){
  $pakai1=floatval($data['qty_pakai']);
  $total1=floatval($data['total_hasil']);
  $hasil_bahan_crsuher=
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['code_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
      <td class=''>{$data['operator']}</td>
			<td class=''>$pakai1 Kg</td>
			<td class=''>{$data['bahan_crusher']}</td>
			<td class=''>$total1 Kg</td>
			<td class=' last'><a href='index.php?url=".encrypt_url('proses_sortir')."&id=$id&delete={$data['id_proses_crusher']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
    $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from proses_crusher where id_proses_crusher='$delete'"));
    $ambil1=floatval($tata['total_hasil']);
    $ambil2=$tata['bahan_crusher'];
    $ambil3=floatval($tata['qty_pakai']);
    $ambil4=$tata['code_bahan'];
    mysqli_query($koneksi,"update kode_bahan set jumlah=jumlah-'$ambil1' where kode_bahan='$ambil2'");
    mysqli_query($koneksi,"update kode_bahan set jumlah=jumlah+'$ambil3' where kode_bahan='$ambil4'");
    mysqli_query($koneksi,"delete from proses_crusher where id_proses_crusher='$delete'");
    header("location:index.php?url=".encrypt_url('proses_sortir')."&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Proses Crusher</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Proses Crusher</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Bahan</label>
                <div class='col-sm-5'>
                <select class='form-control select2' name='kode' style='width: 100%;' id='typeSelect' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Operator</label>
                <div class='col-sm-3'>
                <input type='text' name='opt' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Pakai Bahan</label>
                <div class='col-sm-3'>
                <input type='text' name='pakai' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama bahan</label>
                <div class='col-sm-5'>
                <select class='form-control select2' name='nama' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih1
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Total Bahan Sortir</label>
                <div class='col-sm-3'>
                <input type='text' name='total' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='tes' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=".encrypt_url('proses_bahan')."' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=".encrypt_url('proses_sortir')."&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                <h3 class='card-title'>Data Crusher</h3>
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
						<th class='column-title'>nama Hasil Sortir</th>
						<th class='column-title'>Jumlah Sortir</th>
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