<?php
session_start();
require __DIR__ . '/app/config.php';
require __DIR__ . '/app/core/Database.php';
require __DIR__ . '/app/core/Model.php';
require __DIR__ . '/app/core/Controller.php';
require __DIR__ . '/app/core/View.php';

// Autoload models and controllers
spl_autoload_register(function($class){
    $paths = [__DIR__ . '/app/controllers/', __DIR__ . '/app/models/'];
    foreach($paths as $p){
        $file = $p . $class . '.php';
        if(file_exists($file)) require $file;
    }
});

$route = isset($_GET['r']) ? $_GET['r'] : 'auth/login';
$parts = explode('/', $route);
$controllerName = ucfirst($parts[0]) . 'Controller';
$action = isset($parts[1]) ? $parts[1] : 'index';

if(class_exists($controllerName)){
    $controller = new $controllerName();
    if(method_exists($controller, $action)){
        call_user_func_array([$controller, $action], array_slice($parts,2));
    } else {
        echo "Action not found: {$action} in {$controllerName}";
    }
} else {
    echo "Controller not found: {$controllerName}<br>";
    echo "Looking for file: app/controllers/{$controllerName}.php<br>";
    echo "Route requested: {$route}";
}
