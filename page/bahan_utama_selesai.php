<?php
$id=$_GET['tgl'];
$nama=$_POST['nama'];
$mesin=$_POST['mesin'];
$jumlah=$_POST['jumlah'];
$tgl_selesai = date("Y-m-d H:i:s");
$masuk=$_POST['entry'];

$qy = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM bahan_baku_utama WHERE id_bahan_utama='$id'"));

if ($masuk) {
    // Ambil total jumlah dari bahan_lapak_keluar
    $q_lapak = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM bahan_lapak_keluar WHERE id_keluar='$id'"));
    $total_keluar = $q_lapak['jumlah'];

    if ($jumlah <= $total_keluar) {
        header("location:index.php?url=".encrypt_url('bahan_setengah')."");
        mysqli_query($koneksi, "UPDATE bahan_baku_utama SET tanggal_selesai='$tgl_selesai', qty_hasil='$jumlah', id_mesin='$mesin', operator='$nama', keterangan='Selesai' WHERE id_bahan_utama='$id'");
    } else {
        $ket="<div class='alert alert-danger'>Qty hasil tidak boleh lebih dari total bahan lapak keluar ($total_keluar Kg).</div>";
    }
}

$qy=mysqli_query($koneksi,"select * from mesin");
while($data=mysqli_fetch_array($qy)){
	$pilih.="<option value='{$data['code_mesin']}'>{$data['nama_mesin']}</option>
	";
}

$isi="
    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							<div class='x_panel'>
								<div class='x_title'>
									<h2>Proses Bahan Utama</h2>
									<div class='clearfix'></div>
								</div>
								<div class='x_content'>
									<br />
									<form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Nama Operator <span class='required'>:</span>
											</label>
											<div class='col-md-5 col-sm-5'>
												<input type='text' name='nama'  class='form-control' >
											</div>
										</div>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align'>Mesin :</label>
											<div class='col-md-5 col-sm-5'>
												<select class='form-control' name='mesin'>
													<option>---pilih---</option>
													$pilih
												</select>
											</div>
										</div>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Jumlah Hasil <span class='required'>:</span>
											</label>
											<div class='col-md-2 col-sm-2 '>
												<input type='text' name='jumlah'  class='form-control' >
											</div>
										</div>
										
										<div class='ln_solid'></div>
                                            <div class='item form-group'>
                                            	<div class='col-md-6 col-sm-6 offset-md-3'>
                                                    <input type='submit' name='entry' class='btn btn-success' value='Selesai'>
													<a href='index.php?url=".encrypt_url('bahan_setengah')."' type='button' class='btn btn-danger'>Keluar</a>
                                            	</div>
                                        	</div>
									</form>
                                    $ket
								</div>
							</div>
						</div>
					</div>
";
?>