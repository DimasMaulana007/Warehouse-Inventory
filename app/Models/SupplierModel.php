<?php
require_once '../config/database.php';

class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(id) FROM suppliers");
        return $stmt->fetchColumn();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM suppliers ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO suppliers (name, address, phone) VALUES (:name, :address, :phone)");
        return $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE suppliers SET name = :name, address = :address, phone = :phone WHERE id = :id");
        return $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
