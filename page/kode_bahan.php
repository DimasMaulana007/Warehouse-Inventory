<?php
$kode=$_POST['kode'];
$supplier=$_POST['supplier'];
$bahan=$_POST['bahan'];
$warna=$_POST['warna'];
$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM kode_bahan WHERE kode_bahan = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kode_bahan(kode_bahan,id_supplier,id_jenis_bahan,id_warna)values('$kode','$supplier','$bahan','$warna')");
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
$s1=mysqli_query($koneksi,"SELECT * FROM supplier");
while($data=mysqli_fetch_array($s1)){
	$pilih.="<option value='{$data['id_supplier']}'>{$data['nama_supplier']}</option>
	";
}
$s2=mysqli_query($koneksi,"SELECT * FROM jenis_bahan");
while($data=mysqli_fetch_array($s2)){
	$pilih2.="<option value='{$data['id_jenis_bahan']}'>{$data['nama_jenis_bahan']}</option>
	";
}
$s3=mysqli_query($koneksi,"SELECT * FROM jenis_warna");
while($data=mysqli_fetch_array($s3)){
	$pilih3.="<option value='{$data['id_warna']}'>{$data['nama_warna']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT *
FROM 
    kode_bahan kb
JOIN 
    supplier s ON s.id_supplier = kb.id_supplier
JOIN
    jenis_bahan jb ON jb.id_jenis_bahan=kb.id_jenis_bahan
JOIN 
    jenis_warna jw ON jw.id_warna = kb.id_warna
");
if($id!=""){
    mysqli_query($koneksi,"delete from kode_bahan where kode_bahan='$id'");
    header("location:index.php?url=".encrypt_url('kode_bahan')."");
}
while($data=mysqli_fetch_array($s)){
	$no++;
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
            <td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>".explode(' ', $data['nama_jenis_bahan'])[0]."</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''><a href='index.php?url=".encrypt_url('ekode_bahan')."&id={$data['kode_bahan']}'>Edit</a></td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Bahan Baku</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Bahan Baku</h3>
        </div>
        <div class='card-body'>
		<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Bahan</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Supplier</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='supplier' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Bahan Baku</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='bahan' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih2
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Warna</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='warna' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih3
                </select>
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
                <h3 class='card-title'>Data Kode Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Bahan</th>
					<th class='column-title'>Nama Supplier </th>
                    <th class='column-title'>Jenis Bahan Baku</th>
					<th class='column-title'>Nama Bahan Baku</th>
					<th class='column-title'>Warna</th>
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