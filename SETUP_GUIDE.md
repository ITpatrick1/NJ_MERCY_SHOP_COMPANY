# NJ MERCY SHOP COMPANY - Retail Management System

A comprehensive retail management system for tracking purchases, expenses, credit sales, and generating financial reports.

## 🌟 Features

### Core Functionality
- **Dashboard**: Real-time financial overview showing today's expenses, purchases, and credit sales
- **Credit Sales Management**: Track clients who purchase on credit with due dates and payment status
- **Purchase Tracking**: Record money spent to buy items for business
- **Expense Tracking**: Record money taken from business (including personal use)
- **Product Management**: Maintain product catalog
- **Client Management**: Store and manage client information with credit history
- **Financial Reports**: Generate daily/weekly/monthly/yearly reports

### User Roles
- **Manager**: Full access to all features including reports and approvals
- **Staff**: Limited access for daily operations (credit sales, products, clients)

### System Capabilities
- Icon-rich modern UI with dark mode support
- Real-time search and filtering
- Export reports to CSV/PDF
- Overdue credit notifications
- Client credit history tracking
- Responsive design for mobile and desktop

## 📋 System Requirements

- **Web Server**: Apache (XAMPP, WAMP, or similar)
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Browser**: Modern browser with JavaScript enabled

## 🚀 Installation

### Step 1: Database Setup

1. Start your MySQL server (via XAMPP/WAMP control panel)
2. Open phpMyAdmin or MySQL command line
3. Run the complete schema:
   ```sql
   -- Copy and run the entire db_schema.sql file
   ```

**OR** if you already have the database:

4. Run the migration script to update existing database:
   ```sql
   -- Run db_migration.sql to add missing tables/columns
   ```

### Step 2: Configuration

1. Open `app/config.php`
2. Update database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'retail_credit_system');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

### Step 3: Create First User

Run this SQL to create a manager account:

```sql
INSERT INTO users (full_name, phone, email, role, password_hash) 
VALUES ('Admin Manager', '+234 800 000 0000', 'admin@example.com', 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- Default password: password
```

### Step 4: Access System

1. Navigate to: `http://localhost/NJ_MERCY_SHOP_COMPANY/`
2. Login with:
   - **Phone**: +234 800 000 0000
   - **Password**: password
3. Change your password immediately after first login

## 📱 Usage Guide

### Recording a Purchase
1. Go to **Purchases** > **New Purchase**
2. Select supplier and product
3. Enter quantity and unit price
4. Submit to record

### Recording an Expense
1. Go to **Expenses** > **New Expense**
2. Enter amount and reason
3. Submit to record

### Creating a Credit Sale
1. Go to **Credits** > **New Credit Sale**
2. Enter client name and phone
3. Select due date
4. Add products with quantities and prices
5. Submit to create credit record

### Managing Clients
1. Go to **Clients** > **New Client**
2. Enter client name and phone number
3. View client details to see credit history

### Generating Reports
1. Go to **Reports** menu
2. Select report type:
   - **Financial Report**: Monthly expenses and purchases
   - **Credit Sales**: All credit transactions with status
   - **Overdue Credits**: Credits past due date
   - **Purchase Report**: All purchases
   - **Supplier Purchases**: Purchases by supplier

## 🔧 Troubleshooting

### Common Issues

**1. Database connection error**
- Check MySQL is running
- Verify credentials in `app/config.php`
- Ensure database exists

**2. "Table doesn't exist" error**
- Run `db_schema.sql` for fresh install
- Run `db_migration.sql` for existing database

**3. "Controller not found" or "Action not found"**
- Clear browser cache
- Check URL format: `?r=controller/action`

**4. Login not working**
- Verify user exists in database
- Default password is hashed, use: `password`

**5. Dark mode not persisting**
- Enable browser localStorage
- Clear browser cache and cookies

## 📊 Database Structure

### Main Tables
- **users**: System users (manager, staff)
- **clients**: Customers who purchase on credit
- **suppliers**: Product suppliers
- **products**: Product catalog
- **purchases**: Money spent to buy items
- **expenses**: Money taken from business
- **credit_sales**: Products sold on credit
- **credit_approval_logs**: Credit approval history

## 🎨 Features Overview

### Dashboard
- Today's expenses total
- Today's purchases total
- Today's credit sales total
- Active credits count
- Quick action buttons

### Client Management
- Client list with search
- Client details with credit history
- Automatic client creation from credit sales

### Credit Sales
- Multiple products per credit
- Due date tracking
- Status management (pending, active, overdue, approved, paid)
- Client credit history
- Overdue notifications

### Reports
- **Financial Report**: Shows monthly expenses and purchases independently
- **Credit Sales Report**: All credit transactions with product details
- **Overdue Credits**: Automatically tracked and displayed
- CSV/PDF export options

## 🔐 Security Notes

- Change default admin password immediately
- Use strong passwords for all accounts
- Restrict manager role to trusted users
- Regularly backup your database
- Keep PHP and MySQL updated

## 📝 System Purpose

This system is designed for **financial tracking**, NOT stock management. It helps you:
- Record purchases (money spent to buy items for business)
- Record expenses (money taken from business for any use)
- Track credit sales (clients who get products on credit with due dates)
- Generate reports of money spent and received (daily/weekly/monthly/yearly)

## 🆘 Support

For issues or questions:
1. Check this README first
2. Review error messages in browser console
3. Check PHP error logs in XAMPP/WAMP
4. Verify database schema is up to date

## 📄 License

This system is proprietary software for NJ MERCY SHOP COMPANY.

## 🔄 Updates

### Latest Version Features
- ✅ Icon-rich modern UI
- ✅ Dark mode support
- ✅ Dashboard with real-time financial data
- ✅ Client management with credit history
- ✅ Independent expenses and purchases tracking
- ✅ Multiple products per credit sale
- ✅ Due date management for credits
- ✅ Export reports to CSV/PDF
- ✅ Responsive mobile design
- ✅ Search and filter functionality

---

**Built for NJ MERCY SHOP COMPANY** | Version 2.0 | January 2026
