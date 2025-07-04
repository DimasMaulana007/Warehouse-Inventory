<?php
$tgl=$_GET['tgl'];
$qty=$_GET['qty'];
$kode=$_GET['kode'];
if($_GET['kode']==""){
    $kode="--pilih--";
}else{
    $kode=$_GET['kode'];
}
$jl=mysqli_query($koneksi,"SELECT bj.*,
jw.nama_warna
 FROM barang_jadi bj
JOIN jenis_warna jw ON jw.id_warna=bj.warna
");
while($s=mysqli_fetch_array($jl)){
    if($s['kunci'=='Key']){$key="Key";}
    else{$key='';}
	if($s['hanger']=='Non Hanger'){$hanger='';}
    else{$hanger='Hanger-';}
    $pilih1.="
        <option value='{$s['kode_barang']}'>{$s['kode_barang']} | {$s['karakter']} SSN{$s['susun']} | $hanger$key | {$s['nama_warna']}</option>
	";
}
$gagal1 = $gagal2 = $gagal3 = "";
$gagal = false;

if (isset($_GET['simpan']) && $_GET['simpan'] != '') {
    mysqli_begin_transaction($koneksi);
}

$qy1 = mysqli_query($koneksi, "SELECT 
    kk.*, k.nama_komponen
 FROM komposisi_komponen kk
 JOIN komponen k ON k.code_komponen = kk.kode_komponen
 WHERE kk.kode_barang = '$kode'");

while ($data = mysqli_fetch_array($qy1)) {
    $semua = $qty * $data['qty'];
    $ket1 .= "
    <tr class='even pointer text-center'>
        <td>{$data['kode_komponen']}</td>
        <td>{$data['nama_komponen']}</td>
        <td><input type='text' class='text-center form-control' value='$semua' readonly></td>
    </tr>";

    if (isset($_GET['simpan']) && $_GET['simpan'] != '') {
        $cek = mysqli_query($koneksi, "SELECT jumlah_ok FROM komponen WHERE code_komponen = '{$data['kode_komponen']}'");
        $stok_sekarang = mysqli_fetch_assoc($cek)['jumlah_ok'];

        if ($stok_sekarang >= $semua) {
            $update = mysqli_query($koneksi, "UPDATE komponen 
                SET jumlah_ok = jumlah_ok - $semua 
                WHERE code_komponen = '{$data['kode_komponen']}'");
            mysqli_query($koneksi,"insert into transaksi_komponen(tanggal,kode_komponen,jumlah)values('$tgl','{$data['kode_komponen']}','$semua')");
            if (!$update) {
                $gagal1 .= "Gagal update komponen {$data['kode_komponen']}<br>";
                $gagal = true;
            }
        } else {
            $gagal1 .= "Stok tidak cukup untuk {$data['kode_komponen']}. Sisa: $stok_sekarang, Butuh: $semua<br>";
            $gagal = true;
        }
    }
}

$qy2 = mysqli_query($koneksi, "SELECT 
    kp.*, kkp.nama_barang
 FROM komposisi_pendukung kp
 JOIN kode_komponen_pendukung kkp ON kkp.id_pendukung = kp.kode_pendukung
 WHERE kp.kode_barang = '$kode'");

while ($data = mysqli_fetch_array($qy2)) {
    $semua1 = $qty * $data['qty'];
    $ket2 .= "
    <tr class='even pointer text-center'>
        <td>{$data['kode_pendukung']}</td>
        <td>{$data['nama_barang']}</td>
        <td><input type='text' class='text-center form-control' value='$semua1' readonly></td>
    </tr>";

    if (isset($_GET['simpan']) && $_GET['simpan'] != '') {
        $cek = mysqli_query($koneksi, "SELECT jumlah FROM kode_komponen_pendukung WHERE id_pendukung = '{$data['kode_pendukung']}'");
        $stok_sekarang = mysqli_fetch_assoc($cek)['jumlah'];

        if ($stok_sekarang >= $semua1) {
            $update = mysqli_query($koneksi, "UPDATE kode_komponen_pendukung 
                SET jumlah = jumlah - $semua1 
                WHERE id_pendukung = '{$data['kode_pendukung']}'");
            mysqli_query($koneksi,"insert into transaksi_pendukung(tanggal,kode_pendukung,jumlah)values('$tgl','{$data['kode_pendukung']}','$semua1')");
            if (!$update) {
                $gagal2 .= "Gagal update pendukung {$data['kode_pendukung']}<br>";
                $gagal = true;
            }
        } else {
            $gagal2 .= "Stok tidak cukup untuk {$data['kode_pendukung']}. Sisa: $stok_sekarang, Butuh: $semua1<br>";
            $gagal = true;
        }
    }
}

$qy3 = mysqli_query($koneksi, "SELECT 
    kkar.nama_kardus, koka.*
 FROM komposisi_kardus koka
 JOIN komponen_kardus kkar ON kkar.id_komkar = koka.kode_kardus
 WHERE koka.kode_barang = '$kode'");

while ($data = mysqli_fetch_array($qy3)) {
    $semua2 = $qty * $data['qty'];
    $ket3 .= "
    <tr class='even pointer text-center'>
        <td>{$data['kode_kardus']}</td>
        <td>{$data['nama_kardus']}</td>
        <td><input type='text' class='text-center form-control' value='$semua2' readonly></td>
    </tr>";

    if (isset($_GET['simpan']) && $_GET['simpan'] != '') {
        $cek = mysqli_query($koneksi, "SELECT jumlah FROM komponen_kardus WHERE id_komkar = '{$data['kode_kardus']}'");
        $stok_sekarang = mysqli_fetch_assoc($cek)['jumlah'];
        if ($stok_sekarang >= $semua2) {
            $update = mysqli_query($koneksi, "UPDATE komponen_kardus 
                SET jumlah = jumlah - $semua2 
                WHERE id_komkar = '{$data['kode_kardus']}'");
            mysqli_query($koneksi,"insert into transaksi_kardus(tanggal,id_packing,jumlah)values('$tgl','{$data['kode_kardus']}','$semua2')");
            if (!$update) {
                $gagal3 .= "Gagal update kardus {$data['kode_kardus']}<br>";
                $gagal = true;
            }
        } else {
            $gagal3 .= "Stok tidak cukup untuk {$data['kode_kardus']}. Sisa: $stok_sekarang, Butuh: $semua2<br>";
            $gagal = true;
        }
    }
}

// FINAL COMMIT ATAU ROLLBACK
if (isset($_GET['simpan']) && $_GET['simpan'] != '') {
    if ($gagal) {
        mysqli_rollback($koneksi);
        $gagal5="<div class='alert alert-danger'>Gagal menyimpan data:<br>$gagal1 $gagal2 $gagal3</div>";
    } else {
        mysqli_commit($koneksi);
        $gagal5="<div class='alert alert-success'>Stok berhasil dipotong untuk semua komponen.</div>";
        mysqli_query($koneksi,"insert into assembly_barang_jadi(tanggal,kode_barang,qty)values('$tgl','$kode','$qty')");
        mysqli_query($koneksi,"UPDATE barang_jadi SET jumlah=jumlah+$qty WHERE kode_barang='$kode'");
        header("location:index.php?url=".encrypt_url('assenbly_barang_jadi')."");
    }
}

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Assembly Barang</h1>
</section>
    <!-- Main content -->
<section class='content'>
    <div class='container-fluid'>
	<form method='get' class='form-horizontal' id='quickForm'>
        <div class='card card-default'>
        <div class='card-header'>
        <h3 class='card-title'>Assembly Barang</h3>
        </div>
        <div class='card-body'>
        <input type='hidden' name='url' value='assenbly_barang_jadi'>
        <div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Tanggal</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required value='$tgl'>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Kode Barang</label>
                <div class='col-sm-4'>
                <select class='form-control select2' name='kode' style='width: 100%;' required >
                    <option>$kode</option>
                    $pilih1
                </select>
                </div>
            </div>
			<div class='form-group row'>
                <label for='inputEmail3' class='col-sm-2 offset-sm-2 col-form-label'>Qty</label>
                <div class='col-sm-3'>
                <input type='text' name='qty' class='form-control' required value='$qty'>
                </div>
            </div>
            
			<div class='form-group row'>
                <div class='col-sm-5 offset-sm-4'>
				<input type='submit' class='btn btn-success' value='Buat'>
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
                <h3 class='card-title'>Data Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
                <table class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                        <th class='column-title'>Kode Komponen</th>
						<th class='column-title'>Nama Komponen</th>
						<th class='column-title'>Qty</th>
				  </tr>
                  </thead>
                  <tbody>
                  $ket1
                  $ket2
                  $ket3
                  </tfoot>
                </table><br>
                $gagal5
                <br>
                <a href='index.php?url=".encrypt_url('assenbly_barang_jadi')."&tgl=$tgl&kode=$kode&qty=$qty&simpan=ada' class='btn btn-success'>Simpan</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>
