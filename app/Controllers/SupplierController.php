<?php

require_once '../app/core/Controller.php';
require_once '../app/Models/SupplierModel.php';

class SupplierController extends Controller {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?route=dashboard');
            exit;
        }
        $this->model = new SupplierModel();
    }

    public function index() {
        $data['suppliers'] = $this->model->getAll();
        $this->view('suppliers/index', $data);
    }

    public function create() {
        $this->view('suppliers/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->model->create($_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data Pemasok berhasil disimpan.";
                } else {
                    $_SESSION['flash_error'] = "Gagal menyimpan pemasok.";
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
            }
            header('Location: ?route=suppliers');
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? '';
        $data['supplier'] = $this->model->getById($id);
        
        if (!$data['supplier']) {
            $_SESSION['flash_error'] = "Data tidak ditemukan.";
            header('Location: ?route=suppliers');
            exit;
        }
        $this->view('suppliers/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            try {
                $success = $this->model->update($id, $_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data Pemasok berhasil diupdate.";
                    header('Location: ?route=suppliers');
                } else {
                    $_SESSION['flash_error'] = "Gagal memperbarui data.";
                    header('Location: ?route=suppliers/edit&id=' . urlencode($id));
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=suppliers/edit&id=' . urlencode($id));
            }
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? '';
        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['flash_success'] = "Pemasok berhasil dihapus.";
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Gagal menghapus data: " . $e->getMessage();
            }
        }
        header('Location: ?route=suppliers');
        exit;
    }
}
?>
