<?php
$kode=$_POST['code_komponen'];
$nama=$_POST['nama_komponen'];
$material=$_POST['material'];
$berat=$_POST['berat'];
$cycle=$_POST['cycle'];
$warna=$_POST['warna'];
$type=$_POST['type'];
$simpan=$_POST['simpan'];
$jj=mysqli_query($koneksi,"SELECT * FROM detail_bahan_utama");
while($d=mysqli_fetch_array($jj)){
	$pilih.="
        <option value='{$d['id_detail_bahan_utama']}'>{$d['nama_bahan']}</option>
	";
}
$j=mysqli_query($koneksi,"SELECT * FROM jenis_warna");
while($d=mysqli_fetch_array($j)){
	$pilih1.="
        <option value='{$d['id_warna']}'>{$d['nama_warna']}</option>
	";
}
$c=mysqli_query($koneksi,"SELECT * FROM type");
while($d=mysqli_fetch_array($c)){
	$pilih2.="
        <option value='{$d['id_type']}'>{$d['type']}</option>
	";
}
if ($simpan) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM komponen WHERE code_komponen = '$nama' AND nama_komponen='$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan Kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into komponen(code_komponen,nama_komponen,detail_bahan_utama,berat_komponen,cycle_time,warna,id_type)values('$kode','$nama','$material','$berat','$cycle','$warna','$type')");
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
$s=mysqli_query($koneksi,"SELECT *
FROM 
    komponen k
JOIN 
    detail_bahan_utama dbu ON dbu.id_detail_bahan_utama = k.detail_bahan_utama
JOIN
    type t ON t.id_type=k.id_type
JOIN 
    jenis_warna jw ON jw.id_warna = k.warna");
while($data=mysqli_fetch_array($s)){
	$no++;
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
            <td class=''>{$data['type']}</td>   
            <td class=''>{$data['code_komponen']}</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['berat_komponen']}</td>
			<td class=''>{$data['cycle_time']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''><a href='index.php?url=ekomponen&id={$data['code_komponen']}'>Edit</a></td>
		</tr>
	";
}

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Komponen</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Komponen</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='code_komponen' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='nama_komponen' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Type Lemari</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='type' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih2
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jenis Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='material' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Berat Komponen</label>
                <div class='col-sm-3'>
                <input type='text' name='berat' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Cycle Time</label>
                <div class='col-sm-3'>
                <input type='text' name='cycle' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Warna</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='warna' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih1
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
                <h3 class='card-title'>Data Komponen</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                        <th class=''>No</th>
                        <th class=''>Type Lemari</th>
                        <th class=''>Kode Komponen</th>
                        <th class=''>Nama Komponen</th>
						<th class=''>Jenis Bahan</th>
						<th class=''>Berat Komponen</th>
						<th class=''>Cycle Time</th>
						<th class=''>Warna</th>
						<th class=''>Opsi</th>
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