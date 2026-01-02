-- Database Enhancements for Client Debt Management System
-- Execute this to add missing features to existing database

USE retail_credit_system;

-- Add TIN field to clients table
ALTER TABLE clients 
ADD COLUMN IF NOT EXISTS tin_number VARCHAR(50) DEFAULT NULL AFTER phone,
ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER tin_number;

-- Create payments table for tracking client payments
CREATE TABLE IF NOT EXISTS payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    credit_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL CHECK (amount > 0),
    payment_date DATE NOT NULL DEFAULT CURRENT_DATE,
    payment_method ENUM('cash','mobile_money','bank_transfer','other') DEFAULT 'cash',
    notes TEXT,
    recorded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (credit_id) REFERENCES credit_sales(credit_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- Create daily_sales table if it doesn't exist (for cash sales summary)
CREATE TABLE IF NOT EXISTS daily_sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(12,2) NOT NULL CHECK (amount > 0),
    user_id INT NOT NULL,
    sales_date DATE NOT NULL DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Add amount_paid column to credit_sales for tracking total paid
ALTER TABLE credit_sales 
ADD COLUMN IF NOT EXISTS amount_paid DECIMAL(12,2) DEFAULT 0.00 AFTER total_price;

-- Create additional indexes for better performance
CREATE INDEX IF NOT EXISTS idx_payment_credit ON payments(credit_id);
CREATE INDEX IF NOT EXISTS idx_payment_date ON payments(payment_date);
CREATE INDEX IF NOT EXISTS idx_client_phone ON clients(phone);
CREATE INDEX IF NOT EXISTS idx_client_tin ON clients(tin_number);

-- Create a view for client outstanding balances
CREATE OR REPLACE VIEW client_outstanding_balances AS
SELECT 
    c.client_id,
    c.name AS client_name,
    c.phone,
    c.tin_number,
    COUNT(cs.credit_id) AS total_credits,
    SUM(cs.total_price) AS total_credit_amount,
    SUM(cs.amount_paid) AS total_paid,
    SUM(cs.total_price - cs.amount_paid) AS outstanding_balance,
    MIN(cs.due_date) AS earliest_due_date,
    MAX(cs.date_issued) AS last_credit_date
FROM clients c
LEFT JOIN credit_sales cs ON c.client_id = cs.client_id AND cs.status IN ('pending', 'active', 'overdue', 'approved')
GROUP BY c.client_id, c.name, c.phone, c.tin_number;

-- Create a view for overdue payments with client info
CREATE OR REPLACE VIEW overdue_credits_detail AS
SELECT 
    cs.credit_id,
    cs.client_id,
    c.name AS client_name,
    c.phone,
    c.tin_number,
    p.name AS product_name,
    cs.quantity,
    cs.unit_price,
    cs.total_price,
    cs.amount_paid,
    (cs.total_price - cs.amount_paid) AS balance,
    cs.date_issued,
    cs.due_date,
    DATEDIFF(CURRENT_DATE, cs.due_date) AS days_overdue,
    cs.status
FROM credit_sales cs
JOIN clients c ON cs.client_id = c.client_id
JOIN products p ON cs.product_id = p.product_id
WHERE cs.due_date < CURRENT_DATE 
  AND cs.status IN ('active', 'overdue', 'approved', 'pending')
  AND (cs.total_price - cs.amount_paid) > 0
ORDER BY cs.due_date ASC;

-- Create a stored procedure to calculate client total debt
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS GetClientDebt(IN p_client_id INT)
BEGIN
    SELECT 
        c.client_id,
        c.name,
        c.phone,
        c.tin_number,
        SUM(cs.total_price - cs.amount_paid) AS total_debt,
        COUNT(cs.credit_id) AS unpaid_items_count,
        GROUP_CONCAT(
            CONCAT(p.name, ' (', cs.quantity, ' @ ', cs.unit_price, ' = ', cs.total_price, ')')
            ORDER BY cs.date_issued DESC
            SEPARATOR '; '
        ) AS items_list
    FROM clients c
    LEFT JOIN credit_sales cs ON c.client_id = cs.client_id 
        AND cs.status IN ('pending', 'active', 'overdue', 'approved')
        AND (cs.total_price - cs.amount_paid) > 0
    LEFT JOIN products p ON cs.product_id = p.product_id
    WHERE c.client_id = p_client_id
    GROUP BY c.client_id, c.name, c.phone, c.tin_number;
END//
DELIMITER ;

-- Insert sample notification log table (for tracking sent notifications)
CREATE TABLE IF NOT EXISTS notification_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    notification_type ENUM('sms','email','whatsapp') NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('sent','failed','pending') DEFAULT 'pending',
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_notif_client ON notification_logs(client_id);
CREATE INDEX IF NOT EXISTS idx_notif_sent ON notification_logs(sent_at);

COMMIT;
