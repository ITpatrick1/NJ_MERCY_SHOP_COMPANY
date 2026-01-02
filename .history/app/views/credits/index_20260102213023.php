<style>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes shimmer {
  0% { background-position: -1000px 0; }
  100% { background-position: 1000px 0; }
}

.stats-card-credit {
  animation: fadeInUp 0.5s ease-out;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  border-radius: 16px;
  overflow: hidden;
  position: relative;
}

.stats-card-credit::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  animation: shimmer 3s infinite;
}

.stats-card-credit:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(245, 158, 11, 0.4);
}

.stats-card-credit.danger {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.stats-card-credit.danger:hover {
  box-shadow: 0 12px 24px rgba(239, 68, 68, 0.4);
}

.stats-card-credit.success {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stats-card-credit.success:hover {
  box-shadow: 0 12px 24px rgba(16, 185, 129, 0.4);
}

.stats-card-credit.info {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.stats-card-credit.info:hover {
  box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
}

/* Dark mode stats cards */
body.dark-mode .stats-card-credit {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%) !important;
  box-shadow: 0 8px 24px rgba(146, 64, 14, 0.5) !important;
}

body.dark-mode .stats-card-credit:hover {
  box-shadow: 0 12px 24px rgba(146, 64, 14, 0.6) !important;
}

body.dark-mode .stats-card-credit.danger {
  background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%) !important;
  box-shadow: 0 8px 24px rgba(127, 29, 29, 0.5) !important;
}

body.dark-mode .stats-card-credit.danger:hover {
  box-shadow: 0 12px 24px rgba(127, 29, 29, 0.6) !important;
}

body.dark-mode .stats-card-credit.success {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%) !important;
  box-shadow: 0 8px 24px rgba(6, 78, 59, 0.5) !important;
}

body.dark-mode .stats-card-credit.success:hover {
  box-shadow: 0 12px 24px rgba(6, 78, 59, 0.6) !important;
}

body.dark-mode .stats-card-credit.info {
  background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
  box-shadow: 0 8px 24px rgba(30, 58, 138, 0.5) !important;
}

body.dark-mode .stats-card-credit.info:hover {
  box-shadow: 0 12px 24px rgba(30, 58, 138, 0.6) !important;
}

.page-header-credit {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
}

body.dark-mode .page-header-credit {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%) !important;
}

.search-card-credit {
  border-radius: 16px;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.search-card-credit:hover {
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

body.dark-mode .search-card-credit {
  background: #1a1d23;
  color: #e0e0e0;
}

body.dark-mode .card {
  background: #1a1d23;
  color: #e0e0e0;
}

body.dark-mode .table {
  color: #e0e0e0;
}

body.dark-mode .table-light {
  background: #2a2f38;
  color: #e0e0e0;
}

body.dark-mode .table-bordered {
  border-color: #4a5568;
}

body.dark-mode .table-bordered td,
body.dark-mode .table-bordered th {
  border-color: #4a5568;
}

body.dark-mode .form-control {
  background: #23272b;
  color: #e0e0e0;
  border-color: #4a5568;
}

.credit-row {
  transition: all 0.2s ease;
}

.credit-row:hover {
  background: rgba(245, 158, 11, 0.05);
  transform: scale(1.005);
}

body.dark-mode .credit-row:hover {
  background: rgba(245, 158, 11, 0.1);
}

.status-badge {
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  font-weight: 600;
  font-size: 0.875rem;
  display: inline-block;
}

.status-pending {
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  color: #92400e;
}

.status-overdue {
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  color: #7f1d1d;
  animation: pulse 2s infinite;
}

.status-settled {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  color: #064e3b;
}

body.dark-mode .status-pending {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%);
  color: white;
}

body.dark-mode .status-overdue {
  background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
  color: white;
}

body.dark-mode .status-settled {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
  color: white;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

.action-btn-credit {
  border-radius: 8px;
  padding: 0.5rem 1rem;
  transition: all 0.3s ease;
}

.action-btn-credit:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.search-input-credit {
  border-radius: 12px;
  border: 2px solid #e5e7eb;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.search-input-credit:focus {
  border-color: #f59e0b;
  box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
}

body.dark-mode .search-input-credit {
  background: #23272b;
  border-color: #4a5568;
  color: #e0e0e0;
}

body.dark-mode .search-input-credit:focus {
  border-color: #f59e0b;
  box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
}

.report-btn {
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.report-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.client-avatar-credit {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.1rem;
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
}

body.dark-mode .client-avatar-credit {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%);
}
</style>

<div class="container my-4">
  <!-- Professional Page Header -->
  <div class="page-header-credit">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="fw-bold mb-2">
          <i class="fa fa-credit-card"></i> Credit Sales Management
        </h2>
        <p class="mb-0 opacity-75">
          <i class="fa fa-info-circle"></i> Track and manage all credit sales and payments
        </p>
      </div>
      <a class="btn btn-light btn-lg shadow" href="?r=credit/create">
        <i class="fa fa-plus"></i> New Credit Sale
      </a>
    </div>
  </div>

  <?php
  // Calculate statistics
  $totalCredits = count($credits);
  $overdueCount = 0;
  $settledCount = 0;
  $pendingCount = 0;
  $totalAmount = 0;
  $totalPaid = 0;
  $totalBalance = 0;
  
  foreach($credits as $cr) {
    $totalAmount += $cr['total_price'];
    $totalPaid += $cr['paid'] ?? 0;
    $balance = $cr['total_price'] - ($cr['paid'] ?? 0);
    $totalBalance += $balance;
    
    $status = strtolower($cr['status']);
    if ($status === 'overdue') {
      $overdueCount++;
    } elseif ($status === 'settled' || $status === 'paid') {
      $settledCount++;
    } else {
      $pendingCount++;
    }
  }
  ?>

  <!-- Enhanced Statistics Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-credit shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-credit-card fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Total Credits</h6>
          <div class="display-5 fw-bold"><?= $totalCredits ?></div>
          <small class="opacity-75">Active Sales</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-credit danger shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-exclamation-triangle fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Overdue</h6>
          <div class="display-5 fw-bold"><?= $overdueCount ?></div>
          <small class="opacity-75">Requires Attention</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-credit success shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-check-circle fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Settled</h6>
          <div class="display-5 fw-bold"><?= $settledCount ?></div>
          <small class="opacity-75">Fully Paid</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-credit info shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-money-bill-wave fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Total Balance</h6>
          <div class="display-5 fw-bold"><?= number_format($totalBalance, 0) ?></div>
          <small class="opacity-75">ETB Outstanding</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions & Search -->
  <div class="card search-card-credit p-4 mb-4">
    <h5 class="mb-3">
      <i class="fa fa-search text-warning"></i> Search & Filter
    </h5>
    <div class="row g-3 align-items-end mb-3">
      <div class="col-md-8">
        <form method="get" action="">
          <input type="hidden" name="r" value="credit/index">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fa fa-search text-muted"></i>
            </span>
            <input type="text" 
                   name="search" 
                   class="form-control border-start-0 search-input-credit" 
                   placeholder="Search by client name, phone number, or status..."
                   style="border-left: none;">
            <button class="btn btn-warning text-white" type="submit">
              <i class="fa fa-search"></i> Search
            </button>
          </div>
        </form>
      </div>
      <div class="col-md-4">
        <div class="d-flex gap-2 flex-wrap">
          <a href="?r=report/creditSales" class="btn btn-info report-btn flex-fill">
            <i class="fa fa-file-alt"></i> Credit Report
          </a>
          <a href="?r=report/overdueCredits" class="btn btn-danger report-btn flex-fill">
            <i class="fa fa-exclamation-triangle"></i> Overdue
          </a>
        </div>
      </div>
    </div>
    <div>
      <small class="text-muted" style="text-color: white " >
        <i class="fa fa-info-circle" style="text-color: white  ></i> 
        Showing <strong><?= $totalCredits ?></strong> credit sales | 
        <strong class="text-danger"><?= $overdueCount ?></strong> overdue | 
        <strong class="text-success"><?= $settledCount ?></strong> settled
      </small>
    </div>
  </div>

  <!-- Credits Table -->
  <div class="card shadow-lg border-0" style="border-radius: 16px;">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px 16px 0 0;">
      <h5 class="mb-0">
        <i class="fa fa-table"></i> Credit Sales Records
      </h5>
    </div>
    <div class="card-body p-0">
      <?php if (empty($credits)): ?>
        <div class="text-center py-5">
          <i class="fa fa-credit-card fa-3x mb-3" style="opacity: 0.3;"></i>
          <p class="text-muted mb-0">No credit sales found.</p>
          <small>Start by <a href="?r=credit/create">creating your first credit sale</a></small>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="padding: 1rem;"><i class="fa fa-hashtag"></i> ID</th>
                <th><i class="fa fa-user"></i> Client</th>
                <th><i class="fa fa-phone"></i> Phone</th>
                <th><i class="fa fa-dollar-sign"></i> Total Price</th>
                <th><i class="fa fa-check-circle"></i> Paid</th>
                <th><i class="fa fa-wallet"></i> Balance</th>
                <th><i class="fa fa-calendar-alt"></i> Due Date</th>
                <th><i class="fa fa-info-circle"></i> Status</th>
                <th class="text-center"><i class="fa fa-cog"></i> Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($credits as $cr): ?>
              <?php 
                $paid = $cr['paid'] ?? 0;
                $balance = $cr['total_price'] - $paid;
                $status = strtolower($cr['status']);
                $statusClass = 'status-pending';
                if ($status === 'overdue') $statusClass = 'status-overdue';
                elseif ($status === 'settled' || $status === 'paid') $statusClass = 'status-settled';
              ?>
              <tr class="credit-row">
                <td style="padding: 1rem;">
                  <span class="badge bg-warning text-dark">#<?= $cr['credit_id'] ?></span>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="client-avatar-credit">
                      <?= strtoupper(substr($cr['client_name'] ?? $cr['name'] ?? 'C', 0, 1)) ?>
                    </div>
                    <strong><?= htmlspecialchars($cr['client_name'] ?? $cr['name'] ?? 'N/A') ?></strong>
                  </div>
                </td>
                <td>
                  <i class="fa fa-phone text-success"></i>
                  <?= htmlspecialchars($cr['phone']) ?>
                </td>
                <td>
                  <strong><?= number_format($cr['total_price'], 2) ?> ETB</strong>
                </td>
                <td>
                  <span class="text-success fw-600"><?= number_format($paid, 2) ?> ETB</span>
                </td>
                <td>
                  <?php if ($balance > 0): ?>
                    <span class="text-danger fw-bold"><?= number_format($balance, 2) ?> ETB</span>
                  <?php else: ?>
                    <span class="text-success">0.00 ETB</span>
                  <?php endif; ?>
                </td>
                <td>
                  <i class="fa fa-calendar text-warning"></i>
                  <?= htmlspecialchars($cr['due_date']) ?>
                </td>
                <td>
                  <span class="status-badge <?= $statusClass ?>">
                    <?php if ($status === 'overdue'): ?>
                      <i class="fa fa-exclamation-triangle"></i>
                    <?php elseif ($status === 'settled' || $status === 'paid'): ?>
                      <i class="fa fa-check-circle"></i>
                    <?php else: ?>
                      <i class="fa fa-clock"></i>
                    <?php endif; ?>
                    <?= ucfirst($cr['status']) ?>
                  </span>
                </td>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <a href="?r=credit/view&id=<?= $cr['credit_id'] ?>" 
                       class="btn btn-sm btn-info action-btn-credit" 
                       title="View Details">
                      <i class="fa fa-eye"></i> View
                    </a>
                    <a href="?r=credit/edit&id=<?= $cr['credit_id'] ?>" 
                       class="btn btn-sm btn-success action-btn-credit" 
                       title="Edit Credit">
                      <i class="fa fa-edit"></i> Edit
                    </a>
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

<script>
// Add animation on load
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.stats-card-credit');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
  });
});
</script>
