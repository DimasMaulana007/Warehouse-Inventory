<?php
$awal = isset($_GET['awal']) ? $_GET['awal'] : '';
$akhir = isset($_GET['akhir']) ? $_GET['akhir'] : '';

// Jika tombol submit diklik dan tanggal sudah diisi
if ( $awal != '' && $akhir != '') {
    $download = "<a href='page/stok&laporan/export_spbg_bahan_baku.php?awal=$awal&akhir=$akhir' class='btn btn-success'>Download</a>";
    $s=mysqli_query($koneksi,"SELECT
 spbg_bahan_baku.*,
 spbg_bahan_baku.jumlah as ambil,
 detail_bahan_utama.*,
 detail_bahan_utama.kode_bahan AS id
FROM spbg_bahan_baku
JOIN detail_bahan_utama ON detail_bahan_utama.id_detail_bahan_utama=spbg_bahan_baku.kode_bahan where spbg_bahan_baku.cek='sudah'");
    while($data=mysqli_fetch_array($s)){
    $no++;
    $sisa=number_format($data['ambil'], 0, ',', '.');
    $jumlah=number_format($data['sisa'], 0, ',', '.');
    $ket.="
            <tr class='even pointer text-center'>
                <td class=''>$no</td>
                <td class=''>{$data['tanggal']}</td>
                <td class=''>{$data['no_spbg']}</td>
                <td class=''>{$data['id']}</td>
                <td class=''>$sisa Kg</td>
                <td class=''>$jumlah Kg</td>
                <td class=''>{$data['keterangan']}</td>
            </tr>
	";}
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
        <h1>Laporan SPBG Bahan Baku</h1>
    </div>
</section>

<section class='content'>
    <div class='container-fluid'>
        <form method='get' class='form-horizontal' id='quickForm'>
            <input type='hidden' name='url' value='laporan_spbg_bahan_baku'> <!-- supaya routing tetap -->
            <div class='card card-default'>
                <div class='card-header'>
                    <h3 class='card-title'>Laporan SPBG bahan Baku</h3>
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
                <h3 class='card-title'>Data SPBG Bahan Baku</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center' style='background-color: #8BC34A'>
                        <th class='column-title'>No</th>
						<th class='column-title'>Tanggal</th>
						<th class='column-title'>No SPBG</th>
						<th class='column-title'>Kode Bahan</th>
						<th class='column-title'>Jumlah</th>
                        <th class='column-title'>Sisa Stok Digudang</th>
						<th class='column-title' colspan='2'>Keterangan</th>
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