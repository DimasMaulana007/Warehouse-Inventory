<?php
$id=$_GET['id'];
$qy=mysqli_query($koneksi,"SELECT
  sjd.jumlah as qty,
  sj.*,
  jw.nama_warna,
  bj.*,
  c.*,
  (
    SELECT SUM(sjd2.jumlah)
    FROM surat_jalan_detail sjd2
    WHERE sjd2.id_surat = sj.id_surat
  ) AS total
FROM surat_jalan_detail sjd
JOIN surat_jalan sj ON sj.id_surat=sjd.id_surat
JOIN barang_jadi bj ON bj.kode_barang=sjd.kode_barang
JOIN jenis_warna jw ON jw.id_warna=bj.warna
JOIN customer c ON c.id_customer=sj.customer
WHERE sj.id_surat='$id'
");
while($data=mysqli_fetch_array($qy)){
    $id_surat=$data['no_surat'];
    $tgl=$data['tanggal'];
    $penerima=$data['nama_customer'];
    $alamat=$data['alamat'];
    $tlp=$data['telepon'];
    $email=$data['email'];
    $plat=$data['kode_kendaraan'];
    $sopir=$data['sopir'];
    $total=$data['total'];
    $no++;
    if($data['hanger']=='Non Hanger'){$hanger='';
    }else{$hanger='-Hanger';}
    if($data['kunci']=='Key'){$key='-Key';
    }else{$key='';}
    $ket.="<tr>
              <td>$no</td>
              <td>{$data['merk']}-{$data['karakter']}$hanger$key</td>
              <td>SSN{$data['susun']}</td>
              <td>{$data['nama_warna']}</td>
              <td>{$data['qty']} Unit</td>
              <td>{$data['keterangan']}</td>
           </tr>
	";}
$isi="
<div class='invoice p-3 mb-3'>
              <div class='row'>
                <div class='col-12'>
                  <h4>
                    <i class='fas fa-globe'></i> PT.Inti Plastik Aneka Karet
                    <small class='float-right'>Date: $tgl</small>
                  </h4>
                </div>
              </div>
              <div class='row invoice-info'>
                <div class='col-sm-4 invoice-col'>
                  Penerima
                  <address>
                    <strong>$penerima</strong><br>
                    $alamat<br>
                    Phone: $tlp<br>
                    Email: $email
                  </address>
                </div>
                
                <div class='col-sm-4 invoice-col'>
                  <b>Surat Jalan : $id_surat</b><br>
                  <br>
                  <b>Supir:</b> $sopir<br>
                  <b>No Polisi:</b> $plat<br>
                </div>
              </div>
              <div class='row'>
                <div class='col-12 table-responsive'>
                  <table class='table table-striped'>
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Susun</th>
                      <th>Warna</th>
                      <th>Jumlah</th>
                      <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    $ket
                    </tbody>
                  </table>
                </div>
              </div>
              <div class='row'>
                <div class='col-12'>
                  <div class='table-responsive'>
                    <table class='table'>
                      <tr>
                        <th colspan='5'>Total Barang Kirim:</th>
                        <td>$total Unit</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class='row no-print'>
                <div class='col-12'>
                  <a href='index.php?url=pengiriman_hari' rel='noopener' target='_blank' class='btn btn-danger float-right'><i class='fas fa-arrow-left'></i> Kembali</a>
                </div>
              </div>
            </div>
";
?>
<script>
  window.addEventListener("load", window.print());
</script>