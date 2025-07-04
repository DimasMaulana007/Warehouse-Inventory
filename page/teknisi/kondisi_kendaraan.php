<?php
$qy=mysqli_query($koneksi,"SELECT * FROM kode_kendaraan");
while($data=mysqli_fetch_array($qy)){
  $kode.="
		<th>{$data['kode_kendaraan']}</th>
	";
    $cek1.="<td class=''>{$data['kebersihan']}</td>";
    $cek2.="<td class=''>{$data['air_radiator']}</td>";
    $cek3.="<td class=''>{$data['tangki_bahan_bakar']}</td>";
    $cek4.="<td class=''>{$data['minyak_rem']}</td>";
    $cek5.="<td class=''>{$data['air_aki']}</td>";
    $cek6.="<td class=''>{$data['air_wiper']}</td>";
    $cek7.="<td class=''>{$data['lampu']}</td>";
    $cek8.="<td class=''>{$data['kaca_spion']}</td>";
    $cek9.="<td class=''>{$data['wiper_kaca']}</td>";
    $cek10.="<td class=''>{$data['klakson']}</td>";
    $cek11.="<td class=''>{$data['rem']}</td>";
    $cek12.="<td".((int)$data['ban_kanan_d'] <= 30 ? " style='background-color:red;'" : "") . ">{$data['ban_kanan_d']}</td>";
    $cek13.="<td".((int)$data['ban_kiri_d'] <= 30 ? " style='background-color:red;'" : "") . ">{$data['ban_kiri_d']}</td>";
    $cek14.="<td".((int)$data['ban_kanan_bd'] <= 30 ? " style='background-color:red;'" : "") .">{$data['ban_kanan_bd']}</td>";
    $cek15.="<td".((int)$data['ban_kanan_bl'] <= 30 ? " style='background-color:red;'" : "") .">{$data['ban_kanan_bl']}</td>";
    $cek16.="<td".((int)$data['ban_kiri_bd'] <= 30 ? " style='background-color:red;'" : "") .">{$data['ban_kiri_bd']}</td>";
    $cek17.="<td".((int)$data['ban_kiri_bl'] <= 30 ? " style='background-color:red;'" : "") .">{$data['ban_kiri_bl']}</td>";
    $cek18.="<td class=''>{$data['mesin']}</td>";
    $cek19.="<td class=''>{$data['surat_kendaraan']}</td>";
    $cek20.="<td class=''>{$data['kunci_peralatan']}</td>";
    $cek21.="<td class=''>{$data['kotak_p3k_apar']}</td>";
    $cek22.="<td class=''>{$data['filter_udara']}</td>";
    $cek23.="<td class=''>{$data['filter_oli']}</td>";
}
$ja=mysqli_fetch_array(mysqli_query($koneksi,"SELECT COUNT(kode_kendaraan) AS jumlah FROM kode_kendaraan;"));
$sl=$ja['jumlah'];
$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Kondisi Kendaraan</h1>
</section>
    <!-- Main content -->
</section>
    <!-- Main content -->

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-12'>
            <div class='card'>
              <div class='card-header'>
                <h3 class='card-title'>Kondisi Kendaraan</h3>
              </div>
              <!-- /.card-header -->
              <form method='post'>
              <div class='card-body'>
                <table  class='table table-bordered table-striped'>
                  <thead>
                <tr class='text-center align-middle' style='background-color: rgb(82, 187, 47);'>
                    <th class='align-middle' rowspan='2'>Item Check</th>
                    <th class='align-middle' rowspan='2'>Langah Pengecekan</th>
                    <th class='align-middle' rowspan='2'>Standart</th>
                    <th class='align-middle' colspan='$sl'>No Kendaraan</th>
                </tr>
                <tr class='subheader text-center' style='background-color: rgb(82, 187, 47);'>
                    $kode
                </tr>
                </thead>
                <tr class='even pointer text-center'>
                    <td class=''>Kebersihan body dan mesin</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapih</td>
                    $cek1
                <tr class='even pointer text-center'>
                    <td class=''>Air radiator</td>
                    <td class=''>Visual check</td>
                    <td class=''>di antara leval max dan min</td>
                    $cek2
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Tangki Bahan Bakar </td>
                    <td class=''>Visual check</td>
                    <td class=''>tidak bocor</td>
                    $cek3
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Minyak Rem</td>
                    <td class=''>Visual check</td>
                    <td class=''>di antara leval max dan min</td>
                    $cek4
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Air Aki/Battery</td>
                    <td class=''>Visual check</td>
                    <td class=''>di antara leval max dan min</td>
                    $cek5
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Air wiper</td>
                    <td class=''>Visual check</td>
                    <td class=''>di antara leval max dan min</td>
                    $cek6
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Lampu besar, Lampu rem, lampu sein</td>
                    <td class=''>Visual check</td>
                    <td class=''>berfungsi dengan baik</td>
                    $cek7
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Kaca Spion</td>
                    <td class=''>Visual check</td>
                    <td class=''>jelas dan bersih</td>
                    $cek8
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Wiper kaca</td>
                    <td class=''>Visual check</td>
                    <td class=''>berfungsi dengan baik</td>
                    $cek9
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Klakson </td>
                    <td class=''>Visual check</td>
                    <td class=''>berfungsi dengan baik</td>
                    $cek10
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Rem kaki dan rem tangan </td>
                    <td class=''>Visual check</td>
                    <td class=''>berfungsi dengan baik</td>
                    $cek11
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Ban Depan Kanan</td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek12
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Depan Kiri</td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek13
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kanan dalam</td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek14
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kanan Luar </td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek15
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kiri dalam </td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek16
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kiri Luar </td>
                    <td class=''>Visual check</td>
                    <td class=''>Tidak gundul, baut roda lengkap terpasang, tidak kempes</td>
                    $cek17
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Mesin</td>
                    <td class=''>Visual check</td>
                    <td class=''>Bekerja dengan aman dan tidak ada kebocoran</td>
                    $cek18
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Surat Kendaraan</td>
                    <td class=''>Visual check</td>
                    <td class=''>lengkap</td>
                    $cek19
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Kunci-kunci/Peralatan</td>
                    <td class=''>Visual check</td>
                    <td class=''>lengkap</td>
                    $cek20
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Kotak P3K dan APAR ringan</td>
                    <td class=''>Visual check</td>
                    <td class=''>lengkap</td>
                    $cek21
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Filter Udara</td>
                    <td class=''>Visual check</td>
                    <td class=''>tidak kotor/mampet</td>
                    $cek22
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Filter Oli</td>
                    <td class=''>Visual check</td>
                    <td class=''>lengkap</td>
                    $cek23
                </tr>
                  <tbody>
                  </tfoot>
                </table>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>