<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1">
        <i class="fa fa-exclamation-triangle text-danger"></i> Overdue Credits Report
      </h2>
      <p class="text-muted mb-0">Credits past their due date requiring immediate attention</p>
    </div>
    <div>
      <button onclick="window.print()" class="btn btn-primary">
        <i class="fa fa-print"></i> Print Report
      </button>
      <a href="?r=credit/index" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Credits
      </a>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                <i class="fa fa-exclamation-triangle fa-2x"></i>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="text-muted mb-1">Total Overdue</h6>
              <h3 class="mb-0"><?= count($overdue) ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="fa fa-money-bill-wave fa-2x"></i>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="text-muted mb-1">Total Amount</h6>
              <h3 class="mb-0">RWF <?= number_format(array_sum(array_column($overdue, 'total_price')), 2) ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="fa fa-users fa-2x"></i>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="text-muted mb-1">Unique Clients</h6>
              <h3 class="mb-0"><?= count(array_unique(array_column($overdue, 'client_name'))) ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="fa fa-calendar-times fa-2x"></i>
              </div>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="text-muted mb-1">Avg Days Late</h6>
              <h3 class="mb-0">
                <?php
                  $totalDaysLate = 0;
                  foreach($overdue as $o) {
                    $dueDate = new DateTime($o['due_date']);
                    $now = new DateTime();
                    $diff = $now->diff($dueDate);
                    $totalDaysLate += $diff->days;
                  }
                  echo count($overdue) > 0 ? round($totalDaysLate / count($overdue)) : 0;
                ?>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Overdue Credits Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0">
        <i class="fa fa-list text-danger"></i> Overdue Credits Details
      </h5>
    </div>
    <div class="card-body p-0">
      <?php if(empty($overdue)): ?>
        <div class="text-center py-5">
          <i class="fa fa-check-circle text-success fa-4x mb-3"></i>
          <h4>No Overdue Credits</h4>
          <p class="text-muted">All credits are up to date. Great job!</p>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-4">Credit ID</th>
                <th>Client</th>
                <th>Product</th>
                <th class="text-center">Quantity</th>
                <th class="text-end">Total Price</th>
                <th class="text-end">Paid</th>
                <th class="text-end">Balance</th>
                <th>Due Date</th>
                <th class="text-center">Days Late</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($overdue as $o): 
                $dueDate = new DateTime($o['due_date']);
                $now = new DateTime();
                $diff = $now->diff($dueDate);
                $daysLate = $diff->days;
                $urgencyClass = $daysLate > 30 ? 'danger' : ($daysLate > 14 ? 'warning' : 'info');
              ?>
              <tr>
                <td class="px-4">
                  <span class="badge bg-primary">#<?=$o['credit_id']?></span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                      <i class="fa fa-user"></i>
                    </div>
                    <div>
                      <div class="fw-semibold"><?=htmlspecialchars($o['client_name'])?></div>
                      <small class="text-muted"><?=htmlspecialchars($o['client_phone'] ?? 'N/A')?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="fw-medium"><?=htmlspecialchars($o['product_name'] ?? $o['product_id'])?></div>
                </td>
                <td class="text-center">
                  <span class="badge bg-light text-dark"><?=$o['quantity']?></span>
                </td>
                <td class="text-end">
                  <div class="text-muted small">Total</div>
                  <span class="fw-semibold">RWF <?=number_format($o['total_price'], 2)?></span>
                </td>
                <td class="text-end">
                  <div class="text-success small">Paid</div>
                  <span class="fw-semibold text-success">RWF <?=number_format($o['amount_paid'] ?? 0, 2)?></span>
                </td>
                <td class="text-end">
                  <div class="text-danger small">Remaining</div>
                  <span class="fw-bold text-danger">RWF <?=number_format($o['balance'] ?? $o['total_price'], 2)?></span>
                </td>
                <td>
                  <div>
                    <i class="fa fa-calendar text-muted"></i>
                    <?=date('M d, Y', strtotime($o['due_date']))?>
                  </div>
                </td>
                <td class="text-center">
                  <span class="badge bg-<?=$urgencyClass?> bg-opacity-25 text-<?=$urgencyClass?>">
                    <i class="fa fa-clock"></i> <?=$daysLate?> days
                  </span>
                </td>
                <td class="text-center">
                  <span class="badge bg-danger"><?=htmlspecialchars($o['status'])?></span>
                </td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm">
                    <a href="?r=credit/index" class="btn btn-outline-primary" title="View Details">
                      <i class="fa fa-eye"></i>
                    </a>
                    <button class="btn btn-outline-success" title="Record Payment" 
                            onclick="openPaymentModal(<?=$o['credit_id']?>, '<?=htmlspecialchars($o['client_name'], ENT_QUOTES)?>', <?=$o['balance'] ?? $o['total_price']?>, <?=$o['amount_paid'] ?? 0?>, <?=$o['total_price']?>)">
                      <i class="fa fa-money-bill"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="paymentModalLabel">
          <i class="fa fa-money-bill-wave"></i> Record Payment
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="?r=payment/record" id="paymentForm">
        <div class="modal-body">
          <input type="hidden" name="credit_id" id="modal_credit_id">
          <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          
          <div class="alert alert-info">
            <div class="row">
              <div class="col-md-4">
                <strong>Client:</strong> <span id="modal_client_name"></span>
              </div>
              <div class="col-md-4">
                <strong>Total Price:</strong> <span id="modal_total_price"></span>
              </div>
              <div class="col-md-4">
                <strong>Already Paid:</strong> <span id="modal_already_paid" class="text-success"></span>
              </div>
            </div>
            <hr class="my-2">
            <div class="row">
              <div class="col-12">
                <strong class="text-danger">Remaining Balance:</strong> 
                <span id="modal_balance_owed" class="text-danger fw-bold fs-5"></span>
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="amount" class="form-label fw-semibold">
              <i class="fa fa-money-bill text-success"></i> Payment Amount <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text">RWF</span>
              <input type="number" 
                     class="form-control" 
                     id="amount" 
                     name="amount" 
                     step="0.01" 
                     min="0.01" 
                     placeholder="Enter payment amount"
                     required>
            </div>
            <small class="text-muted">Enter the amount received from the client</small>
          </div>
          
          <div class="mb-3">
            <label for="payment_date" class="form-label fw-semibold">
              <i class="fa fa-calendar text-primary"></i> Payment Date
            </label>
            <input type="date" 
                   class="form-control" 
                   id="payment_date" 
                   name="payment_date" 
                   value="<?= date('Y-m-d') ?>">
          </div>
          
          <div class="mb-3">
            <label for="remarks" class="form-label fw-semibold">
              <i class="fa fa-comment text-info"></i> Remarks (Optional)
            </label>
            <textarea class="form-control" 
                      id="remarks" 
                      name="remarks" 
                      rows="3" 
                      placeholder="Add any notes about this payment..."></textarea>
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
function openPaymentModal(creditId, clientName, balance, amountPaid, totalPrice) {
  document.getElementById('modal_credit_id').value = creditId;
  document.getElementById('modal_client_name').textContent = clientName;
  document.getElementById('modal_total_price').textContent = 'RWF ' + totalPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('modal_already_paid').textContent = 'RWF ' + amountPaid.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('modal_balance_owed').textContent = 'RWF ' + balance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  
  // Set max amount to remaining balance
  document.getElementById('amount').max = balance;
  
  // Open modal
  const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
  modal.show();
}

// Validate payment amount
document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
  const amount = parseFloat(document.getElementById('amount').value);
  const maxAmount = parseFloat(document.getElementById('amount').max);
  
  if (amount > maxAmount) {
    e.preventDefault();
    alert('Payment amount cannot exceed the remaining balance of RWF ' + maxAmount.toFixed(2));
    return false;
  }
});
</script>

<style>
.stat-icon {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
}

.avatar-sm {
  width: 36px;
  height: 36px;
  font-size: 14px;
}

@media print {
  .btn, .btn-group {
    display: none !important;
  }
  
  .card {
    border: 1px solid #dee2e6 !important;
    box-shadow: none !important;
  }
}

body.dark-mode .table-light {
  background: #2d3238 !important;
  color: #ffffff !important;
}

body.dark-mode .badge.bg-light {
  background: #444 !important;
  color: #fff !important;
}
</style>
