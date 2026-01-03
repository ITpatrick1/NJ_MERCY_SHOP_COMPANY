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
                <th class="text-end">Total Amount</th>
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
                  <span class="fw-bold text-danger">RWF <?=number_format($o['total_price'], 2)?></span>
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
                    <button class="btn btn-outline-success" title="Record Payment" onclick="alert('Payment feature coming soon')">
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
