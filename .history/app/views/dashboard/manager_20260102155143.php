<div class="mb-4">
  <h2 class="fw-bold mb-2"><i class="fa fa-tachometer-alt text-primary"></i> Welcome, <span class="text-success"><?=htmlspecialchars($_SESSION['user']['full_name'] ?? 'Manager')?></span>!</h2>
  <p class="lead">Here's a quick overview of your shop's performance and actions.</p>
</div>

<?php if (!empty($showOverdueAlert)): ?>
  <div class="alert alert-danger shadow-sm"><b><i class="fa fa-exclamation-triangle"></i> Attention:</b> There are <?= (int)$overdueCount ?> overdue credits! Please review and take action.</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-money-bill-wave fa-2x text-danger"></i></div>
        <h5 class="card-title">Today's Expenses</h5>
        <div class="display-6 fw-bold text-danger">RWF <?= number_format($summary['todayExpenses'],2) ?></div>
        <small class="text-muted">Money taken from business</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-shopping-cart fa-2x text-primary"></i></div>
        <h5 class="card-title">Today's Purchases</h5>
        <div class="display-6 fw-bold text-primary">RWF <?= number_format($summary['todayPurchases'],2) ?></div>
        <small class="text-muted">Money spent to buy items</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-credit-card fa-2x text-success"></i></div>
        <h5 class="card-title">Today's Credit Sales</h5>
        <div class="display-6 fw-bold text-success">RWF <?= number_format($summary['todayCreditSales'],2) ?></div>
        <small class="text-muted"><?= (int)$summary['todayCreditCount'] ?> credit sale(s)</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
        <h5 class="card-title">Active Credits</h5>
        <div class="display-6 fw-bold text-warning"><?= (int)$summary['activeCredits'] ?></div>
        <small class="text-muted"><?= (int)$summary['totalClients'] ?> total clients</small>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="mb-4">
  <div class="card p-3 shadow-sm border-0">
    <h5 class="text-center mb-3"><i class="fa fa-bolt text-warning"></i> Quick Actions</h5>
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <a href="?r=purchase/create" class="btn btn-primary"><i class="fa fa-cart-plus"></i> New Purchase</a>
      <a href="?r=expense/create" class="btn btn-danger"><i class="fa fa-money-bill-wave"></i> New Expense</a>
      <a href="?r=credit/create" class="btn btn-success"><i class="fa fa-credit-card"></i> New Credit Sale</a>
      <a href="?r=product/create" class="btn btn-secondary"><i class="fa fa-box"></i> New Product</a>
      <a href="?r=report/profit" class="btn btn-dark"><i class="fa fa-chart-line"></i> Financial Report</a>
      <a href="?r=credit/index" class="btn btn-warning"><i class="fa fa-list"></i> View Credits</a>
    </div>
  </div>
</div>

<!-- Charts & Trends (Placeholder) -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="fa fa-chart-bar text-primary"></i> Sales & Purchases Trend</h5>
        <div class="text-center text-muted">[Chart Placeholder]</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="fa fa-bell text-warning"></i> Notifications</h5>
        <?php if (!empty($showOverdueAlert)): ?>
          <div class="alert alert-danger mb-2"><i class="fa fa-exclamation-triangle"></i> <?= (int)$overdueCount ?> overdue credits!</div>
        <?php else: ?>
          <div class="alert alert-success mb-2"><i class="fa fa-check-circle"></i> No urgent notifications.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Overdue Credits Table -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
    <h5 class="card-title mb-3"><i class="fa fa-exclamation-circle text-danger"></i> Overdue Credits</h5>
    <?php if(empty($overdue)): ?>
      <p class="text-success">No overdue credits.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-light">
            <tr><th>ID</th><th>Client</th><th>Phone</th><th>Total</th><th>Due Date</th><th>Status</th><th>Action</th></tr>
          </thead>
          <tbody>
          <?php foreach($overdue as $cr): ?>
            <tr>
              <td><?= $cr['credit_id'] ?></td>
              <td><?=htmlspecialchars($cr['client_name'] ?? $cr['name'] ?? '')?></td>
              <td><?=htmlspecialchars($cr['phone'])?></td>
              <td><?=number_format($cr['total_price'],2)?></td>
              <td><?=htmlspecialchars($cr['due_date'])?></td>
              <td><?=htmlspecialchars($cr['status'])?></td>
              <td>
                <form method="post" action="?r=credit/approve/<?= $cr['credit_id'] ?>" style="display:inline">
                  <input name="remarks" placeholder="remarks">
                  <button class="btn btn-sm btn-success">Approve</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Recent Activity (Placeholder) -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
    <h5 class="card-title mb-3"><i class="fa fa-history text-info"></i> Recent Activity</h5>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">[Recent activity placeholder]</li>
    </ul>
  </div>
</div>
