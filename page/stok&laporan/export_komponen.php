<?php
error_reporting(0);
ob_start(); // Mulai output buffering
$koneksi=mysqli_connect('localhost','root','','ipak')or die("tidak ada koneksi internet");
$filterBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$filterTahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Hasil_Recycle.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Output tabel
echo "
<!DOCTYPE html>
<html lang='id'>
<head>
  <meta charset='UTF-8'>
  <title>Laporan Hasil Produksi Injection</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid black;
      padding: 5px;
      text-align: center;
    }

    .header-orange {
      background-color: orange;
      font-weight: bold;
    }

    .sub-yellow {
      background-color: yellow;
    }

    .judul {
      font-weight: bold;
      text-align: left;
      padding: 10px 0;
    }
  </style>
</head>
<body>
";
echo "<div class='judul'>LAPORAN HASIL PRODUKSI INJECTION MILLENIUM</div>
  <div class='judul'>Periode  : </div>";
echo "
    <table>
    <tr class='header-orange'>
      <th rowspan='2'>TANGGAL</th>
      <th rowspan='2'>SHIFT</th>
      <th rowspan='2'>REGU</th>
      <th rowspan='2'>NAMA OPERATOR</th>
      <th colspan='3'>TIME</th>
      <th rowspan='2'>CODE MESIN</th>
      <th rowspan='2'>NAMA MESIN</th>
      <th rowspan='2'>CODE PRODUK</th>
      <th rowspan='2'>NAMA PRODUK</th>
      <th rowspan='2'>BERAT PRODUK (Gr)</th>
      <th rowspan='2'>WARNA</th>
      <th rowspan='2'>JENIS BAHAN</th>
      <th rowspan='2'>CYCLE TIME (dtk)</th>
      <th rowspan='2'>TARGET PRODUKSI(pcs)</th>
      <th colspan='2'>TOTAL HASIL PRODUKSI (Pcs)</th>
      <th rowspan='2'>PAKAI BAHAN (Kg)</th>
      <th rowspan='2'>SISIP DAN LOSS (Kg)</th>
      <th rowspan='2'>PENCAPAIAN (%)</th>
    </tr>
    <tr class='sub-yellow'>
      <th>START</th>
      <th>END</th>
      <th>TOTAL (menit)</th>
      <th>OK</th>
      <th>NG</th>
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
    
    $sq=mysqli_prepare($koneksi,"SELECT 
    proses_komponen.*,
    komponen.*,
    mesin.*,
    jenis_warna.nama_warna,
    tanggal_komponen.tanggal
    FROM tanggal_komponen 
    JOIN proses_komponen ON proses_komponen.tgl=tanggal_komponen.id_tgl
    JOIN komponen ON komponen.code_komponen=proses_komponen.code_komponen
    JOIN mesin ON mesin.code_mesin=proses_komponen.kode_mesin
    JOIN jenis_warna ON jenis_warna.id_warna=komponen.warna
    WHERE MONTH(tanggal_komponen.tanggal)= ? AND YEAR(tanggal_komponen.tanggal)= ?
    ORDER BY tanggal_komponen.tanggal ASC");
mysqli_stmt_bind_param($sq, "ss", $filterBulan, $filterTahun);
mysqli_stmt_execute($sq);
$result = mysqli_stmt_get_result($sq);
while ($data = mysqli_fetch_array($result)) {
    $tanggalFormatted = formatTanggalIndo($data['tanggal']);
    $pp_black = '';
    $pp_warna = '';
    $pp_bening = '';
    $pp_pk = '';
    
    // Cek berdasarkan kode_bahan atau jenis_bahan atau nama_jenis_bahan
    if (stripos($data['nama_bahan'], 'PP BLACK') !== false) {
        $pp_black = $data['total_hasil'];
    } elseif (stripos($data['nama_bahan'], 'PP BENING') !== false) {
        $pp_bening = $data['total_hasil'];
    }elseif (stripos($data['nama_bahan'], 'PP WARNA') !== false) {
        $pp_warna = $data['total_hasil'];
    }
    elseif (stripos($data['nama_bahan'], 'PP PK') !== false) {
        $pp_pk = $data['total_hasil'];
    }
    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];
    $cycle_time = $data['cycle_time'];
    $pakai_bahan = $data['pakai_bahan'];       // kolom: total_ng
    $berat_gr    = $data['berat_komponen'];    // kolom: berat_produk (dalam gram)

    // Ubah ke format "HH:MM"
    $star = substr(str_replace('.', ':', $jam_mulai), 0, 5);
    $end = substr(str_replace('.', ':', $jam_selesai), 0, 5);
    if ($end < $start) {
        $end += 24 * 60 * 60;
    }
    $mulai = DateTime::createFromFormat('H:i', $star);
    $selesai = DateTime::createFromFormat('H:i', $end);

    // Cek dan tambah hari jika jam selesai lebih kecil dari jam mulai
    if ($selesai <= $mulai) {
        $selesai->modify('+1 day');
    }
    // Hitung selisih menit
    $interval = $mulai->diff($selesai);
    $menit = ($interval->h * 60) + $interval->i;

    if ($data['cycle_time'] > 0) {
        $target_produksi = (3600 / $data['cycle_time']) * ($menit / 60);
        $target_produksi = round($target_produksi); // jika ingin dibulatkan
    } else {
        $target_produksi = 0;
        $pencapaian = 0;
    }
    $sisip_loss = $data['bahan_pakai'] - (($data['produksi_ok'] + $data['produksi_ng']) * ($data['berat_komponen'] / 1000));
    $pakai=number_format($data['bahan_pakai'],0,',','.');
    $pencapaian = ($data['produksi_ok'] + $data['produksi_ng']) / $target_produksi;
    $pencapaian = round($pencapaian * 100, 2); // dalam persen (kalau mau dikali 100)

    echo "
    <tr>
      <td>$tanggalFormatted</td>
      <td>{$data['shift']}</td>
      <td>{$data['regu']}</td>
      <td>{$data['nama_operator']}</td>
      <td>$star</td>
      <td>$end</td>
      <td>$menit</td>
      <td>{$data['code_mesin']}</td>
      <td>{$data['nama_mesin']}</td>
      <td>{$data['code_komponen']}</td>
      <td>{$data['nama_komponen']}</td>
      <td>$berat_gr</td>
      <td>{$data['nama_warna']}</td>
      <td>{$data['bahan']}</td>
      <td>{$data['cycle_time']}</td>
      <td>$target_produksi</td>
      <td>{$data['produksi_ok']}</td>
      <td>{$data['produksi_ng']}</td>
      <td>$pakai</td>
      <td>$sisip_loss</td>
      <td>$pencapaian</td>
    </tr>";
}
echo "</table>
</body>
</html>";

ob_end_flush(); // Kirim output
?>