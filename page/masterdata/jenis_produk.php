<?php
$nama=$_POST['nama_produk'];
$masuk=$_POST['entry'];
if ($masuk) {
    // Cek apakah kode sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM jenis_produk WHERE nama_produk = '$nama'");
    
    if (mysqli_num_rows($cek) > 0) {
        $ket = "<div class='alert alert-warning'>Nama sudah digunakan. Silakan gunakan Nama lain.</div>";
    } else {
		$query=mysqli_query($koneksi,"insert into jenis_produk(nama_produk)values('$nama')");
		if($query)
		{
			$ket="<div class='alert alert-success'>Data Tersimpan</div>";
		}
		else
		{
			$ket="<div class='alert alert-danger'>Memasukan Data Gagal</div>";
		}
    }
}
$qy=mysqli_query($koneksi,"select * from jenis_produk");
while($data=mysqli_fetch_array($qy)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['id_jenis_produk']}</td>
			<td class=' '>{$data['nama_produk']}</td>
           <td class=' '><a href='index.php?url=eproduk&id={$data['id_jenis_produk']}'>Edit</a></td>
		</tr>
	";
}


$isi="
<div class='row'>
                    <div class='col-md-12 col-sm-12 '>
                        <div class='x_panel'>
                            <div class='x_title'>
                                <h2>Jenis Produk</h2>
                                <div class='clearfix'></div>
                            </div>
                            <div class='x_content'>
                                <br />
                                <form id='demo-form2' method='post' data-parsley-validate class='form-horizontal form-label-left'>
                                    <div class='item form-group'>
                                        <label class='col-form-label col-md-3 col-sm-3 label-align'>Nama Produk :</label>
                                        <div class='col-md-4 col-sm-4 '>
                                            <input type='text' name='nama_produk' class='form-control' required>
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
                                <h2>Table Jenis Produk</h2>
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
                                        <th class='column-title'>ID Jenis Produk</th>
                                        <th class='column-title'>Nama Produk</th>
                                        <th class='column-title'>Opsi</th>
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