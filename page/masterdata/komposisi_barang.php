<?php
$kode=$_POST['kode'];
$barang=$_POST['barang'];
$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM komposisi WHERE kode_barang = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into komposisi(kode_barang)values('$kode')");
		if($query)
		{
			header("location:index.php?url=komposisi_komponen&id=$kode");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$s1=mysqli_query($koneksi,"SELECT 
  barang_jadi.*,
  jenis_warna.*,
  type.type AS type_nama
FROM 
  barang_jadi 
JOIN 
  TYPE ON type.id_type = barang_jadi.type
  JOIN 
  jenis_warna ON jenis_warna.id_warna = barang_jadi.warna");
while($data=mysqli_fetch_array($s1)){
	$pilih.="<option value='{$data['kode_barang']}'>{$data['kode_barang']} | {$data['type_nama']}-{$data['hanger']} | {$data['kunci']} | {$data['karakter']}</option>
	";
}
$s=mysqli_query($koneksi,"SELECT 
  barang_jadi.*,
  komposisi_barang.*,
  type.type AS nama
FROM 
  komposisi_barang 
JOIN 
  barang_jadi ON barang_jadi.kode_barang = komposisi_barang.kode_barrang
JOIN
  TYPE ON type.id_type=barang_jadi.type");
while($data=mysqli_fetch_array($s)){
	$no++;
  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
      <td class=''>{$data['kode_barang']}</td>
			<td class=''>{$data['karakter']}</td>
			<td class=''>{$data['nama']}-{$data['hanger']}</td>
			<td class=''>{$data['susun']}</td>
			<td class='project-actions text-center'><a class='btn btn-primary btn-sm' href='index.php?url=detail_komposisi&id={$data['id_kom']}'><i class='fas fa-folder'></i>Detail</a>
      <a class='btn btn-info btn-sm' href='index.php?url=ekomposisi&id={$data['kode_komposisi']}'><i class='fas fa-pencil-alt'></i>Edit</a>
      </td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kode Komposisi</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Kode Komposisi</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang Jadi</label>
                <div class='col-sm-6'>
                <select class='form-control select2' name='kode' style='width: 100%;' required>
                    <option>--Pilih--</option>
                    $pilih
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				        <input type='submit' name='simpan' class='btn btn-success' value='Mulai Input Komponen'>
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
                <h3 class='card-title'>Data Barang Jadi</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
                    <th class='column-title'>Kode Barang</th>
					          <th class='column-title'>Nama Barang Jadi</th>
                    <th class='column-title'>Type Lemari</th>
                    <th class='column-title'>Susun</th>
                    <th class='text-center'>Opsi</th>
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