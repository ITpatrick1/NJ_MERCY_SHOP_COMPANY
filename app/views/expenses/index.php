<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-money-bill-wave"></i> Expenses</h2>
    <a class="btn btn-success" href="?r=expense/create"><i class="fa fa-plus"></i> New Expense</a>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-money-bill-wave fa-2x text-success"></i></div>
          <h5 class="card-title">Total Expenses</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-user fa-2x text-info"></i></div>
          <h5 class="card-title">Users</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-receipt fa-2x text-primary"></i></div>
          <h5 class="card-title">Expense Reasons</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Export & Filter -->
  <div class="card p-3 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <form method="get" action="?r=expense/exportCsv" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
        <label class="form-label mb-0">From</label>
        <input type="date" name="start" class="form-control" value="<?=date('Y-m-01')?>">
        <label class="form-label mb-0">To</label>
        <input type="date" name="end" class="form-control" value="<?=date('Y-m-d')?>">
        <button type="submit" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</button>
      </form>
      <form method="get" action="?r=expense/exportPdf" class="d-flex align-items-center gap-2">
        <input type="hidden" name="start" value="<?=date('Y-m-01')?>">
        <input type="hidden" name="end" value="<?=date('Y-m-d')?>">
        <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export PDF</button>
      </form>
    </div>
  </div>

  <?php if (!empty($flash['msg'])): ?>
    <div class="alert alert-success"> <?= htmlspecialchars($flash['msg']) ?> </div>
  <?php endif; ?>

  <!-- Expenses Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>User</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($expenses as $expense): ?>
          <tr>
            <td><?= htmlspecialchars($expense['expense_date']) ?></td>
            <td><?= htmlspecialchars($expense['amount']) ?></td>
            <td><?= htmlspecialchars($expense['user_name']) ?></td>
            <td><?= htmlspecialchars($expense['reason']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
