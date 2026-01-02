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
              <i class="fa fa-truck text-primary"></i> Supplier <span class="text-danger">*</span>
            </label>
            <select name="supplier_id" class="form-select" required>
              <option value="">-- Select Supplier --</option>
              <?php foreach($suppliers as $s): ?>
                <option value="<?= $s['supplier_id'] ?>" <?= $purchase['supplier_id'] == $s['supplier_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($s['name']) ?> (TIN: <?= htmlspecialchars($s['tin_number']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-box text-warning"></i> Product <span class="text-danger">*</span>
            </label>
            <select name="product_id" class="form-select" required>
              <option value="">-- Select Product --</option>
              <?php foreach($products as $p): ?>
                <option value="<?= $p['product_id'] ?>" <?= $purchase['product_id'] == $p['product_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($p['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-sort-numeric-up text-info"></i> Quantity <span class="text-danger">*</span>
            </label>
            <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($purchase['quantity']) ?>" required min="1" step="1">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">
              <i class="fa fa-tag text-success"></i> Unit Price (RWF) <span class="text-danger">*</span>
            </label>
            <input type="number" name="unit_price" class="form-control" value="<?= htmlspecialchars($purchase['unit_price']) ?>" required min="0" step="0.01">
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
