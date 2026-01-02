</tbody>
      </table>
    </div>
    <style>
      /* Professional badge hover and vibrant color tweaks */
      .badge.bg-danger {
        background: #d32f2f !important;
        color: #fff !important;
        box-shadow: 0 2px 8px #d32f2f33;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .badge.bg-danger:hover {
        background: #b71c1c !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #b71c1c55;
      }
      .badge.bg-success {
        background: #388e3c !important;
        color: #fff !important;
        box-shadow: 0 2px 8px #388e3c33;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .badge.bg-success:hover {
        background: #1b5e20 !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #1b5e2055;
      }
      .badge.bg-warning {
        background: #ffc107 !important;
        color: #212529 !important;
        box-shadow: 0 2px 8px #ffc10733;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;

        /* Table row hover selection color */
        .table-hover tbody tr:hover {
          background-color: #70091bff !important; /* Soft blue-gray for selection */
          transition: background 0.2s;
        }
      }
      .badge.bg-warning:hover {
        background: #ff9800 !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #ff980055;
      }
      .badge.bg-info {
        background: #29b6f6 !important;
        color: #212529 !important;
        box-shadow: 0 2px 8px #5d031933;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .badge.bg-info:hover {
        background: #163708ff !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #0288d155;
      }
      .badge.bg-secondary {
        background: #757575 !important;
        color: #fff !important;
        box-shadow: 0 2px 8px #75757533;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .badge.bg-secondary:hover {
        background: #424242 !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #42424255;
      }
    </style>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0"><i class="fa fa-file-invoice-dollar"></i> Credit Sales Report</h2>
    <div class="d-flex gap-2">
      <a class="btn btn-success" href="?r=report/exportCreditSalesCsv"><i class="fa fa-file-csv"></i> Export CSV</a>
      <a class="btn btn-danger" href="?r=report/exportCreditSalesPdf"><i class="fa fa-file-pdf"></i> Export PDF</a>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-credit-card fa-2x text-warning"></i></div>
          <h5 class="card-title">Total Credit Sales</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></div>
          <h5 class="card-title">Overdue Credits</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-check-circle fa-2x text-success"></i></div>
          <h5 class="card-title">Settled Credits</h5>
          <div class="display-6 fw-bold">--</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Credit Sales Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-primary">
          <tr>
            <th><i class="fa fa-hashtag"></i> ID</th>
            <th><i class="fa fa-user"></i> Client</th>
            <th><i class="fa fa-box"></i> Product</th>
            <th><i class="fa fa-sort-numeric-up"></i> Qty</th>
            <th><i class="fa fa-money-bill"></i> Unit Price</th>
            <th><i class="fa fa-calculator"></i> Total</th>
            <th><i class="fa fa-calendar-plus"></i> Date Issued</th>
            <th><i class="fa fa-calendar-check"></i> Due Date</th>
            <th><i class="fa fa-info-circle"></i> Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
        // Optionally, lookup product name if available
        $productNames = [];
        if (class_exists('Product')) {
          foreach ((new Product())->all() as $p) {
            $productNames[$p['product_id']] = $p['name'];
          }
        }
        foreach($sales as $s):
          $rowClass = '';
          $badge = '';
          $status = strtolower(trim($s['status']));
          if ($status === 'overdue') {
            $rowClass = 'table-danger';
            $badge = '<span class="badge rounded-pill bg-danger px-3 py-2"><i class="fa fa-exclamation-triangle me-1"></i> Overdue</span>';
          } elseif ($status === 'settled') {
            $rowClass = 'table-success';
            $badge = '<span class="badge rounded-pill bg-success px-3 py-2"><i class="fa fa-check-circle me-1"></i> Settled</span>';
          } elseif ($status === 'pending') {
            $rowClass = 'table-warning';
            $badge = '<span class="badge rounded-pill bg-warning text-dark px-3 py-2"><i class="fa fa-hourglass-half me-1"></i> Pending</span>';
          } elseif ($status === 'approved') {
            $rowClass = 'table-info';
            $badge = '<span class="badge rounded-pill bg-info text-dark px-3 py-2"><i class="fa fa-thumbs-up me-1"></i> Approved</span>';
          } else {
            $badge = '<span class="badge rounded-pill bg-secondary px-3 py-2">'.htmlspecialchars($s['status']).'</span>';
          }
        ?>
          <tr class="<?= $rowClass ?>">
            <td><?=$s['credit_id']?></td>
            <td><?=htmlspecialchars($s['client_name'])?></td>
            <td>
              <i class="fa fa-box text-primary"></i> <?=isset($productNames[$s['product_id']]) ? htmlspecialchars($productNames[$s['product_id']]) : $s['product_id']?>
            </td>
            <td><?=$s['quantity']?></td>
            <td>RWF <?=number_format($s['unit_price'],2)?></td>
            <td>RWF <?=number_format($s['total_price'],2)?></td>
            <td><?=htmlspecialchars($s['date_issued'])?></td>
            <td><?=htmlspecialchars($s['due_date'])?></td>
            <td><?=$badge?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
