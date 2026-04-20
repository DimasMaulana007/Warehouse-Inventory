<?php
require_once __DIR__ . '/../core/Controller.php';

class DashboardController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?route=");
            exit;
        }

        $data = [
            'judul' => 'Dashboard SIPAK',
            'user_id' => $_SESSION['user_id'],
            'user_role' => $_SESSION['user_role']
        ];

        $this->view('dashboard/index', $data);
    }
}
?>
