<?php
class AuthController extends Controller {
    // Google OAuth2 entry point
    public function google() {
        require_once __DIR__ . '/../config_google.php';
        require_once __DIR__ . '/../core/GoogleOAuth2.php';
        $google = new \GoogleOAuth2(require __DIR__ . '/../config_google.php');
        header('Location: ' . $google->getAuthUrl());
        exit;
    }

    // Google OAuth2 callback
    public function googleCallback() {
        require_once __DIR__ . '/../config_google.php';
        require_once __DIR__ . '/../core/GoogleOAuth2.php';
        $google = new \GoogleOAuth2(require __DIR__ . '/../config_google.php');
        if (!isset($_GET['code'])) {
            $this->setFlash('Google login failed.','danger');
            redirect(BASE_URL . '/?r=auth/login');
        }
        $token = $google->fetchToken($_GET['code']);
        if (empty($token['access_token'])) {
            $this->setFlash('Google login failed.','danger');
            redirect(BASE_URL . '/?r=auth/login');
        }
        $info = $google->fetchUserInfo($token['access_token']);
        if (empty($info['email'])) {
            $this->setFlash('Google login failed.','danger');
            redirect(BASE_URL . '/?r=auth/login');
        }
        // Only allow allowed domains
        $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com'];
        $domain = strtolower(substr(strrchr($info['email'], '@'), 1));
        if (!in_array($domain, $allowedDomains)) {
            $this->setFlash('Only Gmail, Yahoo, Outlook, Hotmail, or iCloud emails are allowed.','danger');
            redirect(BASE_URL . '/?r=auth/login');
        }
        $userModel = $this->model('User');
        $user = $userModel->findByEmail($info['email']);
        if (!$user) {
            // Auto-register as staff by default
            $full_name = $info['name'] ?? $info['email'];
            $phone = '';
            $role = 'staff';
            $password = bin2hex(random_bytes(8));
            $userModel->create($full_name, $phone, $role, $password, $info['email']);
            $user = $userModel->findByEmail($info['email']);
        }
        $_SESSION['user'] = $user;
        $this->setFlash('Logged in with Google!');
        redirect(BASE_URL . '/?r=dashboard/index');
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $userModel = $this->model('User');
            $user = $userModel->findByPhone($phone);
            if($user && password_verify($password, $user['password_hash'])){
                $_SESSION['user'] = $user;
                redirect('?r=dashboard/index');
            } else {
                $this->view('auth/login',['error'=>'Invalid credentials']);
                return;
            }
        }
        $this->view('auth/login');
    }
    public function logout(){
        session_destroy();
        redirect('?r=auth/login');
    }
    public function register() {
        $error = $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? '';
            $password = $_POST['password'] ?? '';
            if (!$full_name || !$phone || !$role || !$password || !$email) {
                $error = 'All fields are required.';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email format.';
            } else {
                $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com'];
                $domain = strtolower(substr(strrchr($email, '@'), 1));
                if (!in_array($domain, $allowedDomains)) {
                    $error = 'Only Gmail, Yahoo, Outlook, Hotmail, or iCloud emails are allowed.';
                } else {
                    $userModel = $this->model('User');
                    if ($userModel->findByPhone($phone)) {
                        $error = 'Phone number already registered.';
                    } else {
                        $userModel->create($full_name, $phone, $role, $password, $email);
                        $success = 'Registration successful! You can now log in.';
                    }
                }
            }
        }
        $this->view('auth/register', compact('error', 'success'));
    }
}
