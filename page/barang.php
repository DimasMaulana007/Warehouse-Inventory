<?php

$qy=mysqli_query($koneksi,"SELECT 
  barang_jadi.*,
  jenis_warna.*,
  type.type AS type_nama
FROM 
  barang_jadi 
JOIN 
  TYPE ON type.id_type = barang_jadi.type
  JOIN 
  jenis_warna ON jenis_warna.id_warna = barang_jadi.warna
");
while($data=mysqli_fetch_array($qy)){
  $hanger = strtolower(trim($data['hanger']));
  $type = $data['type_nama'];
  
  if ($hanger === 'non hanger' || $hanger === '') {
      // tidak menambah apa pun
  } else {
      $type .= " " . $data['hanger'];
  }
  
    $no++;
    $ket.="
      <tr class='even pointer text-center'>
        <td class=' '>$no</td>
        <td class=' '>{$data['kode_barang']}</td>
        <td class=' '>{$data['merk']}</td>
        <td class=' '>$type</td>
        <td class=' '>{$data['susun']}</td>
        <td class=' '>{$data['karakter']}</td>
        <td class=' '>{$data['kunci']}</td>
        <td class=' '>{$data['nama_warna']}</td>
        <td class=' '><a href='index.php?url=".encrypt_url('ebarang')."&id={$data['kode_barang']}'>Edit</a></td>
      </tr>
    ";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Barang Jadi</h1>
</section>
    <!-- Main content -->

<!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Barang Jadi</h3>
                <a href='index.php?url=".encrypt_url('tbarang_jadi')."' class='btn-sm btn-success float-right'>Tambah Kode Barang Jadi</a>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                  <th class=''>No</th>
                  <th class=''>Kode Barang</th>
                  <th class=''>Merk</th>
                  <th class=''>Type</th>
                  <th class=''>Susun</th>
                  <th class=''>Nama Produk</th>
                  <th class=''>Kunci</th>
                  <th class=''>Warna</th>
                  <th class=''>Opsi</th>
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