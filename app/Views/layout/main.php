<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($judul) ? htmlspecialchars($judul) : 'PT Inti Plastik Aneka Karet' ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?route=logout" class="nav-link text-danger font-weight-bold">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php require_once __DIR__ . '/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-4">
    <!-- Content Header (Page header) -->
    <div class="content-header mb-3">
        <div class="container-fluid">
            <h1 class="m-0 text-dark"><?= isset($judul) ? htmlspecialchars($judul) : 'Dashboard' ?></h1>
        </div>
    </div>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?= $content ?? '' ?>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 2.0 (MVC)
    </div>
    <strong>&copy; <?= date('Y') ?> PT IPAK.</strong> Hak Cipta Dilindungi.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>

<script>
  $(function () {
    if($('.datatable').length) {
      $('.datatable').DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    }
  });
</script>
</body>
</html>
