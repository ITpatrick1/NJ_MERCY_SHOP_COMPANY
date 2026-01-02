-- Setup audit_logs table and add sample data for testing
-- Run this script in your retail_credit_system database

-- Create audit_logs table if it doesn't exist
CREATE TABLE IF NOT EXISTS audit_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add some sample audit log entries for testing (only if table is empty)
-- Note: Replace user_id values with actual user IDs from your users table

-- Example: Login activities
INSERT INTO audit_logs (user_id, action, description, created_at) 
SELECT 1, 'User Login', 'Admin logged into the system', NOW() - INTERVAL 5 MINUTE
WHERE NOT EXISTS (SELECT 1 FROM audit_logs LIMIT 1);

INSERT INTO audit_logs (user_id, action, description, created_at) 
SELECT 1, 'Credit Sale Created', 'Created credit sale for client: Test Client - Amount: 50,000 RWF', NOW() - INTERVAL 3 MINUTE
WHERE EXISTS (SELECT 1 FROM audit_logs WHERE action = 'User Login');

INSERT INTO audit_logs (user_id, action, description, created_at) 
SELECT 1, 'Payment Recorded', 'Recorded payment of 20,000 RWF for credit sale #1', NOW() - INTERVAL 2 MINUTE
WHERE EXISTS (SELECT 1 FROM audit_logs WHERE action = 'User Login');

INSERT INTO audit_logs (user_id, action, description, created_at) 
SELECT 1, 'Product Updated', 'Updated product inventory - Stock: 100 units', NOW() - INTERVAL 1 MINUTE
WHERE EXISTS (SELECT 1 FROM audit_logs WHERE action = 'User Login');

INSERT INTO audit_logs (user_id, action, description, created_at) 
SELECT 1, 'Purchase Created', 'Created purchase from supplier: Test Supplier - Amount: 75,000 RWF', NOW()
WHERE EXISTS (SELECT 1 FROM audit_logs WHERE action = 'User Login');

-- Verify the records
SELECT 
    al.log_id,
    al.action,
    al.description,
    u.full_name as user_name,
    u.role as user_role,
    al.created_at
FROM audit_logs al
JOIN users u ON al.user_id = u.user_id
ORDER BY al.created_at DESC
LIMIT 10;
