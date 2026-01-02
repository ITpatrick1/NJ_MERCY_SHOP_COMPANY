<?php
class ReportController extends Controller {
    private function ensure(){ if(empty($_SESSION['user'])) redirect('?r=auth/login'); }

    public function creditSales(){
        $this->ensure();
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT cs.*, c.name as client_name, c.tin_number as client_tin, c.phone as client_phone, c.client_id, cs.rejection_reason FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id ORDER BY c.name, cs.date_issued DESC");
        $sales = $stmt->fetchAll();
        
        // Calculate summary statistics
        $totalCount = count($sales);
        $totalAmount = 0;
        $totalPaid = 0;
        $totalBalance = 0;
        $overdueCount = 0;
        $overdueAmount = 0;
        $settledCount = 0;
        $settledAmount = 0;
        $notApprovedCount = 0;
        $notApprovedAmount = 0;
        $approvedCount = 0;
        $approvedAmount = 0;
        
        // Group by client
        $grouped_sales = [];
        foreach($sales as $s) {
            $client_id = $s['client_id'];
            if (!isset($grouped_sales[$client_id])) {
                $grouped_sales[$client_id] = [
                    'client_name' => $s['client_name'],
                    'client_tin' => $s['tin_number'] ?? 'N/A',
                    'client_phone' => $s['client_phone'] ?? 'N/A',
                    'client_id' => $client_id,
                    'sales' => [],
                    'total' => 0,
                    'total_paid' => 0,
                    'total_balance' => 0
                ];
            }
            $grouped_sales[$client_id]['sales'][] = $s;
            $grouped_sales[$client_id]['total'] += $s['total_price'];
            $grouped_sales[$client_id]['total_paid'] += $s['amount_paid'] ?? 0;
            $grouped_sales[$client_id]['total_balance'] += ($s['total_price'] - ($s['amount_paid'] ?? 0));
            
            $totalAmount += $s['total_price'];
            $totalPaid += $s['amount_paid'] ?? 0;
            $totalBalance += ($s['total_price'] - ($s['amount_paid'] ?? 0));
            $status = strtolower(trim($s['status']));
            
            if ($status === 'overdue') {
                $overdueCount++;
                $overdueAmount += $s['total_price'];
            } elseif ($status === 'settled' || $status === 'paid') {
                $settledCount++;
                $settledAmount += $s['total_price'];
            }
            
            if ($status === 'approved') {
                $approvedCount++;
                $approvedAmount += $s['total_price'];
            } else {
                // Not approved credits (pending, overdue, settled, or any other status except approved)
                $notApprovedCount++;
                $notApprovedAmount += $s['total_price'];
            }
        }
        
        $this->view('reports/credit_sales', [
            'grouped_sales' => $grouped_sales,
            'totalCount' => $totalCount,
            'totalAmount' => $totalAmount,
            'overdueCount' => $overdueCount,
            'overdueAmount' => $overdueAmount,
            'settledCount' => $settledCount,
            'settledAmount' => $settledAmount,
            'notApprovedCount' => $notApprovedCount,
            'notApprovedAmount' => $notApprovedAmount,
            'approvedCount' => $approvedCount,
            'approvedAmount' => $approvedAmount
        ]);
    }

    public function exportCreditSalesCsv() {
        $this->ensure();
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT cs.*, c.name as client_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id ORDER BY cs.date_issued DESC");
        $sales = $stmt->fetchAll();
        
        // Get product names
        $productNames = [];
        if (class_exists('Product')) {
            foreach ((new Product())->all() as $p) {
                $productNames[$p['product_id']] = $p['name'];
            }
        }
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="credit_sales_report_' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Client', 'Product', 'Quantity', 'Unit Price', 'Total Price', 'Date Issued', 'Due Date', 'Status']);
        
        foreach($sales as $s) {
            $productName = isset($productNames[$s['product_id']]) ? $productNames[$s['product_id']] : $s['product_id'];
            fputcsv($out, [
                $s['credit_id'],
                $s['client_name'],
                $productName,
                $s['quantity'],
                $s['unit_price'],
                $s['total_price'],
                $s['date_issued'],
                $s['due_date'],
                $s['status']
            ]);
        }
        fclose($out);
        exit;
    }

    public function exportCreditSalesPdf() {
        $this->ensure();
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT cs.*, c.name as client_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id ORDER BY cs.date_issued DESC");
        $sales = $stmt->fetchAll();
        
        // Get product names
        $productNames = [];
        if (class_exists('Product')) {
            foreach ((new Product())->all() as $p) {
                $productNames[$p['product_id']] = $p['name'];
            }
        }
        
        $html = '<h2>Credit Sales Report</h2>';
        $html .= '<p>Generated: ' . date('Y-m-d H:i:s') . '</p>';
        $html .= '<table border="1" cellpadding="4" style="border-collapse: collapse; width: 100%;">';
        $html .= '<thead><tr><th>ID</th><th>Client</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Date Issued</th><th>Due Date</th><th>Status</th></tr></thead>';
        $html .= '<tbody>';
        
        foreach($sales as $s) {
            $productName = isset($productNames[$s['product_id']]) ? htmlspecialchars($productNames[$s['product_id']]) : $s['product_id'];
            $html .= '<tr>';
            $html .= '<td>' . $s['credit_id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($s['client_name']) . '</td>';
            $html .= '<td>' . $productName . '</td>';
            $html .= '<td>' . $s['quantity'] . '</td>';
            $html .= '<td>' . number_format($s['unit_price'], 2) . '</td>';
            $html .= '<td>' . number_format($s['total_price'], 2) . '</td>';
            $html .= '<td>' . htmlspecialchars($s['date_issued']) . '</td>';
            $html .= '<td>' . htmlspecialchars($s['due_date']) . '</td>';
            $html .= '<td>' . htmlspecialchars($s['status']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        echo '<html><head><title>Credit Sales Report</title></head><body onload="window.print()">' . $html . '</body></html>';
        exit;
    }

    public function supplierPurchases(){
        $this->ensure();
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT p.*, s.name as supplier_name FROM products p JOIN suppliers s ON p.supplier_id = s.supplier_id ORDER BY p.product_id DESC");
        $purchases = $stmt->fetchAll();
        $this->view('reports/supplier_purchases', ['purchases' => $purchases]);
    }

    public function overdueCredits(){
        $this->ensure();
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT cs.*, c.name as client_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id WHERE cs.due_date < CURDATE() AND cs.status IN ('active','overdue') ORDER BY cs.due_date ASC");
        $overdue = $stmt->fetchAll();
        $this->view('reports/overdue_credits', ['overdue' => $overdue]);
    }

    public function purchaseReport() {
        $this->ensure();
        $type = $_GET['type'] ?? 'daily';
        $date = $_GET['date'] ?? date('Y-m-d');
        $purchaseModel = $this->model('Purchase');
        switch ($type) {
            case 'weekly':
                $purchases = $purchaseModel->weeklyReport($date);
                $total = $purchaseModel->totalByDateRange(
                    date('Y-m-d', strtotime($date.' -'.(date('w', strtotime($date))).' days')),
                    date('Y-m-d', strtotime(date('Y-m-d', strtotime($date.' -'.(date('w', strtotime($date))).' days')).' +6 days'))
                );
                break;
            case 'monthly':
                $purchases = $purchaseModel->monthlyReport($date);
                $total = $purchaseModel->totalByDateRange(
                    date('Y-m-01', strtotime($date)),
                    date('Y-m-t', strtotime($date))
                );
                break;
            case 'yearly':
                $purchases = $purchaseModel->yearlyReport($date);
                $total = $purchaseModel->totalByDateRange(
                    date('Y-01-01', strtotime($date)),
                    date('Y-12-31', strtotime($date))
                );
                break;
            default:
                $purchases = $purchaseModel->dailyReport($date);
                $total = $purchaseModel->totalByDateRange($date, $date);
        }
        $this->view('reports/purchase_report', compact('purchases', 'total', 'date', 'type'));
    }
    /**
     * Show profit report for the current month
     */
    public function profit() {
        $this->ensure();
        $pdo = Database::pdo();
        
        $month = $_GET['month'] ?? date('Y-m');
        
        // Calculate total expenses for the month
        $stmt = $pdo->prepare("SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = ?");
        $stmt->execute([$month]);
        $expensesTotal = $stmt->fetch()['total'];
        
        // Calculate total purchases for the month
        $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantity * unit_price), 0) as total FROM purchases WHERE DATE_FORMAT(purchase_date, '%Y-%m') = ?");
        $stmt->execute([$month]);
        $purchasesTotal = $stmt->fetch()['total'];
        
        $this->view('reports/profit', compact('expensesTotal', 'purchasesTotal', 'month'));
    }
}
