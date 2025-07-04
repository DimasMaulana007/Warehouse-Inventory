
<?php
$tanggal=$_POST['tgl'];
$test=$_POST['tes'];

if($test)
{
		$rand=rand(0,1000000000);
        header("location:index.php?url=".encrypt_url('recycle')."&id=$rand");
		$query=mysqli_query($koneksi,"insert into tanggal_proses_recycle(id_proses,tanggal)values('$rand','$tanggal')");
}
$qy=mysqli_query($koneksi,"SELECT
 proses_recycle.*,
 tanggal_proses_recycle.tanggal,
 kode_bahan.kode_bahan as kod,
 supplier.nama_supplier,
 jenis_bahan.*,
 jenis_warna.nama_warna,
 detail_bahan_utama.*
FROM proses_recycle
JOIN tanggal_proses_recycle 
  ON proses_recycle.id_tanggal_proses = tanggal_proses_recycle.id_proses
JOIN kode_bahan 
  ON proses_recycle.kode_bahan = kode_bahan.kode_bahan
JOIN supplier 
  ON kode_bahan.id_supplier = supplier.id_supplier
JOIN jenis_bahan 
  ON kode_bahan.id_jenis_bahan = jenis_bahan.id_jenis_bahan
JOIN jenis_warna 
  ON kode_bahan.id_warna = jenis_warna.id_warna
JOIN detail_bahan_utama
  ON detail_bahan_utama.id_detail_bahan_utama=proses_recycle.id_detail_bahan_utama
ORDER BY tanggal_proses_recycle.id_proses DESC
LIMIT 1;");
while($data=mysqli_fetch_array($qy)){
  $ambil=number_format($data['qty_ambil'], 0, ',', '.');
  $hasil1=number_format($data['hasil'], 0, ',', '.');
  $jam_mulai = substr(str_replace('.', ':', $data['jam_mulai']), 0, 5);
  $jam_selesai = substr(str_replace('.', ':', $data['jam_selesai']), 0, 5);

    // Buat objek DateTime
    $mulai = DateTime::createFromFormat('H:i', $jam_mulai);
    $selesai = DateTime::createFromFormat('H:i', $jam_selesai);

    // Cek dan tambah hari jika jam selesai lebih kecil dari jam mulai
    if ($selesai <= $mulai) {
        $selesai->modify('+1 day');
    }

    // Hitung selisih menit
    $interval = $mulai->diff($selesai);
    $menit = ($interval->h * 60) + $interval->i;

  $ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
            <td class=''>{$data['line']}</td>
            <td class=''>{$data['shift']}</td>
            <td class=''>$jam_mulai</td>
            <td class=''>$jam_selesai</td>
            <td class=''>$menit</td>
			<td class=''>{$data['kod']}</td>
			<td class=''>{$data['nama_jenis_bahan']}</td>
			<td class=''>{$data['nama_supplier']}</td>
			<td class=''>{$data['nama_warna']}</td>
			<td class=''>$ambil Kg</td>
			<td class=''>{$data['nama_bahan']}</td>
            <td class=''>$hasil1 Kg</td>
		</tr>
	";
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Proses Recycle</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='post' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Proses Recycle</h3>
        </div>
        <div class='card-body'>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal Recycle</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' id='tanggalInput' required>
                </div>
            </div>
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' name='tes' class='btn btn-success' value='Buat Proses Recycle'>
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
                <h3 class='card-title'>Input Terakhir Kali</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center' style='background-color: rgb(126, 228, 128);'>
                    <th class='column-title'>Tanggal </th>
                    <th class='column-title'>Regu</th>
                    <th class='column-title'>Shift</th>
                    <th class='column-title'>Star</th>
                    <th class='column-title'>Stop</th>
                    <th class='column-title'>Menit</th>
                    <th class='column-title'>Kode Bahan</th>
                    <th class='column-title'>Jenis Bahan</th>
                    <th class='column-title'>Supplier</th>
                    <th class='column-title'>Warna</th>
                    <th class='column-title'>Pakai Bahan(Kg)</th>
                    <th class='column-title'>Hasil Bahan</th>
                    <th class='column-title'>Hasil Recycle</th>
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