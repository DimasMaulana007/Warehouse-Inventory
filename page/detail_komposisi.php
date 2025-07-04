<?php
$id=$_GET['id'];
$s=mysqli_query($koneksi,"SELECT 
  detail_komposisi.*,
  komponen.*,
  barang_jadi.*,
  komposisi_barang.*
FROM 
  komposisi_barang
JOIN
  detail_komposisi
ON
 detail_komposisi.id_kom  = komposisi_barang.id_kom
JOIN 
  komponen 
ON 
  detail_komposisi.kode_komponen = komponen.code_komponen
JOIN
  barang_jadi
ON
  barang_jadi.kode_barang = komposisi_barang.kode_barrang WHERE komposisi_barang.id_kom='$id'
");
while($data=mysqli_fetch_array($s)){
	$no++;
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>$no</td>
			<td class=''>{$data['nama_komponen']}</td>
			<td class=''>{$data['qty']}</td>
			<td class=''>{$data['total_berat_komponen']} Gr</td>
		</tr>
	";
}
$ambil=mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
detail_komposisi.*,
komponen.*,
barang_jadi.*,
type.type AS nama,
(detail_komposisi.qty * komponen.berat_komponen) AS total_berat_komponen,
komposisi_barang.*
FROM 
komposisi_barang
JOIN
detail_komposisi
ON
detail_komposisi.id_kom = komposisi_barang.id_kom
JOIN 
komponen 
ON 
detail_komposisi.kode_komponen = komponen.code_komponen
JOIN
barang_jadi
ON
barang_jadi.kode_barang = komposisi_barang.kode_barrang 
JOIN 
TYPE 
ON 
type.id_type = barang_jadi.type WHERE komposisi_barang.id_kom='$id'
"));
$nama_barang=$ambil['karakter'];
$nama="{$ambil['nama']} | {$ambil['hanger']} | {$ambil['kunci']}";
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Produk dan Komponen</h1>
</section>
    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Nama Barang Jadi : $nama_barang </h3> <a href='index.php?url=".encrypt_url('komposisi_barang')."' class='btn btn-lg btn-danger float-right'>Keluar</a><br>
                <h3 class='card-title'>Type Lemari : $nama</h3>
                
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example2' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='column-title'>No</th>
					<th class='column-title'>Nama Komponen </th>
                    <th class='column-title'>Qty</th>
                    <th class='column-title'>Total Berat Komponen (Gr)</th>
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