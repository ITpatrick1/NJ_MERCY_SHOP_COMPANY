<?php
require_once 'app/config.php';
require_once 'app/core/Database.php';

$conn = Database::pdo();

echo "<html><head><style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
.warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
</style></head><body>";

if (isset($_POST['confirm'])) {
    try {
        $conn->exec("TRUNCATE TABLE users");
        echo "<div class='success'>";
        echo "<h2>✓ Users Table Truncated Successfully!</h2>";
        echo "<p>All users have been removed from the database.</p>";
        echo "<p><a href='?r=auth/register' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Register New User</a></p>";
        echo "</div>";
    } catch (PDOException $e) {
        echo "<div class='warning'>";
        echo "<h2>Error!</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "</div>";
    }
} else {
    echo "<div class='warning'>";
    echo "<h2>⚠️ Warning: Truncate Users Table</h2>";
    echo "<p><strong>This will permanently delete ALL users from the database!</strong></p>";
    echo "<p>This action cannot be undone.</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='confirm' value='1' style='background: #dc3545; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;'>Yes, Delete All Users</button>";
    echo " ";
    echo "<a href='show_credentials.php' style='background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>Cancel</a>";
    echo "</form>";
    echo "</div>";
}

echo "</body></html>";
?>
