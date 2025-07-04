<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = $_GET['bulan'] ?? '';
$filterTahun = $_GET['tahun'] ?? '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_Hasil_Sortir.xls");
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
<h3>LAPORAN HASIL SORTIR & CRUSHER</h3>
<p><strong>PERIODE:</strong></p>
<table>";
echo "
    <tr>
    <th rowspan='2'>TANGGAL</th>
    <th rowspan='2'>CODE</th>
    <th rowspan='2'>SUPPLIER</th>
    <th rowspan='2'>JENIS</th>
    <th rowspan='2'>NAMA BAHAN</th>
    <th rowspan='2'>WARNA</th>
    <th rowspan='2'>OPR</th>
    <th rowspan='2'>PAKAI BAHAN (KG)</th>
    <th colspan='13'>HASIL SORTIR & CRUSHER (KG)</th>
    <th rowspan='2'>Total Hasil OK (KG)</th>
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
    <th>PE KARUNG </th>
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
  pc.*,  -- ganti pv.* menjadi pc.* karena tidak ada alias pv
  tpc.tanggal,
  kb1.kode_bahan AS kode_bahan_asal,
  kb1.id_jenis_bahan,
  s.nama_supplier,
  jb.nama_jenis_bahan,
  jb.jenis_bahan,
  jw.nama_warna,
  kb2.kode_bahan AS kode_bahan_crusher,
  jb2.nama_jenis_bahan AS bahan_crusher
FROM proses_crusher pc
JOIN tanggal_proses_crusher tpc ON pc.id_tanggal = tpc.id_tanggal_crusher
JOIN kode_bahan kb1 ON pc.code_bahan = kb1.kode_bahan
JOIN supplier s ON kb1.id_supplier = s.id_supplier
JOIN jenis_bahan jb ON kb1.id_jenis_bahan = jb.id_jenis_bahan
JOIN jenis_warna jw ON kb1.id_warna = jw.id_warna
LEFT JOIN kode_bahan kb2 ON pc.bahan_crusher = kb2.kode_bahan
LEFT JOIN jenis_bahan jb2 ON kb2.id_jenis_bahan = jb2.id_jenis_bahan
WHERE MONTH(tpc.tanggal)= '$filterBulan' AND YEAR(tpc.tanggal)= '$filterTahun'
ORDER BY tpc.tanggal ASC");

while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $pp_black = '';
    $pp_warna = '';
    $pp_bening = '';
    $hd = '';
    $pe_bening = '';
    $pec_bening = '';
    $pe_karung = '';
    $pe_karetA = '';
    $pe_karet_a1 = '';
    $pe_karet = '';
    $pe_sablon_printing = '';
    $pea = '';
    $pea1 = '';
    $pe_superb = '';
    $pe_supera = '';
    
    // Cek berdasarkan kode_bahan atau jenis_bahan atau nama_jenis_bahan
    if (stripos($data['jenis_bahan'], 'PP BLACK') !== false) {
        $pp_black = number_format($data['total_hasil'],0,',','.');
    } elseif (stripos($data['jenis_bahan'], 'PP BENING') !== false) {
        $pp_bening = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['jenis_bahan'], 'PP WARNA') !== false) {
        $pp_warna = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['jenis_bahan'], 'PP PK') !== false) {
        $pp_pk = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['jenis_bahan'], 'HD+') !== false) {
        $hd = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Bening') !== false) {
        $pe_bening = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Karung') !== false) {
        $pe_karung = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Karet A+') !== false) {
        $pe_karetA = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Karet A1') !== false) {
        $pe_karet_a1 = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Karet') !== false) {
        $pe_karet = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Sablon Printing') !== false) {
        $pe_sablon_printing = $data['total_hasil'];
    }elseif (stripos($data['nama_jenis_bahan'], 'PE A+') !== false) {
        $pea = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE A1') !== false) {
        $pea1 = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Super B') !== false) {
        $pe_superb = number_format($data['total_hasil'],0,',','.');
    }elseif (stripos($data['nama_jenis_bahan'], 'PE Super A') !== false) {
        $pe_supera = number_format($data['total_hasil'],0,',','.');
    }
    $pak=number_format($data['qty_pakai'],0,',','.');
    $tot=number_format($data['total_hasil'],0,',','.');
    echo "<tr>
    <td>$tanggalFormatted</td>
    <td>{$data['code_bahan']}</td>
    <td>{$data['nama_supplier']}</td>
    <td>{$data['jenis_bahan']}</td>
    <td>{$data['nama_jenis_bahan']}</td>
    <td>{$data['nama_warna']}</td>
    <td>{$data['operator']}</td>
    <td>$pak</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>$pe_karetA</td>
    <td>$pec_bening</td>
    <td>$pe_bening</td>
    <td>$hd</td>
    <td>$pp_bening</td>
    <td>$pp_warna</td>
    <td>$pp_black</td>
    <td>$tot</td>
  </tr>";
}
echo "</table>
</body>
</html>";

ob_end_flush(); // Kirim output
?>