<?php
$id=$_GET['id'];
$tgl=$_POST['tgl'];
$kebersihan=$_POST['kebersihan'];
$tangki=$_POST['tangki'];
$air_aki=$_POST['air_aki'];
$air_radiator=$_POST['air_radiator'];
$minyak_rem=$_POST['minyak_rem'];
$air_wiper=$_POST['air_wiper'];
$lampu=$_POST['lampu'];
$kaca_spion=$_POST['kaca_spion'];
$wiper=$_POST['wiper'];
$klakson=$_POST['klakson'];
$rem=$_POST['rem'];
$ban_dka=$_POST['ban_dka'];
$ban_dki=$_POST['ban_dki'];
$ban_bkad=$_POST['ban_bkad'];
$ban_bkal=$_POST['ban_bkal'];
$ban_bkid=$_POST['ban_bkid'];
$ban_bkil=$_POST['ban_bkil'];
$mesin=$_POST['mesin'];
$surat=$_POST['surat'];
$kunci=$_POST['kunci'];
$kotak_p3k=$_POST['kotak_p3k'];
$filter_udara=$_POST['filter_udara'];
$filter_oli=$_POST['filter_oli'];
$air_wiper=$_POST['air_wiper'];

$simpan=$_POST['simpan'];
if($simpan)
{
		$cek = mysqli_query($koneksi, "SELECT * FROM kode_kendaraan WHERE kode_kendaraan = '$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Kode sudah digunakan. Silakan gunakan Kode lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into kondisi_kendaraan(tanggal,kode_kendaraan,kebersihan,air_aki,tangki_bahan_bakar,air_radiator,
        minyak_rem,lampu,kaca_spion,wiper_kaca,klakson,rem,ban_kanan_d,ban_kiri_d,ban_kanan_bl,ban_kanan_bd,ban_kiri_bl,ban_kiri_bd,
        mesin,surat_kendaraan,kunci_peralatan,kotak_p3k_apar,filter_udara,filter_oli,air_wiper)
        values('$tgl','$id','$kebersihan','$air_aki','$tangki','$air_radiator','$minyak_rem','$lampu','$kaca_spion','$wiper','$klakson','$rem','$ban_dka',
        '$ban_dki','$ban_bkal','$ban_bkad','$ban_bkil','$ban_bkid','$mesin','$surat','$kunci','$kotak_p3k','$filter_udara','$filter_oli','$air_wiper')");
		if($query)
		{
			mysqli_query($koneksi,"update kode_kendaraan set kebersihan='$kebersihan',air_aki='$air_aki',tangki_bahan_bakar='$tangki',air_radiator='$air_radiator',
            minyak_rem='$minyak_rem',lampu='$lampu',kaca_spion='$kaca_spion',wiper_kaca='$wiper',klakson='$klakson',rem='$rem',ban_kanan_d='$ban_dka',ban_kiri_d='$ban_dki',
            ban_kanan_bd='$ban_bkad',ban_kiri_bd='$ban_bkid',ban_kanan_bl='$ban_bkal',ban_kiri_bl='$ban_bkil',mesin='$mesin',surat_kendaraan='$surat',
            kunci_peralatan='$kunci',kotak_p3k_apar='$kotak_p3k',filter_udara='$filter_udara',filter_oli='$filter_oli',air_wiper='$air_wiper' where kode_kendaraan='$id'");
		header("location:index.php?url=".encrypt_url('kendaraan')."");
        }
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$lihat=mysqli_fetch_array(mysqli_query($koneksi,"select * from kode_kendaraan where kode_kendaraan='$id'"));
$ip1=$lihat['kebersihan'];
$ip2=$lihat['air_aki'];
$ip3=$lihat['tangki_bahan_bakar'];
$ip4=$lihat['air_radiator'];
$ip5=$lihat['minyak_rem'];
$ip6=$lihat['lampu'];
$ip7=$lihat['kaca_spion'];
$ip8=$lihat['wiper_kaca'];
$ip9=$lihat['klakson'];
$ip10=$lihat['rem'];
$ip11=$lihat['ban_kanan_d'];
$ip12=$lihat['ban_kiri_d'];
$ip13=$lihat['ban_kanan_bd'];
$ip14=$lihat['ban_kiri_bd'];
$ip15=$lihat['ban_kanan_bl'];
$ip16=$lihat['ban_kiri_bl'];
$ip17=$lihat['mesin'];
$ip18=$lihat['surat_kendaraan'];
$ip19=$lihat['kunci_peralatan'];
$ip20=$lihat['kotak_p3k_apar'];
$ip21=$lihat['filter_udara'];
$ip22=$lihat['filter_oli'];
$ip23=$lihat['air_wiper'];

$isi="
<section class='content-header'>
    <div class='container-fluid'>
	<h1>Update Kendaraan</h1>
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
                <h3 class='card-title'>Stok Bahan Baku Lapak</h3>
              </div>
              <!-- /.card-header -->
              <form method='post'>
              <div class='card-body'>
              <div class='form-group row'>
                <label  class='col-sm-2 col-form-label'>Tanggal Update</label>
                <div class='col-sm-3'>
                <input type='date' name='tgl' class='form-control' required>
                </div>
            </div>
                <table  class='table table-bordered table-striped'>
                  <thead>
                <tr class='text-center align-middle' style='background-color:yellow'>
                    <th class='align-middle' rowspan='2'>Item Check</th>
                    <th class='align-middle' rowspan='2'>Langah Pengecekan</th>
                    <th class='align-middle' rowspan='2'>Standart</th>
                    <th class='align-middle' colspan='1'>No Kendaraan</th>
                </tr>
                <tr class='subheader text-center' style='background-color:yellow'>
                    <th>$id</th>
                </tr>
                </thead>
                <tr class='even pointer text-center'>
                    <td class=''>Kebersihan body dan mesin</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''>
                    <div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='kebersihan' value='$ip1'></td></div>
                </tr>
                <tr class='even pointer text-center'>
                    <td class=''>Air radiator</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''>
                    <div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='air_radiator' value='$ip4'></td></div>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Tangki Bahan Bakar </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='tangki' value='$ip3'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Minyak Rem</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='minyak_rem' value='$ip5'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Air Aki/Battery</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='air_aki' value='$ip2'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Air wiper</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='air_wiper' value='$ip23'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Lampu besar, Lampu rem, lampu sein</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='lampu' value='$ip6'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Kaca Spion</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='kaca_spion' value='$ip7'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Wiper kaca</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='wiper' value='$ip8'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Klakson </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='klakson' value='$ip9'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Rem kaki dan rem tangan </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='rem' value='$ip10'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Ban Depan Kanan</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_dka' value='$ip11'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Depan Kiri</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_dki' value='$ip12'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kanan dalam</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_bkad' value='$ip13'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kanan Luar </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_bkal' value='$ip15'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kiri dalam </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_bkid' value='$ip14'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Ban Belakang Kiri Luar </td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='ban_bkil' value='$ip16'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Mesin</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='mesin' value='$ip17'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Surat Kendaraan</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='surat' value='$ip18'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''> Kunci-kunci/Peralatan</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='kunci' value='$ip19'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Kotak P3K dan APAR ringan</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='kotak_p3k' value='$ip20'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Filter Udara</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='filter_udara' value='$ip21'></td></div></td>
                </tr>
                <tr class='even pointer text-center'>
                    <tr class='even pointer text-center'>
                    <td class=''>Filter Oli</td>
                    <td class=''>Visual check</td>
                    <td class=''>bersih dan rapi</td>
                    <td class=''><div  class='col-sm-6 offset-sm-3'>
                    <input class='form-control' type='text' name='filter_oli' value='$ip22'></td></div></td>
                </tr>
                  <tbody>
                  </tfoot>
                </table><br>
                <a href='index.php?url=".encrypt_url('kendaraan')."' class='btn btn-danger float-left'>Kembali</a>
                <input type='submit' name='simpan' class='btn btn-success float-right' value='Update'>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
";
?>