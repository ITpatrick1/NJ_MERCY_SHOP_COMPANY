<?php
require_once 'app/config.php';
require_once 'app/core/Database.php';

$db = new Database();
$conn = $db->connect();

echo "<html><head><style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
table { background: white; border-collapse: collapse; width: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
th { background: #667eea; color: white; padding: 12px; text-align: left; }
td { padding: 12px; border-bottom: 1px solid #ddd; }
tr:hover { background: #f9f9f9; }
.info { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
</style></head><body>";

echo "<h2>All Users in Database</h2>";

$stmt = $conn->query("SELECT user_id, full_name, phone, email, role, created_at FROM users ORDER BY user_id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($users)) {
    echo "<div class='info'><strong>No users found!</strong> The database is empty.</div>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>Full Name</th><th>Phone Number</th><th>Email</th><th>Role</th><th>Created At</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['user_id']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "<td><strong>{$user['phone']}</strong></td>";
        echo "<td>{$user['email']}</td>";
        echo "<td><span style='background: " . ($user['role'] == 'manager' ? '#28a745' : '#007bff') . "; color: white; padding: 4px 8px; border-radius: 4px;'>{$user['role']}</span></td>";
        echo "<td>{$user['created_at']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<div class='info'>";
    echo "<h3>Login Instructions:</h3>";
    echo "<strong>Use any phone number from the table above</strong><br>";
    echo "If you don't remember the password, I can reset it for you.<br><br>";
    echo "<strong>Default credentials (if you just created users):</strong><br>";
    echo "Phone: <code>0783086909</code><br>";
    echo "Password: <code>admin123</code> or <code>password123</code>";
    echo "</div>";
}

echo "</body></html>";
?>
