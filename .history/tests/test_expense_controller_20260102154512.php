<?php
// Test accessing expenses/index route
session_start();

// Set up a test session as manager
$_SESSION['user'] = [
    'user_id' => 1,
    'full_name' => 'Test Manager',
    'role' => 'manager'
];

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Controller.php';

echo "Testing ExpenseController::index()\n";
echo "===================================\n\n";

try {
    require_once __DIR__ . '/../app/controllers/ExpenseController.php';
    require_once __DIR__ . '/../app/models/Expense.php';
    
    echo "✓ ExpenseController loaded\n";
    echo "✓ Expense model loaded\n\n";
    
    $controller = new ExpenseController();
    echo "✓ ExpenseController instantiated\n\n";
    
    echo "Checking if index() method exists: ";
    if (method_exists($controller, 'index')) {
        echo "✓ YES\n\n";
        
        echo "Attempting to call index()...\n";
        ob_start();
        try {
            $controller->index();
            $output = ob_get_clean();
            
            echo "✓ Method executed successfully!\n\n";
            
            if (strlen($output) > 0) {
                echo "Output length: " . strlen($output) . " bytes\n";
                echo "\nFirst 500 characters:\n";
                echo substr($output, 0, 500) . "...\n";
            } else {
                echo "⚠ No output generated (might be a redirect)\n";
            }
            
        } catch (Exception $e) {
            ob_end_clean();
            echo "✗ Error calling index(): " . $e->getMessage() . "\n";
            echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
        }
        
    } else {
        echo "✗ NO\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}
