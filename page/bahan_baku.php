<?php
$id=isset($_GET['id']) ? (int) $_GET['id'] : 0;
$kode=$_POST['kode_bahan'];
$qty_sj=$_POST['qty_sj'];
$qty_act=$_POST['qty_act'];
$masuk=$_POST['entry'];
$delete=$_GET['delete'];
$simpan=$_POST['simpan'];
$hapus=$_GET['hapus'];
if($simpan){
	header("location:index.php?url=".encrypt_url('tanggal_bahan_baku')."");
}

if($delete!=""){
    $tata=mysqli_fetch_array(mysqli_query($koneksi,"select * from bahan_baku_lapak where id_bahan_baku='$delete'"));
    $ambil1=$tata['qty_pabrik'];
    $ambil2=$tata['kode_bahan'];
    mysqli_query($koneksi,"update kode_bahan set jumlah=jumlah-'$ambil1' where kode_bahan='$ambil2'");
	mysqli_query($koneksi,"delete from bahan_baku_lapak where id_bahan_baku='$delete'");
	header("location:index.php?url=".encrypt_url('bahan_baku')."&id=$id");
}

$kkd=mysqli_query($koneksi,"SELECT * 
FROM kode_bahan
JOIN supplier ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
WHERE kode_bahan.kode_bahan LIKE 'AL%';
");
while($data_kode=mysqli_fetch_array($kkd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['kode_bahan']}'>{$data_kode['kode_bahan']} | {$data_kode['nama_supplier']} | {$data_kode['nama_jenis_bahan']}</option>
	";
}
$stmt = mysqli_prepare($koneksi, "SELECT * FROM tanggal_bahan_lapak WHERE id_tanggal = ?");
mysqli_stmt_bind_param($stmt, "i", $id); // "i" artinya integer
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$qy = mysqli_fetch_array($result);
$ip1=$qy['tanggal'];
$ip2=$qy['no_surat'];
$ip3=$qy['plat'];
$ip4=$qy['supir'];
$ip5=$qy['tipe_bahan'];

if ($hapus!="") {
    // Hapus dulu data dari bahan_baku yang tergantung pada tanggal itu
	mysqli_query($koneksi,"delete from bahan_baku_lapak where id_tanggal='$id'");
    mysqli_query($koneksi, "DELETE FROM tanggal_bahan_lapak WHERE id_tanggal = '$id'");
	header("location:index.php?url=".encrypt_url('tanggal_bahan_baku')."");
}


if($masuk)
{
		$query=mysqli_query($koneksi,"insert into bahan_baku_lapak(kode_bahan,lokasi,id_tanggal,qty_lapak,qty_pabrik)
        values('$kode','Mille','$id','$qty_sj','$qty_act')");
		if($query)
		{
            $ll=mysqli_fetch_array(mysqli_query($koneksi,"select * from kode_bahan where kode_bahan='$kode'"));
            $lll=$ll['jumlah']+$qty_sj;
            mysqli_query($koneksi,"update kode_bahan set jumlah='$lll' where kode_bahan='$kode'");
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}

$s=mysqli_query($koneksi,"SELECT * FROM bahan_baku_lapak,tanggal_bahan_lapak,kode_bahan,supplier,jenis_bahan,jenis_warna WHERE bahan_baku_lapak.id_tanggal=tanggal_bahan_lapak.id_tanggal AND
bahan_baku_lapak.kode_bahan=kode_bahan.kode_bahan AND kode_bahan.id_supplier=supplier.id_supplier AND
kode_bahan.id_jenis_bahan=jenis_bahan.id_jenis_bahan AND kode_bahan.id_warna=jenis_warna.id_warna and tanggal_bahan_lapak.id_tanggal='$id'");
while($data=mysqli_fetch_array($s)){
	$jenisUtama = explode(' ', $data['nama_jenis_bahan'])[0];
	$ket.="
	<tr class='text-center'>
        <td class=''>{$data['tanggal']}</td>
		<td class=''>{$data['no_surat']}</td>
		<td class=''>{$data['plat']}</td>
		<td class=''>{$data['supir']}</td>
		<td class=''>{$data['kode_bahan']}</td>
		<td class=''>{$data['nama_supplier']}</td>
		<td class=''>$jenisUtama</td>
		<td class=''>{$data['nama_jenis_bahan']}</td>
		<td class=''>{$data['nama_warna']}</td>
		<td class='a-right a-right '>{$data['qty_lapak']} Kg</td>
		<td class='a-right a-right '>{$data['qty_pabrik']} Kg</td>
		<td class=' '><a href='index.php?url=".encrypt_url('bahan_baku')."&id={$data['id_tanggal']}&delete={$data['id_bahan_baku']}'><i class='nav-icon fas fa-trash'></i></a></td>
    </tr>
	";
}
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
                <input type='text' name='tgl' class='form-control' value='$ip1' readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>No Surat</label>
                <div class='col-sm-4'>		
                <input type='text' name='no_surat' class='form-control' value='$ip2' readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Plat Mobil</label>
                <div class='col-sm-4'>
                <input type='text' name='plat' class='form-control' value='$ip3' readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Supir</label>
                <div class='col-sm-4'>
                <input type='text' name='supir' class='form-control' value='$ip4' readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label class='col-sm-1 offset-sm-2 col-form-label'>Kode Bahan</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode_bahan' style='width: 100%;' id='typeSelect' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Qty SJ</label>
                <div class='col-sm-3'>
                <input type='text' name='qty_sj' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-1 offset-sm-2 col-form-label'>Qty Act</label>
                <div class='col-sm-3'>
                <input type='text' name='qty_act' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-3'>
				<input type='submit' name='entry' class='btn btn-success' value='Masukan'>
				<a href='index.php?url=".encrypt_url('tanggal_bahan_baku')."' type='button' class='btn btn-primary'>Selesai</a>
				<a href='index.php?url=".encrypt_url('bahan_baku')."&id=$id&hapus=ada' type='button' class='btn btn-danger'>Hapus</a>
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
                <h3 class='card-title'>Bahan Lapak Masuk</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Tanggal </th>
					<th class='column-title'>NO. SJ/NO. SPBG </th>
					<th class='column-title'>No polisi</th>
					<th class='column-title'>Supir</th>
					<th class='column-title'>Code bahan</th>
					<th class='column-title'>Supplier</th>
					<th class='column-title'>Jenis Bahan</th>
					<th class='column-title'>Nama Barang</th>
					<th class='column-title'>Warna</th>
					<th class='column-title'>Qty SJ(Kg)</th>
					<th class='column-title'>Qty Act(Kg)</th>
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