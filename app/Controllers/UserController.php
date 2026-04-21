<?php

require_once '../app/core/Controller.php';
require_once '../app/Models/UserModel.php';

class UserController extends Controller {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?route=dashboard');
            exit;
        }
        $this->model = new UserModel();
    }

    public function index() {
        $data['users'] = $this->model->getAll();
        $this->view('users/index', $data);
    }

    public function create() {
        $this->view('users/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            
            $existing = $this->model->getByUsername($username);
            if ($existing) {
                $_SESSION['flash_error'] = "Username '{$username}' sudah digunakan terdaftar.";
                header('Location: ?route=users/create');
                exit;
            }

            try {
                $success = $this->model->create($_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data pengguna berhasil disimpan.";
                    header('Location: ?route=users');
                } else {
                    $_SESSION['flash_error'] = "Gagal menyimpan pengguna.";
                    header('Location: ?route=users/create');
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=users/create');
            }
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? '';
        $data['user'] = $this->model->getById($id);
        
        if (!$data['user']) {
            $_SESSION['flash_error'] = "Data tidak ditemukan.";
            header('Location: ?route=users');
            exit;
        }
        $this->view('users/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            
            try {
                $success = $this->model->update($id, $_POST);
                if ($success) {
                    $_SESSION['flash_success'] = "Data berhasil diupdate.";
                    header('Location: ?route=users');
                } else {
                    $_SESSION['flash_error'] = "Gagal memperbarui data.";
                    header('Location: ?route=users/edit&id=' . urlencode($id));
                }
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Error: " . $e->getMessage();
                header('Location: ?route=users/edit&id=' . urlencode($id));
            }
            exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? '';
        // Proteksi jangan hapus diri sendiri (sedang login)
        $target = $this->model->getById($id);
        if ($target && $target['username'] === $_SESSION['user_id']) {
            $_SESSION['flash_error'] = "Anda tidak boleh menghapus akun yang sedang Anda gunakan sendiri.";
            header('Location: ?route=users');
            exit;
        }

        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['flash_success'] = "Pengguna berhasil dihapus.";
            } catch (Exception $e) {
                $_SESSION['flash_error'] = "Gagal menghapus data: " . $e->getMessage();
            }
        }
        header('Location: ?route=users');
        exit;
    }
}
?>
