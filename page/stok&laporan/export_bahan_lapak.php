<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_bahan_lapak.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "<h2>VIP MILLE</h2>
<h3>LAPORAN Bulanan Bahan Lapak</h3>
<p><strong>PERIODE:</strong></p>
<table>";
echo "<table border='1'>";
echo "
<tr>
        <th>Tanggal</th>
        <th>NO. SJ/NO. SPBG</th>
        <th>Plat Mobil</th>
        <th>Supir</th>
        <th>Kode Bahan</th>
        <th>Supplier</th>
        <th>Jenis Bahan</th>
        <th>Nama Barang</th>
        <th>Warna</th>
        <th>Qty SJ (Kg)</th>
        <th>Qty Act (Kg)</th>
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
    bbl.qty_pabrik,
    bbl.qty_lapak,
    jw.nama_warna
FROM bahan_baku_lapak AS bbl
JOIN tanggal_bahan_lapak AS tgl ON bbl.id_tanggal = tgl.id_tanggal
JOIN kode_bahan AS kb ON bbl.kode_bahan = kb.kode_bahan
JOIN jenis_bahan AS jb ON kb.id_jenis_bahan = jb.id_jenis_bahan
JOIN jenis_warna AS jw ON kb.id_warna = jw.id_warna
JOIN supplier AS s ON kb.id_supplier = s.id_supplier
WHERE MONTH(tgl.tanggal)= '$filterBulan' AND YEAR(tgl.tanggal)= '$filterTahun'
GROUP BY tgl.tanggal, kb.kode_bahan
ORDER BY tgl.tanggal ASC");

while ($data = mysqli_fetch_array($sql)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $ql=number_format($data['qty_lapak'],0,'.',',');
    $qa=number_format($data['qty_pabrik'],0,'.',',');
    echo "<tr>
            <td>$tanggalFormatted</td>
            <td>{$data['no_surat']}</td>
            <td>{$data['plat']}</td>
            <td>{$data['supir']}</td>
            <td>{$data['kode_bahan']}</td>
            <td>{$data['nama_supplier']}</td>
            <td>{$data['jenis_bahan']}</td>
            <td>{$data['nama_jenis_bahan']}</td>
            <td>{$data['nama_warna']}</td>
            <td>$ql</td>
            <td>$qa</td>
          </tr>";
}
echo "</table>";

ob_end_flush(); // Kirim output
?>