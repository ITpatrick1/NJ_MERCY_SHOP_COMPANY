<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-edit"></i> Edit Purchase</h2>
    <a class="btn btn-secondary" href="?r=purchase/index"><i class="fa fa-arrow-left"></i> Back to Purchases</a>
  </div>

  <div class="card shadow-sm border-0" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body p-4">
      <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
          <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
          <select name="supplier_id" id="supplier_id" class="form-select" required>
            <option value="">-- Select Supplier --</option>
            <?php foreach($suppliers as $s): ?>
              <option value="<?=$s['supplier_id']?>" <?=$purchase['supplier_id'] == $s['supplier_id'] ? 'selected' : ''?>>
                <?=htmlspecialchars($s['name'])?> (<?=htmlspecialchars($s['tin_number'])?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
          <select name="product_id" id="product_id" class="form-select" required>
            <option value="">-- Select Product --</option>
            <?php foreach($products as $pr): ?>
              <option value="<?=$pr['product_id']?>" <?=$purchase['product_id'] == $pr['product_id'] ? 'selected' : ''?>>
                <?=htmlspecialchars($pr['name'])?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
          <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" class="form-control" value="<?=htmlspecialchars($purchase['quantity'])?>" required>
        </div>

        <div class="mb-3">
          <label for="unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
          <input type="number" step="0.01" min="0" name="unit_price" id="unit_price" class="form-control" value="<?=htmlspecialchars($purchase['unit_price'])?>" required>
        </div>

        <div class="mb-3">
          <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
          <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="<?=htmlspecialchars($purchase['purchase_date'])?>" required>
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Update Purchase
          </button>
          <a href="?r=purchase/index" class="btn btn-outline-secondary">
            <i class="fa fa-times"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
