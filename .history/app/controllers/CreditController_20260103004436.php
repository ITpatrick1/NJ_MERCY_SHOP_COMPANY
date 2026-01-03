<?php
class CreditController extends Controller {
    private function ensure(){ if(empty($_SESSION['user'])) redirect('?r=auth/login'); }

    public function index(){
        $this->ensure();
        $credits = $this->model('Credit')->all();
        $this->view('credits/index',['credits'=>$credits]);
    }
    
    public function show($id = null){
        $this->ensure();
        if(!$id) {
            redirect('?r=credit/index');
            return;
        }
        
        $pdo = Database::pdo();
        
        // Get credit details with client and product info
        $stmt = $pdo->prepare("
            SELECT cs.*, 
                   c.name as client_name, 
                   c.phone as client_phone, 
                   c.tin_number,
                   p.name as product_name,
                   COALESCE(cs.amount_paid, 0) as amount_paid,
                   (cs.total_price - COALESCE(cs.amount_paid, 0)) as balance,
                   u.name as recorded_by_name
            FROM credit_sales cs 
            JOIN clients c ON cs.client_id = c.client_id 
            LEFT JOIN products p ON cs.product_id = p.product_id
            LEFT JOIN users u ON cs.recorded_by = u.user_id
            WHERE cs.credit_id = ?
        ");
        $stmt->execute([$id]);
        $credit = $stmt->fetch();
        
        if (!$credit) {
            echo 'Credit not found';
            return;
        }
        
        // Get payment history for this credit
        $stmt = $pdo->prepare("
            SELECT cp.*, u.name as recorded_by_name
            FROM credit_payments cp
            LEFT JOIN users u ON cp.recorded_by = u.user_id
            WHERE cp.credit_id = ?
            ORDER BY cp.payment_date DESC
        ");
        $stmt->execute([$id]);
        $payments = $stmt->fetchAll();
        
        $this->view('credits/show', [
            'credit' => $credit,
            'payments' => $payments
        ]);
    }

    public function approve($id=null){
        $this->ensure();
        $user = $_SESSION['user'];
        if($user['role']!=='manager'){ echo 'Forbidden'; return; }
        if(!$id) { echo 'Missing id'; return; }
        $this->model('Credit')->markApproved($id, $user['user_id']);
        
        // Log the action
        require_once __DIR__ . '/../models/AuditLog.php';
        $audit = new AuditLog();
        $audit->log($user['user_id'], 'approve_credit', json_encode(['credit_id' => $id]));
        
        redirect($_GET['redirect'] ?? '?r=credit/index');
    }
    
    public function reject() {
        $this->ensure();
        $user = $_SESSION['user'];
        if($user['role']!=='manager'){ echo 'Forbidden'; return; }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credit_id = $_POST['credit_id'] ?? null;
            $reason = $_POST['reason'] ?? '';
            
            if($credit_id) {
                $this->model('Credit')->rejectCredit($credit_id, $user['user_id'], $reason);
                
                // Log the action
                require_once __DIR__ . '/../models/AuditLog.php';
                $audit = new AuditLog();
                $audit->log($user['user_id'], 'reject_credit', json_encode(['credit_id' => $credit_id, 'reason' => $reason]));
            }
        }
        
        redirect($_POST['redirect'] ?? '?r=credit/index');
    }
    
    public function editStatus() {
        $this->ensure();
        $user = $_SESSION['user'];
        if($user['role']!=='manager'){ echo 'Forbidden'; return; }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credit_id = $_POST['credit_id'] ?? null;
            
            if($credit_id) {
                $this->model('Credit')->editCreditStatus($credit_id);
                
                // Log the action
                require_once __DIR__ . '/../models/AuditLog.php';
                $audit = new AuditLog();
                $audit->log($user['user_id'], 'edit_credit_status', json_encode(['credit_id' => $credit_id]));
            }
        }
        
        redirect($_POST['redirect'] ?? '?r=credit/index');
    }

    public function create(){
        $this->ensure();
        $error = '';
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $clientModel = $this->model('Client');
            $client_phone = trim($_POST['client_phone'] ?? '');
            $client_name = trim($_POST['client_name'] ?? '');
            $client_tin = trim($_POST['client_tin'] ?? '');
            $due_date = trim($_POST['due_date'] ?? '');
            $user = $_SESSION['user'];
            if(!$client_phone || !$client_name) {
                $error = 'Client name and phone are required.';
            } elseif (!$due_date) {
                $error = 'Due date is required.';
            } else {
                $client = $clientModel->findByPhone($client_phone);
                if(!$client){
                    $client_id = $clientModel->create($client_name, $client_phone, $client_tin);
                } else {
                    $client_id = $client['client_id'];
                    // Update TIN if provided and different
                    if ($client_tin && $client_tin != $client['tin_number']) {
                        $clientModel->update($client_id, $client_name, $client_phone, $client_tin);
                    }
                }
                $product_names = $_POST['product_name'] ?? [];
                $quantities = $_POST['quantity'] ?? [];
                $unit_prices = $_POST['unit_price'] ?? [];
                $creditModel = $this->model('Credit');
                $hasValid = false;
                for($i=0; $i<count($product_names); $i++) {
                    $product_name = trim($product_names[$i]);
                    $quantity = isset($quantities[$i]) ? (int)$quantities[$i] : 0;
                    $unit_price = isset($unit_prices[$i]) ? (float)$unit_prices[$i] : 0;
                    if(!$product_name || $quantity <= 0 || $unit_price < 0) continue;
                    $hasValid = true;
                    $creditModel->create($client_id, $product_name, $quantity, $unit_price, $user['user_id'], $due_date);
                }
                if(!$hasValid) {
                    $error = 'Please add at least one valid product with quantity and price.';
                } else {
                    redirect('?r=credit/index');
                }
            }
        }
        $this->view('credits/create', ['error' => $error]);
    }

    public function edit($id = null) {
        $this->ensure();
        $user = $_SESSION['user'];
        
        if (!$id) {
            redirect('?r=credit/index');
            return;
        }
        
        $creditModel = $this->model('Credit');
        $credit = $creditModel->find($id);
        
        if (!$credit) {
            echo 'Credit not found';
            return;
        }
        
        // Get credit with client and product details
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("
            SELECT cs.*, c.name as client_name, c.phone as client_phone, c.tin_number, p.name as product_name,
                   COALESCE(cs.amount_paid, 0) as amount_paid
            FROM credit_sales cs 
            JOIN clients c ON cs.client_id = c.client_id 
            JOIN products p ON cs.product_id = p.product_id 
            WHERE cs.credit_id = ?
        ");
        $stmt->execute([$id]);
        $credit = $stmt->fetch();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = (int)($_POST['quantity'] ?? 0);
            $unit_price = (float)($_POST['unit_price'] ?? 0);
            $due_date = trim($_POST['due_date'] ?? '');
            
            if ($quantity <= 0 || $unit_price < 0) {
                $error = 'Invalid quantity or price.';
            } elseif (!$due_date) {
                $error = 'Due date is required.';
            } else {
                $total_price = $quantity * $unit_price;
                
                // Check if new total is less than already paid amount
                if ($total_price < $credit['amount_paid']) {
                    $error = 'New total price (RWF ' . number_format($total_price, 2) . ') cannot be less than the amount already paid (RWF ' . number_format($credit['amount_paid'], 2) . ').';
                } else {
                    $stmt = $pdo->prepare('UPDATE credit_sales SET quantity = ?, unit_price = ?, total_price = ?, due_date = ? WHERE credit_id = ?');
                    $stmt->execute([$quantity, $unit_price, $total_price, $due_date, $id]);
                    
                    // Log the action
                    require_once __DIR__ . '/../models/AuditLog.php';
                    $audit = new AuditLog();
                    $audit->log($user['user_id'], 'edit_credit', json_encode(['credit_id' => $id, 'new_total' => $total_price]));
                    
                    $success = 'Credit updated successfully!';
                    
                    // Refresh credit data
                    $stmt->execute([$id]);
                    $credit = $stmt->fetch();
                }
            }
        }
        
        $this->view('credits/edit', ['credit' => $credit, 'error' => $error, 'success' => $success]);
    }

    public function historyApi() {
        header('Content-Type: application/json');
        $phone = $_GET['phone'] ?? '';
        if (!$phone) {
            echo json_encode(['error' => 'No phone provided']);
            return;
        }
        $clientModel = $this->model('Client');
        $creditModel = $this->model('Credit');
        $client = $clientModel->findByPhone($phone);
        if (!$client) {
            echo json_encode(['history' => [], 'total' => 0, 'outstanding' => 0, 'hasDebt' => false]);
            return;
        }
        $history = $creditModel->findByClient($client['client_id']);
        $summary = $creditModel->getClientSummary($client['client_id']);
        
        $total = 0;
        $outstanding = 0;
        $unpaidItems = [];
        
        foreach ($history as $row) {
            $total += $row['total_price'];
            $balance = ($row['total_price'] - ($row['amount_paid'] ?? 0));
            
            // Only include unpaid/partially paid items
            if (in_array($row['status'], ['pending', 'active', 'overdue', 'partial_paid']) && $balance > 0) {
                $outstanding += $balance;
                $unpaidItems[] = [
                    'credit_id' => $row['credit_id'],
                    'product_name' => $row['product_name'],
                    'quantity' => $row['quantity'],
                    'unit_price' => $row['unit_price'],
                    'total_price' => $row['total_price'],
                    'amount_paid' => $row['amount_paid'] ?? 0,
                    'balance' => $balance,
                    'date_issued' => $row['date_issued'],
                    'due_date' => $row['due_date'],
                    'status' => $row['status']
                ];
            }
        }
        
        echo json_encode([
            'history' => $history,
            'unpaidItems' => $unpaidItems,
            'total' => $total,
            'outstanding' => $outstanding,
            'hasDebt' => $outstanding > 0,
            'summary' => $summary
        ]);
    }
}
