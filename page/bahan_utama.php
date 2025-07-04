<?php
$tanggal=$_POST['date'];
$kode=$_POST['kode'];
$test=$_POST['tes'];

if($test)
{
		$rand=rand(0,1000000000);
		header("location:index.php?url=".encrypt_url('bahan_utama')."&id=$rand");
		$query=mysqli_query($koneksi,"insert into bahan_baku_utama(id_bahan_utama,tanggal,kode_bahan)values('$rand','$tanggal','$kode')");
		
}
$kkd=mysqli_query($koneksi,"select * from detail_bahan_utama");
while($data_kode=mysqli_fetch_array($kkd)){
	//$tes_kode=['kode_bahan'];
	$pilih.="
		<option value='{$data_kode['id_detail_bahan_utama']}'>{$data_kode['nama_bahan']}</option>
	";
}
$isi="
    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							<div class='x_panel'>
								<div class='x_title'>
									<h2>Bahan Utama</h2>
									<div class='clearfix'></div>
								</div>
								<div class='x_content'>
									<br />
									<form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Nama Bahan <span class='required'>:</span>
											</label>
											<div class='col-md-3 col-sm-3 '>
                                                <select class='form-control' name='kode'>
													<option>---pilih---</option>
                                                    $pilih
												</select>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>bekuan <span class='required'>:</span>
											</label>
											<div class='col-md-3 col-sm-3'>
                                                <input type='text' name='' class='form-control' required='required'>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>bekuan <span class='required'>:</span>
											</label>
											<div class='col-md-3 col-sm-3 '>
                                                <input type='text' name='' class='form-control' required='required'>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>bekuan <span class='required'>:</span>
											</label>
											<div class='col-md-3 col-sm-3 '>
                                                <input type='text' name='' class='form-control' required='required'>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Saringan <span class='required'>:</span>
											</label>
											<div class='col-md-2 col-sm-2'>
                                                <input type='text' name='' class='form-control' required='required'>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Susut <span class='required'>:</span>
											</label>
											<div class='col-md-2 col-sm-2'>
                                                <input type='text' name='' class='form-control' required='required'>
											</div>
										</div>
										<div class='item form-group'>
											<div class='col-md-2 col-sm-2 offset-md-3'>
												<input type='submit' name='tes' class='btn btn-success' value='Masukan Kode Bahan'>
											</div>
										</div>
										$coba
									</form>
								</div>
							</div>
						</div>
					</div>
";
?>