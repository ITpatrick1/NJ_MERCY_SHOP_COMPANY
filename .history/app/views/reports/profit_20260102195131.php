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
    bottom: -180px;
    left: 50%;
    transform: translateX(-50%);
    width: 280px;
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
    bottom: -170px;
    opacity: 1;
    pointer-events: auto;
  }
  .card-info-panel:hover {
    bottom: -170px;
    opacity: 1;
    transform: translateX(-50%) scale(1);
  }
  .info-panel-header {
    font-weight: bold;
    font-size: 1rem;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 2px solid rgba(255,255,255,0.3);
  }
  .info-panel-item {
    display: flex;
    justify-content: space-between;
    padding: 8px;
    margin: 4px 0;
    background: rgba(255,255,255,0.1);
    border-radius: 6px;
    font-size: 0.9rem;
    transition: background 0.2s;
  }
  .info-panel-item:hover {
    background: rgba(255,255,255,0.2);
  }
  .info-panel-footer {
    margin-top: 10px;
    padding-top: 8px;
    border-top: 1px solid rgba(255,255,255,0.2);
    font-size: 0.85rem;
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

<div class="container mt-4">
  <div class="mb-4">
    <h2 class="fw-bold">
      <i class="fa fa-chart-line text-success"></i> Financial Report
      <small class="text-muted fs-6">
        <span class="live-indicator"></span>
        <span id="lastUpdated">Last updated: <?=date('M d, Y h:i A')?></span>
      </small>
    </h2>
    <p class="text-muted">Track your expenses and purchases by month</p>
  </div>

  <!-- Month Selector -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <form method="get" action="?r=report/profit" class="d-flex align-items-center gap-2">
        <label class="form-label mb-0 fw-bold">Select Month:</label>
        <input 
          type="month" 
          name="month" 
          class="form-control" 
          style="max-width: 200px;"
          value="<?= htmlspecialchars($month ?? date('Y-m')) ?>"
          onchange="this.form.submit()"
        >
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-search"></i> View
        </button>
      </form>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card stat-card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="fa fa-money-bill-wave fa-2x text-danger me-3"></i>
            <div>
              <h5 class="card-title mb-0">Total Expenses</h5>
              <small class="text-muted">Money taken from business</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-danger">RWF <?=number_format($expensesTotal,2)?></div>
          
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-money-bill-wave"></i> Expenses Breakdown
            </div>
            <div class="info-panel-item">
              <span>💸 Total Amount:</span>
              <strong>RWF <?=number_format($expensesTotal,2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📅 Selected Month:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="info-panel-item">
              <span>📊 Category:</span>
              <strong>Business Expenses</strong>
            </div>
            <div class="info-panel-footer">
              💡 Hover to see details
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card stat-card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="fa fa-shopping-cart fa-2x text-primary me-3"></i>
            <div>
              <h5 class="card-title mb-0">Total Purchases</h5>
              <small class="text-muted">Money spent to buy items</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-primary">RWF <?=number_format($purchasesTotal,2)?></div>
          
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-shopping-cart"></i> Purchases Summary
            </div>
            <div class="info-panel-item">
              <span>🛒 Total Amount:</span>
              <strong>RWF <?=number_format($purchasesTotal,2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📅 Selected Month:</span>
              <strong><?=date('F Y', strtotime($month ?? date('Y-m')))?></strong>
            </div>
            <div class="info-panel-item">
              <span>📦 Category:</span>
              <strong>Inventory Purchases</strong>
            </div>
            <div class="info-panel-footer">
              💡 Hover to see details
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Card -->
  <div class="card border-0 shadow-sm bg-light">
    <div class="card-body">
      <h6 class="fw-bold"><i class="fa fa-info-circle text-info"></i> About This Report</h6>
      <p class="mb-0 text-muted">
        This report shows the total expenses and purchases for the selected month independently. 
        Expenses represent money taken from the business (including personal use), while purchases 
        represent money spent to buy items for the business.
      </p>
    </div>
  </div>

  <!-- Back Button -->
  <div class="mt-4">
    <a href="?r=dashboard/index" class="btn btn-outline-secondary">
      <i class="fa fa-arrow-left"></i> Back to Dashboard
    </a>
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
