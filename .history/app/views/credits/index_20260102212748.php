<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-credit-card"></i> Credit Sales</h2>
    <a class="btn btn-success" href="?r=credit/create"><i class="fa fa-plus"></i> Add Credit Sale</a>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-credit-card fa-2x text-warning"></i></div>
          <h5 class="card-title">Total Credits</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></div>
          <h5 class="card-title">Overdue</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-check-circle fa-2x text-success"></i></div>
          <h5 class="card-title">Settled</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions & Search -->
  <div class="card p-3 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <form class="d-flex gap-2 mb-2 mb-md-0" method="get" action="">
        <input type="hidden" name="r" value="credit/index">
        <input type="text" name="search" class="form-control" placeholder="Search client, phone, status...">
        <button class="btn btn-outline-primary"><i class="fa fa-search"></i> Search</button>
      </form>
      <div class="d-flex gap-2">
        <a href="?r=report/creditSales" class="btn btn-info"><i class="fa fa-file-alt"></i> Credit Sales Report</a>
        <a href="?r=report/overdueCredits" class="btn btn-danger"><i class="fa fa-exclamation-triangle"></i> Overdue Report</a>
      </div>
    </div>
  </div>

  <!-- Credits Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Phone</th>
            <th>Total Price</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($credits as $cr): ?>
          <tr>
            <td><?= $cr['credit_id'] ?></td>
            <td><?=htmlspecialchars($cr['client_name'] ?? $cr['name'] ?? '')?></td>
            <td><?=htmlspecialchars($cr['phone'])?></td>
            <td><?=number_format($cr['total_price'],2)?></td>
            <td><?=htmlspecialchars($cr['due_date'])?></td>
            <td><?=htmlspecialchars($cr['status'])?></td>
            <td>
              <a href="?r=credit/view&id=<?= $cr['credit_id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
              <a href="?r=credit/edit&id=<?= $cr['credit_id'] ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
