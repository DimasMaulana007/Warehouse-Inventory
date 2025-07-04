<?php
$kode=$_POST['kode'];
$nama=$_POST['nama'];
$masuk=$_POST['masuk'];
$id=$_GET['id'];

if($id!=""){
    mysqli_query($koneksi,"delete from lemari where kode_lemari='$id'");
    header("location:index.php?url=".encrypt_url('lemari')."");
}

if($masuk)
{
		$query=mysqli_query($koneksi,"insert into lemari(kode_lemari,nama_lemari)values('$kode','$nama')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
}
$qy=mysqli_query($koneksi,"select * from lemari");
while($data=mysqli_fetch_array($qy)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['kode_lemari']}</td>
			<td class=' '>{$data['nama_lemari']}</td>
			<td class=' last'><a href='index.php?url=".encrypt_url('lemari')."&id={$data['kode_lemari']}'>Delete</a></td>
		</tr>
	";
}

$isi="
    <div class='row'>
		<div class='col-md-12 col-sm-12 '>
			<div class='x_panel'>
				<div class='x_title'>
					<h2>Komponen Bahan</h2>
					<div class='clearfix'></div>
				</div>
				<div class='x_content'>
				<br />
									<form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Kode Lemari <span class='required'>:</span>
											</label>
											<div class='col-md-4 col-sm-4'>
												<input type='text' id='last-name' name='kode' required='required' class='form-control'>
											</div>
										</div>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align' for='last-name'>Nama Lemari <span class='required'>:</span>
											</label>
											<div class='col-md-4 col-sm-4'>
												<input type='text' id='last-name' name='nama' required='required' class='form-control'>
											</div>
										</div>
										<div class='ln_solid'></div>
										<div class='item form-group'>
											<div class='col-md-6 col-sm-6 offset-md-3'>
												<input type='submit' name='masuk' class='btn btn-success' value='Masukan'>
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
											<th class='column-title'>Kode Lemari</th>
											<th class='column-title'>Nama Lemari</th>
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