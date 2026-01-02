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

  <!-- Export & Filter -->
  <div class="card p-3 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <form method="get" action="/purchases/exportCsv" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
        <label class="form-label mb-0">From</label>
        <input type="date" name="start" class="form-control" value="<?=date('Y-m-01')?>">
        <label class="form-label mb-0">To</label>
        <input type="date" name="end" class="form-control" value="<?=date('Y-m-d')?>">
        <button type="submit" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</button>
      </form>
      <form method="get" action="/purchases/exportPdf" class="d-flex align-items-center gap-2">
        <input type="hidden" name="start" value="<?=date('Y-m-01')?>">
        <input type="hidden" name="end" value="<?=date('Y-m-d')?>">
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
        <?php foreach($purchases as $p): ?>
          <tr>
            <td><?=htmlspecialchars($p['purchase_date'])?></td>
            <td><?=htmlspecialchars($p['supplier_name'])?></td>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
