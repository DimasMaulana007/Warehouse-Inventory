<?php
$query = mysqli_query($koneksi,"SELECT 
      DATE_FORMAT(sj.tanggal, '%m') AS bulan,
      SUM(sjd.jumlah) AS total
    FROM surat_jalan sj
    JOIN surat_jalan_detail sjd ON sjd.id_surat = sj.id_surat
    WHERE sj.status = 'diterima' AND YEAR(sj.tanggal) = 2025
    GROUP BY bulan
    ORDER BY bulan
");
$data_db = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data_db[(int)$row['bulan']] = (int)$row['total']; // pastikan key-nya integer
}

$data_points = [];
for ($i = 1; $i <= 12; $i++) {
    $jumlah = isset($data_db[$i]) ? $data_db[$i] : 0;
    $data_points[] = [$i, $jumlah];
}
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Flow Pengiriman Barang</h1>
</section>
    <section class='content'>
      <div class='container-fluid'>
        <div class='col-md-12'>
            <!-- Bar chart -->
            <div class='card card-primary card-outline'>
              <div class='card-header'>
                <h3 class='card-title'>
                  <i class='far fa-chart-bar'></i>
                  Bar Pengiriman Barang
                </h3>
              </div>
              <div class='card-body'>
                <div id='bar-chart' style='height: 300px;'></div>
              </div>
            </div>
      </div>
    </section>
";
?>
