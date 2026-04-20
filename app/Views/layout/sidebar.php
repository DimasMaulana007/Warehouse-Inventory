<?php
// sidebar.php
$role = $_SESSION['user_role'] ?? 'guest';
$username = $_SESSION['user_id'] ?? 'Guest';

$roleDisplay = ucfirst($role);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="?route=dashboard" class="brand-link text-center">
      <span class="brand-text font-weight-light"><?= htmlspecialchars($roleDisplay) ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
      <div class="info">
        <a href="#" class="d-block text-bold" style="color:#c2c7d0; text-decoration:none;">
          <i class="fas fa-user-circle mr-2"></i><?= htmlspecialchars($username) ?>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="?route=dashboard" class="nav-link <?= (!isset($_GET['route']) || $_GET['route'] == 'dashboard') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if ($role === 'admin'): ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard"></i>
            <p>Data Stok <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Stok Bahan Lapak</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Stok Bahan Utama</p></a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>Masterdata <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Kode Bahan Baku</p></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Kode Kendaraan</p></a></li>
          </ul>
        </li>

        <?php elseif ($role === 'Bahan_lapak'): ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>Gudang Bahan Lapak <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Bahan Lapak Masuk</p></a></li>
          </ul>
        </li>

        <?php elseif ($role === 'teknisi'): ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Kendaraan <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Data Kendaraan</p></a></li>
          </ul>
        </li>
        <?php endif; ?>
        
        <!-- Pemisah Modul MVC Baru -->
        <li class="nav-header">MODUL BARU (MVC V2)</li>
        <li class="nav-item">
          <a href="?route=kendaraan" class="nav-link <?= (isset($_GET['route']) && $_GET['route'] == 'kendaraan') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>Manajemen Kendaraan</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
