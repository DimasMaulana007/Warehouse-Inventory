<?php

require_once '../config/database.php';

class KendaraanModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(id) FROM vehicles");
        return $stmt->fetchColumn();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM vehicles ORDER BY vehicle_code ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        // Query param now is `id` or `vehicle_code`? If we edit by ID, query by ID.
        // Wait, current edits are probably routing with `?id=` being the old String based kode_kendaraan.
        // If we upgraded to BigInt Auto Increment 'id', we should query by 'id'.
        $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function getByVehicleCode($vehicle_code) {
        $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE vehicle_code = :vehicle_code");
        $stmt->execute(['vehicle_code' => $vehicle_code]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO vehicles (vehicle_code, name, type, license_plate, manufacture_year, jbki, jbi, capacity, registered_name) VALUES (:kode, :nama, :jenis, :polis, :thn, :jbki, :jbi, :angkut, :mobil_pabrik)");
        return $stmt->execute([
            'kode' => $data['kode'],
            'nama' => $data['nama'],
            'jenis' => $data['jenis'],
            'polis' => $data['polis'],
            'thn' => $data['thn'],
            'jbki' => $data['jbki'],
            'jbi' => $data['jbi'],
            'angkut' => $data['angkut'],
            'mobil_pabrik' => $data['mobil_pabrik']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE vehicles SET name = :nama, type = :jenis, license_plate = :polis, manufacture_year = :thn, jbki = :jbki, jbi = :jbi, capacity = :angkut, registered_name = :mobil_pabrik WHERE id = :id");
        return $stmt->execute([
            'nama' => $data['nama'],
            'jenis' => $data['jenis'],
            'polis' => $data['polis'],
            'thn' => $data['thn'],
            'jbki' => $data['jbki'],
            'jbi' => $data['jbi'],
            'angkut' => $data['angkut'],
            'mobil_pabrik' => $data['mobil_pabrik'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM vehicles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
