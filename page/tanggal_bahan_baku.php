<?php
$surat=$_POST['no_surat'];
$tanggal=$_POST['tgl'];
$plat=$_POST['plat'];
$supir=$_POST['supir'];
$simpan=$_POST['simpan'];

if($simpan)
{
		$rand=rand(0,1000000000);
		header("location:index.php?url=".encrypt_url('bahan_baku')."&id=$rand");
		$query=mysqli_query($koneksi,"insert into tanggal_bahan_lapak(id_tanggal,tanggal,no_surat,plat,supir)values('$rand','$tanggal','$surat','$plat','$supir')");
		
}
$qy=mysqli_query($koneksi,"SELECT
  tbl.*,
  kb.*,
  jw.nama_warna,
  jb.*,
  s.nama_supplier,
  bbl.*
FROM bahan_baku_lapak bbl
JOIN tanggal_bahan_lapak tbl ON tbl.id_tanggal = bbl.id_tanggal
JOIN kode_bahan kb ON kb.kode_bahan = bbl.kode_bahan
JOIN jenis_warna jw ON jw.id_warna = kb.id_warna
JOIN jenis_bahan jb ON jb.id_jenis_bahan = kb.id_jenis_bahan
JOIN supplier s ON s.id_supplier = kb.id_supplier
ORDER BY tbl.id_tanggal DESC
LIMIT 1;
");
while($data=mysqli_fetch_array($qy)){
    $qty_sj=number_format($data['qty_lapak'], 0, ',', '.');
    $qty_act=number_format($data['qty_pabrik'], 0, ',', '.');
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['no_surat']}</td>
			<td class=''>{$data['plat']}</td>
			<td class=''>{$data['supir']}</td>
			<td class=''>{$data['kode_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
            <td class=''>{$data['jenis_bahan']}</td>
            <td class=''>{$data['nama_jenis_bahan']}</td>
            <td class=''>$qty_sj Kg</td>
            <td class=''>$qty_act Kg</td>
		</tr>
	";}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Bahan Lapak Masuk</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Bahan Lapak Masuk</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-2'>
                <input type='date' name='tgl' class='form-control'  id='tanggalInput'  required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>No Surat</label>
                <div class='col-sm-4'>		
                <input type='text' name='no_surat' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Plat Mobil</label>
                <div class='col-sm-4'>
                <input type='text' name='plat' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Supir</label>
                <div class='col-sm-4'>
                <input type='text' name='supir' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-3'>
                <input type='submit' name='simpan' class='btn btn-success' value='Input Kode Bahan'>
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
                    <th class='column-title'>Tanggal</th>
					          <th class='column-title'>No Surat</th>
                    <th class='column-title'>No Polisi</th>
                    <th class='column-title'>Supir</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Nama Bahan</th>
                    <th class='column-title'>Qty Surat Jalan</th>
                    <th class='column-title'>Qty Actual</th>
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