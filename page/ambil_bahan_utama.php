<?php
$jumlah=$_POST['jumlah'];
$kode=$_POST['kode'];
$keterangan=$_POST['ket'];
$ambil=$_POST['ambil'];
$tanggal_now = date("Y-m-d H:i:s");

if($ambil) {
    // 1. Insert ke bahan_lapak_keluar
    $tes = mysqli_query($koneksi, "INSERT INTO bahan_utama_keluar(tgl_keluar,id_bahan_baku_utama,keterangan,jumlah)VALUES('$tanggal_now','$kode','$keterangan','$jumlah')");
}
$qy=mysqli_query($koneksi,"SELECT 
  bbu.*, 
  dbu.*, 
  IFNULL(SUM(bbu.qty_hasil),0) AS total_masuk,
  IFNULL(buk.total_keluar, 0) AS total_keluar,
  IFNULL(SUM(bbu.qty_hasil), 0) - IFNULL(buk.total_keluar, 0) AS total_stok
FROM detail_bahan_utama dbu
LEFT JOIN bahan_baku_utama bbu ON bbu.nama_bahan = dbu.id_detail_bahan_utama
LEFT JOIN (
    SELECT id_bahan_utama, SUM(qty_hasil) AS total_masuk_subquery
    FROM bahan_baku_utama
    GROUP BY id_bahan_utama
) bbu_sub ON bbu_sub.id_bahan_utama = dbu.id_detail_bahan_utama
LEFT JOIN (
    SELECT id_bahan_baku_utama, SUM(jumlah) AS total_keluar
    FROM bahan_utama_keluar
    GROUP BY id_bahan_baku_utama
) buk ON buk.id_bahan_baku_utama = bbu.id_bahan_utama
GROUP BY dbu.id_detail_bahan_utama, bbu.nama_bahan
");
while($data=mysqli_fetch_array($qy)){
    $ket.="
		<tr class='even pointer text-center'>
			<td class=' '>{$data['nama_bahan']}</td>
			<td class='a-right a-right '>{$data['total_stok']} Kg</td>
			<td class=' last'><a href='#'></a><input type='submit' class='btn-success' data-bs-toggle='modal' data-bs-target='#{$data['id_bahan_utama']}'  value='Ambil Bahan'></td>
		</tr>
                        <!-- The Modal -->
                    <div class='modal' id='{$data['id_bahan_utama']}'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                        <!-- Modal Header -->
                        <div class='modal-header'>
                            <h4 class='modal-title'>Ambil Bahan</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'><i class='fa fa-close'></i></button>
                        </div>

                        <!-- Modal body -->
                        <div class='modal-body'>
                           <p><strong>Nama Bahan:</strong> <span id='modal-kode'>{$data['nama_bahan']}</span></p>
                            <p><strong>Stok Tersedia:</strong> <span id='modal-stok'></span>{$data['total_stok']} Kg</p>
                        <form method='post'>
                            <input type='hidden' name='kode' value='{$data['id_bahan_utama']}'>
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
                             <div class='col-sm-12'>Keterangan :
                                <div class='form-group'>
                                 <div class='input-group'>
                                    <input type='text' class='form-control' name='ket'>
                                    </span>
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
									<h2>Stok Bahan Utama</h2>
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
											<th class='column-title'>Bahan Utama</th>
											<th class='column-title'>Total Bahan</th>
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