<?php
// Simple test for User password hashing and role
require_once __DIR__ . '/../app/models/User.php';

$user = new User();
$full_name = 'Test Manager';
$phone = '0999999999';
$role = 'manager';
$password = 'secret123';

$new_id = $user->create($full_name, $phone, $role, $password);
$created = $user->findById($new_id);
assert(password_verify($password, $created['password_hash']));
assert($created['role'] === 'manager');
echo "User password hash and role test passed.\n";
