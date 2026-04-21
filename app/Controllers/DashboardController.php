<?php

require_once '../app/core/Controller.php';
require_once '../app/Models/KendaraanModel.php';
require_once '../app/Models/UserModel.php';
require_once '../app/Models/SupplierModel.php';
require_once '../app/Models/CustomerModel.php';

class DashboardController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?route=/');
            exit;
        }
    }

    public function index() {
        $userModel = new UserModel();
        $kendaraanModel = new KendaraanModel();
        $supplierModel = new SupplierModel();
        $customerModel = new CustomerModel();

        $data['user_id'] = $_SESSION['user_id'];
        $data['user_role'] = $_SESSION['user_role'];
        $data['judul'] = 'Beranda Utama';

        // Ambil metrik untuk Dashboard Infobox
        $data['total_users'] = $userModel->countAll();
        $data['total_vehicles'] = $kendaraanModel->countAll();
        $data['total_suppliers'] = $supplierModel->countAll();
        $data['total_customers'] = $customerModel->countAll();

        $this->view('dashboard/index', $data);
    }
}
?>
