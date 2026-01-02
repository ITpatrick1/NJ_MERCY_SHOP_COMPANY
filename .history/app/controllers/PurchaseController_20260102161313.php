<?php
class PurchaseController extends Controller {
    private function ensure(){ if(empty($_SESSION['user'])) redirect('?r=auth/login'); }
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
        $supplierModel = $this->model('Supplier');
        $productModel = $this->model('Product');
        $suppliers = $supplierModel->all();
        $products = $productModel->all();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_name = trim($_POST['supplier_name'] ?? '');
            $supplier_tin = trim($_POST['supplier_tin'] ?? '');
            $product_names = $_POST['product_name'] ?? [];
            $quantities = $_POST['quantity'] ?? [];
            $unit_prices = $_POST['unit_price'] ?? [];

            // Validate arrays
            if (!is_array($product_names) || count($product_names) === 0) {
                $error = 'Please add at least one product.';
            } else {
                // Validate supplier name is provided
                if ($supplier_name === '') {
                    $error = 'Supplier name is required.';
                } else {
                    // Resolve supplier by TIN or name
                    $supplier_id = null;
                    
                    // Try to find by TIN first (if provided)
                    if ($supplier_tin !== '') {
                        $foundSupplier = $supplierModel->findByTin($supplier_tin);
                        if ($foundSupplier) {
                            $supplier_id = $foundSupplier['supplier_id'];
                        }
                    }
                    
                    // Try to find by name if not found by TIN
                    if (!$supplier_id) {
                        $foundSupplier = $supplierModel->findByName($supplier_name);
                        if ($foundSupplier) {
                            $supplier_id = $foundSupplier['supplier_id'];
                        }
                    }

                    // If supplier doesn't exist, create new supplier
                    if (!$supplier_id) {
                        $phone = ''; // Default empty phone
                        $supplier_id = $supplierModel->create($supplier_name, $supplier_tin, $phone);
                    }
                }
                    // Process multiple products
                    $purchaseModel = $this->model('Purchase');
                    $success_count = 0;
                    $user_id = $_SESSION['user']['user_id'] ?? null;
                    
                    for ($i = 0; $i < count($product_names); $i++) {
                        $product_name = trim($product_names[$i] ?? '');
                        $quantity = floatval($quantities[$i] ?? 0);
                        $unit_price = floatval($unit_prices[$i] ?? 0);
                        
                        if ($product_name === '' || $quantity <= 0 || $unit_price < 0) {
                            continue; // Skip invalid rows
                        }
                        
                        // Resolve product by name or create if not exists
                        $foundProduct = $productModel->findByName($product_name);
                        if ($foundProduct) {
                            $product_id = $foundProduct['product_id'];
                        } else {
                            // Create new product
                            $product_id = $productModel->create($supplier_id, $product_name, $quantity, $unit_price);
                        }
                        
                        // Create purchase
                        $purchaseModel->create($supplier_id, $product_id, $quantity, $unit_price);
                        $success_count++;
                        
                        // Audit log
                        if(class_exists('AuditLog')){
                            $audit = new AuditLog();
                            $audit->log($user_id, 'create_purchase', json_encode(['supplier_id'=>$supplier_id,'product_id'=>$product_id,'quantity'=>$quantity,'unit_price'=>$unit_price]));
                        }
                    }
                    
                if ($success_count > 0) {
                    $this->setFlash("{$success_count} purchase(s) recorded successfully!", 'success');
                    redirect('?r=purchase/index');
                } else {
                    $error = 'No valid products to record. Please check your entries.';
                }
            }
        }
        $this->view('purchases/create', compact('suppliers', 'products', 'error'));
    }

    public function index() {
        $this->ensureRole();
        $purchaseModel = $this->model('Purchase');
        $today = date('Y-m-d');
        $purchases = $purchaseModel->allByDateRange($today, $today);
        $this->view('purchases/index', compact('purchases'));
    }
    public function exportCsv() {
        $this->ensureRole();
        $purchaseModel = $this->model('Purchase');
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-d');
        $purchases = $purchaseModel->allByDateRange($start, $end);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="purchases_' . $start . '_to_' . $end . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Date','Supplier','Product','Quantity','Unit Price','Total']);
        foreach($purchases as $p) {
            fputcsv($out, [
                $p['purchase_date'],
                $p['supplier_name'],
                $p['product_name'],
                $p['quantity'],
                $p['unit_price'],
                $p['total_price']
            ]);
        }
        fclose($out);
        exit;
    }
    public function exportPdf() {
        $this->ensureRole();
        $purchaseModel = $this->model('Purchase');
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-d');
        $purchases = $purchaseModel->allByDateRange($start, $end);
        // Simple HTML for PDF
        $html = '<h2>Purchases Report</h2>';
        $html .= '<p>From: ' . htmlspecialchars($start) . ' To: ' . htmlspecialchars($end) . '</p>';
        $html .= '<table border="1" cellpadding="4"><tr><th>Date</th><th>Supplier</th><th>Product</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>';
        foreach($purchases as $p) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($p['purchase_date']) . '</td>';
            $html .= '<td>' . htmlspecialchars($p['supplier_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($p['product_name']) . '</td>';
            $html .= '<td>' . $p['quantity'] . '</td>';
            $html .= '<td>' . number_format($p['unit_price'],2) . '</td>';
            $html .= '<td>' . number_format($p['total_price'],2) . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        // Fallback: show HTML with print dialog
        echo '<html><head><title>Purchases PDF</title></head><body onload="window.print()">' . $html . '</body></html>';
        exit;
    }
}
