# Complete Feature Testing Guide
## Updated with New Payment & Notification Features

Use this guide alongside the existing TESTING_CHECKLIST.md to verify new features.


## 🆕 NEW FEATURES TO TEST

### 1. Client TIN Number

**Test Case 1.1: Add TIN for New Client**
```
Steps:
1. Credits → Add Credit Sale
2. Enter new phone: 0700111111
3. Name: TIN Test Client
4. TIN: TIN123456789
5. Add product, save

Verify:
- Database query: SELECT tin_number FROM clients WHERE phone='0700111111'
- Expected: TIN123456789

✅ PASS: TIN saved correctly
❌ FAIL: TIN is NULL or incorrect
```

**Test Case 1.2: Update TIN for Existing Client**
```
Steps:
1. Use same phone 0700111111
2. Enter different TIN: TIN999999999
3. Save

Verify:
- Database shows updated TIN
- History shows both transactions

✅ PASS: TIN updates
❌ FAIL: TIN unchanged


### 2. Outstanding Debt Warning

**Test Case 2.1: Client with No Debt**
```
Steps:
1. Credits → Add Credit Sale
2. Enter new phone: 0700222222
3. Enter client name, products
4. Save first credit

Expected:
- No warning shown
- History says "No previous credits"

✅ PASS: Correct behavior
❌ FAIL: Warning shows for new client
```

**Test Case 2.2: Client with Unpaid Debt**
```
Steps:
1. Credits → Add Credit Sale
2. Enter phone from Test 2.1: 0700222222
3. Phone field loses focus

Expected:
- ⚠️ Orange/yellow warning box appears
- Shows: "Outstanding balance of X.XX"
- Table lists unpaid items with:
  * Product name
  * Quantity
  * Total price
  * Amount paid
  * Balance
  * Due date
  * Status badge

✅ PASS: All elements show correctly
❌ FAIL: Warning missing or incomplete
```

**Test Case 2.3: Can Still Record Sale with Debt**
```
Steps:
1. Continue from Test 2.2
2. Add new products despite warning
3. Click Save

Expected:
- Sale records successfully
- No blocking error

✅ PASS: Sale allowed
❌ FAIL: System blocks sale
```

---

### 3. Partial Payment Recording

**Test Case 3.1: Record Partial Payment**
```
Setup:
- Create credit for 10,000
- Status: pending

Steps:
1. Notifications or Credits page
2. Click "Record Payment" for the credit
3. Enter amount: 4,000
4. Remarks: "Partial payment 1"
5. Save

Verify Database:
SELECT credit_id, total_price, amount_paid, balance, status
FROM credit_sales 
WHERE credit_id = [your_credit_id];

Expected:
- amount_paid = 4000
- balance = 6000
- status = 'partial_paid'

✅ PASS: All values correct
❌ FAIL: Values incorrect or status not changed
```

**Test Case 3.2: Second Partial Payment**
```
Steps:
1. Record another payment: 3,000
2. Save

Expected:
- amount_paid = 7000
- balance = 3000
- status = 'partial_paid' (still)

✅ PASS: Cumulative payment tracked
❌ FAIL: amount_paid not cumulative
```

**Test Case 3.3: Final Payment**
```
Steps:
1. Record final payment: 3,000
2. Save

Expected:
- amount_paid = 10000
- balance = 0
- status = 'paid'

✅ PASS: Fully paid, status updated
❌ FAIL: Balance not zero or status not 'paid'
```

---

### 4. Manual Approval (Your Requirement)

**Test Case 4.1: Approve Without Payment Record**
```
Setup:
- Create credit for 5,000
- Don't record any payments
- Client paid cash outside system

Steps:
1. Credits → Index
2. Find the credit
3. Click "Approve" button (or Edit → Approve)
4. Add remarks: "Cash payment received"
5. Confirm

Expected:
- status = 'approved'
- amount_paid may still be 0
- Approval log created

✅ PASS: Approved without payment tracking
❌ FAIL: Requires payment record first

Note: This is YOUR specific requirement - approve manually when client pays
```

---

### 5. Notification System

**Test Case 5.1: Due Today Notifications**
```
Setup:
1. Create credit with due_date = TODAY
2. Save

Steps:
1. Go to Notifications menu
2. Check "Due Today" section

Expected:
- Credit appears in this section
- Shows: Client name, phone, total, balance, due date
- Action buttons: Notify, History, Record Payment

✅ PASS: Shows in Due Today
❌ FAIL: Not visible or in wrong section
```

**Test Case 5.2: Overdue Notifications**
```
Setup:
1. Create credit with due_date = 3 days ago
2. OR manually update database:
   UPDATE credit_sales SET due_date = DATE_SUB(NOW(), INTERVAL 3 DAY) WHERE credit_id = X;

Steps:
1. Run: CALL update_overdue_and_notify();
2. Go to Notifications

Expected:
- Credit appears in "Overdue" section
- Shows days_overdue = 3
- Status = 'overdue'
- Row highlighted (red/danger styling)

✅ PASS: Correctly categorized as overdue
❌ FAIL: Not showing or wrong days count
```

**Test Case 5.3: Notification Message Generation**
```
Steps:
1. From Notifications page
2. Click "Notify" for any overdue credit
3. View generated message

Expected Format:
"Dear [Client Name], your payment of [Amount] is X day(s) overdue 
(Due: YYYY-MM-DD). Outstanding balance: [Balance]. 
Please contact us to settle your account. Phone: [Phone]"

✅ PASS: Message generated with correct details
❌ FAIL: Message missing or incorrect format
```

**Test Case 5.4: CSV Export**
```
Steps:
1. Notifications → Export CSV button
2. File downloads

Expected:
- CSV file named: overdue_notifications_YYYY-MM-DD.csv
- Contains columns: Client Name, Phone, TIN, Total, Paid, Balance, Due Date, Days Overdue, Status
- Data matches what's on screen

✅ PASS: CSV exports with correct data
❌ FAIL: No download or incorrect data
```

---

### 6. Payment History Views

**Test Case 6.1: Payment History for Single Credit**
```
Setup:
- Record 3 partial payments on one credit

Steps:
1. Payments → History?credit_id=X
   OR from credit detail page

Expected:
- Table shows all 3 payments
- Each row: amount, date, recorded by, remarks
- Total shows sum of payments

✅ PASS: Full payment history visible
❌ FAIL: Missing payments or incorrect totals
```

**Test Case 6.2: All Payments for Client**
```
Setup:
- Client has 3 credits
- Payments on all 3

Steps:
1. Payments → Client Payments?client_id=X

Expected:
- Lists all payments across all credits
- Grouped or ordered logically
- Shows which credit each payment belongs to

✅ PASS: Complete client payment history
❌ FAIL: Missing data or incorrect grouping
```

---

### 7. Enhanced Credit History API

**Test Case 7.1: API Returns Debt Status**
```
Test URL:
?r=credit/historyApi&phone=0700222222

Expected JSON Structure:
{
  "history": [...],           // All credits
  "unpaidItems": [...],       // Only unpaid/partial
  "total": 50000,             // Sum of all credits
  "outstanding": 15000,       // Sum of balances
  "hasDebt": true,            // Boolean flag
  "summary": {
    "total_credits": 5,
    "total_credit_amount": 50000,
    "total_paid": 35000,
    "total_balance": 15000
  }
}

✅ PASS: All fields present and correct
❌ FAIL: Missing fields or wrong calculations
```

**Test Case 7.2: API for Client with No Debt**
```
Test URL:
?r=credit/historyApi&phone=0700999999 (all credits paid)

Expected:
{
  "hasDebt": false,
  "outstanding": 0,
  "unpaidItems": []
}

✅ PASS: Correctly shows no debt
❌ FAIL: Shows debt when shouldn't
```

---

### 8. Database Views

**Test Case 8.1: Client Outstanding Debt View**
```sql
SELECT * FROM client_outstanding_debt;
```

Expected:
- Lists all clients with unpaid credits
- Columns: client_id, name, phone, tin_number, total_credits, total_amount, total_paid, total_outstanding
- total_outstanding = total_amount - total_paid

✅ PASS: View exists and calculates correctly
❌ FAIL: View missing or wrong calculations
```

**Test Case 8.2: Overdue Notifications View**
```sql
SELECT * FROM overdue_notifications_view;
```

Expected:
- Shows only credits with due_date < TODAY and balance > 0
- Includes days_overdue calculated correctly
- Example: due_date = 2026-01-01, today = 2026-01-05, days_overdue = 4

✅ PASS: View filters and calculates correctly
❌ FAIL: Includes non-overdue or wrong days
```

---

### 9. Stored Procedure & Event

**Test Case 9.1: Manual Procedure Execution**
```sql
CALL update_overdue_and_notify();
```

Expected:
- No errors
- Updates status to 'overdue' for credits past due_date
- Inserts records in notification_logs

Verify:
```sql
SELECT * FROM notification_logs 
WHERE DATE(sent_date) = CURDATE() 
ORDER BY sent_date DESC;
```

Should show new entries for today

✅ PASS: Procedure runs and logs created
❌ FAIL: Errors or no logs
```

**Test Case 9.2: Event Scheduler Check**
```sql
SHOW VARIABLES LIKE 'event_scheduler';
```
Expected: ON

```sql
SHOW EVENTS FROM retail_credit_system;
```
Expected: daily_overdue_check event exists

```sql
SELECT * FROM information_schema.EVENTS 
WHERE EVENT_NAME = 'daily_overdue_check';
```
Check EXECUTE_AT or INTERVAL_VALUE

✅ PASS: Event exists and scheduled
❌ FAIL: Event missing or disabled
```

---

## 🔄 Integration Test Scenarios

### Scenario A: Complete Client Lifecycle

```
Timeline:

Day 1 - New Client:
1. Create credit: Client A, 20,000, due in 3 days
   ✓ Status: pending
   ✓ No debt warning (first transaction)

Day 2 - Partial Payment:
2. Record payment: 8,000
   ✓ amount_paid: 8,000
   ✓ balance: 12,000
   ✓ status: partial_paid

Day 3 - New Credit (debt exists):
3. Create second credit: 15,000
   ✓ Warning shows: "Outstanding 12,000"
   ✓ Lists first credit in unpaid items
   ✓ Can still proceed
   ✓ Total outstanding now: 27,000

Day 4 - Due Date Arrives:
4. Check notifications
   ✓ First credit in "Due Today" (balance 12,000)
   ✓ Second credit not yet due

Day 5 - Becomes Overdue:
5. Run procedure or wait for event
   ✓ First credit moves to "Overdue" section
   ✓ days_overdue: 1
   ✓ Status: overdue

Day 6 - Full Payment First Credit:
6. Record payment: 12,000
   ✓ First credit: amount_paid: 20,000, balance: 0
   ✓ status: paid
   ✓ Removed from notifications
   ✓ Outstanding now: 15,000 (only second credit)

Day 7 - Approve Second Credit:
7. Client pays cash for second credit
8. Manager clicks "Approve"
   ✓ status: approved
   ✓ No debt warning on new sales
   ✓ API hasDebt: false

✅ PASS if entire scenario completes as described
```

---

## 🛡️ Edge Cases

**Test Case E1: Payment Exceeds Balance**
```
Setup: Credit total = 5,000

Try: Record payment of 6,000

Expected:
- Error: "Payment exceeds total credit amount"
- Payment NOT recorded
- Balance unchanged

✅ PASS: Validation prevents overpayment
❌ FAIL: Allows overpayment
```

**Test Case E2: Negative Payment**
```
Try: Record payment of -100

Expected:
- Error: "Payment amount must be greater than zero"

✅ PASS: Validation blocks negative
❌ FAIL: Accepts negative value
```

**Test Case E3: Multiple Same-Day Credits**
```
Create 5 credits for same client on same day

Expected:
- All 5 show in history
- Outstanding sum is correct
- Each can be paid independently

✅ PASS: Handles multiple correctly
❌ FAIL: Duplicates or wrong totals
```

---

## 📊 Quick Test Summary

| Feature | Status | Notes |
|---------|--------|-------|
| Client TIN Storage | ☐ | Test 1.1, 1.2 |
| Debt Warning Display | ☐ | Test 2.2 |
| Can Record Sale with Debt | ☐ | Test 2.3 |
| Partial Payment | ☐ | Test 3.1-3.3 |
| Manual Approval | ☐ | Test 4.1 |
| Due Today Notifications | ☐ | Test 5.1 |
| Overdue Notifications | ☐ | Test 5.2 |
| CSV Export | ☐ | Test 5.4 |
| Payment History | ☐ | Test 6.1-6.2 |
| Enhanced API | ☐ | Test 7.1-7.2 |
| Database Views | ☐ | Test 8.1-8.2 |
| Stored Procedure | ☐ | Test 9.1 |
| Event Scheduler | ☐ | Test 9.2 |
| Integration Scenario | ☐ | Scenario A |
| Edge Cases | ☐ | E1-E3 |

---

## 🎯 Priority Tests (Must Pass)

1. **Debt Warning Shows** - Test 2.2
2. **Payment Updates Balance** - Test 3.1
3. **Manual Approval Works** - Test 4.1
4. **Notifications Appear** - Test 5.1, 5.2
5. **API Returns hasDebt** - Test 7.1

If these 5 pass, core functionality is working.

---

*Use this alongside existing TESTING_CHECKLIST.md for complete verification*
