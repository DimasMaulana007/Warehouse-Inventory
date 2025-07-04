<?php
$id=$_GET['id'];
$hapus=$_GET['hapus'];
$shift=$_POST['shift'];
$mulai=$_POST['mulai'];
$selesai=$_POST['selesai'];
$cav=$_POST['cav'];
$nama=$_POST['nama'];
$komponen=$_POST['kode_komponen'];
$mesin=$_POST['kode_mesin'];  
$baku=$_POST['bahan_baku'];
$ok=$_POST['ok'];
$ng=$_POST['ng'];
$keterangan=$_POST['keterangan'];
$masuk=$_POST['simpan'];
if($hapus!=""){
  $tat = mysqli_query($koneksi, "SELECT * FROM proses_komponen WHERE tgl = '$id'");
  while($at = mysqli_fetch_array($tat)){
    $ambil2 = $at['code_komponen'];
    // Kembalikan stok bahan awal
    mysqli_query($koneksi, "UPDATE komponen SET jumlah_ok=jumlah_ok-{$at['produksi_ok']},jumlah_ng=jumlah_ng-{$at['produksi_ng']} WHERE code_komponen = '$ambil2'");
  }
    mysqli_query($koneksi,"delete from proses_komponen where tgl='$id'");
    mysqli_query($koneksi,"delete from tanggal_komponen where id_tgl='$id'");
    header("location:index.php?url=".encrypt_url('tanggal_komponen')."");
}
if($masuk)
{
		$query=mysqli_query($koneksi,"insert into proses_komponen(tgl,shift,jam_mulai,jam_selesai,nama_operator,
		kode_mesin,code_komponen,produksi_ok,produksi_ng,cavity,keterangan)
		values('$id','$shift','$mulai','$selesai','$nama','$mesin','$komponen','$ok','$ng','$cav','$keterangan')");
		if($query)
		{
      mysqli_query($koneksi,"update komponen set jumlah_ok=jumlah_ok+'$ok',jumlah_ng=jumlah_ng+'$ng' where code_komponen='$komponen'");
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
  }
$jj=mysqli_query($koneksi,"SELECT * FROM mesin WHERE lokasi='PRODUKSI INJECT'");
while($d=mysqli_fetch_array($jj)){
	$pilih.="
        <option value='{$d['code_mesin']}'>{$d['code_mesin']} | {$d['nama_mesin']}</option>
	";
}
$jl=mysqli_query($koneksi,"SELECT k.*,jw.nama_warna,t.type
FROM komponen k
JOIN jenis_warna jw ON jw.id_warna=k.warna
JOIN type t ON t.id_type=k.id_type");
while($s=mysqli_fetch_array($jl)){
	$pilih1.="
        <option value='{$s['code_komponen']}'>{$s['nama_komponen']} | {$s['nama_warna']} | {$s['type']}</option>
	";
}
$qy=mysqli_query($koneksi,"SELECT
    proses_komponen.*,
    tanggal_komponen.*,
    mesin.nama_mesin,
    komponen.nama_komponen
    FROM proses_komponen
    JOIN tanggal_komponen ON tanggal_komponen.id_tgl=proses_komponen.tgl
    JOIN mesin ON mesin.code_mesin=proses_komponen.kode_mesin
    JOIN komponen ON komponen.code_komponen=proses_komponen.code_komponen AND tgl='$id'");
while($data=mysqli_fetch_array($qy)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['jam_mulai']}</td>
			<td class=''>{$data['jam_selesai']}</td>
			<td class=''>{$data['nama_operator']}</td>
			<td class=''>{$data['nama_mesin']}</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['produksi_ok']} Pcs</td>
			<td class=''>{$data['produksi_ng']} Pcs</td>
			<td class=''><a href='index.php?url=".encrypt_url('komponen')."&id=$id&delete={$data['id_proses']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$delete=$_GET['delete'];
if($delete!=""){
  $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from proses_komponen where id_proses='$delete'"));
    $ambil1=floatval($tata['produksi_ok']);
    $ambil2=floatval($tata['produksi_ng']);
    $ambil3=$tata['code_komponen'];
    mysqli_query($koneksi,"update komponen set jumlah_ok=jumlah_ok-'$ambil1',jumlah_ng=jumlah_ng-'$ambil2' where code_komponen='$ambil3'");
    mysqli_query($koneksi,"delete from proses_komponen where id_proses='$delete'");
    header("location:index.php?url=".encrypt_url('komponen')."&id=$id");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Input Injection Komponen</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Input Injection Komponen</h3>
        </div>
        <div class='card-body'>
        <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Shift</label>
                <div class='col-sm-2'>
                <select class='form-control' name='shift' style='width: 100%;' required>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Operator</label>
                <div class='col-sm-3'>
                <input type='text' name='nama' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Mulai</label>
            <div class='col-sm-3 input-group date' id='jamPicker' data-target-input='nearest'>
              <input type='text' name='mulai' class='form-control datetimepicker-input' data-target='#jamPicker'/>
              <div class='input-group-append' data-target='#jamPicker' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Selesai</label>
            <div class='col-sm-3 input-group date' id='jamPicker1' data-target-input='nearest'>
              <input type='text' name='selesai' class='form-control datetimepicker-input' data-target='#jamPicker1'/>
              <div class='input-group-append' data-target='#jamPicker1' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
          <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Cavity</label>
                <div class='col-sm-1'>
                <input type='text' name='cav' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Mesin</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='kode_mesin' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Komponen</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode_komponen' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih1
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Produk OK</label>
                <div class='col-sm-2'>
                <input type='text' name='ok' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Produk NG</label>
                <div class='col-sm-2'>
                <input type='text' name='ng' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Keterangan</label>
                <div class='col-sm-4'>
                <textarea class='form-control' name='keterangan' required></textarea>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=".encrypt_url('tanggal_komponen')."' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=".encrypt_url('komponen')."&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                    <th>Tanggal </th>
                    <th class='column-title'>Jam Mulai </th>
                    <th class='column-title'>Jam Selesai </th>
                    <th class='column-title'>Nama Operator</th>
                    <th class='column-title'>Nama Mesin</th>
                    <th class='column-title'>Nama Komponen</th>
                    <th class='column-title'>Produksi Ok</th>
                    <th class='column-title'>Produksi NG</th>
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
