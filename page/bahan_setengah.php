<?php
$s=mysqli_query($koneksi,"SELECT 
    bbu.*, 
    blk.*, 
    kb.*,
	dbu.*,
    jb.nama_jenis_bahan AS jenis_bahan
FROM 
    bahan_baku_utama bbu
JOIN 
    bahan_lapak_keluar blk ON blk.id_keluar = bbu.id_bahan_utama
JOIN
	detail_bahan_utama dbu ON dbu.id_detail_bahan_utama=bbu.nama_bahan
JOIN 
    kode_bahan kb ON blk.id_bahan = kb.kode_bahan
JOIN 
    jenis_bahan jb ON kb.id_jenis_bahan = jb.id_jenis_bahan
WHERE 
    bbu.keterangan = 'Belum Selesai'");
while($data=mysqli_fetch_array($s)){
	$ket.="
		<tr class='even pointer text-center'>
			<td class=''>{$data['tanggal']}</td>
			<td class=''>{$data['jenis_bahan']}</td>
			<td class=''>{$data['jumlah']} Kg</td>
			<td class=''>{$data['nama_bahan']}</td>
			<td class=''>{$data['keterangan']}</td>
			<td class=' last'><a href='index.php?url=".encrypt_url('bahan_utama_selesai')."&tgl={$data['id_bahan_utama']}'><button class='btn-primary'>Bahan Utama Selesai Diproses</button></a></td>
		</tr>
	";
}
$isi="
    <div class='row'>
						<div class='col-md-12 col-sm-12 '>
							<div class='col-md-12 col-sm-12  '>
								<div class='x_panel'>
								<div class='x_title'>
									<h2>Proses Bahan Utama</h2>
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

											<th class='column-title'>Tanggal Mulai</th>
											<th class='column-title'>Nama Bahan baku </th>
											<th class='column-title'>Jumlah Yang Diambil</th>
											<th class='column-title'>bahan Utama Yang Dibuat</th>
											<th class='column-title'>keterangan</th>
											<th class='column-title no-link last'><span class='nobr'>Option</span>
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