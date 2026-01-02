<div class="container mt-4" style="max-width:700px;">
  <!-- Summary Card -->
  <div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body d-flex align-items-center gap-3">
      <div><i class="fa fa-shopping-cart fa-2x text-primary"></i></div>
      <div>
        <div class="fw-bold">Record New Product Purchase</div>
        <div class="text-muted small">Fill in supplier details and add multiple products in one purchase. Click "+" to add more products.</div>
      </div>
    </div>
  </div>
  <div class="card p-4 shadow-sm border-0">
    <h2 class="mb-3 text-primary"><i class="fa fa-shopping-cart"></i> New Purchase</h2>
    <form method="post" id="purchaseForm" novalidate>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"> <?=htmlspecialchars($error)?> </div>
      <?php endif; ?>
      
      <!-- Supplier Information -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label"><i class="fa fa-truck"></i> Supplier Name
            <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Type supplier name; it will be matched automatically."></i>
          </label>
          <input list="supplierNameOptions" name="supplier_name" class="form-control" placeholder="Type supplier name" required>
          <datalist id="supplierNameOptions">
            <?php foreach($suppliers as $s): ?>
              <option value="<?=htmlspecialchars($s['name'])?>"><?=htmlspecialchars($s['tin_number'])?></option>
            <?php endforeach; ?>
          </datalist>
          <div class="invalid-feedback">Please type a valid supplier name.</div>
        </div>
        <div class="col-md-6">
          <label class="form-label"><i class="fa fa-id-card"></i> Supplier TIN
            <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Type supplier TIN; it will be matched automatically."></i>
          </label>
          <input list="supplierTinOptions" name="supplier_tin" class="form-control" placeholder="Type supplier TIN" required>
          <datalist id="supplierTinOptions">
            <?php foreach($suppliers as $s): ?>
              <option value="<?=htmlspecialchars($s['tin_number'])?>"><?=htmlspecialchars($s['name'])?></option>
            <?php endforeach; ?>
          </datalist>
          <div class="invalid-feedback">Please type a valid supplier TIN.</div>
        </div>
      </div>

      <!-- Products Section -->
      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <label class="form-label mb-0"><i class="fa fa-box"></i> Products</label>
          <button type="button" class="btn btn-sm btn-success" onclick="addProductRow()">
            <i class="fa fa-plus"></i> Add Product
          </button>
        </div>
        <div id="productsArea">
          <div class="product-row mb-2">
            <div class="row g-2 align-items-end">
              <div class="col-md-5">
                <input list="productNameOptions" name="product_name[]" class="form-control" placeholder="Product name" required>
              </div>
              <div class="col-md-2">
                <input type="number" name="quantity[]" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()">
              </div>
              <div class="col-md-3">
                <input type="number" name="unit_price[]" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()">
              </div>
              <div class="col-md-2">
                <input name="total[]" class="form-control" placeholder="Total" readonly tabindex="-1">
              </div>
            </div>
          </div>
        </div>
        <datalist id="productNameOptions">
          <?php foreach($products as $p): ?>
            <option value="<?=htmlspecialchars($p['name'])?>"></option>
          <?php endforeach; ?>
        </datalist>
      </div>

      <!-- Total -->
      <div class="alert alert-info d-flex justify-content-between align-items-center">
        <strong><i class="fa fa-calculator"></i> Grand Total:</strong>
        <strong id="grandTotal" style="font-size:1.2em;">0.00</strong>
      </div>

      <button class="btn btn-primary w-100" type="submit"><i class="fa fa-save"></i> Record Purchase</button>
    </form>
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
  .was-validated .form-control:invalid, .form-select:invalid, .form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220,53,69,.08);
  }
  .was-validated .form-control:valid, .form-select:valid, .form-control.is-valid, .form-select.is-valid {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25,135,84,.08);
  }
  .product-row {
    position: relative;
  }
  .remove-product-btn {
    position: absolute;
    right: -35px;
    top: 0;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
  }
  .remove-product-btn:hover {
    background: #bb2d3b;
  }
  </style>
  <script>
  function addProductRow() {
    const row = document.createElement('div');
    row.className = 'product-row mb-2';
    row.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-5">
          <input list="productNameOptions" name="product_name[]" class="form-control" placeholder="Product name" required>
        </div>
        <div class="col-md-2">
          <input type="number" name="quantity[]" class="form-control" placeholder="Qty" min="1" value="1" required oninput="updateTotals()">
        </div>
        <div class="col-md-3">
          <input type="number" name="unit_price[]" class="form-control" placeholder="Unit Price" min="0" step="0.01" required oninput="updateTotals()">
        </div>
        <div class="col-md-2">
          <input name="total[]" class="form-control" placeholder="Total" readonly tabindex="-1">
        </div>
      </div>
      <button type="button" class="remove-product-btn" onclick="removeProductRow(this)" title="Remove product">&times;</button>
    `;
    document.getElementById('productsArea').appendChild(row);
    updateTotals();
  }

  function removeProductRow(btn) {
    const row = btn.parentElement;
    row.remove();
    updateTotals();
  }

  function updateTotals() {
    let grand = 0;
    document.querySelectorAll('.product-row').forEach(function(row) {
      const qtyInput = row.querySelector('input[name="quantity[]"]');
      const priceInput = row.querySelector('input[name="unit_price[]"]');
      const totalInput = row.querySelector('input[name="total[]"]');
      
      if (qtyInput && priceInput && totalInput) {
        const qty = parseFloat(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = qty * price;
        totalInput.value = total.toFixed(2);
        grand += total;
      }
    });
    document.getElementById('grandTotal').textContent = grand.toFixed(2);
  }

  // Bootstrap tooltips
  window.onload = function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
    updateTotals();
  };

  // Real-time validation feedback
  document.getElementById('purchaseForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    this.classList.add('was-validated');
  });

  // Auto-update totals on input
  document.getElementById('purchaseForm').addEventListener('input', updateTotals);
  </script>
  </div>
</div>
