<?php
require_once '../config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(id) FROM users");
        return $stmt->fetchColumn();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, username, password, role, is_active) VALUES (:name, :username, :password, :role, :is_active)");
        return $stmt->execute([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'],
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);
    }

    public function update($id, $data) {
        // Jika password diisi string kosong, jangan update passwordnya
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("UPDATE users SET name = :name, username = :username, password = :password, role = :role, is_active = :is_active WHERE id = :id");
            return $stmt->execute([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role' => $data['role'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET name = :name, username = :username, role = :role, is_active = :is_active WHERE id = :id");
            return $stmt->execute([
                'name' => $data['name'],
                'username' => $data['username'],
                'role' => $data['role'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id
            ]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
