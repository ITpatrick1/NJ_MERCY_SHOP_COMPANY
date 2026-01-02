# Quick Reference Guide - Daily Operations

## 📱 Recording a New Credit Sale

**Steps:**
1. Go to: **Credits → Add Credit Sale**
2. Enter: Client phone number
3. Check: System shows any outstanding debt
4. Decide: Collect payment first OR proceed with new sale
5. Fill in:
   - Client name
   - TIN (if applicable)
   - Due date
   - Products (add multiple with + button)
6. Click: **Save Credit Sale**

**⚠️ Important:**
- System WILL show if client has debt
- You CAN still record new sale
- But CONSIDER collecting payment first

---

## 💰 Recording a Payment

**When client makes payment:**

**Option 1: Partial/Full Payment**
1. Go to: **Notifications** OR **Credits**
2. Find the credit
3. Click: **Record Payment** 💵
4. Enter: Amount paid
5. Add: Remarks (optional)
6. Click: **Save**

System automatically:
- Updates total paid
- Recalculates balance
- Changes status if fully paid

**Option 2: Manual Approval (Cash Already Received)**
1. Go to: **Credits**
2. Find the credit
3. Click: **Approve** ✓
4. Enter: Remarks
5. Click: **Confirm**

Status changes to "approved"

---

## 🔔 Checking Notifications

**Daily routine:**
1. Go to: **Notifications** (in menu)
2. Review:
   - **Due Today** (payments due today)
   - **Overdue** (past due payments)
3. For each client:
   - Call using phone link 📞
   - View history 📋
   - Record payment if received 💵

**Actions available:**
- **Notify** 📧 - Generate reminder message
- **History** 📋 - View client's full record
- **Record Payment** 💵 - Log payment received

---

## 📝 Recording Purchases

**Steps:**
1. Go to: **Purchases → Create**
2. Select/Enter: Supplier details
   - Name
   - TIN number
   - Phone
3. Add: Products
   - Product name
   - Quantity
   - Unit price
4. Click: **Save Purchase**

System calculates total automatically

---

## 📊 Generating Reports

**Purchase Report:**
- Go to: **Reports → Purchase Report**
- Select: Daily / Weekly / Monthly / Yearly
- Pick date
- View or Export

**Credit Sales Report:**
- Go to: **Reports → Credit Sales**
- See all credit transactions

**Overdue Report:**
- Go to: **Reports → Overdue Credits**
- OR **Notifications → Export CSV**

**Payment Report:**
- Go to: **Payments → Report**
- Select date range

---

## 🔍 Looking Up Client History

**Method 1: During Credit Creation**
- Enter client phone
- History shows automatically

**Method 2: From Notifications**
- Click **History** button
- Opens in new tab

**Method 3: API Call**
```
?r=credit/historyApi&phone=0783264672
```
Returns JSON with full history

---

## 🎯 Common Workflows

### New Client (First Time)
```
1. Credits → Add Credit Sale
2. Enter new phone + name
3. System creates client record
4. Enter TIN (optional)
5. Add products
6. Set due date
7. Save
```

### Existing Client with Debt
```
1. Credits → Add Credit Sale
2. Enter phone
3. ⚠️ System shows: "Outstanding balance: 20,000"
4. Options:
   a) Record payment first, then new sale
   b) Proceed with new sale
5. Continue as normal
```

### Client Makes Partial Payment
```
1. Notifications → Find client
2. Click "Record Payment"
3. Enter amount (e.g., 10,000 of 20,000 debt)
4. Save
5. Status → "partial_paid"
6. Balance shows remaining
```

### Client Pays in Full
```
Option A: Track final payment
1. Record Payment → Enter final amount
2. System sets balance to 0
3. Status → "paid"

Option B: Already paid outside
1. Credits → Find credit
2. Click "Approve"
3. Status → "approved"
```

### Daily Notification Check
```
1. Login as manager
2. Go to Notifications
3. Review "Due Today" section
4. Call clients with due payments
5. Review "Overdue" section
6. Follow up on overdue (sorted by days)
7. Export CSV if needed for bulk SMS
```

---

## ⚡ Quick Tips

✅ **DO:**
- Check notifications every morning
- Enter client phone to see debt before new sale
- Record payments immediately when received
- Export overdue list weekly for follow-up
- Enter TIN for business clients
- Set realistic due dates

❌ **DON'T:**
- Skip debt check when recording new credit
- Forget to record partial payments
- Approve credits without verifying payment
- Leave notifications unchecked for days

---

## 🔢 Status Meanings

| Status | Meaning | Action Needed |
|--------|---------|---------------|
| **pending** | Credit recorded, not approved | Wait for manager approval |
| **active** | Approved, payment pending | Monitor due date |
| **partial_paid** | Some payment received | Follow up for remainder |
| **overdue** | Past due date, not paid | Urgent follow-up needed |
| **paid** | Fully paid (via payment record) | None - completed |
| **approved** | Paid (manually approved) | None - completed |

---

## 📞 Phone Number Format

✅ Correct: `0783086909` (starts with 0)
❌ Wrong: `783086909`, `+250783086909`

System accepts: 10 or 11 digits starting with 0

---

## 💡 Pro Tips

1. **Before new sale**: ALWAYS enter phone first to check debt
2. **For regular clients**: Save their TIN for faster entry next time
3. **Set due dates**: Default is +3 days, adjust based on client trust
4. **Use remarks**: Add notes when recording payments ("Paid cash", "Mobile money", etc.)
5. **Export CSV**: Use for bulk SMS or printing call lists
6. **Check balance**: If balance column shows value, payment still needed

---

## 🆘 Troubleshooting

**Problem: History not showing**
- Check phone number format (must start with 0)
- Ensure client exists in system
- Try entering phone again

**Problem: Can't record payment**
- Check if credit exists
- Verify amount is positive
- Ensure you're logged in as manager/staff

**Problem: Notifications not showing**
- Check if due dates are set
- Verify credits have balance > 0
- Check status (must be pending/active/overdue)

**Problem: Balance not calculating**
- Database migration may not have run
- Contact system administrator

---

## 📋 Checklists

### Morning Routine (Manager)
- [ ] Check Notifications dashboard
- [ ] Review Due Today section
- [ ] Call clients with due payments
- [ ] Review Overdue section (priority: most days overdue)
- [ ] Export CSV if needed for team

### Recording Credit Sale
- [ ] Enter client phone
- [ ] Check for outstanding debt
- [ ] Decide: collect payment first?
- [ ] Enter TIN if applicable
- [ ] Set appropriate due date
- [ ] Add all products
- [ ] Verify grand total
- [ ] Save

### Receiving Payment
- [ ] Confirm amount received
- [ ] Record payment in system
- [ ] Verify balance calculation
- [ ] Check new status
- [ ] Give receipt to client

### End of Day
- [ ] Generate daily sales report
- [ ] Generate daily purchase report
- [ ] Record any cash sales in Daily Sales
- [ ] Check for any unpaid credits due tomorrow

---

## 🎓 Training Checklist

**Staff Training:**
- [ ] How to record credit sale
- [ ] How to check client debt
- [ ] How to record payment
- [ ] How to use notifications
- [ ] Phone number format

**Manager Training:**
- [ ] All staff training items
- [ ] How to approve credits
- [ ] How to generate reports
- [ ] How to export data
- [ ] How to follow up on overdue

---

*Print this guide and keep near your workstation for quick reference!*
