<?php
session_start();
error_reporting(0);
session_start();
include 'config.php';   // ⬅️ load .env & koneksi DB
include 'helper.php';

$halaman = [
    'tanggal_bahan_baku' => 'page/tanggal_bahan_baku.php',
    'proses_bahan' => 'page/proses_bahan.php',
    'proses_recycle' => 'page/proses_recycle.php',
	'bahan_baku' => 'page/bahan_baku.php',
	'mixing_bahan' => 'page/mixing_bahan.php',
	'bahan_utama_selesai' => 'page/bahan_utama_selesai.php',
	'ambil_bahan_utama' => 'page/ambil_bahan_utama.php',
	'komposisi' => 'page/komposisi.php',
	'komposisi_komponen' => 'page/komposisi_komponen.php',
	'detail_bahan_utama' => 'page/detail_bahan_utama.php',
	'detail_utama' => 'page/detail_utama.php',
	'Assembly' => 'page/Assembly.php',
	'komponen' => 'page/komponen.php',
	'assenbly_barang_jadi' => 'page/assenbly_barang_jadi.php',
	'produk_jadi' => 'page/produk_jadi.php',
	'tanggal_komponen' => 'page/tanggal_komponen.php',
	'barang' => 'page/barang.php',
	'kode_bahan' => 'page/kode_bahan.php',
	'proses_sortir' => 'page/proses_sortir.php',
	'recycle' => 'page/recycle.php',
	'detail_komposisi' => 'page/detail_komposisi.php',
	'tambah_mesin' => 'page/tambah_mesin.php',
	'kode_kendaraan' => 'page/kode_kendaraan.php',
	'kode_pendukung' => 'page/kode_pendukung.php',
	'tambah_kendaraan' => 'page/tambah_kendaraan.php',
	'baku_keluar' => 'page/baku_keluar.php',
	'mesin' => 'page/mesin.php',
	'baku' => 'page/baku.php',
	
	
	//spbg
	'spbg_gudang_lapak' => 'page/spbg/spbg_gudang_lapak.php',
	'spbg_gudang_bahan_baku' => 'page/spbg/spbg_gudang_bahan_baku.php',
	'spbg_komponen' => 'page/spbg/spbg_komponen.php',
	'laporan_spbg_bahan_baku' => 'page/spbg/laporan_spbg_bahan_baku.php',
	'spbg_bahan_baku' => 'page/spbg/spbg_bahan_baku.php',
	'laporan_spbg_komponen' => 'page/spbg/laporan_spbg_komponen.php',
	
	//stok&laporan
	'laporan_bahan_baku' => 'page/stok&laporan/laporan_bahan_baku.php',
	'laporan_recycle' => 'page/stok&laporan/laporan_recycle.php',
	'laporan_sortir' => 'page/stok&laporan/laporan_sortir.php',
	'laporan_proses_komponen' => 'page/stok&laporan/laporan_proses_komponen.php',
	'laporan_assembly' => 'page/stok&laporan/laporan_assembly.php',
	'stok_bahan_baku' => 'page/stok&laporan/stok_bahan_baku.php',
	'stok_bahan_utama' => 'page/stok&laporan/stok_bahan_utama.php',
	'stok_komponen' => 'page/stok&laporan/stok_komponen.php',
	'stok_produk_jadi' => 'page/stok&laporan/stok_produk_jadi.php',
	'laporan_bahan_lapak' => 'page/stok&laporan/laporan_bahan_lapak.php',
	'stok_atk' => 'page/stok&laporan/stok_bahan_baku.php',
	'stok_barang' => 'page/stok&laporan/stok_barang.php',
	'export_bahan_lapak' => 'page/stok&laporan/export_bahan_lapak.php',
	'data_sortir' => 'page/stok&laporan/data_sortir.php',
	'data_recycle' => 'page/stok&laporan/data_recycle.php',
	'laporan_bahan_impor' => 'page/stok&laporan/laporan_bahan_impor.php',

	//teknisi
	'kendaraan' => 'page/teknisi/kendaraan.php',
	'tkendaraan' => 'page/teknisi/tkendaraan.php',
	'upkendaraan' => 'page/teknisi/upkendaraan.php',
	'kondisi_kendaraan' => 'page/teknisi/kondisi_kendaraan.php',

	//edit
	'ebahan' => 'page/edit/ebahan.php',
	'ebaku' => 'page/edit/ebaku.php',
	'ewarna' => 'page/edit/ewarna.php',
	'eproduk' => 'page/edit/eproduk.php',
	'esupplier' => 'page/edit/esupplier.php',
	'ecustomer' => 'page/edit/ecustomer.php',
	'etype' => 'page/edit/etype.php',
	'estiker' => 'page/edit/estiker.php',
	'ekode_bahan' => 'page/edit/ekode_bahan.php',
	'ekomponen' => 'page/edit/ekomponen.php',
	'ebarang' => 'page/edit/ebarang.php',
	'emesin' => 'page/edit/emesin.php',
	'ekomposisi' => 'page/edit/ekomposisi.php',
	'ependukung' => 'page/edit/ependukung.php',
	'ekendaraan' => 'page/edit/ekendaraan.php',

	//tambah
	'tbarang_jadi' => 'page/entry_data/tbarang_jadi.php',
	'atk_tambah' => 'page/entry_data/atk_tambah.php',
	'atk_masuk' => 'page/entry_data/atk_masuk.php',

	//data
	'data_bahan_lapak' => 'page/data/data_bahan_lapak.php',
	'data_hasil_crusher' => 'page/data/data_hasil_crusher.php',
	'data_hasil_recycle' => 'page/data/data_hasil_recycle.php',
	'data_injection' => 'page/data/data_injection.php',
	'rekap_bahan_mille' => 'page/data/rekap_bahan_mille.php',
	'flow_penjualan' => 'page/data/flow_penjualan.php',
	'pengiriman_hari' => 'page/data/pengiriman_hari.php',
	'detail_pengiriman' => 'page/data/detail_pengiriman.php',

	//entry_data
	'bahan_baku_impor' => 'page/entry_data/bahan_baku_impor.php',
	'komponen_kardus' => 'page/entry_data/komponen_kardus.php',
	'komponen_pendukung' => 'page/entry_data/komponen_pendukung.php',
	'komponen_masuk' => 'page/entry_data/komponen_masuk.php',
	'b' => 'page/entry_data/mixing_bahan.php',
	'detail_mixing' => 'page/entry_data/detail_mixing.php',

	//kirim
	'kirim_bahan' => 'page/kirim/kirim_bahan.php',
	'detail_kirim' => 'page/kirim/detail_kirim.php',
	'kirim_barang' => 'page/kirim/kirim_barang.php',
	'detail_kirim_barang' => 'page/kirim/detail_kirim_barang.php',
	'laporan_kirim_bahan' => 'page/kirim/laporan_kirim_bahan.php',
	'laporan_kirim_barang' => 'page/kirim/laporan_kirim_barang.php',

	//masterdata
	'jenis_bahan' => 'page/masterdata/jenis_bahan.php',
	'jenis_warna' => 'page/masterdata/jenis_warna.php',
	'jenis_produk' => 'page/masterdata/jenis_produk.php',
	'Tambah Customer' => 'page/masterdata/Tambah Customer.php',
	'jenis_stiker' => 'page/masterdata/jenis_stiker.php',
	'komponen_detail' => 'page/masterdata/komponen_detail.php',
	'supplier' => 'page/masterdata/supplier.php',
	'type' => 'page/masterdata/type.php',
	'komposisi_barang' => 'page/masterdata/komposisi_barang.php',
	'keluar' => 'keluar',
];

$halaman_admin = ['masterdata_komponen', 'master_barang', 'user_management'];
$halaman_bahan = ['masterdata_komponen', 'master_barang', 'user_management'];
$halaman_produksi = ['masterdata_komponen', 'master_barang', 'user_management'];
$halaman_logistik = ['masterdata_komponen', 'master_barang', 'user_management'];
$halaman_teknisi = ['masterdata_komponen', 'master_barang', 'user_management'];
$halaman_direktur = ['masterdata_komponen', 'master_barang', 'user_management'];

$encrypted = $_GET['url'] ?? '';
$url = decrypt_url($encrypted);
$url = trim($url); // buang spasi awal/akhir
$url = preg_replace('/[^a-zA-Z0-9_]/', '', $url);
if (array_key_exists($url, $halaman)) {
    include $halaman[$url];
}
if($url=='keluar'){
	setcookie('id');
	header('location:index.php');
	exit();
}
if (isset($_POST['login'])) {
$user = $_POST['username'];
$pass = $_POST['password'];

$query = mysqli_prepare($koneksi, "SELECT * FROM users WHERE username= ? AND aktif='aktif'");
mysqli_stmt_bind_param($query, "s", $user);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
if(mysqli_num_rows($result)) {
    $data = mysqli_fetch_assoc($result);
    // Cek apakah masih pakai password lama (plaintext)
    if($pass === $data['password']) {
        // Konversi dan update password ke hashed
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_query($koneksi,"UPDATE users SET password='$hashed' WHERE username='$user'");
        // Lanjut login
        setcookie('id', $user);
        header('Location: index.php');
        exit();
    }
    // Kalau sudah hash, cek pakai password_verify
    elseif(password_verify($pass, $data['password'])) {
        setcookie('id', $user);
        header('Location: index.php');
        exit();
    } else {
        $ket = "<div class='alert alert-danger' style='text-align:center'>Password salah</div>";
    }
}else{
	$ket = "<div class='alert alert-danger' style='text-align:center'>Username & Password salah</div>";
}
}
// Cek login
$loggedIn = isset($_COOKIE['id']) && $_COOKIE['id'] !== '';
// Jika belum login, paksa masuk ke login page
if (!$loggedIn) {
    include('page/login.php');
	echo $tampilan;
    exit(); // Pastikan routing tidak diproses
}else{
	include('page/dasboard.php');
  echo $tampil;
}
?>