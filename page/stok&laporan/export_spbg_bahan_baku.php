<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_SPBG_Bahan_Baku.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "
<!DOCTYPE html>
<html lang='id'>
<head>
  <meta charset='UTF-8'>
  <title>Laporan SPBG</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    h2 {
      margin-bottom: 0;
    }
    .periode {
      margin-top: 0;
      font-weight: bold;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    thead th {
      background-color: #8BC34A; /* Hijau muda */
    }
    .judul {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
";
echo "<div class='judul'>VIP MILLE</div>
  <div class='judul'>SPBG BAHAN BAKU</div>
  <div class='periode'>PERIODE: <span></span></div>
<table>";
echo "
    <thead>
      <tr>
        <th>TGL</th>
        <th>NO. SPBG</th>
        <th>KODE BAHAN</th>
        <th>NAMA BAHAN</th>
        <th>JENIS BAHAN</th>
        <th>WARNA</th>
        <th>JUMLAH (KG)</th>
        <th>STOK SISA (KG)</th>
        <th>KETERANGAN</th>
      </tr>
    </thead>
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
 spbg_bahan_baku.*,
 spbg_bahan_baku.jumlah as ambil,
 detail_bahan_utama.*,
 jenis_warna.nama_warna,
 detail_bahan_utama.kode_bahan AS id
FROM spbg_bahan_baku
JOIN detail_bahan_utama ON detail_bahan_utama.id_detail_bahan_utama=spbg_bahan_baku.kode_bahan
JOIN jenis_warna ON jenis_warna.id_warna=detail_bahan_utama.warna
WHERE MONTH(spbg_bahan_baku.tanggal)= '$filterBulan' AND YEAR(spbg_bahan_baku.tanggal)= '$filterTahun' AND spbg_bahan_baku.cek='sudah'
GROUP BY spbg_bahan_baku.tanggal
ORDER BY spbg_bahan_baku.tanggal ASC");
while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $sisa=number_format($data['ambil'], 0, ',', '.');
    $jumlah=number_format($data['sisa'], 0, ',', '.');
    echo "
  <tbody>
      <tr>
        <td>$tanggalFormatted</td>
        <td>{$data['no_spbg']}</td>
        <td>{$data['id']}</td>
        <td>{$data['jenis_bahan']}</td>
        <td>{$data['nama_bahan']}</td>
        <td>{$data['nama_warna']}</td>
        <td>$jumlah Kg</td>
        <td>$sisa Kg</td>
        <td>{$data['keterangan']}</td>
      </tr>
    </tbody>

  ";
}
echo "</table>
</body>
</html>";

ob_end_flush(); // Kirim output
?>