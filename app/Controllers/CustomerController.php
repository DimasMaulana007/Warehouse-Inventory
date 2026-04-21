<?php

require_once '../app/core/Controller.php';
require_once '../app/Models/CustomerModel.php';

class CustomerController extends Controller {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?route=dashboard');
            exit;
        }
        $this->model = new CustomerModel();
    }

    public function index() {
        $data['customers'] = $this->model->getAll();
        $this->view('customers/index', $data);
    }

    public function create() {
        $this->view('customers/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->model->create($_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data Pelanggan berhasil disimpan.";
                } else {
                    $_SESSION['flash_error'] = "Gagal menyimpan data pelanggan.";
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
            }
            header('Location: ?route=customers');
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? '';
        $data['customer'] = $this->model->getById($id);
        
        if (!$data['customer']) {
            $_SESSION['flash_error'] = "Data tidak ditemukan.";
            header('Location: ?route=customers');
            exit;
        }
        $this->view('customers/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            try {
                $success = $this->model->update($id, $_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data Pelanggan berhasil diupdate.";
                    header('Location: ?route=customers');
                } else {
                    $_SESSION['flash_error'] = "Gagal memperbarui data.";
                    header('Location: ?route=customers/edit&id=' . urlencode($id));
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=customers/edit&id=' . urlencode($id));
            }
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? '';
        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['flash_success'] = "Pelanggan berhasil dihapus.";
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Gagal menghapus data: " . $e->getMessage();
            }
        }
        header('Location: ?route=customers');
        exit;
    }
}
?>
