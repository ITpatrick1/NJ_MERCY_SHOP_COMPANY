<div class="container mt-4">
  <div class="mb-4">
    <h2 class="fw-bold"><i class="fa fa-chart-line text-success"></i> Financial Report</h2>
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
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="fa fa-money-bill-wave fa-2x text-danger me-3"></i>
            <div>
              <h5 class="card-title mb-0">Total Expenses</h5>
              <small class="text-muted">Money taken from business</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-danger">RWF <?=number_format($expensesTotal,2)?></div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="fa fa-shopping-cart fa-2x text-primary me-3"></i>
            <div>
              <h5 class="card-title mb-0">Total Purchases</h5>
              <small class="text-muted">Money spent to buy items</small>
            </div>
          </div>
          <div class="display-5 fw-bold text-primary">RWF <?=number_format($purchasesTotal,2)?></div>
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
