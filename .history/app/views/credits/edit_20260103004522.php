<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid px-2 px-md-4">
  <div class="page-header mb-4">
    <h2 class="fw-bold text-primary mb-2">
      <i class="fa fa-edit"></i> Edit Credit Sale
      <small class="text-muted fs-6 d-block mt-1">Modify credit transaction details</small>
    </h2>
  </div>
  
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
          <h4 class="mb-0">
            <i class="fa fa-file-invoice-dollar"></i> Credit Details - #<?= $credit['credit_id'] ?>
          </h4>
        </div>
        <div class="card-body p-4">
          <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fa fa-exclamation-triangle"></i> <strong>Error!</strong> <?=htmlspecialchars($error)?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <?php if(!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fa fa-check-circle"></i> <strong>Success!</strong> <?=htmlspecialchars($success)?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <!-- Client Information (Read-only) -->
          <div class="mb-4 p-3 bg-light rounded">
            <h5 class="mb-3"><i class="fa fa-user-circle"></i> Client Information</h5>
            <div class="row">
              <div class="col-md-6">
                <p class="mb-2">
                  <strong><i class="fa fa-user"></i> Name:</strong> 
                  <?= htmlspecialchars($credit['client_name']) ?>
                </p>
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <strong><i class="fa fa-phone"></i> Phone:</strong> 
                  <?= htmlspecialchars($credit['client_phone']) ?>
                </p>
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <strong><i class="fa fa-box"></i> Product:</strong> 
                  <?= htmlspecialchars($credit['product_name']) ?>
                </p>
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <strong><i class="fa fa-calendar"></i> Date Issued:</strong> 
                  <?= date('d/m/Y', strtotime($credit['date_issued'])) ?>
                </p>
              </div>
            </div>
          </div>
          
          <form method="POST" id="editCreditForm">
            <!-- Editable Fields -->
            <div class="row g-3">
              <div class="col-md-6">
                <label for="quantity" class="form-label">
                  <i class="fa fa-hashtag"></i> Quantity <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                  <input type="number" name="quantity" id="quantity" class="form-control" 
                         value="<?= $credit['quantity'] ?>" required min="1" step="1">
                  <div class="invalid-feedback">Please enter a valid quantity.</div>
                </div>
              </div>
              
              <div class="col-md-6">
                <label for="unit_price" class="form-label">
                  <i class="fa fa-tag"></i> Unit Price (RWF) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text">RWF</span>
                  <input type="number" name="unit_price" id="unit_price" class="form-control" 
                         value="<?= $credit['unit_price'] ?>" required min="0" step="0.01">
                  <div class="invalid-feedback">Please enter a valid price.</div>
                </div>
              </div>
              
              <div class="col-md-6">
                <label for="due_date" class="form-label">
                  <i class="fa fa-calendar-alt"></i> Due Date <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                  <input type="date" name="due_date" id="due_date" class="form-control" 
                         value="<?= $credit['due_date'] ?>" required>
                  <div class="invalid-feedback">Please select a due date.</div>
                </div>
              </div>
              
              <div class="col-md-6">
                <label class="form-label">
                  <i class="fa fa-money-bill-wave"></i> Total Price
                </label>
                <div class="input-group">
                  <span class="input-group-text">RWF</span>
                  <input type="text" id="total_price_display" class="form-control bg-light" 
                         value="<?= number_format($credit['total_price'], 2) ?>" readonly>
                </div>
              </div>
            </div>
            
            <div class="row mt-4">
              <div class="col-12">
                <div class="alert alert-info">
                  <i class="fa fa-info-circle"></i> 
                  <strong>Note:</strong> Client and product information cannot be changed. 
                  You can only modify the quantity, unit price, and due date.
                  <?php if ($credit['amount_paid'] > 0): ?>
                  <br><strong class="text-warning">Warning:</strong> This credit has already received payments (RWF <?= number_format($credit['amount_paid'], 2) ?>). 
                  The new total price must not be less than this amount.
                  <?php endif; ?>
                </div>
              </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
              <a href="?r=credit/index" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Update Credit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
// Calculate total price dynamically
function updateTotalPrice() {
  const quantity = parseFloat(document.getElementById('quantity').value) || 0;
  const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
  const totalPrice = quantity * unitPrice;
  document.getElementById('total_price_display').value = totalPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

document.getElementById('quantity').addEventListener('input', updateTotalPrice);
document.getElementById('unit_price').addEventListener('input', updateTotalPrice);

// Form validation
document.getElementById('editCreditForm').addEventListener('submit', function(e) {
  const quantity = parseFloat(document.getElementById('quantity').value);
  const unitPrice = parseFloat(document.getElementById('unit_price').value);
  
  if (quantity <= 0) {
    e.preventDefault();
    alert('Quantity must be greater than 0');
    return false;
  }
  
  if (unitPrice < 0) {
    e.preventDefault();
    alert('Unit price cannot be negative');
    return false;
  }
});
</script>

<style>
body.dark-mode .bg-light {
  background-color: #2d3238 !important;
  color: #ffffff !important;
}

body.dark-mode .bg-light p {
  color: #e0e0e0 !important;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
