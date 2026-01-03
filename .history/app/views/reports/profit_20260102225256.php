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

/* Formula Breakdown Styles */
.formula-breakdown {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid #e5e7eb;
}

.formula-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  min-width: 140px;
}

.formula-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.formula-value {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
}

.formula-label {
  font-size: 0.75rem;
  color: #6b7280;
  text-align: center;
}

.formula-operator {
  display: flex;
  align-items: center;
  padding: 0 10px;
}

.formula-result .formula-icon {
  width: 60px;
  height: 60px;
  border: 3px solid #8b5cf6;
}

.formula-result .formula-value {
  font-size: 1.25rem;
}

.formula-result .formula-label {
  font-size: 0.875rem;
}

/* Dark Mode Support for Formula */
body.dark-mode .formula-breakdown {
  background: linear-gradient(135deg, #1a1d23 0%, #23272b 100%) !important;
  border: 2px solid #4a5568 !important;
}

body.dark-mode .formula-value {
  color: #e5e7eb !important;
}

body.dark-mode .formula-label {
  color: #9ca3af !important;
}

body.dark-mode .formula-result .formula-label {
  color: #e5e7eb !important;
}

/* Overdue Credits Dark Mode */
body.dark-mode .card[style*="fef3c7"] {
  background: linear-gradient(135deg, #422006 0%, #713f12 100%) !important;
  border: 2px solid #f59e0b !important;
}

body.dark-mode .card[style*="fef3c7"] h5,
body.dark-mode .card[style*="fef3c7"] small,
body.dark-mode .card[style*="fef3c7"] th,
body.dark-mode .card[style*="fef3c7"] td,
body.dark-mode .card[style*="fef3c7"] strong {
  color: #fde68a !important;
}

body.dark-mode .card[style*="fef3c7"] .h3 {
  color: #fbbf24 !important;
}

body.dark-mode .card[style*="fef3c7"] tr[style*="rgba(255, 255, 255"] {
  background: rgba(0, 0, 0, 0.3) !important;
}

body.dark-mode .card[style*="fef3c7"] thead tr {
  background: rgba(245, 158, 11, 0.3) !important;
}

body.dark-mode .card[style*="fef3c7"] tfoot tr {
  background: rgba(245, 158, 11, 0.4) !important;
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

  <!-- Capital Input and Month Selector -->
  <div class="row g-3 mb-4">
    <!-- Total Capital Input -->
    <div class="col-md-6">
      <div class="card month-selector-card border-0 h-100">
        <div class="card-body p-4">
          <form method="post" class="d-flex align-items-center gap-3 flex-wrap">
            <input type="hidden" name="month" value="<?= htmlspecialchars($month ?? date('Y-m')) ?>">
            <label class="form-label mb-0 fw-bold">
              <i class="fa fa-wallet text-success"></i> Total Capital You Have:
            </label>
            <div class="input-group" style="max-width: 300px;">
              <span class="input-group-text">RWF</span>
              <input 
                type="number" 
                name="total_capital" 
                class="form-control" 
                step="0.01"
                min="0"
                placeholder="Enter your total capital"
                value="<?= htmlspecialchars($totalCapitalInput ?? '') ?>"
                required
              >
            </div>
            <button type="submit" class="btn btn-success">
              <i class="fa fa-save"></i> Save Capital
            </button>
          </form>
          <?php if ($totalCapitalInput > 0): ?>
          <div class="mt-2">
            <small class="text-muted">
              <i class="fa fa-check-circle text-success"></i> 
              Current capital set to: <strong>RWF <?= number_format($totalCapitalInput, 2) ?></strong>
            </small>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Month Selector -->
    <div class="col-md-6">
      <div class="card month-selector-card border-0 h-100">
        <div class="card-body p-4">
          <form method="get" action="" class="d-flex align-items-center gap-3 flex-wrap">
            <input type="hidden" name="r" value="report/profit">
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

  <!-- Row 5: Actual Money You Have (Based on Capital Input) -->
  <?php if ($totalCapitalInput > 0): ?>
  <div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card stat-card-profit border-0" style="border: 3px solid #8b5cf6 !important;">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width: 70px; height: 70px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa fa-money-check-alt fa-2x text-white"></i>
            </div>
            <div class="flex-grow-1">
              <h4 class="card-title mb-1 fw-bold" style="color: #8b5cf6;">💰 Actual Money You Have Now</h4>
              <small class="text-muted">Your Capital + Sales - Money Used (Expenses + Purchases)</small>
            </div>
          </div>
          <div class="display-3 fw-bold mb-3" style="color: <?=$actualMoneyRemaining >= 0 ? '#8b5cf6' : '#ef4444'?>;">RWF <?=number_format($actualMoneyRemaining,2)?></div>
          <div class="border-top pt-3">
            <div class="row">
              <div class="col-md-3">
                <div class="d-flex flex-column">
                  <span class="text-muted small"><i class="fa fa-wallet"></i> Starting Capital:</span>
                  <strong class="text-primary">RWF <?=number_format($totalCapitalInput,2)?></strong>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex flex-column">
                  <span class="text-muted small"><i class="fa fa-plus-circle text-success"></i> Sales Added:</span>
                  <strong class="text-success">+ RWF <?=number_format($totalSalesMonth,2)?></strong>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex flex-column">
                  <span class="text-muted small"><i class="fa fa-minus-circle text-danger"></i> Money Used:</span>
                  <strong class="text-danger">- RWF <?=number_format($totalMoneyUsed,2)?></strong>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex flex-column">
                  <span class="text-muted small"><i class="fa fa-equals"></i> Final Amount:</span>
                  <strong style="color: <?=$actualMoneyRemaining >= 0 ? '#8b5cf6' : '#ef4444'?>;">RWF <?=number_format($actualMoneyRemaining,2)?></strong>
                </div>
              </div>
            </div>
          </div>
          <div class="formula-breakdown mt-4 p-4 rounded-3">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
              <div class="formula-item">
                <div class="formula-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                  <i class="fa fa-wallet"></i>
                </div>
                <div class="formula-value">RWF <?=number_format($totalCapitalInput,2)?></div>
                <div class="formula-label">Starting Capital</div>
              </div>
              
              <div class="formula-operator">
                <i class="fa fa-plus-circle text-success fa-2x"></i>
              </div>
              
              <div class="formula-item">
                <div class="formula-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                  <i class="fa fa-cash-register"></i>
                </div>
                <div class="formula-value">RWF <?=number_format($totalSalesMonth,2)?></div>
                <div class="formula-label">Sales Revenue</div>
              </div>
              
              <div class="formula-operator">
                <i class="fa fa-minus-circle text-danger fa-2x"></i>
              </div>
              
              <div class="formula-item">
                <div class="formula-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                  <i class="fa fa-calculator"></i>
                </div>
                <div class="formula-value">RWF <?=number_format($totalMoneyUsed,2)?></div>
                <div class="formula-label">Money Used</div>
              </div>
              
              <div class="formula-operator">
                <i class="fa fa-equals fa-2x" style="color: #8b5cf6;"></i>
              </div>
              
              <div class="formula-item formula-result">
                <div class="formula-icon" style="background: linear-gradient(135deg, <?=$actualMoneyRemaining >= 0 ? '#8b5cf6, #7c3aed' : '#ef4444, #dc2626'?>);">
                  <i class="fa fa-money-check-alt"></i>
                </div>
                <div class="formula-value fw-bold" style="color: <?=$actualMoneyRemaining >= 0 ? '#8b5cf6' : '#ef4444'?>;">RWF <?=number_format($actualMoneyRemaining,2)?></div>
                <div class="formula-label fw-bold">Your Actual Money</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Overdue Credits Section -->
  <div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card border-0" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-exclamation-triangle fa-2x text-white"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-1" style="color: #92400e;">⚠️ Overdue Credits Alert</h5>
                <small style="color: #78350f;">Clients who have passed their payment due date</small>
              </div>
            </div>
            <div class="text-end">
              <div class="h3 fw-bold mb-0" style="color: #f59e0b;"><?= $overdueCount ?></div>
              <small style="color: #92400e;">Overdue Credits</small>
            </div>
          </div>
          
          <?php if (!empty($overdueCredits)): ?>
          <div class="table-responsive">
            <table class="table table-sm mb-0">
              <thead>
                <tr style="background: rgba(245, 158, 11, 0.2);">
                  <th style="color: #78350f;">#</th>
                  <th style="color: #78350f;">Client Name</th>
                  <th style="color: #78350f;">Phone</th>
                  <th style="color: #78350f;">Total Amount</th>
                  <th style="color: #78350f;">Paid</th>
                  <th style="color: #78350f;">Balance</th>
                  <th style="color: #78350f;">Due Date</th>
                  <th style="color: #78350f;">Days Overdue</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($overdueCredits as $credit): 
                  $balance = $credit['total_price'] - ($credit['amount_paid'] ?? 0);
                  $daysOverdue = (new DateTime())->diff(new DateTime($credit['due_date']))->days;
                ?>
                <tr style="background: rgba(255, 255, 255, 0.7);">
                  <td style="color: #78350f;"><strong><?= $credit['credit_id'] ?></strong></td>
                  <td style="color: #78350f;"><strong><?= htmlspecialchars($credit['client_name']) ?></strong></td>
                  <td style="color: #78350f;"><small><?= htmlspecialchars($credit['phone']) ?></small></td>
                  <td style="color: #78350f;">RWF <?= number_format($credit['total_price'], 2) ?></td>
                  <td style="color: #10b981;">RWF <?= number_format($credit['amount_paid'] ?? 0, 2) ?></td>
                  <td style="color: #ef4444;"><strong>RWF <?= number_format($balance, 2) ?></strong></td>
                  <td style="color: #78350f;"><?= date('M d, Y', strtotime($credit['due_date'])) ?></td>
                  <td>
                    <span class="badge" style="background: #dc2626; color: white;">
                      <?= $daysOverdue ?> day<?= $daysOverdue != 1 ? 's' : '' ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr style="background: rgba(245, 158, 11, 0.3); border-top: 2px solid #f59e0b;">
                  <td colspan="5" class="text-end" style="color: #78350f;"><strong>Total Overdue Balance:</strong></td>
                  <td colspan="3" style="color: #dc2626;"><strong class="h5 mb-0">RWF <?= number_format($overdueAmount, 2) ?></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <?php else: ?>
          <div class="alert mb-0" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #047857;">
            <i class="fa fa-check-circle"></i> <strong>Great!</strong> No overdue credits at the moment.
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
