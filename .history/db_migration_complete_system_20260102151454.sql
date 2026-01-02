-- Complete System Migration Script
-- This script adds all missing features for the retail credit system
-- Run this script to update your database to support all requirements

USE retail_credit_system;

-- 1. Add TIN column to clients table
ALTER TABLE clients 
ADD COLUMN tin_number VARCHAR(50) NULL AFTER phone;

-- 2. Create daily_sales table (for tracking total daily sales)
CREATE TABLE IF NOT EXISTS daily_sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(12,2) NOT NULL CHECK (amount >= 0),
    user_id INT NOT NULL,
    sales_date DATE NOT NULL DEFAULT CURDATE(),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    INDEX idx_sales_date (sales_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create credit_payments table (for tracking partial payments)
CREATE TABLE IF NOT EXISTS credit_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    credit_id INT NOT NULL,
    amount_paid DECIMAL(12,2) NOT NULL CHECK (amount_paid > 0),
    payment_date DATE NOT NULL DEFAULT CURDATE(),
    recorded_by INT NOT NULL,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (credit_id) REFERENCES credit_sales(credit_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    INDEX idx_payment_date (payment_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Add amount_paid column to credit_sales to track total payments
ALTER TABLE credit_sales 
ADD COLUMN amount_paid DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER total_price,
ADD COLUMN balance DECIMAL(12,2) GENERATED ALWAYS AS (total_price - amount_paid) STORED;

-- 5. Create notification_logs table (for tracking sent notifications)
CREATE TABLE IF NOT EXISTS notification_logs (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    credit_id INT NOT NULL,
    client_id INT NOT NULL,
    notification_type ENUM('due_payment', 'overdue', 'reminder') NOT NULL,
    message TEXT NOT NULL,
    sent_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    FOREIGN KEY (credit_id) REFERENCES credit_sales(credit_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    INDEX idx_sent_date (sent_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Update credit_sales status to add 'partial_paid' option
ALTER TABLE credit_sales 
MODIFY COLUMN status ENUM('active','overdue','paid','approved','pending','partial_paid') DEFAULT 'pending';

-- 7. Create audit_logs table if not exists (for system tracking)
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

-- 8. Create view for client total outstanding debt
CREATE OR REPLACE VIEW client_outstanding_debt AS
SELECT 
    c.client_id,
    c.name,
    c.phone,
    c.tin_number,
    COUNT(cs.credit_id) as total_credits,
    SUM(cs.total_price) as total_credit_amount,
    SUM(cs.amount_paid) as total_paid,
    SUM(cs.balance) as total_outstanding,
    MAX(cs.due_date) as latest_due_date
FROM clients c
LEFT JOIN credit_sales cs ON c.client_id = cs.client_id
WHERE cs.status IN ('pending', 'active', 'overdue', 'partial_paid')
GROUP BY c.client_id, c.name, c.phone, c.tin_number;

-- 9. Create view for overdue notifications
CREATE OR REPLACE VIEW overdue_notifications_view AS
SELECT 
    cs.credit_id,
    cs.client_id,
    c.name as client_name,
    c.phone as client_phone,
    cs.total_price,
    cs.amount_paid,
    cs.balance,
    cs.due_date,
    cs.date_issued,
    DATEDIFF(CURDATE(), cs.due_date) as days_overdue,
    cs.status
FROM credit_sales cs
JOIN clients c ON cs.client_id = c.client_id
WHERE cs.due_date <= CURDATE() 
  AND cs.status IN ('pending', 'active', 'overdue', 'partial_paid')
  AND cs.balance > 0
ORDER BY cs.due_date ASC;

-- 10. Create stored procedure to update overdue statuses and generate notifications
DELIMITER $$

CREATE PROCEDURE update_overdue_and_notify()
BEGIN
    -- Update overdue statuses
    UPDATE credit_sales 
    SET status = 'overdue' 
    WHERE due_date < CURDATE() 
      AND status IN ('pending', 'active', 'partial_paid')
      AND balance > 0;
    
    -- Insert notifications for overdue credits (if not already notified today)
    INSERT INTO notification_logs (credit_id, client_id, notification_type, message, status)
    SELECT 
        cs.credit_id,
        cs.client_id,
        'overdue' as notification_type,
        CONCAT('Dear ', c.name, ', your payment of ', cs.balance, ' is overdue since ', cs.due_date, '. Please contact us.') as message,
        'pending' as status
    FROM credit_sales cs
    JOIN clients c ON cs.client_id = c.client_id
    WHERE cs.status = 'overdue'
      AND cs.balance > 0
      AND NOT EXISTS (
          SELECT 1 FROM notification_logs nl
          WHERE nl.credit_id = cs.credit_id
            AND nl.notification_type = 'overdue'
            AND DATE(nl.sent_date) = CURDATE()
      );
      
    -- Insert notifications for payments due today
    INSERT INTO notification_logs (credit_id, client_id, notification_type, message, status)
    SELECT 
        cs.credit_id,
        cs.client_id,
        'due_payment' as notification_type,
        CONCAT('Dear ', c.name, ', your payment of ', cs.balance, ' is due today. Total: ', cs.total_price) as message,
        'pending' as status
    FROM credit_sales cs
    JOIN clients c ON cs.client_id = c.client_id
    WHERE cs.due_date = CURDATE()
      AND cs.status IN ('pending', 'active', 'partial_paid')
      AND cs.balance > 0
      AND NOT EXISTS (
          SELECT 1 FROM notification_logs nl
          WHERE nl.credit_id = cs.credit_id
            AND nl.notification_type = 'due_payment'
            AND DATE(nl.sent_date) = CURDATE()
      );
END$$

DELIMITER ;

-- 11. Create event scheduler to run daily (if events are enabled)
SET GLOBAL event_scheduler = ON;

DROP EVENT IF EXISTS daily_overdue_check;

CREATE EVENT daily_overdue_check
ON SCHEDULE EVERY 1 DAY
STARTS CURDATE() + INTERVAL 1 DAY
DO
CALL update_overdue_and_notify();

COMMIT;

-- Display migration summary
SELECT 'Database migration completed successfully!' as Status;
SELECT 'Added features: TIN for clients, daily_sales table, payment tracking, notifications' as Summary;
