<?php
$id=$_GET['id'];
$delete=$_GET['delete'];
$hapus=$_GET['hapus'];
$kode=$_POST['kode_komponen'];
$qty=$_POST['qty'];
$simpan=$_POST['simpan'];
if($delete!=""){
    mysqli_query($koneksi,"delete from detail_komposisi where id_detail_komposisi='$delete'");
    header("location:index.php?url=".encrypt_url('komposisi_komponen')."&id=$id");
}
if($hapus!=""){
    mysqli_query($koneksi,"delete from detail_komposisi where id_komposisi='$id'");
    mysqli_query($koneksi,"delete from komposisi where kode_komposisi='$id'");
    header("location:index.php?url=".encrypt_url('komposisi')."");
}
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM detail_komposisi WHERE kode_komponen = '$kode' AND id_komposisi='$id'");
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Komponen sudah digunakan. Silakan gunakan Komponen lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into detail_komposisi(kode_komponen,qty,id_komposisi)values('$kode','$qty','$id')");
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
$s=mysqli_query($koneksi,"SELECT 
  detail_komposisi.*,
  komponen.nama_komponen,
  komponen.berat_komponen,
  (detail_komposisi.qty * komponen.berat_komponen) AS total_berat_komponen
FROM 
  detail_komposisi
JOIN 
  komponen 
ON 
  detail_komposisi.kode_komponen = komponen.code_komponen WHERE id_komposisi='$id'
");
while($data=mysqli_fetch_array($s)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['kode_komponen']}</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['qty']}</td>
			<td class=''>{$data['total_berat_komponen']} Gr</td>
			<td class=''><a href='index.php?url=".encrypt_url('komposisi_komponen')."&id=$id&delete={$data['id_detail_komposisi']}'><i class='fa fa-trash'></i></a></td>
		</tr>
	";
}
$si=mysqli_query($koneksi,"SELECT * FROM komponen,type WHERE komponen.id_type=type.id_type");
while($data=mysqli_fetch_array($si)){
	$pilih.="
		<option value='{$data['code_komponen']}'>{$data['code_komponen']} | {$data['nama_komponen']} | {$data['type']}</option>
	";
}
$d=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM komposisi,barang_jadi WHERE komposisi.kode_barang_jadi=barang_jadi.kode_barang and kode_komposisi='$id'"));
$ip0=$d["kode_komposisi"];
$ip1="{$d['kode_barang_jadi']} | {$d['karakter']} | {$d['kunci']}";
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Assembly</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Assembly Barang Jadi</h3>
        </div>
        <div class='card-body'>
		<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Assembly</label>
                <div class='col-sm-3'>
                <input type='text' name='kode' class='form-control' value='$ip0' required readonly>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang Jadi</label>
                <div class='col-sm-5'>
                <input type='text' name='barang' class='form-control' value='$ip1' required readonly>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Komponen</label>
                <div class='col-sm-5'>
                <select class='form-control select2' name='kode_komponen' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Qty</label>
                <div class='col-sm-2'>
                <input type='text' name='qty' class='form-control' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='simpan' class='btn btn-success' value='Masukan'>
                <a href='index.php?url=".encrypt_url('komposisi')."' class='btn btn-primary'>Selesai</a>
                <a href='index.php?url=".encrypt_url('komposisi_komponen')."&id=$id&hapus=ada' class='btn btn-danger'>Hapus</a>
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
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>Kode Komponen</th>
					          <th class='column-title'>Nama Komponen </th>
                    <th class='column-title'>Qty</th>
                    <th class='column-title'>Total Berat Komponen (Gr)</th>
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