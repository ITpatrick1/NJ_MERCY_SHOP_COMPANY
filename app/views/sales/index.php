<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-list"></i> Daily Sales Records</h2>
    <form method="get" action="/sales/exportCsv" class="d-flex align-items-center gap-2">
      <label class="form-label mb-0">From</label>
      <input type="date" name="start" class="form-control" value="<?=date('Y-m-01')?>">
      <label class="form-label mb-0">To</label>
      <input type="date" name="end" class="form-control" value="<?=date('Y-m-d')?>">
      <button type="submit" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</button>
    </form>
  </div>
  <?php if (!empty($flash['msg'])): ?>
    <div class="alert alert-success"> <?= htmlspecialchars($flash['msg']) ?> </div>
  <?php endif; ?>
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>User</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($sales as $sale): ?>
          <tr>
            <td><?= htmlspecialchars($sale['sales_date']) ?></td>
            <td><?= htmlspecialchars($sale['amount']) ?></td>
            <td><?= htmlspecialchars($sale['user_name']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
