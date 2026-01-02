<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php
$products = (new Product())->all();
?>
<div class="container-fluid px-2 px-md-4">
  <div class="page-header mb-4">
    <h2 class="fw-bold text-primary mb-2">
      <i class="fa fa-credit-card"></i> New Credit Sale
      <small class="text-success fs-6 d-block mt-1">Record a new credit transaction for your client</small>
    </h2>
  </div>
  
  <div class="row g-4 justify-content-center">
    <!-- Summary Cards with Animation -->
    <div class="col-12 col-md-4">
      <div class="card info-card shadow-sm border-0 bg-gradient-primary text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrapper me-3">
            <i class="fa fa-user-plus fa-2x"></i>
          </div>
          <div>
            <div class="fw-bold fs-5">New Credit Sale</div>
            <div class="small opacity-75">Record a new credit transaction for a client</div>
          </div>
        </div>
        <div class="card-shine"></div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card info-card shadow-sm border-0 bg-gradient-info text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrapper me-3">
            <i class="fa fa-history fa-2x"></i>
          </div>
          <div>
            <div class="fw-bold fs-5">Client History</div>
            <div class="small opacity-75">View previous credits for this client</div>
          </div>
        </div>
        <div class="card-shine"></div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card info-card shadow-sm border-0 bg-gradient-success text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrapper me-3">
            <i class="fa fa-coins fa-2x"></i>
          </div>
          <div>
            <div class="fw-bold fs-5">Grand Total</div>
            <div class="small opacity-75">RWF <span id="headerGrandTotal">0.00</span></div>
          </div>
        </div>
        <div class="card-shine"></div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center mt-4">
    <div class="col-12 col-lg-10 col-xl-9">
      <div class="card credit-form shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
          <h4 class="mb-0">
            <i class="fa fa-file-invoice-dollar"></i> Credit Sale Details
          </h4>
        </div>
        <div class="card-body p-4">
          <form method="post" autocomplete="on" id="creditSaleForm" novalidate>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="fa fa-exclamation-triangle"></i> <strong>Error!</strong> <?=htmlspecialchars($error)?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <!-- Client Information Section -->
            <div class="form-section">
              <h5 class="section-title">
                <i class="fa fa-user-circle"></i> Client Information
              </h5>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="client_name" class="form-label">
                    <i class="fa fa-user"></i> Client Name <span class="text-danger">*</span>
                    <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the full name of the client."></i>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                    <input id="client_name" name="client_name" type="text" class="form-control" required placeholder="e.g. IT Patrick" title="Enter the client's full name">
                    <div class="invalid-feedback">Please enter the client's name.</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="client_phone" class="form-label">
                    <i class="fa fa-phone"></i> Client Phone <span class="text-danger">*</span>
                    <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter a valid phone number for the client."></i>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    <input id="client_phone" name="client_phone" type="text" class="form-control" required placeholder="e.g. 0701234567" title="Enter the client's phone number" pattern="^0\d{9,10}$">
                    <div class="invalid-feedback">Please enter a valid phone number (e.g. 0783086909).</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="client_tin" class="form-label">
                    <i class="fa fa-id-card"></i> Client TIN Number
                    <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Optional: Enter the TIN number if applicable."></i>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                    <input id="client_tin" name="client_tin" type="text" class="form-control" placeholder="e.g. 123456789" title="Enter TIN number (optional)">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="due_date" class="form-label">
                    <i class="fa fa-calendar"></i> Due Date <span class="text-danger">*</span>
                    <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Select when payment is due."></i>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    <input id="due_date" name="due_date" type="date" class="form-control" required title="Select the payment due date">
                    <div class="invalid-feedback">Please select a due date.</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Client History Section -->
            <div id="client-history" class="form-section" style="display:none">
              <h5 class="section-title">
                <i class="fa fa-history"></i> Client Credit History
                <span class="loading-spinner" id="historyLoader" style="display:none;">
                  <i class="fa fa-spinner fa-spin"></i> Loading...
                </span>
              </h5>
              <div id="history-outstanding" class="alert alert-warning shadow-sm" style="display:none">
                <div class="d-flex align-items-start">
                  <i class="fa fa-exclamation-triangle fa-2x me-3"></i>
                  <div class="flex-fill">
                    <strong>Outstanding Debt!</strong>
                    <div id="outstanding-message" class="mt-2"></div>
                    <div id="unpaid-items-list" class="mt-3"></div>
                    <div class="mt-3">
                      <small><i class="fa fa-info-circle"></i> You can still record this sale, but consider collecting payment first.</small>
                    </div>
                  </div>
                </div>
              </div>
              <div id="history-list" class="history-content"></div>
              <div id="history-total" class="history-total"></div>
            </div>
            
            <!-- Products Section -->
            <div class="form-section">
              <h5 class="section-title">
                <i class="fa fa-box-open"></i> Products & Services
              </h5>
              <div id="productsArea">
                <div class="product-row">
                  <div class="product-inputs">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-box"></i></span>
                      <input name="product_name[]" type="text" class="form-control" placeholder="Product Name" required title="Enter product name">
                    </div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-sort-numeric-up"></i></span>
                      <input name="quantity[]" type="number" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()" title="Enter quantity">
                    </div>
                    <div class="input-group">
                      <span class="input-group-text">RWF</span>
                      <input name="unit_price[]" type="number" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()" title="Enter unit price">
                    </div>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-calculator"></i></span>
                      <input name="total[]" type="text" class="form-control total-field" placeholder="Total" readonly tabindex="-1">
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-remove" onclick="removeProductRow(this)" title="Remove product">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </div>
              <button type="button" class="btn btn-outline-primary mt-3" onclick="addProductRow()">
                <i class="fa fa-plus-circle"></i> Add Another Product
              </button>
            </div>
            
            <!-- Grand Total Section -->
            <div class="grand-total-section">
              <div class="grand-total-card">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <i class="fa fa-calculator fa-2x text-primary"></i>
                    <span class="ms-2 fs-5 fw-bold">Grand Total:</span>
                  </div>
                  <div class="grand-total-value">
                    <span class="currency">RWF</span>
                    <span id="grandTotal" class="amount">0.00</span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
              <a href="?r=credit/index" class="btn btn-outline-secondary btn-lg">
                <i class="fa fa-arrow-left"></i> Back to Credits
              </a>
              <button class="btn btn-success btn-lg px-5" type="submit">
                <i class="fa fa-save"></i> Save Credit Sale
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
/* Animation Keyframes */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
}

/* Page Header */
.page-header {
  animation: fadeInUp 0.6s ease-out;
}

/* Info Cards */
.info-card {
  animation: fadeInUp 0.6s ease-out;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
}

.info-card .icon-wrapper {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  transition: all 0.3s;
}

.info-card:hover .icon-wrapper {
  transform: rotate(10deg) scale(1.1);
  background: rgba(255,255,255,0.3);
}

.card-shine {
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  animation: shimmer 3s infinite;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-info {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
}

.bg-gradient-success {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
}

/* Credit Form Card */
.credit-form {
  animation: fadeInUp 0.8s ease-out;
  border-radius: 16px;
}

.credit-form .card-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 16px 16px 0 0 !important;
  padding: 1.5rem 2rem;
  border: none;
}

/* Form Sections */
.form-section {
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: #f8f9fa;
  border-radius: 12px;
  border-left: 4px solid #667eea;
  animation: slideIn 0.6s ease-out;
}

.section-title {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.section-title i {
  font-size: 1.2em;
}

/* Form Inputs */
.form-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-control {
  border-radius: 8px;
  border: 2px solid #e5e7eb;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  transition: all 0.3s;
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  outline: none;
}

.form-control::placeholder {
  color: #9ca3af;
  opacity: 1;
}

.input-group-text {
  background: #667eea;
  color: white;
  border: 2px solid #667eea;
  font-weight: 600;
  border-radius: 8px 0 0 8px;
}

.input-group .form-control {
  border-left: none;
  border-radius: 0 8px 8px 0;
}

.input-group .form-control:focus {
  border-left: 2px solid #667eea;
}

/* Validation */
.was-validated .form-control:invalid,
.form-control.is-invalid {
  border-color: #ef4444;
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.was-validated .form-control:valid,
.form-control.is-valid {
  border-color: #10b981;
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.invalid-feedback {
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

/* Product Rows */
.product-row {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 1rem;
  align-items: flex-start;
  animation: slideIn 0.4s ease-out;
}

.product-inputs {
  display: grid;
  grid-template-columns: 2fr 1fr 1.5fr 1.5fr;
  gap: 0.75rem;
  flex: 1;
}

.product-row .btn-remove {
  height: 48px;
  width: 48px;
  border-radius: 8px;
  transition: all 0.3s;
}

.product-row .btn-remove:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.total-field {
  font-weight: 600;
  color: #667eea;
  background: #f3f4f6 !important;
}

/* Client History */
.history-content {
  max-height: 400px;
  overflow-y: auto;
  padding: 1rem;
  background: white;
  border-radius: 8px;
}

.history-content::-webkit-scrollbar {
  width: 6px;
}

.history-content::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.history-content::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
  border-radius: 10px;
}

.history-total {
  font-weight: 600;
  padding: 1rem;
  background: white;
  border-radius: 8px;
  margin-top: 1rem;
  border-left: 4px solid #667eea;
}

/* Grand Total Section */
.grand-total-section {
  margin: 2rem 0;
}

.grand-total-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem;
  border-radius: 12px;
  color: white;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
  animation: pulse 2s infinite;
}

.grand-total-value {
  display: flex;
  align-items: baseline;
  gap: 0.5rem;
}

.grand-total-value .currency {
  font-size: 1.2rem;
  opacity: 0.9;
}

.grand-total-value .amount {
  font-size: 2.5rem;
  font-weight: 700;
  letter-spacing: -0.5px;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding-top: 2rem;
  border-top: 2px solid #e5e7eb;
}

.btn {
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-success {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border: none;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.btn-outline-primary {
  border: 2px solid #667eea;
  color: #667eea;
}

.btn-outline-primary:hover {
  background: #667eea;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-outline-secondary {
  border: 2px solid #6b7280;
  color: #6b7280;
}

.btn-outline-secondary:hover {
  background: #6b7280;
  color: white;
  transform: translateY(-2px);
}

/* Loading Spinner */
.loading-spinner {
  font-size: 0.875rem;
  color: #f59e0b;
  margin-left: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
  .product-inputs {
    grid-template-columns: 1fr;
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .form-actions .btn {
    width: 100%;
    justify-content: center;
  }
  
  .grand-total-value .amount {
    font-size: 2rem;
  }
}

/* Dark Mode */
body.dark-mode .page-header h2 {
  color: #a78bfa !important;
}

body.dark-mode .page-header small {
  color: #4ade80 !important;
}

body.dark-mode .credit-form {
  background: #2d3748;
  color: #e0e0e0;
}

body.dark-mode .credit-form .card-header {
  background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
}

body.dark-mode .form-section {
  background: #374151;
  border-left-color: #a78bfa;
}

body.dark-mode .section-title {
  color: #a78bfa;
}

body.dark-mode .form-label {
  color: #e0e0e0;
}

body.dark-mode .form-control {
  background: #1f2937;
  color: #e0e0e0;
  border-color: #4a5568;
}

body.dark-mode .form-control:focus {
  background: #1f2937;
  border-color: #a78bfa;
  box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.1);
}

body.dark-mode .form-control::placeholder {
  color: #6b7280;
}

body.dark-mode .input-group-text {
  background: #a78bfa;
  border-color: #a78bfa;
}

body.dark-mode .total-field {
  background: #374151 !important;
  color: #a78bfa !important;
}

body.dark-mode .history-content {
  background: #1f2937;
}

body.dark-mode .history-total {
  background: #1f2937;
  border-left-color: #a78bfa;
  color: #e0e0e0;
}

body.dark-mode .grand-total-card {
  background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
}

body.dark-mode .form-actions {
  border-top-color: #4a5568;
}

body.dark-mode .btn-outline-primary {
  border-color: #a78bfa;
  color: #a78bfa;
}

body.dark-mode .btn-outline-primary:hover {
  background: #a78bfa;
  color: #1f2937;
}

body.dark-mode .btn-outline-secondary {
  border-color: #9ca3af;
  color: #9ca3af;
}

body.dark-mode .btn-outline-secondary:hover {
  background: #9ca3af;
  color: #1f2937;
}

body.dark-mode .alert-warning {
  background: #4a3f1f;
  color: #fbbf24;
  border-color: #92400e;
}

body.dark-mode .alert-danger {
  background: #4a1f23;
  color: #fca5a5;
  border-color: #991b1b;
}

body.dark-mode .table {
  color: #e0e0e0;
}

body.dark-mode .table thead {
  background: #374151;
}

body.dark-mode .table-bordered td,
body.dark-mode .table-bordered th {
  border-color: #4a5568;
}

body.dark-mode .history-content::-webkit-scrollbar-track {
  background: #374151;
}

body.dark-mode .history-content::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #a78bfa 0%, #764ba2 100%);
}
</style>
<script>
// Add product row with animation
function addProductRow() {
  const row = document.createElement('div');
  row.className = 'product-row';
  row.innerHTML = `
    <div class="product-inputs">
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-box"></i></span>
        <input name="product_name[]" type="text" class="form-control" placeholder="Product Name" required>
      </div>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-sort-numeric-up"></i></span>
        <input name="quantity[]" type="number" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()">
      </div>
      <div class="input-group">
        <span class="input-group-text">RWF</span>
        <input name="unit_price[]" type="number" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()">
      </div>
      <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calculator"></i></span>
        <input name="total[]" type="text" class="form-control total-field" placeholder="Total" readonly tabindex="-1">
      </div>
    </div>
    <button type="button" class="btn btn-danger btn-remove" onclick="removeProductRow(this)" title="Remove product">
      <i class="fa fa-trash"></i>
    </button>
  `;
  document.getElementById('productsArea').appendChild(row);
}

// Remove product row
function removeProductRow(btn) {
  const row = btn.parentNode;
  row.style.animation = 'fadeOut 0.3s ease-out';
  setTimeout(() => {
    row.remove();
    updateTotals();
  }, 300);
}

// Update totals
function updateTotals() {
  let grand = 0;
  document.querySelectorAll('.product-row').forEach(function(row) {
    const qty = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
    const price = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
    const total = qty * price;
    row.querySelector('input[name="total[]"]').value = total.toFixed(2);
    grand += total;
  });
  document.getElementById('grandTotal').textContent = grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('headerGrandTotal').textContent = grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// Fetch client history
function fetchClientHistory() {
  const phone = document.getElementById('client_phone').value.trim();
  if (!phone) return;
  
  const historyLoader = document.getElementById('historyLoader');
  historyLoader.style.display = 'inline-block';
  
  fetch('?r=credit/historyApi&phone=' + encodeURIComponent(phone))
    .then(res => res.json())
    .then(data => {
      historyLoader.style.display = 'none';
      
      const historyDiv = document.getElementById('client-history');
      const listDiv = document.getElementById('history-list');
      const totalDiv = document.getElementById('history-total');
      const outstandingDiv = document.getElementById('history-outstanding');
      const outstandingMsg = document.getElementById('outstanding-message');
      const unpaidItemsList = document.getElementById('unpaid-items-list');
      
      if (data.hasDebt && data.outstanding > 0) {
        // Show outstanding debt warning
        outstandingMsg.innerHTML = `This client has an outstanding balance of <strong style="color:#dc2626; font-size:1.1em;">RWF ${parseFloat(data.outstanding).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong> from ${data.unpaidItems.length} unpaid transaction(s).`;
        
        let unpaidHtml = '<div style="max-height:250px; overflow-y:auto; margin-top:1rem;"><table class="table table-sm table-bordered table-hover mb-0"><thead class="table-dark"><tr><th>Product</th><th>Qty</th><th>Total</th><th>Paid</th><th>Balance</th><th>Due Date</th><th>Status</th></tr></thead><tbody>';
        data.unpaidItems.forEach(item => {
          const statusClass = item.status === 'overdue' ? 'danger' : 'warning';
          unpaidHtml += `<tr>
            <td><i class="fa fa-box text-primary"></i> ${item.product_name}</td>
            <td>${item.quantity}</td>
            <td>RWF ${parseFloat(item.total_price).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
            <td class="text-success">RWF ${parseFloat(item.amount_paid).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
            <td class="fw-bold text-danger">RWF ${parseFloat(item.balance).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
            <td>${item.due_date}</td>
            <td><span class="badge bg-${statusClass}">${item.status}</span></td>
          </tr>`;
        });
        unpaidHtml += '</tbody></table></div>';
        unpaidItemsList.innerHTML = unpaidHtml;
        outstandingDiv.style.display = 'block';
      } else {
        outstandingDiv.style.display = 'none';
      }
      
      if (data.history && data.history.length > 0) {
        let html = '<h6 class="mt-3 mb-3"><i class="fa fa-list-ul"></i> All Transaction History:</h6>';
        let lastDate = '';
        data.history.forEach(row => {
          if (row.date_issued !== lastDate) {
            html += `<div style='margin-top:1rem;margin-bottom:0.5rem;font-weight:600;color:#667eea;font-size:1.05rem;'><i class="fa fa-calendar"></i> ${row.date_issued}</div>`;
            lastDate = row.date_issued;
          }
          const balance = row.total_price - (row.amount_paid || 0);
          const statusBadge = row.status === 'settled' || row.status === 'paid' ? 
            '<span class="badge bg-success">Settled</span>' : 
            row.status === 'overdue' ? '<span class="badge bg-danger">Overdue</span>' :
            '<span class="badge bg-warning">Pending</span>';
          html += `<div style='margin-left:1.5rem;padding:0.75rem;background:rgba(102,126,234,0.05);border-radius:8px;margin-bottom:0.5rem;border-left:3px solid #667eea;'>
            <div><i class="fa fa-box text-primary"></i> <strong>${row.product_name}</strong> × ${row.quantity} @ RWF ${parseFloat(row.unit_price).toLocaleString('en-US', {minimumFractionDigits: 2})} = <strong>RWF ${parseFloat(row.total_price).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong></div>
            <div style='font-size:0.9rem;color:#6b7280;margin-top:0.25rem;'>
              <span class="me-3"><i class="fa fa-check-circle text-success"></i> Paid: RWF ${parseFloat(row.amount_paid || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
              <span class="me-3"><i class="fa fa-hand-holding-usd text-danger"></i> Balance: RWF ${balance.toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
              ${statusBadge}
            </div>
          </div>`;
        });
        listDiv.innerHTML = html;
        totalDiv.innerHTML = `
          <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:8px;color:white;">
            <div><i class="fa fa-calculator"></i> <strong>Total All Credits:</strong></div>
            <div style="font-size:1.2rem;font-weight:700;">RWF ${parseFloat(data.total).toLocaleString('en-US', {minimumFractionDigits: 2})}</div>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem;background:#fef3c7;border-radius:8px;margin-top:0.5rem;color:#78350f;">
            <div><i class="fa fa-exclamation-triangle"></i> <strong>Outstanding Balance:</strong></div>
            <div style="font-size:1.2rem;font-weight:700;">RWF ${parseFloat(data.outstanding).toLocaleString('en-US', {minimumFractionDigits: 2})}</div>
          </div>
        `;
        historyDiv.style.display = 'block';
      } else {
        listDiv.innerHTML = '<div style="text-align:center;padding:2rem;color:#9ca3af;"><i class="fa fa-inbox fa-3x mb-3"></i><div>No previous credits for this client.</div></div>';
        totalDiv.innerHTML = '';
        historyDiv.style.display = 'block';
      }
    })
    .catch(error => {
      historyLoader.style.display = 'none';
      console.error('Error fetching history:', error);
    });
}

// Event listeners
document.getElementById('client_phone').addEventListener('blur', fetchClientHistory);
document.getElementById('creditSaleForm').addEventListener('input', updateTotals);

// Bootstrap tooltips
window.onload = function() {
  updateTotals();
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
  
  // Set minimum due date to today
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('due_date').setAttribute('min', today);
};

// Real-time validation feedback
document.getElementById('creditSaleForm').addEventListener('submit', function(event) {
  if (!this.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
  }
  this.classList.add('was-validated');
});

// Add fadeOut animation
const style = document.createElement('style');
style.textContent = `
  @keyframes fadeOut {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(20px); }
  }
`;
document.head.appendChild(style);
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>