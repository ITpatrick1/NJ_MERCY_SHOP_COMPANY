<?php
require_once __DIR__ . '/../core/Model.php';

class Notification extends Model {
    /**
     * Get all pending notifications (due today or overdue)
     */
    public function getPendingNotifications() {
        $stmt = $this->db->query('
            SELECT * FROM overdue_notifications_view 
            ORDER BY days_overdue DESC, due_date ASC
        ');
        return $stmt->fetchAll();
    }
    
    /**
     * Get notifications for a specific client
     */
    public function getClientNotifications($client_id) {
        $stmt = $this->db->prepare('
            SELECT nl.*, cs.total_price, cs.balance, cs.due_date
            FROM notification_logs nl
            JOIN credit_sales cs ON nl.credit_id = cs.credit_id
            WHERE nl.client_id = ?
            ORDER BY nl.sent_date DESC
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Create a manual notification
     */
    public function createNotification($credit_id, $client_id, $type, $message) {
        $stmt = $this->db->prepare('
            INSERT INTO notification_logs (credit_id, client_id, notification_type, message, status) 
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([$credit_id, $client_id, $type, $message, 'pending']);
        return $this->db->lastInsertId();
    }
    
    /**
     * Mark notification as sent
     */
    public function markAsSent($notification_id) {
        $stmt = $this->db->prepare('UPDATE notification_logs SET status = ? WHERE notification_id = ?');
        return $stmt->execute(['sent', $notification_id]);
    }
    
    /**
     * Mark notification as failed
     */
    public function markAsFailed($notification_id) {
        $stmt = $this->db->prepare('UPDATE notification_logs SET status = ? WHERE notification_id = ?');
        return $stmt->execute(['failed', $notification_id]);
    }
    
    /**
     * Get all due payment notifications for today
     */
    public function getTodayDueNotifications() {
        $stmt = $this->db->query('
            SELECT 
                cs.credit_id,
                cs.client_id,
                c.name as client_name,
                c.phone as client_phone,
                cs.total_price,
                cs.balance,
                cs.due_date,
                cs.status
            FROM credit_sales cs
            JOIN clients c ON cs.client_id = c.client_id
            WHERE cs.due_date = CURDATE()
              AND cs.status IN ("pending", "active", "partial_paid")
              AND cs.balance > 0
            ORDER BY c.name ASC
        ');
        return $stmt->fetchAll();
    }
    
    /**
     * Get all overdue notifications
     */
    public function getOverdueNotifications() {
        $stmt = $this->db->query('
            SELECT 
                cs.credit_id,
                cs.client_id,
                c.name as client_name,
                c.phone as client_phone,
                c.tin_number,
                cs.total_price,
                cs.amount_paid,
                cs.balance,
                cs.due_date,
                cs.date_issued,
                DATEDIFF(CURDATE(), cs.due_date) as days_overdue,
                cs.status
            FROM credit_sales cs
            JOIN clients c ON cs.client_id = c.client_id
            WHERE cs.due_date < CURDATE()
              AND cs.status IN ("pending", "active", "overdue", "partial_paid")
              AND cs.balance > 0
            ORDER BY cs.due_date ASC
        ');
        return $stmt->fetchAll();
    }
    
    /**
     * Get notification history
     */
    public function getNotificationHistory($limit = 100) {
        $stmt = $this->db->prepare('
            SELECT nl.*, c.name as client_name, c.phone as client_phone
            FROM notification_logs nl
            JOIN clients c ON nl.client_id = c.client_id
            ORDER BY nl.sent_date DESC
            LIMIT ?
        ');
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Generate notification message for a credit
     */
    public function generateNotificationMessage($credit_id) {
        $stmt = $this->db->prepare('
            SELECT cs.*, c.name as client_name, c.phone
            FROM credit_sales cs
            JOIN clients c ON cs.client_id = c.client_id
            WHERE cs.credit_id = ?
        ');
        $stmt->execute([$credit_id]);
        $credit = $stmt->fetch();
        
        if (!$credit) {
            return null;
        }
        
        $days_overdue = (strtotime(date('Y-m-d')) - strtotime($credit['due_date'])) / 86400;
        
        if ($days_overdue > 0) {
            $message = sprintf(
                "Dear %s, your payment of %s is %d day(s) overdue (Due: %s). Outstanding balance: %s. Please contact us to settle your account. Phone: %s",
                $credit['client_name'],
                number_format($credit['total_price'], 2),
                $days_overdue,
                $credit['due_date'],
                number_format($credit['balance'], 2),
                $credit['phone']
            );
        } elseif ($days_overdue == 0) {
            $message = sprintf(
                "Dear %s, reminder: your payment of %s is due today. Outstanding balance: %s. Thank you for your prompt payment.",
                $credit['client_name'],
                number_format($credit['total_price'], 2),
                number_format($credit['balance'], 2)
            );
        } else {
            $message = sprintf(
                "Dear %s, your payment of %s is due on %s. Outstanding balance: %s. Thank you.",
                $credit['client_name'],
                number_format($credit['total_price'], 2),
                $credit['due_date'],
                number_format($credit['balance'], 2)
            );
        }
        
        return [
            'credit' => $credit,
            'message' => $message,
            'days_overdue' => $days_overdue
        ];
    }
}
