# NJ MERCH SHOP COMPANY LTD — Retail Management System

## Features
- POS sales (with credit or cash)
- Inventory management
- Credit tracking (3-day repayment, overdue detection)
- Manager approval for offline payments
- Purchases/expenses logging
- Financial reporting (sales, purchases, profit, overdue credits)
- User management (manager/staff)
- Secure login (bcrypt password)

## Tech
- PHP 8+, MySQL, PDO
- MVC (no framework)
- Simple responsive UI (HTML/CSS)

## Setup
1. Import `db_schema.sql` into your MySQL server.
2. Update `app/config.php` with your DB credentials.
3. Place project in your web root (e.g. `htdocs/NY_MERCY_SHOP_COMPANY`).
4. Access via `http://localhost/NY_MERCY_SHOP_COMPANY/`
5. Login as manager: phone `+250780000000`, password as set in sample data.

## Structure
- `index.php` — front controller
- `app/`
  - `controllers/` — controllers (Auth, Dashboard, Product, Sale, Credit, Purchase, Report)
  - `models/` — models (User, Product, Customer, Sale, Credit, Purchase)
  - `views/` — views (layout, auth, dashboard, products, sales, credits, purchases, reports)
  - `core/` — base MVC classes
  - `config.php` — config
- `db_schema.sql` — MySQL schema & sample data

## Usage
- Login as manager or staff
- Use dashboard for quick links
- POS: create sales, optionally as credit
- Manager: approve overdue credits
- Purchases: log incoming stock
- Reports: view profit, sales, etc.

## Security
- Passwords hashed (bcrypt)
- Role-based access
- Approval logs for audit

## To Do
- Add more reports, CSV export
- Add SMS notification integration
- Add user management UI
- Add product edit/delete

---
System by IT Patrick, 2025
