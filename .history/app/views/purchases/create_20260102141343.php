<div class="container mt-4" style="max-width:540px;">
  <!-- Summary Card -->
  <div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body d-flex align-items-center gap-3">
      <div><i class="fa fa-shopping-cart fa-2x text-primary"></i></div>
      <div>
        <div class="fw-bold">Record a New Product Purchase</div>
        <div class="text-muted small">Fill in the details below to add a new purchase to your inventory. All fields are required.</div>
      </div>
    </div>
  </div>
  <div class="card p-4 shadow-sm border-0">
    <h2 class="mb-3 text-primary"><i class="fa fa-shopping-cart"></i> New Purchase</h2>
    <form method="post" id="purchaseForm" novalidate>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"> <?=htmlspecialchars($error)?> </div>
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-truck"></i> Supplier
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Type TIN or select the supplier."></i>
        </label>
        <input list="supplierTinOptions" name="supplier_tin" class="form-control mb-2" placeholder="Type supplier TIN (optional)">
        <datalist id="supplierTinOptions">
          <?php foreach($suppliers as $s): ?>
            <option value="<?=htmlspecialchars($s['tin_number'])?>"><?=htmlspecialchars($s['name'])?></option>
          <?php endforeach; ?>
        </datalist>
        <select name="supplier_id" class="form-select" required>
          <option value="">Select Supplier</option>
          <?php foreach($suppliers as $s): ?>
            <option value="<?=$s['supplier_id']?>"><?=htmlspecialchars($s['name'])?> (TIN: <?=htmlspecialchars($s['tin_number'])?>)</option>
          <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Please select a supplier or type a valid TIN.</div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-box"></i> Product
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Type product name or select it."></i>
        </label>
        <input list="productNameOptions" name="product_name" class="form-control mb-2" placeholder="Type product name (optional)">
        <datalist id="productNameOptions">
          <?php foreach($products as $p): ?>
            <option value="<?=htmlspecialchars($p['name'])?>"></option>
          <?php endforeach; ?>
        </datalist>
        <select name="product_id" class="form-select" required>
          <option value="">Select Product</option>
          <?php foreach($products as $p): ?>
            <option value="<?=$p['product_id']?>"><?=htmlspecialchars($p['name'])?></option>
          <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Please select a product or type a valid name.</div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-sort-numeric-up"></i> Quantity
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the quantity purchased."></i>
        </label>
        <input type="number" name="quantity" class="form-control" min="1" required placeholder="Enter quantity">
        <div class="invalid-feedback">Please enter a valid quantity.</div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-money-bill"></i> Unit Price
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the unit price for this product."></i>
        </label>
        <input type="number" name="unit_price" class="form-control" min="0" step="0.01" required placeholder="Enter unit price">
        <div class="invalid-feedback">Please enter the unit price.</div>
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
  </style>
  <script>
  // Bootstrap tooltips
  window.onload = function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  };
  // Real-time validation feedback
  document.getElementById('purchaseForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    this.classList.add('was-validated');
  });
  </script>
  </div>
</div>
