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

.page-header-profit {
  background: #ffffff;
  color: #1f2937;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  border: 2px solid #8b5cf6;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.page-header-profit h2 {
  color: #8b5cf6;
  font-size: 2rem;
  font-weight: 700;
}

.page-header-profit p {
  color: #6b7280;
}

.page-header-profit .header-icon {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  color: white;
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.btn-back-dashboard {
  background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
  color: white;
  border: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-back-dashboard:hover {
  background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

body.dark-mode .page-header-profit {
  background: #23272b !important;
  color: #ffffff !important;
  border: 2px solid #4c1d95;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-mode .page-header-profit h2 {
  color: #a78bfa !important;
}

body.dark-mode .page-header-profit p {
  color: #9ca3af !important;
}

body.dark-mode .page-header-profit .header-icon {
  background: linear-gradient(135deg, #4c1d95 0%, #5b21b6 100%);
}

body.dark-mode .btn-back-dashboard {
  background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
}

body.dark-mode .btn-back-dashboard:hover {
  background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
  box-shadow: 0 4px 12px rgba(75, 85, 99, 0.5);
}

.stat-card-profit {
  animation: fadeInUp 0.5s ease-out;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: #ffffff;
  color: #1f2937;
  border-radius: 16px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  position: relative;
}

.stat-card-profit:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

body.dark-mode .stat-card-profit {
  background: #23272b !important;
  color: #ffffff !important;
  border: 1px solid #4a5568;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-mode .stat-card-profit:hover {
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
}

.month-selector-card {
  background: #ffffff;
  border-radius: 16px;
  border: 2px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.month-selector-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

body.dark-mode .month-selector-card {
  background: #23272b !important;
  border: 2px solid #4a5568;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.info-card-profit {
  background: #f3f4f6;
  border-radius: 16px;
  border: 2px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

body.dark-mode .info-card-profit {
  background: #1a1d23 !important;
  color: #e0e0e0 !important;
  border: 2px solid #4a5568;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.live-indicator {
  animation: pulse 2s infinite;
  display: inline-block;
  width: 8px;
  height: 8px;
  background: #10b981;
  border-radius: 50%;
  margin-right: 5px;
}
</style>

<div class="container my-4">
  <!-- Professional Page Header -->
  <div class="page-header-profit">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div class="d-flex align-items-center">
        <div class="header-icon">
          <i class="fa fa-chart-line fa-lg"></i>
        </div>
        <div>
          <h2 class="fw-bold mb-1">
            Financial Report
          </h2>
          <p class="mb-0">
            <i class="fa fa-info-circle"></i> Track your expenses and purchases by month
            <span class="ms-3">
              <span class="live-indicator"></span>
              <small id="lastUpdated">Last updated: <?=date('M d, Y h:i A')?></small>
            </span>
          </p>
        </div>
      </div>
      <a class="btn btn-back-dashboard btn-lg" href="?r=dashboard/index">
        <i class="fa fa-arrow-left"></i> Back to Dashboard
      </a>
    </div>
  </div>

  <!-- Month Selector -->
  <div class="card month-selector-card border-0 mb-4">
    <div class="card-body p-4">
      <form method="get" action="?r=report/profit" class="d-flex align-items-center gap-3 flex-wrap">
        <label class="form-label mb-0 fw-bold">
          <i class="fa fa-calendar-alt text-primary"></i> Select Month:
        </label>
        <input 
          type="month" 
          name="month" 
          class="form-control" 
          style="max-width: 200px;"
          value="<?= htmlspecialchars($month ?? date('Y-m')) ?>"
          onchange="this.form.submit()"
        >
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-search"></i> View Report
        </button>
      </form>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-4 mb-4">
    <!-- Row 1: Expenses and Purchases -->
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-money-bill-wave fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Total Expenses</h5>
              <small class="text-muted">Money taken from business</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-danger mb-3">RWF <?=number_format($expensesTotal,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-calendar"></i> Period:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-tag"></i> Category:</span>
              <strong>Business Expenses</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-shopping-cart fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Total Purchases</h5>
              <small class="text-muted">Money spent to buy items</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-primary mb-3">RWF <?=number_format($purchasesTotal,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-calendar"></i> Period:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-tag"></i> Category:</span>
              <strong>Inventory Purchases</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 2: Total Capital and Sales -->
  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-piggy-bank fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Total Capital Invested</h5>
              <small class="text-muted">All-time money invested</small>
            </div>
          </div>
          <div class="display-6 fw-bold text-purple mb-3" style="color: #8b5cf6;">RWF <?=number_format($totalCapitalInvested,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-info-circle"></i> Type:</span>
              <strong>Total Inventory Investment</strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-chart-line"></i> Status:</span>
              <strong>Cumulative</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-cash-register fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Total Sales Revenue</h5>
              <small class="text-muted">Sales for this month</small>
            </div>
          </div>
          <div class="display-6 fw-bold text-success mb-3">RWF <?=number_format($totalSalesMonth,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-calendar"></i> Period:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-tag"></i> Includes:</span>
              <strong>Cash + Credit Payments</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 3: Yesterday's Sales and Total Money Used -->
  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-calendar-day fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Yesterday's Sales</h5>
              <small class="text-muted"><?=date('M d, Y', strtotime('-1 day'))?></small>
            </div>
          </div>
          <div class="display-6 fw-bold" style="color: #f59e0b;">RWF <?=number_format($yesterdayTotal,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-clock"></i> Date:</span>
              <strong><?=date('l, F d', strtotime('-1 day'))?></strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-tag"></i> Type:</span>
              <strong>Daily Revenue</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card stat-card-profit border-0 h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-calculator fa-2x text-white"></i>
            </div>
            <div>
              <h5 class="card-title mb-1 fw-bold">Total Money Used</h5>
              <small class="text-muted">Expenses + Purchases</small>
            </div>
          </div>
          <div class="display-6 fw-bold text-secondary mb-3">RWF <?=number_format($totalMoneyUsed,2)?></div>
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted"><i class="fa fa-calendar"></i> Period:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted"><i class="fa fa-info-circle"></i> Total:</span>
              <strong>RWF <?=number_format($expensesTotal + $purchasesTotal,2)?></strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 4: Available Money (Profit/Loss) -->
  <div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card stat-card-profit border-0">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 70px; height: 70px; background: linear-gradient(135deg, <?=$availableMoney >= 0 ? '#10b981, #059669' : '#ef4444, #dc2626'?>); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa <?=$availableMoney >= 0 ? 'fa-chart-line' : 'fa-exclamation-triangle'?> fa-2x text-white"></i>
            </div>
            <div class="flex-grow-1">
              <h4 class="card-title mb-1 fw-bold">Available Money (Profit/Loss)</h4>
              <small class="text-muted">Sales Revenue - Total Money Used for <?=date('F Y', strtotime($month ?? date('Y-m')))?></small>
            </div>
          </div>
          <div class="display-4 fw-bold mb-3" style="color: <?=$availableMoney >= 0 ? '#10b981' : '#ef4444'?>;">RWF <?=number_format($availableMoney,2)?></div>
          <div class="border-top pt-3">
            <div class="row">
              <div class="col-md-4">
                <div class="d-flex justify-content-between">
                  <span class="text-muted"><i class="fa fa-plus-circle text-success"></i> Sales:</span>
                  <strong class="text-success">RWF <?=number_format($totalSalesMonth,2)?></strong>
                </div>
              </div>
              <div class="col-md-4">
                <div class="d-flex justify-content-between">
                  <span class="text-muted"><i class="fa fa-minus-circle text-danger"></i> Used:</span>
                  <strong class="text-danger">RWF <?=number_format($totalMoneyUsed,2)?></strong>
                </div>
              </div>
              <div class="col-md-4">
                <div class="d-flex justify-content-between">
                  <span class="text-muted"><i class="fa fa-equals"></i> Result:</span>
                  <strong style="color: <?=$availableMoney >= 0 ? '#10b981' : '#ef4444'?>;">
                    <?=$availableMoney >= 0 ? 'Profit' : 'Loss'?>
                  </strong>
                </div>
              </div>
            </div>
          </div>
          <?php if ($availableMoney < 0): ?>
          <div class="alert alert-danger mt-3 mb-0">
            <i class="fa fa-exclamation-triangle"></i> <strong>Warning:</strong> Your expenses and purchases exceed your sales revenue for this month.
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Card -->
  <div class="card info-card-profit border-0">
    <div class="card-body p-4">
      <h6 class="fw-bold mb-3">
        <i class="fa fa-info-circle text-info"></i> About This Report
      </h6>
      <div class="row">
        <div class="col-md-6">
          <p class="text-muted mb-3">
            <strong>Monthly Metrics:</strong><br>
            • <strong>Expenses:</strong> Money taken from business<br>
            • <strong>Purchases:</strong> Money spent on inventory<br>
            • <strong>Sales Revenue:</strong> Cash sales + credit payments received<br>
            • <strong>Total Money Used:</strong> Expenses + Purchases<br>
            • <strong>Available Money:</strong> Sales - Money Used (Profit/Loss)
          </p>
        </div>
        <div class="col-md-6">
          <p class="text-muted mb-0">
            <strong>Additional Insights:</strong><br>
            • <strong>Total Capital Invested:</strong> All-time purchases (inventory investment)<br>
            • <strong>Yesterday's Sales:</strong> Revenue from <?=date('M d, Y', strtotime('-1 day'))?><br>
            • Use the month selector above to view different periods<br>
            • Positive Available Money = Profit, Negative = Loss
          </p>
        </div>
      </div>
    </div>
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
