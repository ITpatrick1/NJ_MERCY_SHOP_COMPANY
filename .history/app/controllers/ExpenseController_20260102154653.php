<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Expense.php';

class ExpenseController extends Controller {
    private function ensureRole($roles = ['manager']) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || !in_array($user['role'], $roles)) {
            $this->setFlash('Access denied.','danger');
            header('Location: /dashboard');
            exit;
        }
    }

    public function create() {
        $this->ensureRole();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
            $user_id = $_SESSION['user']['user_id'] ?? null;
            $reason = trim($_POST['reason'] ?? '');
            if ($amount <= 0) {
                $error = 'Amount must be greater than zero.';
            } elseif (!$user_id) {
                $error = 'User not authenticated.';
            } elseif ($reason === '') {
                $error = 'Reason is required.';
            } else {
                $expense = new Expense();
                $expense->create($amount, $user_id, $reason);
                $this->setFlash('Expense recorded successfully!', 'success');
                header('Location: ?r=expense/index');
                exit;
            }
        }
        $this->view('expenses/create', ['error' => $error]);
    }

    public function index() {
        $this->ensureRole();
        $expense = new Expense();
        $expenses = $expense->allByDateRange(date('Y-m-01'), date('Y-m-t'));
        $this->view('expenses/index', ['expenses' => $expenses]);
    }

    public function exportCsv() {
        $this->ensureRole();
        $expense = new Expense();
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-d');
        $expenses = $expense->allByDateRange($start, $end);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="expenses_' . $start . '_to_' . $end . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Date','Amount','User','Reason']);
        foreach($expenses as $e) {
            fputcsv($out, [
                $e['expense_date'],
                $e['amount'],
                $e['user_name'],
                $e['reason']
            ]);
        }
        fclose($out);
        exit;
    }

    public function exportPdf() {
        $this->ensureRole();
        $expense = new Expense();
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-d');
        $expenses = $expense->allByDateRange($start, $end);
        $html = '<h2>Expenses Report</h2>';
        $html .= '<p>From: ' . htmlspecialchars($start) . ' To: ' . htmlspecialchars($end) . '</p>';
        $html .= '<table border="1" cellpadding="4"><tr><th>Date</th><th>Amount</th><th>User</th><th>Reason</th></tr>';
        foreach($expenses as $e) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($e['expense_date']) . '</td>';
            $html .= '<td>' . htmlspecialchars($e['amount']) . '</td>';
            $html .= '<td>' . htmlspecialchars($e['user_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($e['reason']) . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        echo '<html><head><title>Expenses PDF</title></head><body onload="window.print()">' . $html . '</body></html>';
        exit;
    }
}
