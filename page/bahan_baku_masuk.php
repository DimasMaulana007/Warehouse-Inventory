<?php
$id=$_GET['id'];
$codebahan=$_POST['code_bahan'];
$qtysj=$_POST['qty_sj'];
$qtyact=$_POST['qty_act'];
$masuk=$_POST['entry'];
$test=$_POST['tes'];
if($masuk)
{
		$query=mysqli_query($koneksi,"insert into bahan_baku(no_sj,plat_kendaraan,supir,kode_bahan,tipe_bahan,stok,lokasi,tanggal)values('$surat','$plat','$supir','$codebahan','$bahanbaku','$qtysj','mille','$tanggal')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}

$qy=mysqli_query($koneksi,"select * from tanggal_bahan_baku where tanggal='$id'");
while($data=mysqli_fetch_array($qy)){
    $tanggal="{$data['tanggal']}";
    $surat="{$data['no_surat']}";
    $plat="{$data['no_polisi']}";
    $tipe="{$data['tipe_bahan']}";
    $supir="{$data['nama_supir']}";
	/*$ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['tanggal']}</td>
			<td class=' '>{$data['no_sj']}</td>
			<td class=' '>{$data['plat_kendaraan']}</td>
			<td class=' '>{$data['supir']}</td>
			<td class=' '>{$data['kode_bahan']}</td>
			<td class=' '>Supplier</td>
			<td class=' '>Jenis Bahan</td>
			<td class=' '>Nama Barang</td>
			<td class=' '>Warna</td>
			<td class='a-right a-right '>{$data['stok']}</td>
			<td class='a-right a-right '>{$data['stok']}</td>
			<td class='a-right a-right '>{$data['tipe_bahan']}</td>
			<td class=' last'><a href='#'>View</a></td>
		</tr>
	";*/
}
$isi="
    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							<div class='x_panel'>
								<div class='x_title'>
									<h2>Bahan Baku</h2>
									<div class='clearfix'></div>
								</div>
								<div class='x_content'>
									<br />
									<form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>

										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align'>Tanggal :</label>
											<div class='col-md-3 col-sm-3 '>
												<input type='date' name='date' class='form-control' value='$tanggal' required Readonly>
											</div>
										</div>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>No.Surat jalan <span class='required'>:</span>
											</label>
											<div class='col-md-6 col-sm-6 '>
												<input type='text' name='no_surat' id='first-name' required='required' value='$surat' class='form-control' Readonly>
											</div>
										</div>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Plat Kendaraan <span class='required'>:</span>
											</label>
											<div class='col-md-6 col-sm-6 '>
												<input type='text' name='plat' id='first-name' required='required' value='$plat' class='form-control' Readonly>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Nama Supir <span class='required'>:</span>
											</label>
											<div class='col-md-6 col-sm-6 '>
												<input type='text' name='plat' id='first-name' required='required' value='$supir' class='form-control' Readonly>
											</div>
										</div>
                                        <div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='first-name'>Tipe Bahan <span class='required'>:</span>
											</label>
											<div class='col-md-6 col-sm-6 '>
												<input type='text' name='plat' id='first-name' required='required' value='$tipe' class='form-control' Readonly>
											</div>
										</div>
										<div class='item form-group'>
												<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Code Bahan <span class='required'>:</span>
												</label>
												<div class='col-md-6 col-sm-6 '>
													<input type='text' id='last-name' name='code_bahan' required='required' class='form-control'>
												</div>
											</div>
											<div class='item form-group'>
												<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Qty Sj <span class='required'>:</span>
												</label>
												<div class='col-md-2 col-sm-2 '>
													<input type='text' id='last-name' name='qty_sj' required='required' class='form-control'>
												</div>
											</div>
											<div class='item form-group'>
												<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Qty Act <span class='required'>:</span>
												</label>
												<div class='col-md-2 col-sm-2 '>
													<input type='text' id='last-name' name='qty_act' required='required' class='form-control'>
												</div>
											</div>
											<div class='ln_solid'></div>
											<div class='item form-group'>
												<div class='col-md-6 col-sm-6 offset-md-3'>
													<input type='submit' name='entry' class='btn btn-success' value='Masukan'>
												</div> 
											</div>
									</form>
								</div>
							</div>
							<div class='col-md-12 col-sm-12  '>
								<div class='x_panel'>
								<div class='x_title'>
									<h2>Bahan Baku</h2>
									<ul class='nav navbar-right panel_toolbox'>
									</li>
									</li>
									</ul>
									<div class='clearfix'></div>
								</div>

								<div class='x_content'>
									<div class='table-responsive'>
									<table class='table table-striped jambo_table bulk_action'>
										<thead>
										<tr class='headings text-center'>

											<th class='column-title'>Tanggal </th>
											<th class='column-title'>NO. SJ/NO. SPBG </th>
											<th class='column-title'>No polisi</th>
											<th class='column-title'>Supir</th>
											<th class='column-title'>Code bahan</th>
											<th class='column-title'>Supplier</th>
											<th class='column-title'>Jenis Bahan</th>
											<th class='column-title'>Nama Barang</th>
											<th class='column-title'>Warna</th>
											<th class='column-title'>Qty SJ(Kg)</th>
											<th class='column-title'>Qty Act(Kg)</th>
											<th class='column-title'>Tipe bahan</th>
											<th class='column-title no-link last'><span class='nobr'>aksi</span>
											</th>
											<th class='bulk-actions' colspan='7'>
											<a class='antoo' style='color:#fff; font-weight:500;'>Bulk Actions ( <span class='action-cnt'> </span> ) <i class='fa fa-chevron-down'></i></a>
											</th>
										</tr>
										</thead>
										<tbody>
										$ket
										</tbody>
									</table>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
";
?>