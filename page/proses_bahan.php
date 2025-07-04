
<?php
$tanggal=$_POST['tgl'];
$test=$_POST['tes'];

if($test)
{
		$rand=rand(0,1000000000);
		header("location:index.php?url=".encrypt_url('proses_sortir')."&id=$rand");
        $query=mysqli_query($koneksi,"insert into tanggal_proses_crusher(id_tanggal_crusher,tanggal)values('$rand','$tanggal')");
}
$qy=mysqli_query($koneksi,"SELECT 
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
ORDER BY tanggal_proses_crusher.id_tanggal_crusher DESC
LIMIT 1;
");
while($data=mysqli_fetch_array($qy)){
    $pakai1=number_format($data['qty_pakai'], 0, '.', ',');
    $total1=number_format($data['total_hasil'], 0, '.', ',');
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
          </tr>
      ";
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
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Crusher</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' id='tanggalInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='tes' class='btn btn-success' value='Buat Proses Crusher'>
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
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Operator</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Nama Bahan Sortir</th>
                    <th class='column-title'>Jumlah Sortir</th>
                  </tr>
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