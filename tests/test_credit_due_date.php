<?php
// Simple test for Credit model's due date enforcement
require_once __DIR__ . '/../app/models/Credit.php';

$credit = new Credit();
$client_id = 1; // Use a valid client_id from your DB
$product_id = 1; // Use a valid product_id from your DB
$quantity = 2;
$unit_price = 1000;
$recorded_by = 1; // Use a valid user_id from your DB

$new_id = $credit->create($client_id, $product_id, $quantity, $unit_price, $recorded_by);
$created = $credit->find($new_id);

assert($created['due_date'] === date('Y-m-d', strtotime($created['date_issued'] . ' +3 days')));
echo "Credit due date enforcement test passed.\n";
