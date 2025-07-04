<?php
$qy=mysqli_query($koneksi,"SELECT 
    ka.*,
    -- Subquery stok awal
    (
        IFNULL((
            SELECT SUM(masuk) FROM atk_masuk 
            WHERE id_atk = ka.kode_atk AND tanggal < '2025-05-01'
        ), 0)
        -
        IFNULL((
            SELECT SUM(keluar) FROM atk_keluar 
            WHERE id_atk = ka.kode_atk AND tanggal < '2025-05-01'
        ), 0)
    ) AS stok_awal,

    -- Total masuk selama periode
    IFNULL(SUM(CASE WHEN am.tanggal >= '2025-05-01' THEN am.masuk ELSE 0 END), 0) AS total_masuk,

    -- Total keluar selama periode
    IFNULL(SUM(CASE WHEN ak.tanggal >= '2025-05-01' THEN ak.keluar ELSE 0 END), 0) AS total_keluar,

    -- Total stok akhir = stok awal + masuk - keluar
    (
        IFNULL((
            SELECT SUM(masuk) FROM atk_masuk 
            WHERE id_atk = ka.kode_atk AND tanggal < '2025-05-01'
        ), 0)
        -
        IFNULL((
            SELECT SUM(keluar) FROM atk_keluar 
            WHERE id_atk = ka.kode_atk AND tanggal < '2025-05-01'
        ), 0)
        +
        IFNULL(SUM(CASE WHEN am.tanggal >= '2025-05-01' THEN am.masuk ELSE 0 END), 0)
        -
        IFNULL(SUM(CASE WHEN ak.tanggal >= '2025-05-01' THEN ak.keluar ELSE 0 END), 0)
    ) AS total_stok

FROM kode_atk ka
LEFT JOIN atk_masuk am ON am.id_atk = ka.kode_atk
LEFT JOIN atk_keluar ak ON ak.id_atk = ka.kode_atk
GROUP BY ka.kode_atk, ka.nama_barang;

");
while($data=mysqli_fetch_array($qy)){
    $no++;
    $ket.="
      <tr class='even pointer text-center'>
        <td class=' '>$no</td>
        <td class=' '>{$data['kode_atk']}</td>
        <td class=' '>{$data['nama_barang']}</td>
        <td class=' '>{$data['uraian']}</td>
        <td class=' '>{$data['stok_awal']} Pcs</td>
        <td class=' '>{$data['total_masuk']} Pcs</td>
        <td class=' '>{$data['total_keluar']} Pcs</td>
        <td class=' '>{$data['total_stok']} Pcs</td>
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
                <a href='index.php?url=atk_tambah' class='btn-sm btn-success float-right'>Tambah Kode ATK</a>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                  <th class=''>No</th>
                  <th class=''>Kode Barang</th>
                  <th class=''>Nama Barang</th>
                  <th class=''>Uraian</th>
                  <th class=''>Stok Awal</th>
                  <th class=''>Barang Masuk</th>
                  <th class=''>Barang Keluar</th>
                  <th class=''>Stok Akhir</th>
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