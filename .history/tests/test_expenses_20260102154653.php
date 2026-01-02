<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/core/Database.php';

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Check if expenses table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'expenses'");
    $result = $stmt->fetch();
    
    if ($result) {
        echo "✓ Table 'expenses' exists\n\n";
        
        // Show structure
        echo "Table Structure:\n";
        echo "----------------\n";
        $stmt = $conn->query("DESCRIBE expenses");
        $cols = $stmt->fetchAll();
        foreach ($cols as $col) {
            echo $col['Field'] . " - " . $col['Type'] . "\n";
        }
        
        echo "\n";
        
        // Count records
        $stmt = $conn->query("SELECT COUNT(*) as count FROM expenses");
        $count = $stmt->fetchColumn();
        echo "Total expenses records: $count\n\n";
        
        // Try to fetch some expenses
        echo "Testing Expense model:\n";
        echo "---------------------\n";
        require_once __DIR__ . '/../app/core/Model.php';
        require_once __DIR__ . '/../app/models/Expense.php';
        
        $expense = new Expense();
        $expenses = $expense->allByDateRange(date('Y-m-01'), date('Y-m-t'));
        echo "Expenses this month: " . count($expenses) . "\n";
        
        if (count($expenses) > 0) {
            echo "\nSample record:\n";
            print_r($expenses[0]);
        }
        
    } else {
        echo "✗ Table 'expenses' does NOT exist\n";
        echo "\nYou need to create the expenses table.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString();
}
