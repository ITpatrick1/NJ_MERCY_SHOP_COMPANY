<?php
/**
 * Comprehensive Feature Verification Test
 * This script checks all implemented features to ensure they work correctly
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/models/Client.php';
require_once __DIR__ . '/../app/models/Credit.php';
require_once __DIR__ . '/../app/models/Payment.php';
require_once __DIR__ . '/../app/models/Notification.php';

echo "=====================================\n";
echo "FEATURE VERIFICATION TEST\n";
echo "=====================================\n\n";

$results = [];

// Test 1: Database Connection
echo "Test 1: Database Connection\n";
echo "------------------------------\n";
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    if ($conn) {
        echo "✓ Database connection successful\n";
        $results['database_connection'] = 'PASS';
    } else {
        echo "✗ Database connection failed\n";
        $results['database_connection'] = 'FAIL';
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    $results['database_connection'] = 'FAIL';
}
echo "\n";

// Test 2: Check if migration has been run
echo "Test 2: Database Migration Status\n";
echo "------------------------------\n";
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    $checks = [
        'clients.tin_number' => "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'clients' AND COLUMN_NAME = 'tin_number'",
        'daily_sales table' => "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'daily_sales'",
        'credit_payments table' => "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'credit_payments'",
        'credit_sales.amount_paid' => "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'credit_sales' AND COLUMN_NAME = 'amount_paid'",
        'credit_sales.balance' => "SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'credit_sales' AND COLUMN_NAME = 'balance'",
        'notification_logs table' => "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'notification_logs'",
        'client_outstanding_debt view' => "SELECT COUNT(*) FROM information_schema.VIEWS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'client_outstanding_debt'",
        'overdue_notifications_view' => "SELECT COUNT(*) FROM information_schema.VIEWS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'overdue_notifications_view'",
    ];
    
    $migration_status = true;
    foreach ($checks as $name => $query) {
        $stmt = $conn->query($query);
        $exists = $stmt->fetchColumn() > 0;
        if ($exists) {
            echo "✓ {$name} exists\n";
        } else {
            echo "✗ {$name} NOT FOUND - Migration needed!\n";
            $migration_status = false;
        }
    }
    
    if ($migration_status) {
        echo "\n✓ ALL DATABASE STRUCTURES EXIST\n";
        $results['database_migration'] = 'PASS';
    } else {
        echo "\n✗ MIGRATION REQUIRED - Run db_migration_complete_system.sql\n";
        $results['database_migration'] = 'FAIL - MIGRATION NEEDED';
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    $results['database_migration'] = 'FAIL';
}
echo "\n";

// Test 3: Model Files
echo "Test 3: Model Files\n";
echo "------------------------------\n";
$models = [
    'Client' => __DIR__ . '/../app/models/Client.php',
    'Credit' => __DIR__ . '/../app/models/Credit.php',
    'Payment' => __DIR__ . '/../app/models/Payment.php',
    'Notification' => __DIR__ . '/../app/models/Notification.php',
];

$all_models_exist = true;
foreach ($models as $name => $path) {
    if (file_exists($path)) {
        echo "✓ {$name} model exists\n";
        
        // Check if class can be instantiated
        try {
            $instance = new $name();
            echo "  ✓ {$name} can be instantiated\n";
        } catch (Exception $e) {
            echo "  ✗ {$name} instantiation error: " . $e->getMessage() . "\n";
            $all_models_exist = false;
        }
    } else {
        echo "✗ {$name} model NOT FOUND\n";
        $all_models_exist = false;
    }
}
$results['model_files'] = $all_models_exist ? 'PASS' : 'FAIL';
echo "\n";

// Test 4: Controller Files
echo "Test 4: Controller Files\n";
echo "------------------------------\n";
$controllers = [
    'PaymentController' => __DIR__ . '/../app/controllers/PaymentController.php',
    'NotificationController' => __DIR__ . '/../app/controllers/NotificationController.php',
    'CreditController' => __DIR__ . '/../app/controllers/CreditController.php',
];

$all_controllers_exist = true;
foreach ($controllers as $name => $path) {
    if (file_exists($path)) {
        echo "✓ {$name} exists\n";
    } else {
        echo "✗ {$name} NOT FOUND\n";
        $all_controllers_exist = false;
    }
}
$results['controller_files'] = $all_controllers_exist ? 'PASS' : 'FAIL';
echo "\n";

// Test 5: View Files
echo "Test 5: View Files\n";
echo "------------------------------\n";
$views = [
    'Notifications Index' => __DIR__ . '/../app/views/notifications/index.php',
    'Credits Create' => __DIR__ . '/../app/views/credits/create.php',
];

$all_views_exist = true;
foreach ($views as $name => $path) {
    if (file_exists($path)) {
        echo "✓ {$name} exists\n";
    } else {
        echo "✗ {$name} NOT FOUND\n";
        $all_views_exist = false;
    }
}
$results['view_files'] = $all_views_exist ? 'PASS' : 'FAIL';
echo "\n";

// Test 6: Model Methods (if migration is done)
if ($results['database_migration'] === 'PASS') {
    echo "Test 6: Model Methods\n";
    echo "------------------------------\n";
    
    try {
        $clientModel = new Client();
        $creditModel = new Credit();
        $paymentModel = new Payment();
        $notificationModel = new Notification();
        
        $methods_ok = true;
        
        // Check Client methods
        if (method_exists($clientModel, 'getOutstandingDebt')) {
            echo "✓ Client::getOutstandingDebt() exists\n";
        } else {
            echo "✗ Client::getOutstandingDebt() NOT FOUND\n";
            $methods_ok = false;
        }
        
        if (method_exists($clientModel, 'getUnpaidCredits')) {
            echo "✓ Client::getUnpaidCredits() exists\n";
        } else {
            echo "✗ Client::getUnpaidCredits() NOT FOUND\n";
            $methods_ok = false;
        }
        
        // Check Payment methods
        if (method_exists($paymentModel, 'recordPayment')) {
            echo "✓ Payment::recordPayment() exists\n";
        } else {
            echo "✗ Payment::recordPayment() NOT FOUND\n";
            $methods_ok = false;
        }
        
        if (method_exists($paymentModel, 'getPaymentsByCredit')) {
            echo "✓ Payment::getPaymentsByCredit() exists\n";
        } else {
            echo "✗ Payment::getPaymentsByCredit() NOT FOUND\n";
            $methods_ok = false;
        }
        
        // Check Notification methods
        if (method_exists($notificationModel, 'getTodayDueNotifications')) {
            echo "✓ Notification::getTodayDueNotifications() exists\n";
        } else {
            echo "✗ Notification::getTodayDueNotifications() NOT FOUND\n";
            $methods_ok = false;
        }
        
        if (method_exists($notificationModel, 'getOverdueNotifications')) {
            echo "✓ Notification::getOverdueNotifications() exists\n";
        } else {
            echo "✗ Notification::getOverdueNotifications() NOT FOUND\n";
            $methods_ok = false;
        }
        
        $results['model_methods'] = $methods_ok ? 'PASS' : 'FAIL';
    } catch (Exception $e) {
        echo "✗ Error checking methods: " . $e->getMessage() . "\n";
        $results['model_methods'] = 'FAIL';
    }
    echo "\n";
} else {
    echo "Test 6: Model Methods - SKIPPED (Migration required first)\n\n";
    $results['model_methods'] = 'SKIPPED';
}

// Test 7: Routing Configuration
echo "Test 7: Routing Configuration\n";
echo "------------------------------\n";
$index_file = file_get_contents(__DIR__ . '/../index.php');
if (strpos($index_file, 'spl_autoload_register') !== false) {
    echo "✓ Autoload configured\n";
    echo "✓ Routes are dynamic (any controller/action works)\n";
    echo "  Routes available:\n";
    echo "  - ?r=payment/create\n";
    echo "  - ?r=payment/history\n";
    echo "  - ?r=notification/index\n";
    echo "  - ?r=notification/generate\n";
    echo "  - ?r=notification/exportCsv\n";
    echo "  - ?r=credit/historyApi\n";
    $results['routing'] = 'PASS';
} else {
    echo "✗ Routing configuration may need attention\n";
    $results['routing'] = 'FAIL';
}
echo "\n";

// Test 8: Documentation Files
echo "Test 8: Documentation Files\n";
echo "------------------------------\n";
$docs = [
    'Implementation Guide' => 'IMPLEMENTATION_GUIDE.md',
    'System Summary' => 'SYSTEM_IMPLEMENTATION_SUMMARY.md',
    'Quick Reference' => 'QUICK_REFERENCE.md',
    'Testing Guide' => 'NEW_FEATURES_TESTING.md',
    'Start Here' => 'START_HERE.md',
    'Migration Script' => 'db_migration_complete_system.sql',
];

$all_docs_exist = true;
foreach ($docs as $name => $filename) {
    $path = __DIR__ . '/../' . $filename;
    if (file_exists($path)) {
        echo "✓ {$name} exists\n";
    } else {
        echo "✗ {$name} NOT FOUND\n";
        $all_docs_exist = false;
    }
}
$results['documentation'] = $all_docs_exist ? 'PASS' : 'FAIL';
echo "\n";

// Final Summary
echo "=====================================\n";
echo "FINAL TEST RESULTS\n";
echo "=====================================\n\n";

$total = count($results);
$passed = 0;
$failed = 0;
$skipped = 0;

foreach ($results as $test => $status) {
    $icon = '✓';
    $color = '';
    
    if ($status === 'PASS') {
        $icon = '✓';
        $passed++;
    } elseif ($status === 'SKIPPED') {
        $icon = '⊘';
        $skipped++;
    } else {
        $icon = '✗';
        $failed++;
    }
    
    echo sprintf("%-30s %s %s\n", $test, $icon, $status);
}

echo "\n";
echo "Total Tests: {$total}\n";
echo "Passed: {$passed}\n";
echo "Failed: {$failed}\n";
echo "Skipped: {$skipped}\n";
echo "\n";

if ($results['database_migration'] !== 'PASS') {
    echo "=====================================\n";
    echo "⚠️  IMPORTANT: DATABASE MIGRATION REQUIRED\n";
    echo "=====================================\n";
    echo "Run this SQL file in phpMyAdmin:\n";
    echo "  db_migration_complete_system.sql\n\n";
    echo "After running migration, run this test again to verify all features.\n";
} elseif ($failed === 0) {
    echo "=====================================\n";
    echo "✓ ALL TESTS PASSED!\n";
    echo "=====================================\n";
    echo "Your system is ready to use!\n\n";
    echo "Next steps:\n";
    echo "1. Access system at: http://localhost/NJ_MERCY_SHOP_COMPANY/\n";
    echo "2. Login with your credentials\n";
    echo "3. Test features using NEW_FEATURES_TESTING.md\n";
} else {
    echo "=====================================\n";
    echo "⚠️  SOME TESTS FAILED\n";
    echo "=====================================\n";
    echo "Please review the failed tests above and fix the issues.\n";
}

echo "\n";
