<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Credit.php';
require_once __DIR__ . '/../models/Client.php';

class PaymentController extends Controller {
    private function ensureRole($roles = ['manager', 'staff']) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || !in_array($user['role'], $roles)) {
            $this->setFlash('Access denied.','danger');
            header('Location: /dashboard');
            exit;
        }
    }

    /**
     * Record a new payment
     */
    public function create() {
        $this->ensureRole();
        $error = '';
        $credit_id = $_GET['credit_id'] ?? null;
        
        // Get credit details
        $creditModel = new Credit();
        $credit = $credit_id ? $creditModel->find($credit_id) : null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credit_id = $_POST['credit_id'] ?? null;
            $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
            $remarks = $_POST['remarks'] ?? '';
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$credit_id) {
                $error = 'Credit ID is required.';
            } elseif ($amount <= 0) {
                $error = 'Payment amount must be greater than zero.';
            } elseif (!$user_id) {
                $error = 'User not authenticated.';
            } else {
                $paymentModel = new Payment();
                try {
                    $payment_id = $paymentModel->recordPayment($credit_id, $amount, $user_id, $remarks);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user_id, 'record_payment', json_encode(['payment_id'=>$payment_id, 'credit_id'=>$credit_id, 'amount'=>$amount]));
                    
                    $this->setFlash('Payment recorded successfully!');
                    header('Location: /credits');
                    exit;
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        
        $this->view('payments/create', ['error' => $error, 'credit' => $credit]);
    }
    
    /**
     * View payment history for a credit
     */
    public function history() {
        $this->ensureRole();
        $credit_id = $_GET['credit_id'] ?? null;
        
        if (!$credit_id) {
            $this->setFlash('Credit ID is required.', 'danger');
            header('Location: /credits');
            exit;
        }
        
        $paymentModel = new Payment();
        $creditModel = new Credit();
        
        $payments = $paymentModel->getPaymentsByCredit($credit_id);
        $credit = $creditModel->find($credit_id);
        
        $this->view('payments/history', ['payments' => $payments, 'credit' => $credit]);
    }
    
    /**
     * View all payments for a client
     */
    public function clientPayments() {
        $this->ensureRole();
        $client_id = $_GET['client_id'] ?? null;
        
        if (!$client_id) {
            $this->setFlash('Client ID is required.', 'danger');
            header('Location: /clients');
            exit;
        }
        
        $paymentModel = new Payment();
        $clientModel = new Client();
        
        $payments = $paymentModel->getPaymentsByClient($client_id);
        $client = $clientModel->find($client_id);
        
        $this->view('payments/client_payments', ['payments' => $payments, 'client' => $client]);
    }
    
    /**
     * Payment report by date range
     */
    public function report() {
        $this->ensureRole();
        
        $start_date = $_GET['start'] ?? date('Y-m-01');
        $end_date = $_GET['end'] ?? date('Y-m-d');
        
        $paymentModel = new Payment();
        $payments = $paymentModel->getPaymentsByDateRange($start_date, $end_date);
        
        $total = array_sum(array_column($payments, 'amount_paid'));
        
        $this->view('payments/report', [
            'payments' => $payments,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total' => $total
        ]);
    }
    
    /**
     * Approve a payment
     */
    public function approve() {
        $this->ensureRole(['manager']); // Only managers can approve
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_id = $_POST['payment_id'] ?? null;
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$payment_id || !$user_id) {
                $this->setFlash('Invalid request.', 'danger');
            } else {
                $paymentModel = new Payment();
                try {
                    $paymentModel->approvePayment($payment_id, $user_id);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user_id, 'approve_payment', json_encode(['payment_id' => $payment_id]));
                    
                    $this->setFlash('Payment approved successfully!', 'success');
                } catch (Exception $e) {
                    $this->setFlash('Error: ' . $e->getMessage(), 'danger');
                }
            }
        }
        
        // Redirect back to wherever they came from
        $redirect = $_POST['redirect'] ?? '?r=payment/index';
        header('Location: ' . $redirect);
        exit;
    }
    
    /**
     * Reject a payment
     */
    public function reject() {
        $this->ensureRole(['manager']); // Only managers can reject
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_id = $_POST['payment_id'] ?? null;
            $reason = $_POST['reason'] ?? '';
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$payment_id || !$user_id) {
                $this->setFlash('Invalid request.', 'danger');
            } else {
                $paymentModel = new Payment();
                try {
                    $paymentModel->rejectPayment($payment_id, $user_id, $reason);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user_id, 'reject_payment', json_encode(['payment_id' => $payment_id, 'reason' => $reason]));
                    
                    $this->setFlash('Payment rejected successfully!', 'warning');
                } catch (Exception $e) {
                    $this->setFlash('Error: ' . $e->getMessage(), 'danger');
                }
            }
        }
        
        // Redirect back
        $redirect = $_POST['redirect'] ?? '?r=payment/index';
        header('Location: ' . $redirect);
        exit;
    }
    /**
     * Record a payment (for AJAX/modal submission)
     */
    public function record() {
        $this->ensureRole();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credit_id = $_POST['credit_id'] ?? null;
            $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
            $remarks = $_POST['remarks'] ?? '';
            $user_id = $_SESSION['user']['user_id'] ?? null;
            
            if (!$credit_id) {
                $this->setFlash('Credit ID is required.', 'danger');
            } elseif ($amount <= 0) {
                $this->setFlash('Payment amount must be greater than zero.', 'danger');
            } elseif (!$user_id) {
                $this->setFlash('User not authenticated.', 'danger');
            } else {
                $paymentModel = new Payment();
                try {
                    $payment_id = $paymentModel->recordPayment($credit_id, $amount, $user_id, $remarks);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user_id, 'record_payment', json_encode(['payment_id'=>$payment_id, 'credit_id'=>$credit_id, 'amount'=>$amount]));
                    
                    $this->setFlash('Payment of RWF ' . number_format($amount, 2) . ' recorded successfully!', 'success');
                } catch (Exception $e) {
                    $this->setFlash('Error: ' . $e->getMessage(), 'danger');
                }
            }
        }
        
        // Redirect back to wherever they came from
        $redirect = $_POST['redirect'] ?? '?r=report/creditSales';
        header('Location: ' . $redirect);
        exit;
    }
    
    /**
     * Edit payment status (undo approve/reject)
     */
    public function editStatus() {
        $this->ensureRole(['manager']); // Only managers can edit status
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_id = $_POST['payment_id'] ?? null;
            $user_id = $_SESSION['user_id'] ?? null;
            
            if (!$payment_id || !$user_id) {
                $this->setFlash('Invalid request.', 'danger');
            } else {
                $paymentModel = new Payment();
                try {
                    $paymentModel->editPaymentStatus($payment_id);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user_id, 'edit_payment_status', json_encode(['payment_id' => $payment_id]));
                    
                    $this->setFlash('Payment status reset to pending!', 'info');
                } catch (Exception $e) {
                    $this->setFlash('Error: ' . $e->getMessage(), 'danger');
                }
            }
        }
        
        // Redirect back
        $redirect = $_POST['redirect'] ?? '?r=payment/index';
        header('Location: ' . $redirect);
        exit;
    }
    
    /**
     * List all payments with approval status
     */
    public function index() {
        $this->ensureRole();
        
        $paymentModel = new Payment();
        $stmt = $paymentModel->db->prepare('
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
        $payments = $stmt->fetchAll();
        
        $this->view('payments/index', ['payments' => $payments]);
    }
}
