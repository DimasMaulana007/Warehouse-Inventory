<?php
$am=mysqli_fetch_array(mysqli_query($koneksi,"select * from users where username='{$_COOKIE['id']}'"));
switch($am['role']){
	case"admin":
		$link="
    <!-- Sidebar -->
    <div class='sidebar'>
      <!-- Sidebar Menu -->
      <nav class='mt-2'>
        <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-clipboard'></i><p>Data Stok<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_bahan_baku')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Stok Bahan Lapak</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('data_sortir')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Bahan Crusher</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_bahan_utama')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Bahan Baku</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_komponen')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Komponen</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_barang')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Produk Jadi</p></a></li>
              </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-clipboard'></i><p>ATK<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
			        <li class='nav-item'><a href='index.php?url=".encrypt_url('atk_masuk')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Atk Masuk</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Atk Keluar</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_atk')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Stok ATK</p></a></li>
              </ul>
          </li>          
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-clipboard'></i><p>Laporan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
			        <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_bahan_lapak')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan Bulanan Lapak</p></a></li>
			        <li class='nav-item'><a href='index.php?url=".encrypt_url('')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan Surat Jalan</p></a></li>
              </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-database'></i><p>Masterdata<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('kode_bahan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Bahan Baku</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('jenis_stiker')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Jenis Stiker</p></a>
              </li><li class='nav-item'><a href='index.php?url=".encrypt_url('komponen_detail')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Komponen</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('barang')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Barang Jadi</p></a>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('mesin')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Mesin</p></a>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('komposisi_barang')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Komposisi</p></a>
             
              <li class='nav-item'><a href='index.php?url=".encrypt_url('kode_kendaraan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Kendaraan</p></a>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('kode_pendukung')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kode Komponen Pendukung</p></a>
              </li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-database'></i><p>Mini Data<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('jenis_bahan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Bahan Baku</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('baku')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Jenis Bahan</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('jenis_warna')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Jenis Warna</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('supplier')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Supplier</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('Tambah Customer')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Customer</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('type')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Type Lemari</p></a></li>
            </ul>
          </li>
		</ul>
      </nav>
    </div>
    ";
		$jabatan="<a href='index.php' class='brand-link text-center'>
                  <span class='brand-text font-weight-light'>Admin</span>
              </a>";break;
    case"Bahan_lapak":
		$link="
    <!-- Sidebar -->
    <div class='sidebar'>
      <!-- Sidebar Menu -->
      <nav class='mt-2'>
        <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Gudang Bahan Lapak<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('tanggal_bahan_baku')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Bahan Lapak Masuk</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('proses_bahan')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Proses Crusher/Sortir</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('proses_recycle')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Proses Recycle</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Stok Bahan Lapak<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_bahan_baku')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Stok Bahan Lapak</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('data_sortir')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Hasil Sortir</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('data_recycle')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Stok Hasil Recycle</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Laporan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_bahan_lapak')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan Bulanan Lapak</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_sortir')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan Bulanan Sortir</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_recycle')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan Bulanan Recycle</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Mixing Bahan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('b')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Mixing</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>SPBG Bahan Baku<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_spbg_bahan_baku')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan SPBG</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('spbg_bahan_baku')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Pengambilan Bahan Baku</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Bahan Baku Impor<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_bahan_impor')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan bahan Baku Impor</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('bahan_baku_impor')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Bahan Baku Masuk</p></a></li>
            </ul>
          </li>
		</ul>
      </nav>
    </div>
    ";
		$jabatan="<a href='index.php' class='brand-link text-center'>
                <span class='brand-text font-weight-light'>Gudang Bahan</span>
              </a>";break;
    case"Produksi":
		$link="
    <!-- Sidebar -->
    <div class='sidebar'>
      <!-- Sidebar Menu -->
      <nav class='mt-2'>
        <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Produksi<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('tanggal_komponen')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Proses Injection</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('assenbly_barang_jadi')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Assembly Barang Jadi</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Produk Impor</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('mixing')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Mixing</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Stok Barang<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_komponen')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Stok Komponen</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_produk_jadi')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Stok Produk</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Laporan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_proses_komponen')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>laporan Injection Komponen</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_assembly')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>laporan Assembly Barang</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>SPBG<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('spbg_komponen')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>SPBG Komponen</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_spbg_komponen')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Laporan SPBG</p></a></li>
            </ul>
          </li>
                 <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Barang Pengiriman Masuk<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('komponen_kardus')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Barang Kardus</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('komponen_pendukung')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Barang Komponen Pendukung</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('komponen_masuk')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Barang Komponen</p></a></li>
            </ul>
          </li>
		  </ul>
		</ul>
      </nav>
    </div>
    ";
		$jabatan="<a href='index.php' class='brand-link text-center'>
                <span class='brand-text font-weight-light'>Produksi</span>
              </a>";break;
    case"teknisi":
		$link="
    <!-- Sidebar -->
    <div class='sidebar'>
      <!-- Sidebar Menu -->
      <nav class='mt-2'>
        <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Kendaraan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('kendaraan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Data Kendaraan</p></a></li>
            </ul>
          </li>
         <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Mesin<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('data_mesin')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Data Mesin</p></a></li>
            </ul>
          </li>
      </nav>
    </div>
    ";
		$jabatan="<a href='index.php' class='brand-link text-center'>
                <span class='brand-text font-weight-light'>Teknisi</span>
              </a>";break;
              case"direkrut":
                $link="
                <!-- Sidebar -->
                <div class='sidebar'>
                  <!-- Sidebar Menu -->
                  <nav class='mt-2'>
                    <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Data Mille<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_bahan_lapak')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Data Bahan Lapak Masuk</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_hasil_crusher')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Hasil Crusher</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_hasil_recycle')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Hasil Recycle</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_injection')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Injection Komponen</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_assembly_barang')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Assembly Barang</p></a></li>
                        </ul>
                      </li>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Stok Barang Mille<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_bahan_baku')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Data Stock Lapak</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_sortir')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Stock Crusher</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('data_recycle')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Stock Recycle</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_komponen')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Stock Komponen</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('stok_produk_jadi')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Data Stock Barang</p></a></li>
                        </ul>
                      </li>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Rekapan Mille<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('rekap_bahan_mille')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Rekap Bahan Mille</p></a></li>
                         </ul>
                      </li>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Laporan Pengiriman<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_kirim_bahan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Pengririman Bahan</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('laporan_kirim_barang')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Pengririman Barang</p></a></li>
                         </ul>
                      </li>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Data Pengiriman<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('pengiriman_hari')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Pengiriman Produk</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('flow_penjualan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Flot Chart Penjualan</p></a></li>
                         </ul>
                      </li>
                      <li class='nav-item'>
                        <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Data Kendaraan<i class='fas fa-angle-left right'></i></p></a>
                        <ul class='nav nav-treeview'>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('kondisi_kendaraan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Kondisi Kendaraan</p></a></li>
                          <li class='nav-item'><a href='index.php?url=".encrypt_url('')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Data Mesin</p></a></li>
                        </ul>
                      </li>
                </ul>
                  </nav>
                </div>
                ";
                $jabatan="<a href='index.php' class='brand-link text-center'>
                            <span class='brand-text font-weight-light'>Direktur</span>
                          </a>";break;
    case"Logistik":
		$link="
    <!-- Sidebar -->
    <div class='sidebar'>
      <!-- Sidebar Menu -->
      <nav class='mt-2'>
        <ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Surat Jalan<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('')."".encrypt_url('kirim_bahan')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Surat Jalan Bahan Baku</p></a></li>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('')."".encrypt_url('kirim_barang')."' class='nav-link '><i class='far fa-circle nav-icon'></i><p>Surat Jalan Barang Jadi</p></a></li>
            </ul>
          </li>
          <li class='nav-item'>
            <a href='#' class='nav-link'><i class='nav-icon fas fa-industry'></i><p>Return<i class='fas fa-angle-left right'></i></p></a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'><a href='index.php?url=".encrypt_url('')."".encrypt_url('')."' class='nav-link'><i class='far fa-circle nav-icon'></i><p>Return Barang</p></a></li>
            </ul>
          </li>
		</ul>
      </nav>
    </div>
    ";
		$jabatan="<a href='index.php' class='brand-link text-center'>
                <span class='brand-text font-weight-light'>Logistik</span>
              </a>";break;  
}
$tampil="
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>PT Inti Plastik Aneka Karet</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'>
  <!-- Font Awesome -->
  <link rel='stylesheet' href='plugins/fontawesome-free/css/all.min.css'>
  <!-- daterange picker -->
  <link rel='stylesheet' href='plugins/daterangepicker/daterangepicker.css'>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel='stylesheet' href='plugins/icheck-bootstrap/icheck-bootstrap.min.css'>
  <!-- Bootstrap Color Picker -->
  <link rel='stylesheet' href='plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'>
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel='stylesheet' href='plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'>
  <!-- Select2 -->
  <link rel='stylesheet' href='plugins/select2/css/select2.min.css'>
  <link rel='stylesheet' href='plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'>
  <!-- Bootstrap4 Duallistbox -->
  <link rel='stylesheet' href='plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'>
  <!-- BS Stepper -->
  <link rel='stylesheet' href='plugins/bs-stepper/css/bs-stepper.min.css'>
  <!-- dropzonejs -->
  <link rel='stylesheet' href='plugins/dropzone/min/dropzone.min.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='dist/css/adminlte.min.css'>
  <link rel='stylesheet' href='plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'>
  <link rel='stylesheet' href='plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'>
  <link rel='stylesheet' href='plugins/datatables-responsive/css/responsive.bootstrap4.min.css'>
  <link rel='stylesheet' href='plugins/datatables-buttons/css/buttons.bootstrap4.min.css'>
</head>
<body class='hold-transition sidebar-mini'>
<div class='wrapper'>
  <!-- Navbar -->
  <nav class='main-header navbar navbar-expand navbar-white navbar-light'>
    <!-- Left navbar links -->
    <ul class='navbar-nav'>
      <li class='nav-item'>
        <a class='nav-link' data-widget='pushmenu' href='#' role='button'><i class='fas fa-bars'></i></a>
      </li>
    </ul>
    <ul class='navbar-nav ml-auto'>
	  <li class='nav-item d-none d-sm-inline-block'>
        <a href='index.php?url=".encrypt_url('keluar')."' class='nav-link'>Keluar</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class='main-sidebar sidebar-dark-primary elevation-4'>
    <!-- Brand Logo -->
    $jabatan
    $link
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class='content-wrapper'>
    <!-- Content Header (Page header) -->
    $isi
  </div>
  <footer class='main-footer'>
    <div class='float-right d-none d-sm-block'>
      <b>Version</b> 1.0
    </div>
    <strong>Warehouse<a href=''></a></strong> 
  </footer>
  <aside class='control-sidebar control-sidebar-dark'>
  </aside>
</div>
<!-- jQuery -->
<script src='plugins/jquery/jquery.min.js'></script>
<!-- Bootstrap 4 -->
<script src='plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- Select2 -->
<script src='plugins/select2/js/select2.full.min.js'></script>
<!-- Bootstrap4 Duallistbox -->
<script src='plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'></script>
<!-- InputMask -->
<script src='plugins/moment/moment.min.js'></script>
<script src='plugins/inputmask/jquery.inputmask.min.js'></script>
<!-- date-range-picker -->
<script src='plugins/daterangepicker/daterangepicker.js'></script>
<!-- bootstrap color picker -->
<script src='plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src='plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'></script>
<!-- Bootstrap Switch -->
<script src='plugins/bootstrap-switch/js/bootstrap-switch.min.js'></script>
<!-- BS-Stepper -->
<script src='plugins/bs-stepper/js/bs-stepper.min.js'></script>
<!-- dropzonejs -->
<script src='plugins/dropzone/min/dropzone.min.js'></script>
<!-- AdminLTE App -->
<script src='dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='dist/js/demo.js'></script>
<!-- Page specific script -->
<script src='plugins/datatables/jquery.dataTables.min.js'></script>
<script src='plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'></script>
<script src='plugins/datatables-responsive/js/dataTables.responsive.min.js'></script>
<script src='plugins/datatables-responsive/js/responsive.bootstrap4.min.js'></script>
<script src='plugins/datatables-buttons/js/dataTables.buttons.min.js'></script>
<script src='plugins/datatables-buttons/js/buttons.bootstrap4.min.js'></script>
<script src='plugins/jszip/jszip.min.js'></script>
<script src='plugins/pdfmake/pdfmake.min.js'></script>
<script src='plugins/pdfmake/vfs_fonts.js'></script>
<script src='plugins/datatables-buttons/js/buttons.html5.min.js'></script>
<script src='plugins/datatables-buttons/js/buttons.print.min.js'></script>
<script src='plugins/datatables-buttons/js/buttons.colVis.min.js'></script>
<script src='plugins/bootstrap-switch/js/bootstrap-switch.min.js'></script>
<script src='plugins/flot/jquery.flot.js'></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $('input[data-bootstrap-switch]').each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector('#template')
  previewNode.id = ''
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: '/target-url', // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: '#previews', // Define the container to display the previews
    clickable: '.fileinput-button' // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on('addedfile', function(file) {
    // Hookup the start button
    file.previewElement.querySelector('.start').onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on('totaluploadprogress', function(progress) {
    document.querySelector('#total-progress .progress-bar').style.width = progress + '%'
  })

  myDropzone.on('sending', function(file) {
    // Show the total progress bar when upload starts
    document.querySelector('#total-progress').style.opacity = '1'
    // And disable the start button
    file.previewElement.querySelector('.start').setAttribute('disabled', 'disabled')
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on('queuecomplete', function(progress) {
    document.querySelector('#total-progress').style.opacity = '0'
  })

  // Setup the buttons for all transfers
  // The 'add files' button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector('#actions .start').onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector('#actions .cancel').onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
<script>
  $(function () {
    $('#example1').DataTable({
      'responsive': true, 'lengthChange': false, 'autoWidth': false,
      'buttons': ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false,
      'responsive': true,	
    });
  });
</script>
<script>
  // Fokus ke input saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('typeInput').focus();
  });
  $(document).ready(function() {
    $('#typeSelect').select2().select2('open'); // langsung buka
  });
  document.addEventListener('DOMContentLoaded', function() {
    const inputTanggal = document.getElementById('tanggalInput');
    inputTanggal.focus();
    inputTanggal.click(); // beberapa browser memicu datepicker dengan click
  });
  $(function () {
    $('#jamPicker').datetimepicker({
      format: 'HH:mm', // 24 jam, contoh: 14:30
      icons: {
        time: 'far fa-clock',
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down'
      },
      locale: 'id' // opsional jika kamu pakai moment.js + lokal Indonesia
    });
  });
  $(function () {
    $('#jamPicker1').datetimepicker({
      format: 'HH:mm', // 24 jam, contoh: 14:30
      icons: {
        time: 'far fa-clock',
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down'
      },
      locale: 'id' // opsional jika kamu pakai moment.js + lokal Indonesia
    });
  });
  $('input[data-bootstrap-switch]').each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>
<script>
var bar_data = {
      data : ".json_encode($data_points).",
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [[1,'januari'], [2,'Februari'], [3,'Maret'], [4,'April'], [5,'Mei'], [6,'Juni'], [7,'Juli'], 
        [8,'Agustus'], [9,'September'], [10,'Oktober'], [11,'November'], [12,'Desember']]
      }
    })
</script>
</body>
</html>
";
?>