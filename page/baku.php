<?php
$produk=$_POST['nama_komponen'];
$simpan=$_POST['simpan'];
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM detail_bahan_utama WHERE nama_bahan = '$produk'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into detail_bahan_utama(nama_bahan)values('$produk')");
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
$s=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama");
while($data=mysqli_fetch_array($s)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class='last'><a href='index.php?url=".encrypt_url('ebaku')."&id={$data['id_detail_bahan_utama']}'>Edit</a></td>
		</tr>
	";
}

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Jenis Bahan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Jenis Bahan</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Bahan</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_komponen' class='form-control' id='typeInput' required>
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
                <h3 class='card-title'>Data Jenis Bahan</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Nama Bahan</th>
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