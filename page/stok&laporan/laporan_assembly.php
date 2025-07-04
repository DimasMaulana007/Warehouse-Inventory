<?php
$awal = isset($_GET['awal']) ? $_GET['awal'] : '';
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';

// Jika tombol submit diklik dan tanggal sudah diisi
if ( $awal != '' && $akhir != '') {
    $download = "<a href='page/stok&laporan/export_komponen.php?awal=$awal&akhir=$akhir' class='btn btn-success'>Download</a>";
    $s=mysqli_query($koneksi,"SELECT 
    abj.*, 
    k.nama_komponen, 
    k.jumlah_ok,
    k.jumlah_ng,
    jw.nama_warna, 
    bj.*, 
    dk.*
FROM 
    barang_jadi bj
JOIN 
    detail_komposisi dk ON dk.kode_barang = bj.kode_barang
JOIN 
    assembly_barang_jadi abj ON abj.tanggal = dk.id_detail_komposisi
JOIN 
    komponen k ON k.code_komponen = dk.kode_komponen
JOIN 
    jenis_warna jw ON jw.id_warna = bj.warna
WHERE 
    abj.tanggal BETWEEN '$awal' AND '$akhir'
ORDER BY 
    abj.tanggal ASC;
");
    while($data=mysqli_fetch_array($s)){
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>{$data['merk']}</td>
                <td class=''>{$data['karakter']}</td>
                <td class=''>{$data['susun']}</td>
                <td class=''>{$data['kunci']}-{$data['hanger']}</td>
                <td class=''>{$data['nama_warna']}</td>
                <td class=''>{$data['jumlah']}</td>
            </tr>
	";
}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan Assembly</h1>
    </div>
</section>

<section class='content'>
    <div class='container-fluid'>
        <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_assembly'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan Assembly</h3>
                </div>
                <div class='card-body'>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Awal</label>
                        <div class='col-sm-3'>
                            <input type='date' name='awal' class='form-control' required value='$awal'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Akhir</label>
                        <div class='col-sm-3'>
                            <input type='date' name='akhir' class='form-control' required value='$akhir'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-5 offset-sm-4'>
                            <button type='submit' class='btn btn-primary'>Tampilkan</button>
                            $download
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
                <h3 class='card-title'>Data Barang</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                        <th class='column-title'>Tanggal </th>
						<th class='column-title'>Merk</th>
						<th class='column-title'>Karakter</th>
                        <th class='column-title'>Susun</th>
                        <th class='column-title'>Accesoris</th>
						<th class='column-title'>Warna</th>
						<th class='column-title'>Jumlah</th>
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