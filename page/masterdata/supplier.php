<?php
$nama=$_POST['supplier'];
$alamat=$_POST['alamat'];
$tlp=$_POST['tlp'];
$masuk=$_POST['entry'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM supplier WHERE nama_supplier = '$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into supplier(nama_supplier,alamat,no_tlp)values('$nama','$alamat','$tlp')");
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
$qy=mysqli_query($koneksi,"select * from supplier");
while($data=mysqli_fetch_array($qy)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
			<td class=' '>$no</td>
      <td class=' '>{$data['nama_supplier']}</td>
			<td class=' '>{$data['alamat']}</td>
      <td class=' '>{$data['no_tlp']}</td>
      <td class=' '><a href='index.php?url=esupplier&id={$data['id_supplier']}'>Edit</a></td>
			</td>
		</tr>
	";
}


$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Supplier</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Tambah Supplier</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Supplier</label>
                <div class='col-sm-3'>
                <input type='text' name='supplier' id='typeInput' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Alamat</label>
                <div class='col-sm-3'>
                <textarea class='form-control' rows='3' name='alamat'></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No. Tlp</label>
                <div class='col-sm-3'>
                <input type='text' name='tlp' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='entry' class='btn btn-success' value='Masukan'>
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
                <h3 class='card-title'>Data Supplier</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Nama Supplier</th>
					          <th class='column-title'>Alamat </th>
                    <th class='column-title'>No. Tlp</th>
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