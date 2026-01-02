<!DOCTYPE html>
<html>
<head>
    <title>Test Expense Route</title>
</head>
<body>
    <h1>Testing Expense Controller Route</h1>
    
    <?php
    session_start();
    
    // Set test user session if not logged in
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = [
            'user_id' => 1,
            'full_name' => 'Test Manager',
            'role' => 'manager'
        ];
        echo "<p style='color: orange;'>⚠️ Created test session (manager)</p>";
    }
    
    require __DIR__ . '/app/config.php';
    require __DIR__ . '/app/core/Database.php';
    require __DIR__ . '/app/core/Model.php';
    require __DIR__ . '/app/core/Controller.php';
    require __DIR__ . '/app/core/View.php';

    // Autoload
    spl_autoload_register(function($class){
        $paths = [__DIR__ . '/app/controllers/', __DIR__ . '/app/models/'];
        foreach($paths as $p){
            $file = $p . $class . '.php';
            if(file_exists($file)) require $file;
        }
    });

    $route = 'expense/index';
    $parts = explode('/', $route);
    $controllerName = ucfirst($parts[0]) . 'Controller';
    $action = isset($parts[1]) ? $parts[1] : 'index';
    
    echo "<p><strong>Route:</strong> $route</p>";
    echo "<p><strong>Controller:</strong> $controllerName</p>";
    echo "<p><strong>Action:</strong> $action</p>";

    if(class_exists($controllerName)){
        echo "<p style='color: green;'>✓ Controller class found</p>";
        
        $controller = new $controllerName();
        
        if(method_exists($controller, $action)){
            echo "<p style='color: green;'>✓ Action method found</p>";
            echo "<hr>";
            echo "<h2>Output from ExpenseController::index():</h2>";
            
            call_user_func_array([$controller, $action], array_slice($parts,2));
        } else {
            echo "<p style='color: red;'>✗ Action not found</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Controller not found</p>";
        echo "<p>Looking for: app/controllers/{$controllerName}.php</p>";
    }
    ?>
</body>
</html>
