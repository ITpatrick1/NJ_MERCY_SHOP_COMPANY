<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid px-2 px-md-4">
  <div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="fw-bold text-primary mb-0">
        <i class="fa fa-file-invoice"></i> Credit Sale Details
        <small class="text-muted fs-6 d-block mt-1">Credit #<?= $credit['credit_id'] ?></small>
      </h2>
      <a href="?r=credit/index" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back to List
      </a>
    </div>
  </div>
  
  <div class="row g-4">
    <!-- Client Information Card -->
    <div class="col-12 col-lg-6">
      <div class="card shadow border-0 h-100">
        <div class="card-header bg-gradient-primary text-white">
          <h5 class="mb-0"><i class="fa fa-user-circle"></i> Client Information</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-user"></i> Client Name</label>
                <div class="fw-bold fs-5"><?= htmlspecialchars($credit['client_name']) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-phone"></i> Phone Number</label>
                <div class="fw-semibold"><?= htmlspecialchars($credit['client_phone']) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-id-card"></i> TIN Number</label>
                <div class="fw-semibold"><?= $credit['tin_number'] ? htmlspecialchars($credit['tin_number']) : '<span class="text-muted">N/A</span>' ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Credit Status Card -->
    <div class="col-12 col-lg-6">
      <div class="card shadow border-0 h-100">
        <div class="card-header bg-gradient-info text-white">
          <h5 class="mb-0"><i class="fa fa-info-circle"></i> Credit Status</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-calendar"></i> Date Issued</label>
                <div class="fw-semibold"><?= date('d/m/Y', strtotime($credit['date_issued'])) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-calendar-alt"></i> Due Date</label>
                <div class="fw-semibold"><?= date('d/m/Y', strtotime($credit['due_date'])) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-tag"></i> Status</label>
                <div>
                  <?php
                  $status = strtolower($credit['status']);
                  $statusClass = 'secondary';
                  if ($status === 'paid' || $status === 'approved') $statusClass = 'success';
                  elseif ($status === 'overdue') $statusClass = 'danger';
                  elseif ($status === 'partial_paid') $statusClass = 'warning';
                  elseif ($status === 'pending') $statusClass = 'info';
                  ?>
                  <span class="badge bg-<?= $statusClass ?> fs-6"><?= ucfirst($credit['status']) ?></span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-user-tie"></i> Recorded By</label>
                <div class="fw-semibold"><?= htmlspecialchars($credit['recorded_by_name']) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Product & Financial Details Card -->
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header bg-gradient-success text-white">
          <h5 class="mb-0"><i class="fa fa-box"></i> Product & Financial Details</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-box"></i> Product Name</label>
                <div class="fw-bold"><?= htmlspecialchars($credit['product_name']) ?></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-hashtag"></i> Quantity</label>
                <div class="fw-semibold"><?= number_format($credit['quantity']) ?></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-tag"></i> Unit Price</label>
                <div class="fw-semibold">RWF <?= number_format($credit['unit_price'], 2) ?></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-calculator"></i> Total Price</label>
                <div class="fw-bold text-primary fs-5">RWF <?= number_format($credit['total_price'], 2) ?></div>
              </div>
            </div>
          </div>
          
          <hr class="my-3">
          
          <div class="row g-3">
            <div class="col-md-4">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-check-circle"></i> Amount Paid</label>
                <div class="fw-bold text-success fs-5">RWF <?= number_format($credit['amount_paid'], 2) ?></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-exclamation-circle"></i> Balance</label>
                <div class="fw-bold text-danger fs-5">RWF <?= number_format($credit['balance'], 2) ?></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-item">
                <label class="text-muted mb-1"><i class="fa fa-percent"></i> Payment Progress</label>
                <div>
                  <?php
                  $percentage = $credit['total_price'] > 0 ? ($credit['amount_paid'] / $credit['total_price']) * 100 : 0;
                  ?>
                  <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: <?= $percentage ?>%;" 
                         aria-valuenow="<?= $percentage ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                      <?= number_format($percentage, 1) ?>%
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Payment History Card -->
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header bg-gradient-warning text-dark">
          <h5 class="mb-0">
            <i class="fa fa-history"></i> Payment History 
            <span class="badge bg-dark ms-2"><?= count($payments) ?> Payment<?= count($payments) !== 1 ? 's' : '' ?></span>
          </h5>
        </div>
        <div class="card-body">
          <?php if (empty($payments)): ?>
            <div class="alert alert-info mb-0">
              <i class="fa fa-info-circle"></i> No payments recorded yet for this credit.
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th><i class="fa fa-hashtag"></i> #</th>
                    <th><i class="fa fa-calendar"></i> Payment Date</th>
                    <th><i class="fa fa-money-bill-wave"></i> Amount</th>
                    <th><i class="fa fa-user"></i> Recorded By</th>
                    <th><i class="fa fa-comment"></i> Remarks</th>
                    <th><i class="fa fa-tag"></i> Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($payments as $index => $payment): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($payment['payment_date'])) ?></td>
                    <td class="fw-bold text-success">RWF <?= number_format($payment['amount_paid'], 2) ?></td>
                    <td><?= htmlspecialchars($payment['recorded_by_name']) ?></td>
                    <td><?= $payment['remarks'] ? htmlspecialchars($payment['remarks']) : '<span class="text-muted">-</span>' ?></td>
                    <td>
                      <?php
                      $payStatus = strtolower($payment['status']);
                      $payStatusClass = 'secondary';
                      if ($payStatus === 'approved') $payStatusClass = 'success';
                      elseif ($payStatus === 'pending') $payStatusClass = 'warning';
                      ?>
                      <span class="badge bg-<?= $payStatusClass ?>"><?= ucfirst($payment['status']) ?></span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                  <tr>
                    <th colspan="2" class="text-end">Total Paid:</th>
                    <th class="text-success">RWF <?= number_format($credit['amount_paid'], 2) ?></th>
                    <th colspan="3"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between flex-wrap gap-2">
            <div class="btn-group" role="group">
              <a href="?r=credit/edit&id=<?= $credit['credit_id'] ?>" class="btn btn-success">
                <i class="fa fa-edit"></i> Edit Credit
              </a>
              <?php if ($credit['balance'] > 0): ?>
              <button type="button" class="btn btn-primary" onclick="openPaymentModal()">
                <i class="fa fa-money-bill-wave"></i> Record Payment
              </button>
              <?php endif; ?>
            </div>
            <a href="?r=credit/index" class="btn btn-secondary">
              <i class="fa fa-arrow-left"></i> Back to List
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="?r=payment/record" id="paymentForm">
        <input type="hidden" name="credit_id" value="<?= $credit['credit_id'] ?>">
        <input type="hidden" name="redirect" value="?r=credit/show&id=<?= $credit['credit_id'] ?>">
        
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="paymentModalLabel">
            <i class="fa fa-money-bill-wave"></i> Record Payment
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <div class="alert alert-info">
            <div class="row">
              <div class="col-md-6">
                <strong>Client:</strong> <?= htmlspecialchars($credit['client_name']) ?>
              </div>
              <div class="col-md-6">
                <strong>Total Price:</strong> RWF <?= number_format($credit['total_price'], 2) ?>
              </div>
            </div>
            <hr class="my-2">
            <div class="row">
              <div class="col-md-6">
                <strong class="text-success">Paid:</strong> 
                <span class="text-success">RWF <?= number_format($credit['amount_paid'], 2) ?></span>
              </div>
              <div class="col-md-6">
                <strong class="text-danger">Balance:</strong> 
                <span class="text-danger fw-bold">RWF <?= number_format($credit['balance'], 2) ?></span>
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="amount" class="form-label">Payment Amount (RWF) <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" 
                   required min="0.01" step="0.01" max="<?= $credit['balance'] ?>">
            <div class="form-text">Maximum: RWF <?= number_format($credit['balance'], 2) ?></div>
          </div>
          
          <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" 
                   value="<?= date('Y-m-d') ?>" required>
          </div>
          
          <div class="mb-3">
            <label for="remarks" class="form-label">Remarks (Optional)</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="3" 
                      placeholder="Enter any additional notes..."></textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i> Record Payment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openPaymentModal() {
  const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
  modal.show();
}

// Validate payment amount
document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
  const amount = parseFloat(document.getElementById('amount').value);
  const maxAmount = <?= $credit['balance'] ?>;
  
  if (amount > maxAmount) {
    e.preventDefault();
    alert('Payment amount cannot exceed the remaining balance of RWF ' + maxAmount.toFixed(2));
    return false;
  }
  
  if (amount <= 0) {
    e.preventDefault();
    alert('Payment amount must be greater than zero');
    return false;
  }
});
</script>

<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-info {
  background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
}

.bg-gradient-success {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-warning {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.info-item {
  padding: 0.5rem;
  border-radius: 0.375rem;
  transition: background-color 0.2s;
}

.info-item:hover {
  background-color: rgba(0,0,0,0.02);
}

body.dark-mode .info-item:hover {
  background-color: rgba(255,255,255,0.05);
}

body.dark-mode .table-light {
  background-color: #2d3238 !important;
  color: #ffffff !important;
}

body.dark-mode .alert-info {
  background-color: #1a3a52 !important;
  border-color: #2c5f8d !important;
  color: #ffffff !important;
}

body.dark-mode .card {
  background-color: #1a1d23 !important;
  color: #ffffff !important;
}

body.dark-mode .text-muted {
  color: #a0a0a0 !important;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
