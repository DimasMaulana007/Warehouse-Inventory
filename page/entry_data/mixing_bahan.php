
<?php
$tanggal=$_POST['tgl'];
$star=$_POST['star'];
$end=$_POST['end'];
$kode=$_POST['kode'];
$jumlah=$_POST['jumlah'];
$keterangan=$_POST['keterangan'];
$test=$_POST['tes'];

if($test)
{
		$rand=rand(0,1000000000);
        header("location:index.php?url=detail_mixing&id=$rand");
		$query=mysqli_query($koneksi,"insert into mixing_master(id_mixing,tanggal,star,end,kode_bahan,hasil,keterangan)
        values('$rand','$tanggal','$star','$end','$kode','$jumlah','$keterangan')");
}
$kd=mysqli_query($koneksi,"SELECT * 
FROM detail_bahan_utama dbu
JOIN jenis_warna jw ON jw.id_warna = dbu.warna
");
while($data_kode=mysqli_fetch_array($kd)){
	$pilih.="
	<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_bahan']} | {$data_kode['nama_warna']}</option>
";
}
$qy=mysqli_query($koneksi,"SELECT
 mm.*,
 dbu.*,
 jw.nama_warna
FROM mixing_master mm
JOIN detail_bahan_utama dbu 
  ON dbu.id_detail_bahan_utama = mm.kode_bahan
join jenis_warna jw
  on jw.id_warna=dbu.warna
ORDER BY mm.id_mixing DESC
LIMIT 1");
while($data=mysqli_fetch_array($qy)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
      <td class=''>{$data['kode_bahan']}</td>
      <td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>{$data['hasil']}</td>
			<td class=''>{$data['keterangan']}</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Proses Mixing</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Proses Mixing</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Pembuatan Bahan</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' id='tanggalInput' required>
                </div>
            </div>
            <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Mulai</label>
            <div class='col-sm-3 input-group date' id='jamPicker' data-target-input='nearest'>
              <input type='text' name='star' class='form-control datetimepicker-input' data-target='#jamPicker'/>
              <div class='input-group-append' data-target='#jamPicker' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-2 offset-sm-2 col-form-label'>Jam Selesai</label>
            <div class='col-sm-3 input-group date' id='jamPicker1' data-target-input='nearest'>
              <input type='text' name='end' class='form-control datetimepicker-input' data-target='#jamPicker1'/>
              <div class='input-group-append' data-target='#jamPicker1' data-toggle='datetimepicker'>
                <div class='input-group-text'><i class='far fa-clock'></i></div>
              </div>
            </div>
          </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Hasil Bahan Mixing</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Jumlah</label>
                <div class='col-sm-3'>
                <input type='text' name='jumlah' class='form-control' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Keterangan</label>
                <div class='col-sm-3'>
                <textarea class='form-control' name='keterangan'></textarea>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='tes' class='btn btn-success' value='Tambahkan Bahan'>
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
                <h3 class='card-title'>Input Terakhir Kali</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center' style='background-color: rgb(126, 228, 128);'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Qty</th>
                    <th class='column-title'>Keterangan</th>
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