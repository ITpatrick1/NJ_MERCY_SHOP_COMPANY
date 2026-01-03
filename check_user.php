<?php
require_once 'app/config.php';
require_once 'app/core/Database.php';

$db = new Database();
$conn = $db->connect();

// Check existing users
echo "<h2>Existing Users:</h2>";
$stmt = $conn->query("SELECT user_id, full_name, phone, role, email FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($users)) {
    echo "<p>No users found in database.</p>";
    
    // Create a default manager user
    $phone = '0783086909';
    $password = 'admin123';
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO users (full_name, phone, role, password_hash, email, created_at) 
            VALUES ('Admin User', ?, 'manager', ?, 'admin@mercy.shop', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$phone, $password_hash]);
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>✓ Default User Created!</h3>";
    echo "<strong>Phone:</strong> $phone<br>";
    echo "<strong>Password:</strong> $password<br>";
    echo "<strong>Role:</strong> manager";
    echo "</div>";
} else {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['user_id']}</td>";
        echo "<td>{$user['full_name']}</td>";
        echo "<td>{$user['phone']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>Need to Reset a Password?</h3>";
    echo "<form method='post' style='margin-top: 10px;'>";
    echo "Phone: <input type='text' name='reset_phone' placeholder='0783086909' required style='padding: 5px;'><br><br>";
    echo "New Password: <input type='text' name='new_password' placeholder='password123' required style='padding: 5px;'><br><br>";
    echo "<button type='submit' name='reset' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Reset Password</button>";
    echo "</form>";
    echo "</div>";
}

// Handle password reset
if (isset($_POST['reset'])) {
    $phone = trim($_POST['reset_phone']);
    $new_password = trim($_POST['new_password']);
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
    
    $sql = "UPDATE users SET password_hash = ? WHERE phone = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$password_hash, $phone])) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>✓ Password Reset Successful!</h3>";
        echo "<strong>Phone:</strong> $phone<br>";
        echo "<strong>New Password:</strong> $new_password";
        echo "</div>";
        echo "<script>setTimeout(() => location.reload(), 2000);</script>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
        echo "Error: User not found or update failed.";
        echo "</div>";
    }
}
?>
