<style>
  /* Stat Card Animations */
  .stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border: 2px solid transparent;
    overflow: hidden;
    position: relative;
  }
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }
  .stat-card:hover::before {
    left: 100%;
  }
  .stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
  }
  
  /* Info Panel */
  .card-info-panel {
    position: absolute;
    bottom: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 260px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;
    pointer-events: none;
  }
  .stat-card:hover .card-info-panel {
    bottom: -190px;
    opacity: 1;
    pointer-events: auto;
  }
  .card-info-panel:hover {
    bottom: -190px;
    opacity: 1;
    transform: translateX(-50%) scale(1);
  }
  .info-panel-header {
    font-weight: bold;
    font-size: 0.95rem;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 2px solid rgba(255,255,255,0.3);
  }
  .info-panel-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 8px;
    margin: 3px 0;
    background: rgba(255,255,255,0.1);
    border-radius: 6px;
    font-size: 0.85rem;
    transition: background 0.2s;
  }
  .info-panel-item:hover {
    background: rgba(255,255,255,0.2);
  }
  .info-panel-footer {
    margin-top: 8px;
    padding-top: 6px;
    border-top: 1px solid rgba(255,255,255,0.2);
    font-size: 0.8rem;
    text-align: center;
    opacity: 0.9;
  }
  
  /* Real-time update indicator */
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }
  .live-indicator {
    animation: pulse 2s infinite;
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #4caf50;
    border-radius: 50%;
    margin-right: 5px;
  }
</style>

<div class="mb-4">
  <h2 class="fw-bold mb-2">
    <i class="fa fa-tachometer-alt text-primary"></i> Welcome, <span class="text-success"><?=htmlspecialchars($_SESSION['user']['full_name'] ?? 'Manager')?></span>!
    <small class="text-muted fs-6 d-block mt-1">
      <span class="live-indicator"></span>
      <span id="lastUpdated">Last updated: <?=date('M d, Y h:i A')?></span>
    </small>
  </h2>
  <p class="lead">Here's a quick overview of your shop's performance and actions.</p>
</div>

<?php if (!empty($showOverdueAlert)): ?>
  <div class="alert alert-danger shadow-sm"><b><i class="fa fa-exclamation-triangle"></i> Attention:</b> There are <?= (int)$overdueCount ?> overdue credits! Please review and take action.</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-money-bill-wave fa-2x text-danger"></i></div>
        <h5 class="card-title">Today's Expenses</h5>
        <div class="display-6 fw-bold text-danger">RWF <?= number_format($summary['todayExpenses'],2) ?></div>
        <small class="text-muted">Money taken from business</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-money-bill-wave"></i> Expenses Today
          </div>
          <div class="info-panel-item">
            <span>💸 Amount:</span>
            <strong>RWF <?= number_format($summary['todayExpenses'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Type:</span>
            <strong>Daily Expenses</strong>
          </div>
          <div class="info-panel-footer">
            💡 Track business costs
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-shopping-cart fa-2x text-primary"></i></div>
        <h5 class="card-title">Today's Purchases</h5>
        <div class="display-6 fw-bold text-primary">RWF <?= number_format($summary['todayPurchases'],2) ?></div>
        <small class="text-muted">Money spent to buy items</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-shopping-cart"></i> Purchases Today
          </div>
          <div class="info-panel-item">
            <span>🛒 Amount:</span>
            <strong>RWF <?= number_format($summary['todayPurchases'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-item">
            <span>📦 Type:</span>
            <strong>Inventory Buys</strong>
          </div>
          <div class="info-panel-footer">
            💡 Stock investment
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-credit-card fa-2x text-success"></i></div>
        <h5 class="card-title">Today's Credit Sales</h5>
        <div class="display-6 fw-bold text-success">RWF <?= number_format($summary['todayCreditSales'],2) ?></div>
        <small class="text-muted"><?= (int)$summary['todayCreditCount'] ?> credit sale(s)</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-credit-card"></i> Credits Today
          </div>
          <div class="info-panel-item">
            <span>💰 Amount:</span>
            <strong>RWF <?= number_format($summary['todayCreditSales'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Count:</span>
            <strong><?= (int)$summary['todayCreditCount'] ?> sales</strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-footer">
            💡 Sales on credit
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
        <h5 class="card-title">Active Credits</h5>
        <div class="display-6 fw-bold text-warning"><?= (int)$summary['activeCredits'] ?></div>
        <small class="text-muted"><?= (int)$summary['totalClients'] ?> total clients</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-clock"></i> Active Credits
          </div>
          <div class="info-panel-item">
            <span>⏰ Active:</span>
            <strong><?= (int)$summary['activeCredits'] ?> credits</strong>
          </div>
          <div class="info-panel-item">
            <span>👥 Clients:</span>
            <strong><?= (int)$summary['totalClients'] ?> total</strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Status:</span>
            <strong>Pending Payment</strong>
          </div>
          <div class="info-panel-footer">
            💡 Outstanding credits
          </div>
        </div>
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

<!-- Charts & Trends -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0"><i class="fa fa-chart-bar text-primary"></i> Sales & Purchases Trend (Last 7 Days)</h5>
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary active" onclick="updateChartView('both')">Both</button>
            <button type="button" class="btn btn-outline-success" onclick="updateChartView('sales')">Sales</button>
            <button type="button" class="btn btn-outline-info" onclick="updateChartView('purchases')">Purchases</button>
          </div>
        </div>
        
        <!-- Chart Container -->
        <div style="position: relative; height: 300px;">
          <canvas id="trendChart"></canvas>
        </div>
        
        <!-- Legend & Stats -->
        <div class="row mt-3 text-center">
          <div class="col-6">
            <div class="p-2 bg-success bg-opacity-10 rounded">
              <i class="fa fa-arrow-up text-success"></i>
              <strong class="text-success">Total Sales:</strong>
              <span id="totalSales">RWF <?=number_format(array_sum(array_column($trendData, 'sales')), 2)?></span>
            </div>
          </div>
          <div class="col-6">
            <div class="p-2 bg-primary bg-opacity-10 rounded">
              <i class="fa fa-shopping-cart text-primary"></i>
              <strong class="text-primary">Total Purchases:</strong>
              <span id="totalPurchases">RWF <?=number_format(array_sum(array_column($trendData, 'purchases')), 2)?></span>
            </div>
          </div>
        </div>
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

<script>
// Auto-refresh timestamp every minute
setInterval(() => {
  const now = new Date();
  const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
  document.getElementById('lastUpdated').innerHTML = '<span class="live-indicator"></span>Last updated: ' + now.toLocaleDateString('en-US', options);
}, 60000);
</script>
