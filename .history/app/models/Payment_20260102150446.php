<?php
require_once __DIR__ . '/../core/Model.php';

class Payment extends Model {
    
    /**
     * Record a payment for a credit sale
     */
    public function create($credit_id, $amount, $recorded_by, $payment_method = 'cash', $notes = '', $payment_date = null) {
        $date = $payment_date ?: date('Y-m-d');
        
        $this->db->beginTransaction();
        try {
            // Insert payment record
            $stmt = $this->db->prepare('INSERT INTO payments (credit_id, amount, payment_date, payment_method, notes, recorded_by) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$credit_id, $amount, $date, $payment_method, $notes, $recorded_by]);
            $payment_id = $this->db->lastInsertId();
            
            // Update amount_paid in credit_sales
            $stmt2 = $this->db->prepare('UPDATE credit_sales SET amount_paid = amount_paid + ? WHERE credit_id = ?');
            $stmt2->execute([$amount, $credit_id]);
            
            // Check if fully paid and update status
            $stmt3 = $this->db->prepare('SELECT total_price, amount_paid FROM credit_sales WHERE credit_id = ?');
            $stmt3->execute([$credit_id]);
            $credit = $stmt3->fetch();
            
            if ($credit && $credit['amount_paid'] >= $credit['total_price']) {
                $stmt4 = $this->db->prepare('UPDATE credit_sales SET status = "paid" WHERE credit_id = ?');
                $stmt4->execute([$credit_id]);
            }
            
            $this->db->commit();
            return $payment_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Get all payments for a specific credit sale
     */
    public function findByCreditId($credit_id) {
        $stmt = $this->db->prepare('SELECT p.*, u.full_name as recorded_by_name FROM payments p JOIN users u ON p.recorded_by = u.user_id WHERE p.credit_id = ? ORDER BY p.payment_date DESC, p.created_at DESC');
        $stmt->execute([$credit_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get all payments for a specific client
     */
    public function findByClientId($client_id) {
        $stmt = $this->db->prepare('SELECT p.*, cs.client_id, cs.total_price as credit_total, pr.name as product_name, u.full_name as recorded_by_name FROM payments p JOIN credit_sales cs ON p.credit_id = cs.credit_id JOIN products pr ON cs.product_id = pr.product_id JOIN users u ON p.recorded_by = u.user_id WHERE cs.client_id = ? ORDER BY p.payment_date DESC');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get total payments for a specific credit sale
     */
    public function totalByCreditId($credit_id) {
        $stmt = $this->db->prepare('SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE credit_id = ?');
        $stmt->execute([$credit_id]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Get total payments by client
     */
    public function totalByClientId($client_id) {
        $stmt = $this->db->prepare('SELECT COALESCE(SUM(p.amount), 0) as total FROM payments p JOIN credit_sales cs ON p.credit_id = cs.credit_id WHERE cs.client_id = ?');
        $stmt->execute([$client_id]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Get payments by date range
     */
    public function findByDateRange($start_date, $end_date) {
        $stmt = $this->db->prepare('SELECT p.*, cs.client_id, c.name as client_name, pr.name as product_name, u.full_name as recorded_by_name FROM payments p JOIN credit_sales cs ON p.credit_id = cs.credit_id JOIN clients c ON cs.client_id = c.client_id JOIN products pr ON cs.product_id = pr.product_id JOIN users u ON p.recorded_by = u.user_id WHERE p.payment_date BETWEEN ? AND ? ORDER BY p.payment_date DESC');
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get total payments by date range
     */
    public function totalByDateRange($start_date, $end_date) {
        $stmt = $this->db->prepare('SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_date BETWEEN ? AND ?');
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchColumn();
    }
    
    /**
     * Delete a payment (admin function)
     */
    public function delete($payment_id) {
        $this->db->beginTransaction();
        try {
            // Get payment details first
            $stmt = $this->db->prepare('SELECT credit_id, amount FROM payments WHERE payment_id = ?');
            $stmt->execute([$payment_id]);
            $payment = $stmt->fetch();
            
            if ($payment) {
                // Decrease amount_paid in credit_sales
                $stmt2 = $this->db->prepare('UPDATE credit_sales SET amount_paid = amount_paid - ?, status = CASE WHEN status = "paid" THEN "active" ELSE status END WHERE credit_id = ?');
                $stmt2->execute([$payment['amount'], $payment['credit_id']]);
                
                // Delete payment
                $stmt3 = $this->db->prepare('DELETE FROM payments WHERE payment_id = ?');
                $stmt3->execute([$payment_id]);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
