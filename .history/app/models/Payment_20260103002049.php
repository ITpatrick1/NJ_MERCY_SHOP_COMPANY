<?php
require_once __DIR__ . '/../core/Model.php';

class Payment extends Model {
    /**
     * Record a payment against a credit sale
     */
    public function recordPayment($credit_id, $amount_paid, $recorded_by, $remarks = '', $payment_date = null) {
        $this->db->beginTransaction();
        
        try {
            // Use current date if not provided
            if (!$payment_date) {
                $payment_date = date('Y-m-d H:i:s');
            } else {
                // Convert date to datetime if only date provided
                if (strlen($payment_date) === 10) {
                    $payment_date = $payment_date . ' ' . date('H:i:s');
                }
            }
            
            // Get current credit details
            $stmt = $this->db->prepare('SELECT * FROM credit_sales WHERE credit_id = ?');
            $stmt->execute([$credit_id]);
            $credit = $stmt->fetch();
            
            if (!$credit) {
                throw new Exception('Credit not found');
            }
            
            $current_paid = $credit['amount_paid'] ?? 0;
            $total_price = $credit['total_price'];
            $new_total_paid = $current_paid + $amount_paid;
            
            // Validate payment amount
            if ($amount_paid <= 0) {
                throw new Exception('Payment amount must be greater than zero');
            }
            
            if ($new_total_paid > $total_price) {
                throw new Exception('Payment exceeds total credit amount');
            }
            
            // Insert payment record with pending status and custom payment date
            $stmt = $this->db->prepare('INSERT INTO credit_payments (credit_id, amount_paid, payment_date, status, recorded_by, remarks) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$credit_id, $amount_paid, $payment_date, 'pending', $recorded_by, $remarks]);
            $payment_id = $this->db->lastInsertId();
            
            // Update credit_sales amount_paid
            $stmt = $this->db->prepare('UPDATE credit_sales SET amount_paid = amount_paid + ? WHERE credit_id = ?');
            $stmt->execute([$amount_paid, $credit_id]);
            
            // Update status based on payment
            $balance = $total_price - $new_total_paid;
            if ($balance <= 0) {
                // Fully paid
                $stmt = $this->db->prepare('UPDATE credit_sales SET status = ? WHERE credit_id = ?');
                $stmt->execute(['paid', $credit_id]);
            } else {
                // Partially paid
                $stmt = $this->db->prepare('UPDATE credit_sales SET status = ? WHERE credit_id = ?');
                $stmt->execute(['partial_paid', $credit_id]);
            }
            
            $this->db->commit();
            return $payment_id;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Get all payments for a credit
     */
    public function getPaymentsByCredit($credit_id) {
        $stmt = $this->db->prepare('
            SELECT p.*, u.full_name as recorded_by_name 
            FROM credit_payments p 
            JOIN users u ON p.recorded_by = u.user_id 
            WHERE p.credit_id = ? 
            ORDER BY p.payment_date DESC, p.created_at DESC
        ');
        $stmt->execute([$credit_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get all payments for a client
     */
    public function getPaymentsByClient($client_id) {
        $stmt = $this->db->prepare('
            SELECT p.*, cs.credit_id, u.full_name as recorded_by_name, c.name as client_name
            FROM credit_payments p 
            JOIN credit_sales cs ON p.credit_id = cs.credit_id
            JOIN clients c ON cs.client_id = c.client_id
            JOIN users u ON p.recorded_by = u.user_id 
            WHERE cs.client_id = ? 
            ORDER BY p.payment_date DESC, p.created_at DESC
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Approve a payment
     */
    public function approvePayment($payment_id, $approved_by) {
        $stmt = $this->db->prepare('UPDATE credit_payments SET status = ?, approved_by = ?, approved_at = NOW() WHERE payment_id = ?');
        return $stmt->execute(['approved', $approved_by, $payment_id]);
    }
    
    /**
     * Reject a payment
     */
    public function rejectPayment($payment_id, $approved_by, $reason = '') {
        $stmt = $this->db->prepare('UPDATE credit_payments SET status = ?, approved_by = ?, approved_at = NOW(), rejection_reason = ? WHERE payment_id = ?');
        return $stmt->execute(['rejected', $approved_by, $reason, $payment_id]);
    }
    
    /**
     * Edit payment status back to pending (undo approve/reject)
     */
    public function editPaymentStatus($payment_id) {
        $stmt = $this->db->prepare('UPDATE credit_payments SET status = ?, approved_by = NULL, approved_at = NULL, rejection_reason = NULL WHERE payment_id = ?');
        return $stmt->execute(['pending', $payment_id]);
    }
    
    /**
     * Get a single payment by ID
     */
    public function findPayment($payment_id) {
        $stmt = $this->db->prepare('
            SELECT p.*, u.full_name as recorded_by_name, a.full_name as approved_by_name
            FROM credit_payments p 
            JOIN users u ON p.recorded_by = u.user_id
            LEFT JOIN users a ON p.approved_by = a.user_id
            WHERE p.payment_id = ?
        ');
        $stmt->execute([$payment_id]);
        return $stmt->fetch();
    }
    
    /**
     * Get total payments for a credit
     */
    public function getTotalPayments($credit_id) {
        $stmt = $this->db->prepare('SELECT SUM(amount_paid) as total FROM credit_payments WHERE credit_id = ?');
        $stmt->execute([$credit_id]);
        return $stmt->fetchColumn() ?? 0;
    }
    /**
     * Get all payments with details
     */
    public function getAllPayments() {
        $stmt = $this->db->prepare('
            SELECT p.*, 
                   cs.credit_id,
                   c.name as client_name, 
                   u.full_name as recorded_by_name,
                   a.full_name as approved_by_name
            FROM credit_payments p
            JOIN credit_sales cs ON p.credit_id = cs.credit_id
            JOIN clients c ON cs.client_id = c.client_id
            JOIN users u ON p.recorded_by = u.user_id
            LEFT JOIN users a ON p.approved_by = a.user_id
            ORDER BY p.created_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get payment details by date range
     */
    public function getPaymentsByDateRange($start_date, $end_date) {
        $stmt = $this->db->prepare('
            SELECT p.*, cs.credit_id, c.name as client_name, c.phone, u.full_name as recorded_by_name
            FROM credit_payments p 
            JOIN credit_sales cs ON p.credit_id = cs.credit_id
            JOIN clients c ON cs.client_id = c.client_id
            JOIN users u ON p.recorded_by = u.user_id 
            WHERE p.payment_date BETWEEN ? AND ?
            ORDER BY p.payment_date DESC, p.created_at DESC
        ');
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }
}
