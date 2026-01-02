<style>
.page-header-purchase-edit {
  background: #ffffff;
  color: #1f2937;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  border: 2px solid #10b981;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.page-header-purchase-edit h2 {
  color: #10b981;
  font-size: 2rem;
  font-weight: 700;
}

.page-header-purchase-edit p {
  color: #6b7280;
}

.page-header-purchase-edit .header-icon {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

body.dark-mode .page-header-purchase-edit {
  background: #23272b !important;
  color: #ffffff !important;
  border: 2px solid #064e3b;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-mode .page-header-purchase-edit h2 {
  color: #34d399 !important;
}

body.dark-mode .page-header-purchase-edit p {
  color: #9ca3af !important;
}

body.dark-mode .page-header-purchase-edit .header-icon {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
}

.form-card-purchase {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

body.dark-mode .form-card-purchase {
  background: #23272b !important;
  border: 1px solid #4a5568;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}
</style>

<div class="container my-4">
  <!-- Professional Page Header -->
  <div class="page-header-purchase-edit">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div class="d-flex align-items-center">
        <div class="header-icon">
          <i class="fa fa-edit fa-lg"></i>
        </div>
        <div>
          <h2 class="fw-bold mb-1">
            Edit Purchase
          </h2>
          <p class="mb-0">
            <i class="fa fa-info-circle"></i> Update purchase record #<?= $purchase['purchase_id'] ?>
          </p>
        </div>
      </div>
      <a class="btn btn-outline-secondary btn-lg" href="?r=purchase/index">
        <i class="fa fa-arrow-left"></i> Back to Purchases
      </a>
    </div>
  </div>

  <?php if(!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="card form-card-purchase border-0" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px 16px 0 0;">
      <h5 class="mb-0">
        <i class="fa fa-edit"></i> Purchase Information
      </h5>
    </div>
    <div class="card-body p-4">
      <form method="post">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-truck text-primary"></i> Supplier TIN <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="supplier_tin" 
                   class="form-control" 
                   placeholder="Type or select supplier TIN" 
                   list="supplier_list"
                   value="<?= htmlspecialchars($purchase['supplier_tin'] ?? '') ?>"
                   required>
            <datalist id="supplier_list">
              <?php foreach($suppliers as $s): ?>
                <option value="<?= htmlspecialchars($s['tin_number']) ?>">
                  <?= htmlspecialchars($s['name']) ?>
                </option>
              <?php endforeach; ?>
            </datalist>
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> Type the supplier's TIN number
            </small>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-user text-primary"></i> Supplier Name
            </label>
            <input type="text" 
                   class="form-control" 
                   value="<?= htmlspecialchars($purchase['supplier_name']) ?>" 
                   readonly
                   style="background-color: #f8f9fa;">
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> Current supplier: <?= htmlspecialchars($purchase['supplier_name']) ?>
            </small>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-box text-warning"></i> Product Name <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="product_name" 
                   class="form-control" 
                   placeholder="Type or select product name" 
                   list="product_list"
                   value="<?= htmlspecialchars($purchase['product_name']) ?>"
                   required>
            <datalist id="product_list">
              <?php foreach($products as $p): ?>
                <option value="<?= htmlspecialchars($p['name']) ?>">
                  ID: <?= $p['product_id'] ?> - Stock: <?= $p['stock_quantity'] ?>
                </option>
              <?php endforeach; ?>
            </datalist>
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> Type the product name
            </small>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-calendar text-info"></i> Purchase Date
            </label>
            <input type="date" 
                   name="purchase_date" 
                   class="form-control" 
                   value="<?= htmlspecialchars($purchase['purchase_date']) ?>">
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> Optional: Leave blank to keep current date
            </small>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-sort-numeric-up text-info"></i> Quantity <span class="text-danger">*</span>
            </label>
            <input type="number" 
                   name="quantity" 
                   class="form-control" 
                   value="<?= htmlspecialchars($purchase['quantity']) ?>" 
                   required 
                   min="1" 
                   step="1"
                   placeholder="Enter quantity">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-tag text-success"></i> Unit Price (RWF) <span class="text-danger">*</span>
            </label>
            <input type="number" 
                   name="unit_price" 
                   class="form-control" 
                   value="<?= htmlspecialchars($purchase['unit_price']) ?>" 
                   required 
                   min="0" 
                   step="0.01"
                   placeholder="Enter unit price">
          </div>
        </div>

        <div class="mt-4 d-flex gap-2 flex-wrap">
          <button type="submit" class="btn btn-success btn-lg">
            <i class="fa fa-save"></i> Update Purchase
          </button>
          <a href="?r=purchase/index" class="btn btn-outline-secondary btn-lg">
            <i class="fa fa-times"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
