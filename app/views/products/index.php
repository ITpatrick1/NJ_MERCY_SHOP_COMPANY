<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-box"></i> Products</h2>
    <a class="btn btn-success" href="?r=product/create"><i class="fa fa-plus"></i> Add Product</a>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-box fa-2x text-primary"></i></div>
          <h5 class="card-title">Total Products</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-cubes fa-2x text-success"></i></div>
          <h5 class="card-title">In Stock</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></div>
          <h5 class="card-title">Low Stock</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions & Search -->
  <div class="card p-3 shadow-sm border-0 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <form class="d-flex gap-2 mb-2 mb-md-0" method="get" action="">
        <input type="hidden" name="r" value="product/index">
        <input type="text" name="search" class="form-control" placeholder="Search name, stock, price...">
        <button class="btn btn-outline-primary"><i class="fa fa-search"></i> Search</button>
      </form>
      <div class="d-flex gap-2">
        <a href="?r=report/profit" class="btn btn-info"><i class="fa fa-chart-line"></i> Profit Report</a>
      </div>
    </div>
  </div>

  <!-- Products Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Buy Price</th>
            <th>Stock</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($products as $p): ?>
          <tr>
            <td><?=$p['product_id']?></td>
            <td><?=htmlspecialchars($p['name'])?></td>
            <td><?=number_format($p['unit_price'],2)?></td>
            <td><?=$p['quantity']?></td>
            <td>
              <a href="?r=product/edit&id=<?=$p['product_id']?>" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i></a>
              <a href="?r=product/view&id=<?=$p['product_id']?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
