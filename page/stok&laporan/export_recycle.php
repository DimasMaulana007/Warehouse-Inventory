<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_recycle.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "
<!DOCTYPE html>
<html lang='id'>
<head>
  <meta charset='UTF-8'>
  <title>Laporan Sortir & Crusher</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      font-size: 14px;
      text-align: center;
    }
    th, td {
      border: 1px solid #000;
      padding: 5px;
    }
    th {
      background-color: #8BC34A;
    }
    .subheader {
      background-color: #FCE4EC;
    }
    .pp-color {
      background-color: #FFD600;
    }
    .header-yellow {
      background-color: #FFB300;
      font-weight: bold;
    }
    .total-ok {
      background-color: #AED581;
    }
    .sampah {
      background-color: #FFF176;
    }
  </style>
</head>
<body>
";
echo "<h2>VIP MILLE</h2>
<h3>LAPORAN HASIL RECYCLE</h3>
<p><strong>PERIODE:</strong></p>
<table>";
echo "
    <tr>
    <th rowspan='2'>TANGGAL</th>
    <th rowspan='2'>REGU</th>
    <th rowspan='2'>SHIFT</th>
    <th rowspan='2'>START</th>
    <th rowspan='2'>STOP</th>
    <th rowspan='2'>TOTAL</th>
    <th rowspan='2'>TARGET PRODUKSI</th>
    <th rowspan='2'>CODE</th>
    <th rowspan='2'>SUPPLIER</th>
    <th rowspan='2'>JENIS</th>
    <th rowspan='2'>NAMA BAHAN</th>
    <th rowspan='2'>WARNA</th>
    <th rowspan='2'>PAKAI BAHAN SORTIR (KG)</th>
    <th rowspan='2'>PAKAI BAHAN NON SORTIR (KG)</th>
    <th colspan='13'>HASIL RECYCLE (KG)</th>
    <th rowspan='2'>Total Hasil OK (KG)</th>
    <th rowspan='2'>Bekuan</th>
    <th rowspan='2'>Saringan</th>
    <th rowspan='2'>Susut</th>
  </tr>
  <tr class='subheader'>
    <th>PE Super A</th>
    <th>PE Super B</th>
    <th>PE A1</th>
    <th>PE A+</th>
    <th>PE SABLON PRINTING</th>
    <th>PE KARET</th>
    <th>PE KARET A1</th>
    <th>PE KARET A+</th>
    <th>PE KARUNG G</th>
    <th class='pp-color'>PP Karung Boncos</th>
    <th class='pp-color'>PP Bening</th>
    <th class='pp-color'>PP Warna</th>
    <th class='pp-color'>PP Black</th>
  </tr>
";

      function formatTanggalIndo($tanggal) {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $timestamp = strtotime($tanggal);
        if (!$timestamp) return 'Format Salah';
        $tanggal = date('j', $timestamp);
        $bulanIndex = (int)date('n', $timestamp);
        $tahun = date('Y', $timestamp);
        return $tanggal . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
    }
    
$sql = mysqli_query($koneksi, "SELECT 
    tgl.*,
    kb.kode_bahan AS kode,
    jb.*,
    s.nama_supplier,
    pr.*,
    jw.nama_warna,
    dbu.nama_bahan,
    dbu.kode_bahan
FROM proses_recycle AS pr
JOIN tanggal_proses_recycle AS tgl ON pr.id_tanggal_proses = tgl.id_proses
JOIN kode_bahan AS kb ON pr.kode_bahan = kb.kode_bahan
JOIN jenis_bahan AS jb ON kb.id_jenis_bahan = jb.id_jenis_bahan
JOIN jenis_warna AS jw ON kb.id_warna = jw.id_warna
JOIN supplier AS s ON kb.id_supplier = s.id_supplier
JOIN detail_bahan_utama AS dbu ON dbu.id_detail_bahan_utama = pr.id_detail_bahan_utama
WHERE MONTH(tgl.tanggal)= '$filterBulan' AND YEAR(tgl.tanggal)= '$filterTahun'
ORDER BY tgl.tanggal ASC");

while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $pp_black = '';
    $pp_warna = '';
    $pp_bening = '';
    $pp_pk = '';
    $sortir = '';
    $non_sortir = '';
    
    // Cek berdasarkan kode_bahan atau jenis_bahan atau nama_jenis_bahan
    if (stripos($data['jenis_bahan'], 'PP BLACK') !== false) {
        $pp_black = number_format($data['hasil'],0,',','.');
    } elseif (stripos($data['jenis_bahan'], 'PP BENING') !== false) {
        $pp_bening = number_format($data['hasil'],0,',','.');
    }elseif (stripos($data['jenis_bahan'], 'PP WARNA') !== false) {
        $pp_warna = number_format($data['hasil'],0,',','.');
    }elseif (stripos($data['jenis_bahan'], 'PP PK') !== false) {
        $pp_pk = number_format($data['hasil'],0,',','.');
    }
    if ($data['sortir'] === 'sortir') {
      $sortir = number_format($data['qty_ambil'], 0, ',', '.');
    } elseif ($data['sortir'] === 'non-sortir') {
        $non_sortir = number_format($data['qty_ambil'], 0, ',', '.');
    }
    $jam_m = $data['jam_mulai']; // contoh: "19.00.00"
    $jam_s = $data['jam_selesai']; // contoh: "07.00.00"

    // Ubah ke format "HH:MM"
    $jam_mulai = substr(str_replace('.', ':', $jam_m), 0, 5);
    $jam_selesai = substr(str_replace('.', ':', $jam_s), 0, 5);

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

    $target_produk = round(($menit / 720) * 4000);
    $hal=number_format($data['hasil'],0,',','.');
    $beku=number_format($data['bekuan'],0,',','.');
    $saring=number_format($data['saringan'],0,',','.');
    $sut=number_format($data['susut'],0,',','.');
    echo "<tr>
    <td>$tanggalFormatted</td>
    <td>{$data['line']}</td>
    <td>{$data['shift']}</td>
    <td>$jam_mulai</td>
    <td>$jam_selesai</td>
    <td>$menit</td>
    <td>$target_produk</td>
    <td>{$data['kode']}</td>
    <td>{$data['nama_supplier']}</td>
    <td>{$data['jenis_bahan']}</td>
    <td>{$data['nama_jenis_bahan']}</td>
    <td>{$data['nama_warna']}</td>
    <td>$sortir</td>
    <td>$non_sortir</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>$pp_bening</td>
    <td>$pp_warna</td>
    <td>$pp_black</td>
    <td>$hal</td>
    <td>$beku</td>
    <td>$saring</td>
    <td>{$data['susut']}</td>
  </tr>";
}
echo "</table>
</body>
</html>";

ob_end_flush(); // Kirim output
?>