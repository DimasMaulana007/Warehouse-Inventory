<?php
// sidebar.php
$role = $_SESSION['user_role'] ?? 'guest';
$username = $_SESSION['user_id'] ?? 'Guest';

$roleDisplay = ucfirst($role);
$currentRoute = $_GET['route'] ?? 'dashboard';
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
          <a href="?route=dashboard" class="nav-link <?= ($currentRoute == 'dashboard' || $currentRoute == '') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if ($role === 'admin'): ?>
        
        <li class="nav-header">MASTER DATA UTAMA</li>
        
        <li class="nav-item">
          <a href="?route=users" class="nav-link <?= (strpos($currentRoute, 'users') === 0) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Manajemen Pengguna</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="?route=kendaraan" class="nav-link <?= (strpos($currentRoute, 'kendaraan') === 0) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>Sistem Kendaraan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="?route=suppliers" class="nav-link <?= (strpos($currentRoute, 'suppliers') === 0) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-industry"></i>
            <p>Data Pemasok</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="?route=customers" class="nav-link <?= (strpos($currentRoute, 'customers') === 0) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Data Pelanggan</p>
          </a>
        </li>

        <li class="nav-header">LOGISTIK & PRODUKSI</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Modul Material <span class="badge badge-warning right">Segera</span></p>
          </a>
        </li>

        <?php elseif ($role === 'warehouse' || $role === 'Bahan_lapak'): ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>Gudang Lapak <span class="badge badge-warning right">Segera</span></p>
          </a>
        </li>

        <?php elseif ($role === 'teknisi'): ?>
        <li class="nav-item">
          <a href="?route=kendaraan" class="nav-link <?= (strpos($currentRoute, 'kendaraan') === 0) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Data Kendaraan</p>
          </a>
        </li>
        <?php endif; ?>
        
      </ul>
    </nav>
  </div>
</aside>
