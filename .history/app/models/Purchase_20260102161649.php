<?php
require_once __DIR__ . '/../core/Model.php';
class Purchase extends Model {
    public function create($supplier_id, $product_id, $quantity, $unit_price, $purchase_date = null) {
        $total_price = $quantity * $unit_price;
        $date = $purchase_date ?: date('Y-m-d');
        $stmt = $this->db->prepare('INSERT INTO purchases (supplier_id, product_id, quantity, unit_price, total_price, purchase_date) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$supplier_id, $product_id, $quantity, $unit_price, $total_price, $date]);
        return $this->db->lastInsertId();
    }
    public function allByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT p.*, s.name as supplier_name, pr.name as product_name FROM purchases p JOIN suppliers s ON p.supplier_id = s.supplier_id JOIN products pr ON p.product_id = pr.product_id WHERE p.purchase_date BETWEEN ? AND ? ORDER BY p.purchase_date DESC');
        $stmt->execute([$start, $end]);
        return $stmt->fetchAll();
    }
    public function totalByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT SUM(total_price) as total FROM purchases WHERE purchase_date BETWEEN ? AND ?');
        $stmt->execute([$start, $end]);
        return $stmt->fetchColumn();
    }
    public function dailyReport($date) {
        return $this->allByDateRange($date, $date);
    }
    public function weeklyReport($date): mixed {
        $start = date('Y-m-d', strtotime($date.' -'.(date('w', strtotime($date))).' days'));
        $end = date('Y-m-d', strtotime($start.' +6 days'));
        return $this->allByDateRange($start, $end);
    }
    public function monthlyReport($date) {
        $start = date('Y-m-01', strtotime($date));
        $end = date('Y-m-t', strtotime($date));
        return $this->allByDateRange($start, $end);
    }
    public function yearlyReport($date) {
        $start = date('Y-01-01', strtotime($date));
        $end = date('Y-12-31', strtotime($date));
        return $this->allByDateRange($start, $end);
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT p.*, s.name as supplier_name, pr.name as product_name FROM purchases p JOIN suppliers s ON p.supplier_id = s.supplier_id JOIN products pr ON p.product_id = pr.product_id WHERE p.purchase_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $supplier_id, $product_id, $quantity, $unit_price, $purchase_date = null) {
        $total_price = $quantity * $unit_price;
        $date = $purchase_date ?: date('Y-m-d');
        $stmt = $this->db->prepare('UPDATE purchases SET supplier_id = ?, product_id = ?, quantity = ?, unit_price = ?, total_price = ?, purchase_date = ? WHERE purchase_id = ?');
        $stmt->execute([$supplier_id, $product_id, $quantity, $unit_price, $total_price, $date, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM purchases WHERE purchase_id = ?');
        $stmt->execute([$id]);
    }
}
