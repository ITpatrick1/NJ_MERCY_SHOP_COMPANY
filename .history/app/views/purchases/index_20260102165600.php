<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-shopping-cart"></i> Purchases</h2>
    <a class="btn btn-success" href="?r=purchase/create"><i class="fa fa-plus"></i> New Purchase</a>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-shopping-cart fa-2x text-success"></i></div>
          <h5 class="card-title">Total Purchases</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-truck fa-2x text-info"></i></div>
          <h5 class="card-title">Suppliers</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-boxes fa-2x text-primary"></i></div>
          <h5 class="card-title">Products Purchased</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search by Date Range -->
  <div class="card p-3 shadow-sm border-0 mb-3">
    <form method="get" action="?r=purchase/index" class="d-flex gap-2 align-items-center">
      <input type="hidden" name="r" value="purchase/index">
      <label class="form-label mb-0 fw-bold">Filter by Date:</label>
      <label class="form-label mb-0">From</label>
      <input type="date" name="start" class="form-control" style="width: auto;" value="<?=htmlspecialchars($start)?>" required>
      <label class="form-label mb-0">To</label>
      <input type="date" name="end" class="form-control" style="width: auto;" value="<?=htmlspecialchars($end)?>" required>
      <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
      <a href="?r=purchase/index" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
    </form>
  </div>

  <!-- Export & Filter -->
  <div class="card p-3 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <form method="get" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
        <input type="hidden" name="r" value="purchase/exportCsv">
        <label class="form-label mb-0">From</label>
        <input type="date" name="start" class="form-control" style="width: auto;" value="<?=htmlspecialchars($start)?>">
        <label class="form-label mb-0">To</label>
        <input type="date" name="end" class="form-control" style="width: auto;" value="<?=htmlspecialchars($end)?>">
        <button type="submit" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</button>
      </form>
      <form method="get" class="d-flex align-items-center gap-2">
        <input type="hidden" name="r" value="purchase/exportPdf">
        <input type="hidden" name="start" value="<?=htmlspecialchars($start)?>">
        <input type="hidden" name="end" value="<?=htmlspecialchars($end)?>">
        <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export PDF</button>
      </form>
    </div>
  </div>

  <!-- Purchases Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Supplier</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($grouped_purchases)): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">No purchases found for this date range.</td>
          </tr>
        <?php else: ?>
          <?php foreach($grouped_purchases as $group): ?>
            <!-- Supplier Header Row -->
            <tr style="background-color: #d1ecf1; border-left: 4px solid #0c5460;">
              <td colspan="7" class="fw-bold" style="color: #0c5460;">
                👤 <?=htmlspecialchars($group['supplier_name'])?> (<?=htmlspecialchars($group['supplier_tin'])?>)
              </td>
            </tr>
            <!-- Purchases for this supplier -->
            <?php foreach($group['purchases'] as $p): ?>
            <tr>
              <td><?=htmlspecialchars($p['purchase_date'])?></td>
              <td></td>
              <td><?=htmlspecialchars($p['product_name'])?></td>
              <td><?=$p['quantity']?></td>
              <td><?=number_format($p['unit_price'],2)?></td>
              <td><?=number_format($p['total_price'],2)?></td>
              <td>
                <a href="?r=purchase/edit&id=<?=$p['purchase_id']?>" class="btn btn-sm btn-primary" title="Edit">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="?r=purchase/delete&id=<?=$p['purchase_id']?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this purchase?')">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <!-- Supplier Subtotal Row -->
            <tr style="background-color: #fff3cd; border-left: 4px solid #856404;">
              <td colspan="5" class="text-end fw-bold" style="color: #856404;">🧮 Subtotal for <?=htmlspecialchars($group['supplier_name'])?>:</td>
              <td class="fw-bold" style="color: #856404;"><?=number_format($group['total'],2)?></td>
              <td></td>
            </tr>
          <?php endforeach; ?>
          <!-- Grand Total Row -->
          <tr style="background-color: #d4edda; border-left: 4px solid #155724;">
            <td colspan="5" class="text-end fw-bold fs-5" style="color: #155724;">💰 GRAND TOTAL:</td>
            <td class="fw-bold fs-5" style="color: #155724;"><?=number_format($grand_total,2)?></td>
            <td></td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
