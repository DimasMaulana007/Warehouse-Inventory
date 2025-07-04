<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_bahan_impor.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "
<!DOCTYPE html>
<html lang='id'>
<head>
  <meta charset='UTF-8'>
  <title>Laporan Bahan Baku Impor</title>
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
<h3>LAPORAN BHANA BAKU IMPOR</h3>
<p><strong>PERIODE:</strong></p>
<table>";
echo "
    <tr>
    <th rowspan='2'>NO</th>
    <th rowspan='2'>TANGGAL</th>
    <th rowspan='2'>NO SPBG</th>
    <th rowspan='2'>NAMA BAHAN</th>
    <th rowspan='2'>SUPPLIER</th>
    <th colspan='2'>TIMBANG</th>
  </tr>
  <tr class='subheader'>
    <th>QTY SJ</th>
    <th>QTY ACT</th>
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
        bbi.*,
        dbu.nama_bahan,
        s.nama_supplier
        FROM bahan_baku_impor bbi
        JOIN detail_bahan_utama dbu ON dbu.id_detail_bahan_utama=bbi.bahan
        JOIN supplier s ON s.id_supplier=bbi.supplier
        WHERE MONTH(tanggal)= '$filterBulan' AND YEAR(tanggal)= '$filterTahun' ORDER BY tanggal ASC");
while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $QTY_SJ=number_format($data['jumlah_sj'],0,',','.');
    $QTY_ACT=number_format($data['jumlah_act'],0,',','.');
    $no++;
    echo "<tr>
    <td>$no</td>
    <td>$tanggalFormatted</td>
    <td>{$data['no_spbg']}</td>
    <td>{$data['nama_bahan']}</td>
    <td>{$data['nama_supplier']}</td>
    <td>$QTY_SJ</td>
    <td>$QTY_ACT</td>
  </tr>";
}
echo "</table>
</body>
</html>";

ob_end_flush(); // Kirim output
?>