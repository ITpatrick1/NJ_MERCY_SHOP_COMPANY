<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container-fluid px-2 px-md-4 mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0">
      <i class="fa fa-bell"></i> Payment Due Notifications
    </h2>
    <div class="d-flex gap-2">
      <a href="?r=notification/history" class="btn btn-outline-info">
        <i class="fa fa-history"></i> Notification History
      </a>
      <a href="?r=notification/exportCsv" class="btn btn-success">
        <i class="fa fa-download"></i> Export CSV
      </a>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <div class="mb-2"><i class="fa fa-calendar-day fa-3x text-warning"></i></div>
          <h5 class="card-title">Due Today</h5>
          <div class="display-5 fw-bold text-warning"><?= count($dueToday) ?></div>
          <small class="text-muted">Payment(s) due today</small>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <div class="mb-2"><i class="fa fa-exclamation-triangle fa-3x text-danger"></i></div>
          <h5 class="card-title">Overdue</h5>
          <div class="display-5 fw-bold text-danger"><?= count($overdue) ?></div>
          <small class="text-muted">Overdue payment(s)</small>
        </div>
      </div>
    </div>
  </div>

  <?php if (count($dueToday) > 0): ?>
  <!-- Due Today Section -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-warning text-white">
      <h5 class="mb-0"><i class="fa fa-calendar-day"></i> Payments Due Today</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Credit ID</th>
            <th>Client Name</th>
            <th>Phone</th>
            <th>Total Amount</th>
            <th>Balance</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dueToday as $item): ?>
          <tr>
            <td>#<?= $item['credit_id'] ?></td>
            <td><?= htmlspecialchars($item['client_name']) ?></td>
            <td>
              <a href="tel:<?= htmlspecialchars($item['client_phone']) ?>" class="text-decoration-none">
                <i class="fa fa-phone"></i> <?= htmlspecialchars($item['client_phone']) ?>
              </a>
            </td>
            <td><?= number_format($item['total_price'], 2) ?></td>
            <td><strong class="text-warning"><?= number_format($item['balance'], 2) ?></strong></td>
            <td><?= htmlspecialchars($item['due_date']) ?></td>
            <td><span class="badge bg-warning"><?= htmlspecialchars($item['status']) ?></span></td>
            <td>
              <a href="?r=notification/generate&credit_id=<?= $item['credit_id'] ?>" class="btn btn-sm btn-primary" title="Generate Notification">
                <i class="fa fa-envelope"></i> Notify
              </a>
              <a href="?r=credit/historyApi&phone=<?= urlencode($item['client_phone']) ?>" class="btn btn-sm btn-info" target="_blank" title="View Client History">
                <i class="fa fa-history"></i> History
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <?php if (count($overdue) > 0): ?>
  <!-- Overdue Section -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-danger text-white">
      <h5 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Overdue Payments</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Credit ID</th>
            <th>Client Name</th>
            <th>Phone</th>
            <th>TIN</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Due Date</th>
            <th>Days Overdue</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($overdue as $item): ?>
          <tr class="<?= $item['days_overdue'] > 7 ? 'table-danger' : '' ?>">
            <td>#<?= $item['credit_id'] ?></td>
            <td><?= htmlspecialchars($item['client_name']) ?></td>
            <td>
              <a href="tel:<?= htmlspecialchars($item['client_phone']) ?>" class="text-decoration-none">
                <i class="fa fa-phone"></i> <?= htmlspecialchars($item['client_phone']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($item['tin_number'] ?? 'N/A') ?></td>
            <td><?= number_format($item['total_price'], 2) ?></td>
            <td><?= number_format($item['amount_paid'], 2) ?></td>
            <td><strong class="text-danger"><?= number_format($item['balance'], 2) ?></strong></td>
            <td><?= htmlspecialchars($item['due_date']) ?></td>
            <td><span class="badge bg-danger"><?= $item['days_overdue'] ?> days</span></td>
            <td><span class="badge bg-danger"><?= htmlspecialchars($item['status']) ?></span></td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="?r=notification/generate&credit_id=<?= $item['credit_id'] ?>" class="btn btn-primary" title="Generate Notification">
                  <i class="fa fa-envelope"></i>
                </a>
                <a href="?r=credit/historyApi&phone=<?= urlencode($item['client_phone']) ?>" class="btn btn-info" target="_blank" title="View History">
                  <i class="fa fa-history"></i>
                </a>
                <a href="?r=payment/create&credit_id=<?= $item['credit_id'] ?>" class="btn btn-success" title="Record Payment">
                  <i class="fa fa-money-bill"></i>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <?php if (count($dueToday) == 0 && count($overdue) == 0): ?>
  <div class="alert alert-success text-center">
    <h4><i class="fa fa-check-circle"></i> All Clear!</h4>
    <p class="mb-0">No payments due or overdue at this time.</p>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
