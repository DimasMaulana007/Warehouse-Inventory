<?php
$spbg=$_POST['spbg'];
$tgl=$_POST['tgl'];
$bahan=$_POST['bahan'];
$supplier=$_POST['supplier'];
$qty_sj=$_POST['qty_sj'];
$qty_act=$_POST['qty_act'];
$masuk=$_POST['masuk'];
if ($masuk) {
		$query=mysqli_query($koneksi,"insert into bahan_baku_impor(no_spbg,tanggal,bahan,supplier,jumlah_sj,jumlah_act)
        values('$spbg','$tgl','$bahan','$supplier','$qty_sj','$qty_act')");
		if($query)
		{
            mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah+'$qty_act' where id_detail_bahan_utama='$bahan'");
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}
$a=mysqli_query($koneksi,"select * from detail_bahan_utama");
while($data=mysqli_fetch_array($a)){
	$kod.="
		<option value='{$data['id_detail_bahan_utama']}'>{$data['kode_bahan']} | {$data['nama_bahan']} | {$data['jenis_bahan']}</option>
	";
}
$b=mysqli_query($koneksi,"select * from supplier");
while($data=mysqli_fetch_array($b)){
	$sup.="
		<option value='{$data['id_supplier']}'>{$data['nama_supplier']}</option>
	";
}
$qy=mysqli_query($koneksi,"SELECT
    bbi.*,
    dbu.*,
    s.nama_supplier
    FROM bahan_baku_impor bbi
    JOIN detail_bahan_utama dbu ON dbu.id_detail_bahan_utama=bbi.bahan
    JOIN supplier s ON s.id_supplier=bbi.supplier
    WHERE bbi.cek='belum'");
while($data=mysqli_fetch_array($qy)){
    $no++;
    $sj=number_format($data['jumlah_sj'],0,',','.');
    $act=number_format($data['jumlah_act'],0,',','.');
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
            <td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['no_spbg']}</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>$sj Kg</td>
			<td class=''>$act Kg</td>
			<td class=''><a href='index.php?url=bahan_baku_impor&delete={$data['id_impor']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
    $tombol="<a href='index.php?url=bahan_baku_impor&simpan=ada' class='btn-sm btn-primary float-right'>Simpan</a>";
}
$delete=$_GET['delete'];
if($delete!=""){
    $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from bahan_baku_impor where id_impor='$delete'"));
    $ambil=$tata['bahan'];
    $ambil1=$tata['jumlah_act'];
    mysqli_query($koneksi,"update detail_bahan_utama set jumlah=jumlah-'$ambil1' where id_detail_bahan_utama='$ambil'");
    mysqli_query($koneksi,"delete from bahan_baku_impor where id_impor='$delete'");
    header("location:index.php?url=bahan_baku_impor");
}
$simpan=$_GET['simpan'];
if($simpan!=""){
    mysqli_query($koneksi,"update bahan_baku_impor set cek='sudah'");
    header("location:index.php?url=bahan_baku_impor");
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Bahan Baku Impor</h1>
</section>
    <section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Bahan Baku Impor</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>No Surat Jalan</label>
                <div class='col-sm-3'>
                <input type='text' name='spbg' class='form-control' id='typeInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Bahan</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='bahan' style='width: 100%;' required>
                    <option>---pilih---</option>
					$kod
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Supplier</label>
                <div class='col-sm-3'>
                <select class='form-control select2' name='supplier' style='width: 100%;' required>
                    <option>---pilih---</option>
					$sup
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Qty SJ</label>
                <div class='col-sm-3'>
                <input type='text' name='qty_sj' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Qty Act</label>
                <div class='col-sm-3'>
                <input type='text' name='qty_act' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='masuk' class='btn btn-success' value='Masukan'>
                </div>
            </div>	
        </div>
        </div>
	</form>
    </div>
</section>
<section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Bahan Baku Impor</h3>
                $tombol
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
						<th class='column-title'>No</th>
						<th class='column-title'>Tanggal</th>
						<th class='column-title'>No SPBG</th>
						<th class='column-title'>Nama Bahan</th>
						<th class='column-title'>Supplier</th>
						<th class='column-title'>Qty SJ</th>
						<th class='column-title'>Qty Act</th>
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