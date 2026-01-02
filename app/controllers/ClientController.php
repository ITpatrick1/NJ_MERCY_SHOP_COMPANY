<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Client.php';

class ClientController extends Controller {
    private function ensureRole($roles = ['manager', 'staff']) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user || !in_array($user['role'], $roles)) {
            $this->setFlash('Access denied.','danger');
            header('Location: ?r=dashboard/index');
            exit;
        }
    }

    public function index() {
        $this->ensureRole();
        $clientModel = new Client();
        $db = Database::pdo();
        $stmt = $db->query('SELECT * FROM clients ORDER BY name ASC');
        $clients = $stmt->fetchAll();
        $this->view('clients/index', ['clients' => $clients]);
    }

    public function create() {
        $this->ensureRole();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            
            if (empty($name)) {
                $error = 'Client name is required.';
            } elseif (empty($phone)) {
                $error = 'Client phone is required.';
            } else {
                $clientModel = new Client();
                $existing = $clientModel->findByPhone($phone);
                if ($existing) {
                    $error = 'A client with this phone number already exists.';
                } else {
                    $clientModel->create($name, $phone);
                    $this->setFlash('Client created successfully!', 'success');
                    header('Location: ?r=client/index');
                    exit;
                }
            }
        }
        $this->view('clients/create', ['error' => $error]);
    }

    public function show($id = null) {
        $this->ensureRole();
        if (!$id) {
            header('Location: ?r=client/index');
            exit;
        }
        $clientModel = new Client();
        $client = $clientModel->find($id);
        if (!$client) {
            $this->setFlash('Client not found.', 'danger');
            header('Location: ?r=client/index');
            exit;
        }
        
        // Get client's credit history
        require_once __DIR__ . '/../models/Credit.php';
        $creditModel = new Credit();
        $credits = $creditModel->findByClient($id);
        
        $this->view('clients/view', ['client' => $client, 'credits' => $credits]);
    }
}
