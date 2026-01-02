<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../models/Client.php';

class NotificationController extends Controller {
    private function ensureRole($roles = ['manager']) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || !in_array($user['role'], $roles)) {
            $this->setFlash('Access denied.','danger');
            header('Location: /dashboard');
            exit;
        }
    }

    /**
     * View all pending notifications
     */
    public function index() {
        $this->ensureRole();
        
        $notificationModel = new Notification();
        $dueToday = $notificationModel->getTodayDueNotifications();
        $overdue = $notificationModel->getOverdueNotifications();
        
        $this->view('notifications/index', [
            'dueToday' => $dueToday,
            'overdue' => $overdue
        ]);
    }
    
    /**
     * View notification history
     */
    public function history() {
        $this->ensureRole();
        
        $limit = $_GET['limit'] ?? 100;
        $notificationModel = new Notification();
        $notifications = $notificationModel->getNotificationHistory($limit);
        
        $this->view('notifications/history', ['notifications' => $notifications]);
    }
    
    /**
     * Generate notification for a specific credit
     */
    public function generate() {
        $this->ensureRole();
        
        $credit_id = $_GET['credit_id'] ?? null;
        
        if (!$credit_id) {
            $this->setFlash('Credit ID is required.', 'danger');
            header('Location: /credits');
            exit;
        }
        
        $notificationModel = new Notification();
        $notification = $notificationModel->generateNotificationMessage($credit_id);
        
        if (!$notification) {
            $this->setFlash('Credit not found.', 'danger');
            header('Location: /credits');
            exit;
        }
        
        $this->view('notifications/generate', ['notification' => $notification]);
    }
    
    /**
     * Send notification (manual trigger)
     */
    public function send() {
        $this->ensureRole();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credit_id = $_POST['credit_id'] ?? null;
            $client_id = $_POST['client_id'] ?? null;
            $type = $_POST['type'] ?? 'reminder';
            $message = $_POST['message'] ?? '';
            
            if (!$credit_id || !$client_id || !$message) {
                $this->setFlash('All fields are required.', 'danger');
                header('Location: /notifications');
                exit;
            }
            
            $notificationModel = new Notification();
            $notification_id = $notificationModel->createNotification($credit_id, $client_id, $type, $message);
            
            // Here you would integrate with SMS/Email service
            // For now, we'll just mark it as sent
            $notificationModel->markAsSent($notification_id);
            
            // Log the action
            require_once __DIR__ . '/../models/AuditLog.php';
            $audit = new AuditLog();
            $audit->log($_SESSION['user_id'], 'send_notification', json_encode(['notification_id'=>$notification_id, 'credit_id'=>$credit_id]));
            
            $this->setFlash('Notification sent successfully!');
            header('Location: /notifications');
            exit;
        }
    }
    
    /**
     * Export notifications to CSV
     */
    public function exportCsv() {
        $this->ensureRole();
        
        $notificationModel = new Notification();
        $overdue = $notificationModel->getOverdueNotifications();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="overdue_notifications_' . date('Y-m-d') . '.csv"');
        
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Client Name','Phone','TIN','Total Amount','Paid','Balance','Due Date','Days Overdue','Status']);
        
        foreach($overdue as $n) {
            fputcsv($out, [
                $n['client_name'],
                $n['client_phone'],
                $n['tin_number'] ?? '',
                number_format($n['total_price'], 2),
                number_format($n['amount_paid'], 2),
                number_format($n['balance'], 2),
                $n['due_date'],
                $n['days_overdue'],
                $n['status']
            ]);
        }
        
        fclose($out);
        exit;
    }
}
