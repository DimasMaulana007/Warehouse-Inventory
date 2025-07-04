<?php

$qy=mysqli_query($koneksi,"SELECT 
sj.*,
c.nama_customer
FROM surat_jalan sj
JOIN customer c ON c.id_customer=sj.customer
WHERE STATUS='dikirim'
");
while($data=mysqli_fetch_array($qy)){
    $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['no_surat']}</td>
			<td class=''>{$data['sopir']}</td>
			<td class=''>{$data['kode_kendaraan']}</td>
			<td class=''>{$data['nama_customer']}</td>
			<td class=''>{$data['status']}</td>
            <td class=''><a href='index.php?url=detail_pengiriman&id={$data['id_surat']}' class='btn-sm btn-success'>Detail</a></td>
		</tr>
	";}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Data Pengiriman Barang</h1>
</section>
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Data Pengiriman Barang</h3>
                
              </div>
              <!-- /.card-header -->
              
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center' style='background-color: rgb(255, 255, 255);'>
                    <th class='column-title'>Tanggal</th>
					<th class='column-title'>No Surat</th>
                    <th class='column-title'>Supir</th>
                    <th class='column-title'>No Polisi</th>
                    <th class='column-title'>Nama Penerima</th>
                    <th class='column-title'>Status</th>
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