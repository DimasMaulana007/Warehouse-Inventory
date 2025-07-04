<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan Recycle.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "<table border='1'>";
echo "
<tr>
        <th>Tanggal</th>
        <th>Shift</th>
        <th>Star</th>
        <th>Stop</th>
        <th>Total</th>
        <th>Target Per Shift</th>
        <th>Kode</th>
        <th>Supplier</th>
        <th>Jenis</th>
        <th>Nama Bahan</th>
        <th>Warna</th>
        <th>Sortir</th>
        <th>Non Sortir</th>
        <th>Total Pakai</th>
        <th>Hasil Recycle</th>
        <th>Total Hasil</th>
      </tr>";

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
    kb.kode_bahan,
    jb.*,
    s.nama_supplier,
    pr.*,
    jw.nama_warna
FROM proses_recycle AS pr
JOIN tanggal_proses_recycle AS tgl ON pr.id_tanggal_proses = tgl.id_proses
JOIN kode_bahan AS kb ON pr.kode_bahan = kb.kode_bahan
JOIN jenis_bahan AS jb ON kb.id_jenis_bahan = jb.id_jenis_bahan
JOIN jenis_warna AS jw ON kb.id_warna = jw.id_warna
JOIN supplier AS s ON kb.id_supplier = s.id_supplier
WHERE tgl.tanggal BETWEEN '$awal' AND '$akhir'
GROUP BY tgl.tanggal, kb.kode_bahan
ORDER BY tgl.tanggal ASC");

while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $val_sortir = '';
    $val_non_sortir = '';
    if ($data['sortir'] == 'sortir') {
      $val_sortir = $data['pakai_bahan'];
    } else if ($data['sortir'] == 'non sortir') {
      $val_non_sortir = $data['pakai_bahan'];
}
    echo "<tr>
            <td>$tanggalFormatted</td>
            <td>{$data['shift']}</td>
            <td>{$data['jam_mulai']}</td>
            <td>{$data['jam_selesai']}</td>
            <td>{$data['total_jam']}</td>
            <td>{$data['target']}</td>
            <td>{$data['kode_bahan']}</td>
            <td>{$data['nama_supplier']}</td>
            <td>{$data['jenis_bahan']}</td>
            <td>{$data['nama_jenis_bahan']}</td>
            <td>{$data['nama_warna']}</td>
            <td>$val_sortir</td>
            <td>$val_non_sortir</td>
            <td>{$data['pakai_bahan']}</td>
            <td>{$data['nama_bahan']}</td>
            <td>{$data['hasil']}</td>
          </tr>";
}
echo "</table>";

ob_end_flush(); // Kirim output
?>