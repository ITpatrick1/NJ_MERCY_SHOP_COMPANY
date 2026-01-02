<?php
require_once __DIR__ . '/../core/Model.php';
class Expense extends Model {
    public function create($amount, $user_id, $reason, $expense_date = null) {
        $date = $expense_date ?: date('Y-m-d');
        $stmt = $this->db->prepare('INSERT INTO expenses (amount, user_id, reason, expense_date) VALUES (?, ?, ?, ?)');
        $stmt->execute([$amount, $user_id, $reason, $date]);
        return $this->db->lastInsertId();
    }
    public function allByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT e.*, u.full_name as user_name FROM expenses e JOIN users u ON e.user_id = u.user_id WHERE e.expense_date BETWEEN ? AND ? ORDER BY e.expense_date DESC');
        $stmt->execute([$start, $end]);
        return $stmt->fetchAll();
    }
    public function totalByDateRange($start, $end) {
        $stmt = $this->db->prepare('SELECT SUM(amount) as total FROM expenses WHERE expense_date BETWEEN ? AND ?');
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
