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
            $supplier_id = $_POST['supplier_id'] ?? '';
            $product_id = $_POST['product_id'] ?? '';
            $supplier_tin = trim($_POST['supplier_tin'] ?? '');
            $product_name = trim($_POST['product_name'] ?? '');
            $quantity = $_POST['quantity'] ?? 0;
            $unit_price = $_POST['unit_price'] ?? 0;

            // Resolve supplier by TIN if typed
            if (!$supplier_id && $supplier_tin !== '') {
                $foundSupplier = $supplierModel->findByTin($supplier_tin);
                if ($foundSupplier) {
                    $supplier_id = $foundSupplier['supplier_id'];
                } else {
                    $error = 'Supplier TIN not found. Please use an existing supplier TIN.';
                }
            }

            // Resolve product by name if typed
            if (!$product_id && $product_name !== '' && empty($error)) {
                $foundProduct = $productModel->findByName($product_name);
                if ($foundProduct) {
                    $product_id = $foundProduct['product_id'];
                } else {
                    $error = 'Product name not found. Please use an existing product name.';
                }
            }

            if (empty($error) && (!$supplier_id || !$product_id || $quantity <= 0 || $unit_price < 0)) {
                $error = 'All fields are required and must be valid.';
            } else {
                $purchaseModel = $this->model('Purchase');
                $purchaseModel->create($supplier_id, $product_id, $quantity, $unit_price);
                // Audit log
                $user_id = $_SESSION['user']['user_id'] ?? null;
                if(class_exists('AuditLog')){
                    $audit = new AuditLog();
                    $audit->log($user_id, 'create_purchase', json_encode(['supplier_id'=>$supplier_id,'product_id'=>$product_id,'quantity'=>$quantity,'unit_price'=>$unit_price]));
                }
                redirect('?r=purchase/index');
            }
        }
        $this->view('purchases/create', compact('suppliers', 'products', 'error'));
    }

    public function index() {
        $this->ensureRole();
        $purchaseModel = $this->model('Purchase');
        
        // Get date range from request or use today's date
        $start = $_GET['start'] ?? date('Y-m-d');
        $end = $_GET['end'] ?? date('Y-m-d');
        
        $purchases = $purchaseModel->allByDateRange($start, $end);
        
        // Group purchases by supplier and calculate grand total
        $grouped_purchases = [];
        $grand_total = 0;
        
        foreach($purchases as $purchase) {
            $supplier_id = $purchase['supplier_id'];
            if (!isset($grouped_purchases[$supplier_id])) {
                $grouped_purchases[$supplier_id] = [
                    'supplier_name' => $purchase['supplier_name'],
                    'supplier_id' => $supplier_id,
                    'supplier_tin' => $purchase['supplier_tin'] ?? '',
                    'purchases' => [],
                    'total' => 0
                ];
            }
            $grouped_purchases[$supplier_id]['purchases'][] = $purchase;
            $grouped_purchases[$supplier_id]['total'] += $purchase['total_price'];
            $grand_total += $purchase['total_price'];
        }
        
        $this->view('purchases/index', compact('grouped_purchases', 'start', 'end', 'grand_total'));
    }
    public function edit() {
        $this->ensureRole();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            redirect('?r=purchase/index');
        }
        
        $error = '';
        $purchaseModel = $this->model('Purchase');
        $purchase = $purchaseModel->find($id);
        
        if (!$purchase) {
            $this->setFlash('Purchase not found.', 'danger');
            redirect('?r=purchase/index');
        }
        
        $supplierModel = $this->model('Supplier');
        $productModel = $this->model('Product');
        $suppliers = $supplierModel->all();
        $products = $productModel->all();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_tin = trim($_POST['supplier_tin'] ?? '');
            $product_name = trim($_POST['product_name'] ?? '');
            $quantity = $_POST['quantity'] ?? 0;
            $unit_price = $_POST['unit_price'] ?? 0;
            $purchase_date = $_POST['purchase_date'] ?? null;
            
            // Resolve supplier by TIN
            $supplier_id = null;
            if ($supplier_tin !== '') {
                $foundSupplier = $supplierModel->findByTin($supplier_tin);
                if ($foundSupplier) {
                    $supplier_id = $foundSupplier['supplier_id'];
                } else {
                    $error = 'Supplier TIN not found. Please use an existing supplier TIN.';
                }
            }

            // Resolve product by name
            $product_id = null;
            if ($product_name !== '' && empty($error)) {
                $foundProduct = $productModel->findByName($product_name);
                if ($foundProduct) {
                    $product_id = $foundProduct['product_id'];
                } else {
                    $error = 'Product name not found. Please use an existing product name.';
                }
            }
            
            if (empty($error) && (!$supplier_id || !$product_id || $quantity <= 0 || $unit_price < 0)) {
                $error = 'All fields are required and must be valid.';
            } else if (empty($error)) {
                $purchaseModel->update($id, $supplier_id, $product_id, $quantity, $unit_price, $purchase_date);
                
                // Audit log
                $user_id = $_SESSION['user']['user_id'] ?? null;
                if(class_exists('AuditLog')){
                    $audit = new AuditLog();
                    $audit->log($user_id, 'update_purchase', json_encode(['purchase_id'=>$id,'supplier_tin'=>$supplier_tin,'product_name'=>$product_name,'quantity'=>$quantity,'unit_price'=>$unit_price]));
                }
                
                $this->setFlash('Purchase updated successfully.', 'success');
                redirect('?r=purchase/index');
            }
        }
        
        $this->view('purchases/edit', compact('purchase', 'suppliers', 'products', 'error'));
    }
    
    public function delete() {
        $this->ensureRole();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            redirect('?r=purchase/index');
        }
        
        $purchaseModel = $this->model('Purchase');
        $purchase = $purchaseModel->find($id);
        
        if (!$purchase) {
            $this->setFlash('Purchase not found.', 'danger');
            redirect('?r=purchase/index');
        }
        
        $purchaseModel->delete($id);
        
        // Audit log
        $user_id = $_SESSION['user']['user_id'] ?? null;
        if(class_exists('AuditLog')){
            $audit = new AuditLog();
            $audit->log($user_id, 'delete_purchase', json_encode(['purchase_id'=>$id]));
        }
        
        $this->setFlash('Purchase deleted successfully.', 'success');
        redirect('?r=purchase/index');
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
