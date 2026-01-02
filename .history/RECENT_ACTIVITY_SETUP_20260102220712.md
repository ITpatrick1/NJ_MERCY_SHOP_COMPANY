# Recent Activity Setup Guide

## Issue: Recent Activity Not Showing

The "Recent Activity" section on your dashboard is not synchronizing because the `audit_logs` table either doesn't exist or has no data yet.

## Solution

### Step 1: Run the SQL Script
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Select the `retail_credit_system` database
3. Go to the SQL tab
4. Open the file `setup_audit_logs.sql` from your project root
5. Copy and paste the entire content
6. Click "Go" to execute

### Step 2: Verify the Table
After running the script, you should see:
- The `audit_logs` table in your database
- 5 sample activity records for testing

### Step 3: Check Your Dashboard
1. Refresh your dashboard page
2. Scroll to the "Recent Activity" section
3. You should now see sample activities

## How It Works

The system automatically logs activities when you:
- ✅ Login/Logout
- ✅ Create credit sales
- ✅ Record payments
- ✅ Create purchases
- ✅ Update products
- ✅ Manage clients and suppliers

## Updated Message

The empty state message has been updated to be more informative:
- Shows what types of activities will be logged
- Provides helpful guidance on how to generate activity logs
- More user-friendly and clear

## Next Steps

Once the table is set up, the system will automatically populate it as you use the application. The sample data is just for testing - real activity logs will be created as you perform actions in the system.

## Troubleshooting

If you still don't see activities after setup:
1. Check that the script ran successfully without errors
2. Verify the `audit_logs` table exists in your database
3. Ensure your user ID exists in the users table
4. Try performing a new action (create a sale, record payment, etc.)
5. Refresh the dashboard page
