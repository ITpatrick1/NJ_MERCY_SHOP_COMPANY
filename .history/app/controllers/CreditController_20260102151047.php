<?php
class CreditController extends Controller {
    private function ensure(){ if(empty($_SESSION['user'])) redirect('?r=auth/login'); }

    public function index(){
        $this->ensure();
        $credits = $this->model('Credit')->overdue();
        $this->view('credits/index',['credits'=>$credits]);
    }

    public function approve($id=null){
        $this->ensure();
        $user = $_SESSION['user'];
        if($user['role']!=='manager'){ echo 'Forbidden'; return; }
        if(!$id) { echo 'Missing id'; return; }
        $this->model('Credit')->markApproved($id,$user['user_id'], $_POST['remarks'] ?? '');
        redirect('?r=credit/index');
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
            echo json_encode(['history' => [], 'total' => 0]);
            return;
        }
        $history = $creditModel->findByClient($client['client_id']);
        $total = 0;
        foreach ($history as $row) {
            $total += $row['total_price'];
        }
        echo json_encode(['history' => $history, 'total' => $total]);
    }
}
