<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Sale.php';

class SaleController extends Controller {
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
			$user_id = $_SESSION['user_id'] ?? null;
			if ($amount <= 0) {
				$error = 'Amount must be greater than zero.';
			} elseif (!$user_id) {
				$error = 'User not authenticated.';
			} else {
				$sale = new Sale();
				$sale->create($amount, $user_id);
				// Audit log
				$audit = new AuditLog();
				$audit->log($user_id, 'create_sale', json_encode(['amount'=>$amount]));
				$this->setFlash('Sales total recorded successfully!');
				header('Location: /sales');
				exit;
			}
		}
		$this->view('sales/pos', ['error' => $error]);
	}

	public function index() {
		$this->ensureRole();
		$sale = new Sale();
		$sales = $sale->allByDateRange(date('Y-m-01'), date('Y-m-t'));
		$this->view('sales/index', ['sales' => $sales]);
	}

	public function exportCsv() {
		$this->ensureRole();
		$sale = new Sale();
		$start = $_GET['start'] ?? date('Y-m-01');
		$end = $_GET['end'] ?? date('Y-m-d');
		$sales = $sale->allByDateRange($start, $end);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="sales_' . $start . '_to_' . $end . '.csv"');
		$out = fopen('php://output', 'w');
		fputcsv($out, ['Date','Amount','User']);
		foreach($sales as $s) {
			fputcsv($out, [
				$s['sales_date'],
				$s['amount'],
				$s['user_name']
			]);
		}
		fclose($out);
		exit;
	}
}
