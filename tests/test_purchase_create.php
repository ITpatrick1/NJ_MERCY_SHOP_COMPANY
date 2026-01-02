<?php
// Simple test for Purchase model's product creation
require_once __DIR__ . '/../app/models/Purchase.php';

$purchase = new Purchase();
$supplier_id = 1; // Use a valid supplier_id from your DB
$name = 'Test Product';
$quantity = 5;
$unit_price = 500;

$new_id = $purchase->create($supplier_id, $name, $quantity, $unit_price);
assert($new_id > 0);
echo "Purchase creation test passed.\n";
