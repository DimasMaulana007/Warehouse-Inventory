<?php
require_once '../config/database.php';

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(id) FROM customers");
        return $stmt->fetchColumn();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM customers ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, address, phone) VALUES (:name, :address, :phone)");
        return $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE customers SET name = :name, address = :address, phone = :phone WHERE id = :id");
        return $stmt->execute([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
