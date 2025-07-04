<?php
$produk=$_POST['produk'];
$id=$_GET['id'];
$simpan=$_POST['simpan'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_produk WHERE nama_produk = '$produk' AND nama_produk != '$produk'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"update jenis_produk set nama_produk='$produk' where id_jenis_produk='$id'");
		if($query)
		{
			header("location:index.php?url=jenis_produk");
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_fetch_array(mysqli_query($koneksi,"select * from jenis_produk where id_jenis_produk='$id'"));
$ip0=$qy['nama_produk'];

$isi="
    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							<div class='x_panel'>
								<div class='x_title'>
									<h2>Bahan Baku Utama</h2>
									<div class='clearfix'></div>
								</div>
								<div class='x_content'>
									<br />
									<form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>
										<div class='item form-group'>
											<label class='col-form-label col-md-3 col-sm-3 label-align'>Nama Produk :</label>
											<div class='col-md-3 col-sm-3 '>
												<input type='text' name='produk' class='form-control' value='$ip0' required >
											</div>
										</div>
										<div class='ln_solid'></div>
                                            <div class='item form-group'>
                                            	<div class='col-md-6 col-sm-6 offset-md-3'>
                                                    <input type='submit' name='simpan' class='btn btn-success' value='Simpan'>
                                                    <a href='index.php?url=jenis_produk' class='btn btn-danger'>Keluar</a>
                                            	</div>
                                        	</div>
									</form>
								</div>
							</div>
							
						</div>
					</div>
";
?>          