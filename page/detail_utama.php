<?php
$id=$_GET['id'];
$jumlah=$_POST['jumlah'];
$bahan=$_POST['bahan'];
$ambil=$_POST['ambil'];
$kode=$_POST['kode'];
$tanggal_now = date("Y-m-d H:i:s");

$qy=mysqli_query($koneksi,"SELECT * 
FROM bahan_baku_utama, detail_bahan_utama 
WHERE bahan_baku_utama.nama_bahan = detail_bahan_utama.id_detail 
  AND bahan_baku_utama.nama_bahan = '$id';");
while($data=mysqli_fetch_array($qy)){
    $ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['tanggal_proses']}</td>
			<td class='a-right a-right '>{$data['operator']}</td>
            <td class='a-right a-right '>{$data['id_mesin']}</td>
            <td class='a-right a-right '>{$data['qty_hasil']} Kg</td>
			<td class=' last'><a href='#'></a>
            <input type='submit' class='btn-success' data-bs-toggle='modal' data-bs-target='#{$data['kode_bahan']}'  value='Ambil Bahan'>
            <input type='submit' class='btn-primary' data-bs-toggle='modal' data-bs-target='index.php?url=".encrypt_url('detail_utama')."&id={$data['kode_bahan']}'  value='Lihat Detail'>
            </td>
		</tr>
                        <!-- The Modal -->
                    <div class='modal' id='{$data['kode_bahan']}'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                        <!-- Modal Header -->
                        <div class='modal-header'>
                            <h4 class='modal-title'>Ambil Bahan</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'><i class='fa fa-close'></i></button>
                        </div>

                        <!-- Modal body -->
                        <div class='modal-body'>
                           <p><strong>Kode Bahan:</strong> <span id='modal-kode'>{$data['kode_jenis_bahan']}</span></p>
                            <p><strong>Jenis Bahan:</strong> <span id='modal-jenis'>{$data['nama_jenis_bahan']}</span></p>
                            <p><strong>Warna:</strong> <span id='modal-warna'></span>{$data['nama_warna']}</p>
                            <p><strong>Stok Tersedia:</strong> <span id='modal-stok'></span>{$data['total_stok']} Kg</p>
                        <form method='post'>
                            <input type='hidden' name='kode' value='{$data['kode_bahan']}'>
                            <!-- Tambahkan input pengambilan -->
                            <div class='col-sm-12'>Jumlah Ambil bahan :
                                <div class='form-group'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' name='jumlah'>
                                    <span class='input-group-addon'>
                                    <span class='glyphicon'>KG</span>
                                    </span>
                                </div>
                                </div>
                            </div>
                             <div class='col-sm-12'>untuk Bahan :
                                <div class='form-group'>
                                <div class='input-group'>
                                    <select class='form-control' name='bahan'>
													<option>---pilih---</option>
                                                    $pilih
												</select>
                                </div>
                                </div>
                            <input type='submit' name='ambil' class='btn btn-primary' value='ambil'>
                            </div>
                        </form>
                        </div>

                        <!-- Modal footer -->
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Keluar</button>
                        </div>

                        </div>
                    </div>
                    </div>
	";
}
$isi="
                    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							
							<div class='col-md-12 col-sm-12  '>
								<div class='x_panel'>
								<div class='x_title'>
									<h2>Stok Bahan Baku</h2>
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
											<th class='column-title'>Tanggal proses</th>
											<th class='column-title'>Operator</th>
                                            <th class='column-title'>Id_mesin</th>
                                            <th class='column-title'>Hasil</th>
											<th class='column-title no-link last'><span class='nobr'>Ambil Bahan</span>
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