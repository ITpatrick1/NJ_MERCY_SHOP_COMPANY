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

.stats-card-purchase {
  animation: fadeInUp 0.5s ease-out;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  border-radius: 16px;
  overflow: hidden;
  position: relative;
}

.stats-card-purchase::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  animation: shimmer 3s infinite;
}

.stats-card-purchase:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(16, 185, 129, 0.4);
}

.stats-card-purchase.info {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.stats-card-purchase.info:hover {
  box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
}

.stats-card-purchase.warning {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.stats-card-purchase.warning:hover {
  box-shadow: 0 12px 24px rgba(245, 158, 11, 0.4);
}

.stats-card-purchase.purple {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.stats-card-purchase.purple:hover {
  box-shadow: 0 12px 24px rgba(139, 92, 246, 0.4);
}

/* Dark mode stats cards */
body.dark-mode .stats-card-purchase {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%) !important;
  box-shadow: 0 8px 24px rgba(6, 78, 59, 0.5) !important;
}

body.dark-mode .stats-card-purchase:hover {
  box-shadow: 0 12px 24px rgba(6, 78, 59, 0.6) !important;
}

body.dark-mode .stats-card-purchase.info {
  background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
  box-shadow: 0 8px 24px rgba(30, 58, 138, 0.5) !important;
}

body.dark-mode .stats-card-purchase.info:hover {
  box-shadow: 0 12px 24px rgba(30, 58, 138, 0.6) !important;
}

body.dark-mode .stats-card-purchase.warning {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%) !important;
  box-shadow: 0 8px 24px rgba(146, 64, 14, 0.5) !important;
}

body.dark-mode .stats-card-purchase.warning:hover {
  box-shadow: 0 12px 24px rgba(146, 64, 14, 0.6) !important;
}

body.dark-mode .stats-card-purchase.purple {
  background: linear-gradient(135deg, #4c1d95 0%, #5b21b6 100%) !important;
  box-shadow: 0 8px 24px rgba(76, 29, 149, 0.5) !important;
}

body.dark-mode .stats-card-purchase.purple:hover {
  box-shadow: 0 12px 24px rgba(76, 29, 149, 0.6) !important;
}

.page-header-purchase {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
}

body.dark-mode .page-header-purchase {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%) !important;
}

.filter-card {
  border-radius: 16px;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.filter-card:hover {
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

body.dark-mode .filter-card {
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

body.dark-mode .form-control,
body.dark-mode .form-select {
  background: #23272b;
  color: #e0e0e0;
  border-color: #4a5568;
}

body.dark-mode .input-group-text {
  background: #2a2f38;
  color: #e0e0e0;
  border-color: #4a5568;
}

.supplier-header {
  background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
  border-left: 4px solid #2563eb;
  transition: all 0.3s ease;
}

.supplier-header:hover {
  background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
}

body.dark-mode .supplier-header {
  background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
  border-left: 4px solid #3b82f6;
  color: white !important;
}

.supplier-subtotal {
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-left: 4px solid #f59e0b;
}

body.dark-mode .supplier-subtotal {
  background: linear-gradient(135deg, #92400e 0%, #b45309 100%) !important;
  border-left: 4px solid #f59e0b;
  color: white !important;
}

.grand-total-row {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  border-left: 4px solid #10b981;
}

body.dark-mode .grand-total-row {
  background: linear-gradient(135deg, #064e3b 0%, #065f46 100%) !important;
  border-left: 4px solid #10b981;
  color: white !important;
}

.purchase-row {
  transition: all 0.2s ease;
}

.purchase-row:hover {
  background: rgba(16, 185, 129, 0.05);
  transform: scale(1.005);
}

body.dark-mode .purchase-row:hover {
  background: rgba(16, 185, 129, 0.1);
}

.action-btn-purchase {
  border-radius: 8px;
  padding: 0.4rem 0.8rem;
  transition: all 0.3s ease;
}

.action-btn-purchase:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.date-filter-box {
  border-radius: 12px;
  border: 2px solid #e5e7eb;
  transition: all 0.3s ease;
}

.date-filter-box:focus {
  border-color: #10b981;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

body.dark-mode .date-filter-box {
  background: #23272b;
  border-color: #4a5568;
  color: #e0e0e0;
}

body.dark-mode .date-filter-box:focus {
  border-color: #10b981;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.export-btn {
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.export-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}
</style>

<div class="container my-4">
  <!-- Professional Page Header -->
  <div class="page-header-purchase">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="fw-bold mb-2">
          <i class="fa fa-shopping-cart"></i> Purchase Management
        </h2>
        <p class="mb-0 opacity-75">
          <i class="fa fa-info-circle"></i> Track and manage all your inventory purchases
        </p>
      </div>
      <a class="btn btn-light btn-lg shadow" href="?r=purchase/create">
        <i class="fa fa-plus"></i> New Purchase
      </a>
    </div>
  </div>

  <?php
  // Calculate statistics
  $totalPurchases = count($grouped_purchases);
  $uniqueSuppliers = count($grouped_purchases);
  $totalProducts = 0;
  $totalAmount = 0;
  
  foreach($grouped_purchases as $group) {
    $totalProducts += count($group['purchases']);
    $totalAmount += $group['total'];
  }
  ?>

  <!-- Enhanced Statistics Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-purchase shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-shopping-cart fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Total Purchases</h6>
          <div class="display-5 fw-bold"><?= $totalProducts ?></div>
          <small class="opacity-75">Items Purchased</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-purchase info shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-truck fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Suppliers</h6>
          <div class="display-5 fw-bold"><?= $uniqueSuppliers ?></div>
          <small class="opacity-75">Active Suppliers</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-purchase warning shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-dollar-sign fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Total Amount</h6>
          <div class="display-5 fw-bold"><?= number_format($grand_total, 0) ?></div>
          <small class="opacity-75">ETB Spent</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card-purchase purple shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-calendar-alt fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Date Range</h6>
          <div class="h5 fw-bold mt-3"><?= date('M d', strtotime($start)) ?></div>
          <small class="opacity-75">to</small>
          <div class="h5 fw-bold"><?= date('M d, Y', strtotime($end)) ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search by Date Range -->
  <div class="card filter-card p-4 mb-4">
    <h5 class="mb-3">
      <i class="fa fa-filter text-success"></i> Filter Purchases
    </h5>
    <form method="get" action="?r=purchase/index" class="row g-3 align-items-end">
      <input type="hidden" name="r" value="purchase/index">
      <div class="col-md-5">
        <label class="form-label fw-600">
          <i class="fa fa-calendar"></i> From Date
        </label>
        <input type="date" name="start" class="form-control date-filter-box" value="<?=htmlspecialchars($start)?>" required>
      </div>
      <div class="col-md-5">
        <label class="form-label fw-600">
          <i class="fa fa-calendar"></i> To Date
        </label>
        <input type="date" name="end" class="form-control date-filter-box" value="<?=htmlspecialchars($end)?>" required>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100 export-btn">
          <i class="fa fa-search"></i> Search
        </button>
      </div>
    </form>
    <div class="mt-3">
      <a href="?r=purchase/index" class="btn btn-outline-secondary">
        <i class="fa fa-refresh"></i> Reset Filter
      </a>
    </div>
  </div>

  <!-- Export Options -->
  <div class="card filter-card p-4 mb-4">
    <h5 class="mb-3">
      <i class="fa fa-download text-primary"></i> Export Options
    </h5>
    <div class="d-flex flex-wrap gap-3">
      <form method="get" class="d-flex align-items-center gap-2">
        <input type="hidden" name="r" value="purchase/exportCsv">
        <input type="hidden" name="start" value="<?=htmlspecialchars($start)?>">
        <input type="hidden" name="end" value="<?=htmlspecialchars($end)?>">
        <button type="submit" class="btn btn-success export-btn">
          <i class="fa fa-file-csv"></i> Export to CSV
        </button>
      </form>
      <form method="get" class="d-flex align-items-center gap-2">
        <input type="hidden" name="r" value="purchase/exportPdf">
        <input type="hidden" name="start" value="<?=htmlspecialchars($start)?>">
        <input type="hidden" name="end" value="<?=htmlspecialchars($end)?>">
        <button type="submit" class="btn btn-danger export-btn">
          <i class="fa fa-file-pdf"></i> Export to PDF
        </button>
      </form>
      <div class="ms-auto text-muted">
        <small>
          <i class="fa fa-info-circle"></i> Export current date range: 
          <strong><?= date('M d', strtotime($start)) ?> - <?= date('M d, Y', strtotime($end)) ?></strong>
        </small>
      </div>
    </div>
  </div>

  <!-- Purchases Table -->
  <div class="card shadow-lg border-0" style="border-radius: 16px;">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px 16px 0 0;">
      <h5 class="mb-0">
        <i class="fa fa-table"></i> Purchase Records
      </h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="padding: 1rem;"><i class="fa fa-calendar"></i> Date</th>
              <th><i class="fa fa-truck"></i> Supplier</th>
              <th><i class="fa fa-box"></i> Product</th>
              <th><i class="fa fa-sort-numeric-up"></i> Quantity</th>
              <th><i class="fa fa-tag"></i> Unit Price</th>
              <th><i class="fa fa-calculator"></i> Total</th>
              <th class="text-center"><i class="fa fa-cog"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($grouped_purchases)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-5">
                <div>
                  <i class="fa fa-shopping-cart fa-3x mb-3" style="opacity: 0.3;"></i>
                  <p class="mb-0">No purchases found for this date range.</p>
                  <small>Try adjusting your date filter or <a href="?r=purchase/create">create a new purchase</a></small>
                </div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach($grouped_purchases as $group): ?>
              <!-- Supplier Header Row -->
              <tr class="supplier-header">
                <td colspan="7" class="fw-bold py-3" style="font-size: 1.05rem;">
                  <i class="fa fa-user-tie"></i> <?=htmlspecialchars($group['supplier_name'])?> 
                  <span class="badge bg-primary ms-2">TIN: <?=htmlspecialchars($group['supplier_tin'])?></span>
                </td>
              </tr>
              <!-- Purchases for this supplier -->
              <?php foreach($group['purchases'] as $p): ?>
              <tr class="purchase-row">
                <td style="padding: 1rem;">
                  <strong><?=htmlspecialchars($p['purchase_date'])?></strong>
                </td>
                <td></td>
                <td>
                  <i class="fa fa-box text-success"></i>
                  <strong><?=htmlspecialchars($p['product_name'])?></strong>
                </td>
                <td>
                  <span class="badge bg-info"><?=$p['quantity']?> units</span>
                </td>
                <td><?=number_format($p['unit_price'],2)?> ETB</td>
                <td><strong><?=number_format($p['total_price'],2)?> ETB</strong></td>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <a href="?r=purchase/edit&id=<?=$p['purchase_id']?>" 
                       class="btn btn-sm btn-primary action-btn-purchase" 
                       title="Edit Purchase">
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="?r=purchase/delete&id=<?=$p['purchase_id']?>" 
                       class="btn btn-sm btn-danger action-btn-purchase" 
                       title="Delete Purchase" 
                       onclick="return confirm('Are you sure you want to delete this purchase?')">
                      <i class="fa fa-trash"></i> Delete
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
              <!-- Supplier Subtotal Row -->
              <tr class="supplier-subtotal">
                <td colspan="5" class="text-end fw-bold py-3" style="font-size: 1.05rem;">
                  <i class="fa fa-calculator"></i> Subtotal for <?=htmlspecialchars($group['supplier_name'])?>:
                </td>
                <td class="fw-bold py-3" style="font-size: 1.05rem;">
                  <?=number_format($group['total'],2)?> ETB
                </td>
                <td></td>
              </tr>
            <?php endforeach; ?>
            <!-- Grand Total Row -->
            <tr class="grand-total-row">
              <td colspan="5" class="text-end fw-bold py-4" style="font-size: 1.2rem;">
                <i class="fa fa-money-bill-wave"></i> GRAND TOTAL:
              </td>
              <td class="fw-bold py-4" style="font-size: 1.3rem;">
                <?=number_format($grand_total,2)?> ETB
              </td>
              <td></td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
// Add animation on load
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.stats-card-purchase');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
  });
  
  // Highlight current date inputs
  const dateInputs = document.querySelectorAll('.date-filter-box');
  dateInputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.style.borderColor = '#10b981';
    });
  });
});
</script>
