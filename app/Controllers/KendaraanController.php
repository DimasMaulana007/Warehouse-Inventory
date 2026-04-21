<?php

require_once '../app/core/Controller.php';
require_once '../app/Models/KendaraanModel.php';

class KendaraanController extends Controller {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?route=/');
            exit;
        }
        $this->model = new KendaraanModel();
    }

    public function index() {
        $data['kendaraan'] = $this->model->getAll();
        $this->view('kendaraan/index', $data);
    }

    public function create() {
        $this->view('kendaraan/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            
            // Cek apakah vehicle code sudah ada
            $existing = $this->model->getByVehicleCode($kode);
            if ($existing) {
                $_SESSION['flash_error'] = "Kode kendaraan '{$kode}' sudah digunakan. Gunakan kode lain.";
                header('Location: ?route=kendaraan/create');
                exit;
            }

            try {
                $success = $this->model->create($_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data kendaraan berhasil disimpan.";
                    header('Location: ?route=kendaraan');
                } else {
                    $_SESSION['flash_error'] = "Terjadi kesalahan saat menyimpan data.";
                    header('Location: ?route=kendaraan/create');
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=kendaraan/create');
            }
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? '';
        $data['kendaraan'] = $this->model->getById($id);
        
        if (!$data['kendaraan']) {
            $_SESSION['flash_error'] = "Data tidak ditemukan.";
            header('Location: ?route=kendaraan');
            exit;
        }
        $this->view('kendaraan/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            
            try {
                $success = $this->model->update($id, $_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data kendaraan berhasil diupdate.";
                    header('Location: ?route=kendaraan');
                } else {
                    $_SESSION['flash_error'] = "Gagal memperbarui data.";
                    header('Location: ?route=kendaraan/edit&id=' . urlencode($id));
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=kendaraan/edit&id=' . urlencode($id));
            }
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? '';
        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['flash_success'] = "Data kendaraan berhasil dihapus.";
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Gagal menghapus data: " . $e->getMessage();
            }
        }
        header('Location: ?route=kendaraan');
        exit;
    }
}
?>
