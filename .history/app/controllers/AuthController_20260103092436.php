<?php
class AuthController extends Controller {
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
