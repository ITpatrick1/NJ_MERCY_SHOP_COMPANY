<?php
require_once __DIR__ . '/../core/Model.php';
class Sale extends Model {
    public function create($amount, $user_id, $sales_date = null) {
        $date = $sales_date ?: date('Y-m-d');
        $stmt = $this->db->prepare('INSERT INTO daily_sales (amount, user_id, sales_date) VALUES (?, ?, ?)');
        $stmt->execute([$amount, $user_id, $date]);
        return $this->db->lastInsertId();
    }
    public function getByDate($date) {
        $stmt = $this->db->prepare('SELECT * FROM daily_sales WHERE sales_date = ?');
        $stmt->execute([$date]);
        return $stmt->fetch();
    }
    public function allByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT s.*, u.username as user_name FROM daily_sales s JOIN users u ON s.user_id = u.user_id WHERE s.sales_date BETWEEN ? AND ? ORDER BY s.sales_date DESC');
        $stmt->execute([$start, $end]);
        return $stmt->fetchAll();
    }
    public function totalByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT SUM(amount) as total FROM daily_sales WHERE sales_date BETWEEN ? AND ?');
        $stmt->execute([$start, $end]);
        return $stmt->fetchColumn();
    }
    public function dailyReport($date) {
        return $this->allByDateRange($date, $date);
    }
    public function weeklyReport($date) {
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
}
