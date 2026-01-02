<?php
class Supplier extends Model {
    public function create($name, $tin_number, $phone) {
        $stmt = $this->db->prepare('INSERT INTO suppliers (name, tin_number, phone) VALUES (?, ?, ?)');
        $stmt->execute([$name, $tin_number, $phone]);
        return $this->db->lastInsertId();
    }
    public function findByName($name) {
        $stmt = $this->db->prepare('SELECT * FROM suppliers WHERE LOWER(name) = LOWER(?) LIMIT 1');
        $stmt->execute([$name]);
        return $stmt->fetch();
    }
    public function findByTin($tin) {
        $stmt = $this->db->prepare('SELECT * FROM suppliers WHERE tin_number = ? LIMIT 1');
        $stmt->execute([$tin]);
        return $stmt->fetch();
    }
    public function getDefaultSupplierId() {
        $stmt = $this->db->query('SELECT supplier_id FROM suppliers LIMIT 1');
        $row = $stmt->fetch();
        if ($row) return $row['supplier_id'];
        return $this->create('Default Supplier', 'TIN0000', '0000000000');
    }
    public function all() {
        return $this->db->query('SELECT * FROM suppliers ORDER BY name')->fetchAll();
    }
    
    public function updateTin($supplier_id, $new_tin) {
        $stmt = $this->db->prepare('UPDATE suppliers SET tin_number = ? WHERE supplier_id = ?');
        $stmt->execute([$new_tin, $supplier_id]);
    }
    
    public function updateName($supplier_id, $new_name) {
        $stmt = $this->db->prepare('UPDATE suppliers SET name = ? WHERE supplier_id = ?');
        $stmt->execute([$new_name, $supplier_id]);
    }
}
