<?php
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
$tahunSekarang = date('Y');
for ($i = $tahunSekarang; $i >= 2024; $i--) {
  $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : '';
  $ket2.="<option value='$i' $selected>$i</option>";
}
$komponen = []; // ambil semua kode komponen
$qk = mysqli_query($koneksi, "SELECT code_komponen FROM komponen");
while($r = mysqli_fetch_assoc($qk)){
    $komponen[] = $r['code_komponen'];
}
$data = [];
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $nama_bulan = date('F', mktime(0, 0, 0, $bulan, 10));
    // Misalnya: $bulan = 5; $tahun = 2025;
    $bulan_sebelumnya = $bulan - 1;
    $tahun_sebelumnya = $tahun;

    if ($bulan_sebelumnya == 0) {
        $bulan_sebelumnya = 12;
        $tahun_sebelumnya -= 1;
    }
    $bulan_lanjut = $bulan + 1;
    $tahun_lanjut = $tahun;

    if ($bulan_lanjut == 0) {
        $bulan_lanjut = 12;
        $tahun_lanjut -= 1;
    }
    $query = mysqli_query($koneksi,"SELECT 
    (
        (SELECT COALESCE(SUM(abj.qty * bj.berat_produk), 0) 
         FROM assembly_barang_jadi abj
         JOIN barang_jadi bj ON bj.kode_barang = abj.kode_barang
         WHERE (YEAR(abj.tanggal) < $tahun_sebelumnya) 
            OR (YEAR(abj.tanggal) = $tahun_sebelumnya AND MONTH(abj.tanggal) <= $bulan_sebelumnya)
        ) +
        (SELECT COALESCE(SUM(pk.produksi_ok * k.berat_komponen), 0)
         FROM proses_komponen pk
         LEFT JOIN komponen k ON k.code_komponen = pk.code_komponen
         LEFT JOIN tanggal_komponen tk ON tk.id_tgl = pk.tgl
         WHERE (YEAR(tk.tanggal) < $tahun_sebelumnya) 
            OR (YEAR(tk.tanggal) = $tahun_sebelumnya AND MONTH(tk.tanggal) <= $bulan_sebelumnya)
        )
    ) AS awal");
    $stok_awal_sekarang = mysqli_fetch_assoc($query)['awal'];
    // Masuk
    $lapak = mysqli_query($koneksi,"SELECT 
            (SELECT COALESCE(SUM(abj.qty*bj.berat_produk), 0) 
                FROM assembly_barang_jadi abj
                join barang_jadi bj on bj.kode_barang=abj.kode_barang
                WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun)+
            (SELECT COALESCE(SUM(pk.produksi_ok*k.berat_komponen), 0)
                FROM proses_komponen pk
                LEFT JOIN komponen k ON k.code_komponen = pk.code_komponen
                left join tanggal_komponen tk on tk.id_tgl=pk.tgl
                WHERE MONTH(tk.tanggal) = $bulan AND YEAR(tk.tanggal) = $tahun)
            AS saldo");
    $masuk = mysqli_fetch_assoc($lapak)['saldo'];

    // Keluar (pengiriman)
    $kirim = mysqli_query($koneksi,"SELECT 
            (SELECT COALESCE(SUM(jumlah), 0) 
                FROM transaksi_komponen 
                WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun)+
            (SELECT COALESCE(SUM(sjd.jumlah), 0)
                FROM surat_jalan sj
                LEFT JOIN surat_jalan_detail sjd ON sjd.id_surat = sj.id_surat
                WHERE MONTH(sj.tanggal) = $bulan AND YEAR(sj.tanggal) = $tahun) 
            AS pengiriman");
    $pengiriman = mysqli_fetch_assoc($kirim)['pengiriman'];
    // Stok komponen
    $q_in = mysqli_query($koneksi,"SELECT 
                            COALESCE(SUM(pk.produksi_ok * k.berat_komponen), 0) AS sisa_stok_komponen 
                        FROM proses_komponen pk
                        LEFT JOIN tanggal_komponen tgl ON tgl.id_tgl = pk.tgl
                        LEFT JOIN komponen k ON k.code_komponen = pk.code_komponen
                        WHERE (YEAR(tgl.tanggal) < $tahun_lanjut) 
                        OR (YEAR(tgl.tanggal) = $tahun_lanjut AND MONTH(tgl.tanggal) < $bulan_lanjut)
    ");
    $stok_komponen = mysqli_fetch_assoc($q_in)['sisa_stok_komponen'];

    // Stok barang jadi
    $q_out = mysqli_query($koneksi,"SELECT COALESCE(SUM(abj.qty*bj.berat_produk), 0) AS sisa_stok_barang
                FROM assembly_barang_jadi abj
                join barang_jadi bj on bj.kode_barang=abj.kode_barang
                 WHERE (YEAR(abj.tanggal) < $tahun_lanjut) 
                  OR (YEAR(abj.tanggal) = $tahun_lanjut AND MONTH(abj.tanggal) < $bulan_lanjut)
    ");
    $stok_barang = mysqli_fetch_assoc($q_out)['sisa_stok_barang'];

    if ($masuk == 0 && $pengiriman == 0) {
      // Tidak ada aktivitas nyata — set data kosong
      $data[$nama_bulan] = [
          'stok_awal' => 0,
          'masuk' => 0,
          'pengiriman' => 0,
          'stok_barang' => 0,
          'stok_komponen' => 0,
          'total_sisa' => 0
      ];
      continue;
  }

  // Simpan ke array (data nyata)
  $data[$nama_bulan] = [
      'stok_awal' => $stok_awal_sekarang,
      'masuk' => $masuk,
      'pengiriman' => $pengiriman,
      'stok_barang' => $stok_barang,
      'stok_komponen' => $stok_komponen,
      'total_sisa' => $stok_barang+$stok_komponen
  ];
}
$ket = '';
$no = 0;
$total_masuk = 0;
$total_pengiriman = 0;
$total_saldo_akhir = 0;
$total_barang_jadi = 0;
$total_komponen = 0;
$total_total_sisa = 0;
$total_selisih_kg = 0;
foreach ($data as $bulan => $d) {
    $saldo_akhir = $d['stok_awal'] + $d['masuk'] - $d['pengiriman'];
    $total_selisih = $d['total_sisa'] - $saldo_akhir;

    if ($d['total_sisa'] != 0) {
        $selisih_persen = number_format(($total_selisih / $d['total_sisa']) * 100, 2);
    } else {
        $selisih_persen = 0;
    }

    $total_masuk += $d['masuk'];
    $total_pengiriman += $d['pengiriman'];
    $total_saldo_akhir += $saldo_akhir;
    $total_barang_jadi += $d['stok_barang'];
    $total_komponen += $d['stok_komponen'];
    $total_total_sisa += $d['total_sisa'];
    $total_selisih_kg += $total_selisih;

    $awal_saldo = number_format($d['stok_awal'], 0, ',', '.');
    $masuk_1 = number_format($d['masuk'], 0, ',', '.');
    $kirim = number_format($d['pengiriman'], 0, ',', '.');
    $stok_b = number_format($d['stok_barang'], 0, ',', '.');
    $stok_k = number_format($d['stok_komponen'], 0, ',', '.');
    $sisa = number_format($d['total_sisa'], 0, ',', '.');
    $no++;

    $ket .= "<tr class='text-center'>
        <td>$no</td>
        <td>$bulan</td>
        <td>$awal_saldo</td>
        <td>$masuk_1</td>
        <td>$kirim</td>
        <td>" . number_format($saldo_akhir, 0, ',', '.') . "</td>
        <td>$stok_b</td>
        <td>$stok_k</td>
        <td>$sisa</td>
        <td>" . number_format($total_selisih, 0, ',', '.') . "</td>
        <td>$selisih_persen %</td>
    </tr>";
}

// Tambahkan total setelah foreach
$ket .= "<tr class='text-center font-weight-bold bg-light'>
    <td colspan='3'>TOTAL</td>
    <td>" . number_format($total_masuk, 0, ',', '.') . "</td>
    <td>" . number_format($total_pengiriman, 0, ',', '.') . "</td>
    <td>" . number_format($total_saldo_akhir, 0, ',', '.') . "</td>
    <td>" . number_format($total_barang_jadi, 0, ',', '.') . "</td>
    <td>" . number_format($total_komponen, 0, ',', '.') . "</td>
    <td>" . number_format($total_total_sisa, 0, ',', '.') . "</td>
    <td>" . number_format($total_selisih_kg, 0, ',', '.') . "</td>
    <td>-</td>
</tr>";

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Rekapan Mille</h1>
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Rekapan Berat</h3>
              </div>
              <!-- /.card-header -->
              <div class='card-body'>
              <form method='GET' action=''>
            <input type='hidden' name='url' value='rekap_bahan_mille'>
            <div class='form-group row'>
                            <label for='inputEmail3' class=' col-form-label'>Tahun </label>
                            <div class='col-sm-2'>
                            <select class='form-control' name='tahun' style='width: 100%;' id='typeInput' required>
                                <option>--Pilih Tahun</option>
                                $ket2
                            </select>
                            </div>
                            <div class='col-md-3'>
                  <button type='submit' class='btn btn-primary'>Tampilkan</button>
                </div>
            </div>
            </form>
                <table id='example1' class='table table-bordered table-striped'>
                  <thead>
                  <tr class='text-center'>
                    <th class='' rowspan='2'>No</th>
					          <th class='' rowspan='2'>Bulan</th>
                    <th class='' rowspan='2'>Stock Awal (Kg)</th>
                    <th class='' rowspan='2'>In/Produksi(Kg)</th>
                    <th class='' rowspan='2'>Pengiriman</th>
                    <th class='' rowspan='2'>Saldo Akhir</th>
                    <th class='' colspan='3'>Sisa Stock</th>
                    <th class='' rowspan='2'>Total Selisih</th>
                    <th class='' rowspan='2'>Selisih(%)</th>
                  </tr>
                  <tr class='subheader'>
                    <th>Barang Jadi</th>
                    <th>Komponen</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>
                  $ket
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>