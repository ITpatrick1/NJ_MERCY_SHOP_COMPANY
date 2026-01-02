<div class="mb-4">
  <h2 class="fw-bold mb-2"><i class="fa fa-tachometer-alt text-primary"></i> Welcome, <span class="text-success"><?=htmlspecialchars($_SESSION['user']['full_name'] ?? 'Staff')?></span>!</h2>
  <p class="lead">Here's your daily summary and quick actions.</p>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-credit-card fa-2x text-success"></i></div>
        <h5 class="card-title">Today's Credit Sales</h5>
        <div class="display-6 fw-bold text-success">RWF <?= number_format($summary['todayCreditSales'],2) ?></div>
        <small class="text-muted"><?= (int)$summary['todayCreditCount'] ?> sale(s)</small>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
        <h5 class="card-title">Active Credits</h5>
        <div class="display-6 fw-bold text-warning"><?= (int)$summary['activeCredits'] ?></div>
        <small class="text-muted">Pending payments</small>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-users fa-2x text-info"></i></div>
        <h5 class="card-title">Total Clients</h5>
        <div class="display-6 fw-bold text-info"><?= (int)$summary['totalClients'] ?></div>
        <small class="text-muted">In database</small>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="mb-4">
  <div class="card p-3 shadow-sm border-0">
    <h5 class="text-center mb-3"><i class="fa fa-bolt text-warning"></i> Quick Actions</h5>
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <a href="?r=credit/create" class="btn btn-success"><i class="fa fa-credit-card"></i> New Credit Sale</a>
      <a href="?r=credit/index" class="btn btn-primary"><i class="fa fa-list"></i> View Credits</a>
      <a href="?r=product/index" class="btn btn-secondary"><i class="fa fa-box"></i> View Products</a>
      <a href="?r=client/index" class="btn btn-info"><i class="fa fa-users"></i> View Clients</a>
    </div>
  </div>
</div>

<!-- Charts & Trends (Placeholder) -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="fa fa-chart-bar text-primary"></i> Sales Trend</h5>
        <div class="text-center text-muted">[Chart Placeholder]</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="fa fa-bell text-warning"></i> Notifications</h5>
        <div class="alert alert-success mb-2"><i class="fa fa-check-circle"></i> No urgent notifications.</div>
      </div>
    </div>
  </div>
</div>

<!-- Assigned Sales Table (Placeholder) -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
    <h5 class="card-title mb-3"><i class="fa fa-list text-primary"></i> Assigned Sales</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr><th>ID</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th></tr>
        </thead>
        <tbody>
        <!-- TODO: Populate with assigned sales -->
        <tr><td colspan="5" class="text-center text-muted">No sales assigned.</td></tr>
        </tbody>
      </table>
    </div>
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
