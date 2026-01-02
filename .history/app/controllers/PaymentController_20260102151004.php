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
}
