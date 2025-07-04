<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
$kategori=$_POST['kategori'];
$ud=$_POST['ud'];
$ul=$_POST['ul'];
$spek=$_POST['spek'];
$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM kode_komponen_pendukung WHERE id_pendukung = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kode_komponen_pendukung(id_pendukung,nama_barang,jenis_bahan,kategori,ukuran_dalam,
        ukuran_luar,spek)values('$kode','$nama','$jenis','$kategori','$ud','$ul','$spek')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$s=mysqli_query($koneksi,"SELECT * FROM kode_komponen_pendukung");
while($data=mysqli_fetch_array($s)){
	$no++;
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
            <td class=''>{$data['id_pendukung']}</td>
			<td class=''>{$data['nama_barang']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
			<td class=''>{$data['kategori']}</td>
			<td class=''><a href=''>View</a> <a href='index.php?url=".encrypt_url('ependukung')."&id={$data['id_pendukung']}'>Edit</a></td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Komponen Pendukung</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Komponen Pendukung</h3>
        </div>
        <div class='card-body'>
		
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Barang</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control' name='jenis' style='width: 100%;' required>
                    <option>---pilih---</option>
					<option>KARTON</option>
                    <option>STICKER</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kategori</label>
                <div class='col-sm-3'>
                <select class='form-control' name='kategori' style='width: 100%;' required>
                    <option>---pilih---</option>
					<option>Master Box</option>
                    <option>Inner Box</option>
                    <option>Sticker</option>
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Ukuran Dalam</label>
                <div class='col-sm-2'>
                <input type='text' name='ud' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Ukuran Luar</label>
                <div class='col-sm-2'>
                <input type='text' name='ul' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Spek</label>
                <div class='col-sm-2'>
                <input type='text' name='spek' class='form-control' required>
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
                <h3 class='card-title'>Data Komponen Pendukung</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Barang</th>
					<th class='column-title'>Nama Barang </th>
                    <th class='column-title'>Jenis Bahan</th>
					<th class='column-title'>Kategori</th>
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