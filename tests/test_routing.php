<?php
// Debug routing for expense controller
session_start();

// Simulate the routing
$route = 'expense/index';
$parts = explode('/', $route);
$controllerName = ucfirst($parts[0]) . 'Controller';
$action = isset($parts[1]) ? $parts[1] : 'index';

echo "Testing Routing\n";
echo "================\n\n";
echo "Route: $route\n";
echo "Parts: " . print_r($parts, true) . "\n";
echo "Controller Name: $controllerName\n";
echo "Action: $action\n\n";

// Check autoload
require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/core/Database.php';
require __DIR__ . '/../app/core/Model.php';
require __DIR__ . '/../app/core/Controller.php';

spl_autoload_register(function($class){
    $paths = [__DIR__ . '/../app/controllers/', __DIR__ . '/../app/models/'];
    foreach($paths as $p){
        $file = $p . $class . '.php';
        echo "Checking: $file ... ";
        if(file_exists($file)) {
            echo "FOUND!\n";
            require $file;
            return;
        }
        echo "not found\n";
    }
});

echo "\nTrying to load: $controllerName\n";
echo "Class exists: " . (class_exists($controllerName) ? 'YES' : 'NO') . "\n\n";

if (class_exists($controllerName)) {
    echo "✓ Controller found!\n";
    $controller = new $controllerName();
    echo "✓ Controller instantiated!\n";
    
    if (method_exists($controller, $action)) {
        echo "✓ Action method exists!\n";
        echo "\nThe routing should work!\n";
    } else {
        echo "✗ Action method NOT found!\n";
    }
} else {
    echo "✗ Controller NOT found!\n";
}
