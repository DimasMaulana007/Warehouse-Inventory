
<?php
$tgl=$_POST['tgl'];
$customer=$_POST['customer'];
$supir=$_POST['supir'];
$polis=$_POST['polis'];
$keterangan=$_POST['keterangan'];
$simpan=$_POST['buat'];

if($simpan)
{
		$rand=rand(0,1000000000);
        header("location:index.php?url=detail_kirim&id=$rand");
		$query=mysqli_query($koneksi,"insert into pengiriman_bahan_recycle(id_kirim,tanggal_kirim,customer,nama_supir,plat,keterangan)
        values('$rand','$tgl','$customer','$supir','$polis','$keterangan')");
}
$qy=mysqli_query($koneksi,"SELECT
 pbr.*,
 dpb.*,
 c.nama_customer
FROM pengiriman_bahan_recycle pbr
JOIN detail_pengiriman_bahan dpb ON dpb.id_kirim=pbr.id_kirim
JOIN customer c ON c.id_customer=pbr.customer
ORDER BY pbr.id_kirim DESC
LIMIT 1;");
while($data=mysqli_fetch_array($qy)){
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal_kirim']}</td>
            <td class=''>{$data['customer']}</td>
            <td class=''>{$data['nama_supir']}</td>
			<td class=''>{$data['plat']}</td>
		</tr>
	";
}
$kd=mysqli_query($koneksi,"SELECT * FROM
customer");
while($data_kode=mysqli_fetch_array($kd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_customer']}'>{$data_kode['nama_customer']} | {$data_kode['alamat']}</option>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kirim bahan</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kirim bahan</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Pengririman</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' id='tanggalInput' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Customer</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='customer' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Nama Supir</label>
                <div class='col-sm-3'>
                <input type='text' name='supir' class='form-control' id='tanggalInput' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Polisi</label>
                <div class='col-sm-3'>
                <input type='text' name='polis' class='form-control' id='tanggalInput' required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Keterangan</label>
                <div class='col-sm-4'>
                <textarea class='form-control' name='keterangan'></textarea>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='buat' class='btn btn-success' value='Masukan Barang'>
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
                    <th class='column-title'>Customer</th>
                    <th class='column-title'>Nama Supir</th>
                    <th class='column-title'>Plat No</th>
                    <th class='column-title'>Stop</th>
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