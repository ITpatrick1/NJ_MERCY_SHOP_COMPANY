<?php
abstract class Controller {
    protected function model($name){
        if(class_exists($name)) return new $name();
        throw new Exception("Model $name not found");
    }
    protected function view($path, $data=[]){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($data['flash']) && isset($_SESSION['flash'])) {
            $data['flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
        extract($data);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $path . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
    protected function render_partial($path, $data=[]){
        extract($data);
        require __DIR__ . '/../views/' . $path . '.php';
    }
    protected function setFlash($msg, $type = 'success') {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
    }
}
