<?php
$products = (new Product())->all();
?>
<div class="container-fluid px-2 px-md-4">
  <div class="row g-4 justify-content-center mt-3">
    <!-- Summary Cards -->
    <div class="col-12 col-md-4 mb-2">
      <div class="card shadow-sm border-0 bg-gradient-primary text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 display-5"><i class="fa fa-user-plus"></i></div>
          <div>
            <div class="fw-bold fs-5">New Credit Sale</div>
            <div class="small">Record a new credit transaction for a client</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-2">
      <div class="card shadow-sm border-0 bg-gradient-info text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 display-5"><i class="fa fa-history"></i></div>
          <div>
            <div class="fw-bold fs-5">Client History</div>
            <div class="small">View previous credits for this client</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-2">
      <div class="card shadow-sm border-0 bg-gradient-success text-white h-100">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 display-5"><i class="fa fa-coins"></i></div>
          <div>
            <div class="fw-bold fs-5">Total Due</div>
            <div class="small">See the running total for this sale</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
      <div class="card p-4 mt-4 credit-form shadow-lg border-0">
        <h3 class="mb-3 text-primary"><i class="fa fa-credit-card"></i> Record New Credit Sale</h3>
        <form method="post" autocomplete="on" id="creditSaleForm" novalidate>
          <?php if(!empty($error)): ?>
              <div class="error"><i class="fa fa-exclamation-triangle"></i> <?=htmlspecialchars($error)?></div>
          <?php endif; ?>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="client_name" class="form-label"><i class="fa fa-user"></i> Client Name
                <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the full name of the client."></i>
              </label>
              <input id="client_name" name="client_name" type="text" class="form-control" required placeholder="e.g. IT Patrick" title="Enter the client's full name">
              <div class="invalid-feedback">Please enter the client's name.</div>
            </div>
            <div class="col-md-6">
              <label for="client_phone" class="form-label"><i class="fa fa-phone"></i> Client Phone
                <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter a valid phone number for the client."></i>
              </label>
              <input id="client_phone" name="client_phone" type="text" class="form-control" required placeholder="e.g. 0701234567" title="Enter the client's phone number" pattern="^0\d{9,10}$">
              <div class="invalid-feedback">Please enter a valid phone number (e.g. 0783086909).</div>
            </div>
            <div class="col-md-6">
              <label for="client_tin" class="form-label"><i class="fa fa-id-card"></i> Client TIN Number
                <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Optional: Enter the TIN number if applicable."></i>
              </label>
              <input id="client_tin" name="client_tin" type="text" class="form-control" placeholder="e.g. 123456789" title="Enter TIN number (optional)">
            </div>
            <div class="col-md-6">
              <label for="due_date" class="form-label"><i class="fa fa-calendar"></i> Due Date
                <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Select when payment is due."></i>
              </label>
              <input id="due_date" name="due_date" type="date" class="form-control" required title="Select the payment due date">
              <div class="invalid-feedback">Please select a due date.</div>
            </div>
          </div>
          <div id="client-history" class="mb-3 mt-3" style="display:none">
            <h5 class="mb-2"><i class="fa fa-history"></i> Client Credit History</h5>
            <div id="history-outstanding" class="alert alert-warning" style="display:none">
              <strong><i class="fa fa-exclamation-triangle"></i> Outstanding Debt!</strong>
              <div id="outstanding-message"></div>
              <div id="unpaid-items-list" class="mt-2"></div>
              <div class="mt-2">
                <small><i class="fa fa-info-circle"></i> You can still record this sale, but consider collecting payment first.</small>
              </div>
            </div>
            <div id="history-list"></div>
            <div id="history-total" style="font-weight:600;"></div>
          </div>
          <div id="productsArea" class="mt-3">
            <label class="form-label"><i class="fa fa-box"></i> Products
              <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Add all products for this credit sale. Use the plus button to add more."></i>
            </label>
            <div class="product-row">
              <input name="product_name[]" type="text" class="form-control" placeholder="Product Name" required title="Enter product name">
              <input name="quantity[]" type="number" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()" title="Enter quantity">
              <input name="unit_price[]" type="number" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()" title="Enter unit price">
              <input name="total[]" type="text" class="form-control" placeholder="Total" readonly tabindex="-1" style="max-width:100px;">
              <button type="button" class="remove-btn" onclick="removeProductRow(this)" title="Remove product"><i class="fa fa-trash"></i></button>
            </div>
          </div>
          <button type="button" class="btn btn-outline-primary mb-2 mt-2" onclick="addProductRow()"><i class="fa fa-plus"></i> Add Product</button>
          <div class="totals fs-5 mt-2">
            <i class="fa fa-calculator"></i> Grand Total: <span id="grandTotal">0.00</span>
          </div>
          <div class="actions mt-4 d-flex justify-content-between align-items-center">
            <a href="?r=credit/index" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to Credits</a>
            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save Credit Sale</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<style>
.form-control::placeholder {
  color: #6c757d;
  opacity: 1;
  transition: color 0.2s;
}
body.dark-mode .form-control::placeholder {
  color: #bfc9d1;
  opacity: 1;
}
.was-validated .form-control:invalid, .form-control.is-invalid {
  border-color: #dc3545;
  box-shadow: 0 0 0 0.2rem rgba(220,53,69,.08);
}
.was-validated .form-control:valid, .form-control.is-valid {
  border-color: #198754;
  box-shadow: 0 0 0 0.2rem rgba(25,135,84,.08);
}

.bg-gradient-primary {
  background: linear-gradient(90deg, #2a3d66 60%, #4e7fff 100%) !important;
}
.bg-gradient-info {
  background: linear-gradient(90deg, #117a8b 60%, #4e7fff 100%) !important;
}
.bg-gradient-success {
  background: linear-gradient(90deg, #218838 60%, #4e7fff 100%) !important;
}
.credit-form { max-width: 700px; margin: 2.5rem auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 18px rgba(44,62,80,0.13); padding: 2.2rem 2rem 1.5rem 2rem; }
.credit-form .form-label { font-weight: 500; color: #2a3d66; }
.credit-form input, .credit-form select { border-radius: 6px; font-size: 1.08rem; }
.credit-form input:focus, .credit-form select:focus { outline: none; box-shadow: 0 0 0 2px #4e7fff33; border-color: #4e7fff; }
.credit-form .actions { margin-bottom: 1.2rem; }
.credit-form .btn { border-radius: 6px; font-size: 1.1rem; font-weight: 600; transition: background 0.2s; }
.credit-form .btn-success { background: linear-gradient(90deg, #218838 60%, #4e7fff 100%); color: #fff; border: none; }
.credit-form .btn-success:hover { background: linear-gradient(90deg, #4e7fff 60%, #218838 100%); }
.credit-form .btn-outline-primary { border: 1.5px solid #4e7fff; color: #4e7fff; background: #fff; }
.credit-form .btn-outline-primary:hover { background: #4e7fff; color: #fff; }
.credit-form .btn-outline-secondary { border: 1.5px solid #6c757d; color: #6c757d; background: #fff; }
.credit-form .btn-outline-secondary:hover { background: #6c757d; color: #fff; }
.credit-form .error { color: #d32f2f; background: #ffeaea; border: 1px solid #ffcdd2; border-radius: 4px; padding: 0.7rem 1rem; margin-bottom: 1.2rem; text-align: center; font-size: 1rem; }
.credit-form .product-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: flex-end; }
.credit-form .product-row input, .credit-form .product-row select { flex: 1; }
.credit-form .product-row .remove-btn { background: #d32f2f; color: #fff; border: none; border-radius: 4px; padding: 0.3rem 0.7rem; font-size: 1.1rem; margin-left: 0.3rem; }
.credit-form .product-row .remove-btn:hover { background: #b71c1c; }
.credit-form .totals { font-weight: 600; color: #2a3d66; margin-top: 1rem; text-align: right; }
</style>
<script>
function addProductRow() {
  const row = document.createElement('div');
  row.className = 'product-row';
  row.innerHTML = `
    <input name="product_name[]" type="text" class="form-control" placeholder="Product Name" required>
    <input name="quantity[]" type="number" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()">
    <input name="unit_price[]" type="number" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()">
    <input name="total[]" type="text" class="form-control" placeholder="Total" readonly tabindex="-1" style="max-width:100px;">
    <button type="button" class="remove-btn" onclick="removeProductRow(this)">&times;</button>
  `;
  document.getElementById('productsArea').appendChild(row);
}
function removeProductRow(btn) {
  const row = btn.parentNode;
  row.parentNode.removeChild(row);
  updateTotals();
}
function updateTotals() {
  let grand = 0;
  document.querySelectorAll('.product-row').forEach(function(row) {
    const qty = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
    const price = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
    const total = qty * price;
    row.querySelector('input[name="total[]"]').value = total.toFixed(2);
    grand += total;
  });
  document.getElementById('grandTotal').textContent = grand.toFixed(2);
}
function fetchClientHistory() {
  const phone = document.getElementById('client_phone').value.trim();
  if (!phone) return;
  fetch('?r=credit/historyApi&phone=' + encodeURIComponent(phone))
    .then(res => res.json())
    .then(data => {
      const historyDiv = document.getElementById('client-history');
      const listDiv = document.getElementById('history-list');
      const totalDiv = document.getElementById('history-total');
      if (data.history && data.history.length > 0) {
        let html = '';
        let lastDate = '';
        data.history.forEach(row => {
          if (row.date_issued !== lastDate) {
            html += `<div style='margin-top:0.7em;font-weight:500;color:#2a3d66;'>${row.date_issued}</div>`;
            lastDate = row.date_issued;
          }
          html += `<div style='margin-left:1em;'>${row.product_name} &times; ${row.quantity} @ ${row.unit_price} = <b>${row.total_price}</b> <span style='font-size:0.95em;color:#888;'>[${row.status}]</span></div>`;
        });
        listDiv.innerHTML = html;
        totalDiv.innerHTML = 'Total Credit: <span style="color:#d32f2f">' + data.total.toFixed(2) + '</span>';
        historyDiv.style.display = '';
      } else {
        listDiv.innerHTML = '<em>No previous credits for this client.</em>';
        totalDiv.innerHTML = '';
        historyDiv.style.display = '';
      }
    });
}
document.getElementById('client_phone').addEventListener('blur', fetchClientHistory);
document.getElementById('creditSaleForm').addEventListener('input', updateTotals);
// Bootstrap tooltips
window.onload = function() {
  updateTotals();
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
};

// Real-time validation feedback
document.getElementById('creditSaleForm').addEventListener('submit', function(event) {
  if (!this.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
  }
  this.classList.add('was-validated');
});
</script>