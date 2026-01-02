<div class="container my-4">
  <div class="mb-4">
    <a href="?r=client/index" class="btn btn-outline-secondary mb-3">
      <i class="fa fa-arrow-left"></i> Back to Clients
    </a>
    <h2 class="fw-bold"><i class="fa fa-user text-info"></i> Client Details</h2>
  </div>

  <!-- Client Information Card -->
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-3"><i class="fa fa-address-card text-info"></i> Client Information</h5>
          <table class="table table-borderless">
            <tr>
              <th width="40%"><i class="fa fa-hashtag"></i> Client ID:</th>
              <td><?= htmlspecialchars($client['client_id']) ?></td>
            </tr>
            <tr>
              <th><i class="fa fa-user"></i> Name:</th>
              <td><strong><?= htmlspecialchars($client['name']) ?></strong></td>
            </tr>
            <tr>
              <th><i class="fa fa-phone"></i> Phone:</th>
              <td><?= htmlspecialchars($client['phone']) ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center">
          <i class="fa fa-credit-card fa-3x text-warning mb-2"></i>
          <h5>Quick Actions</h5>
          <a href="?r=credit/create" class="btn btn-success mt-2">
            <i class="fa fa-plus"></i> New Credit Sale
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Credit History -->
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-3"><i class="fa fa-history text-primary"></i> Credit History</h5>
      
      <?php if (empty($credits)): ?>
        <div class="alert alert-info">
          <i class="fa fa-info-circle"></i> No credit sales found for this client.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><i class="fa fa-hashtag"></i> ID</th>
                <th><i class="fa fa-box"></i> Product</th>
                <th><i class="fa fa-sort-numeric-up"></i> Qty</th>
                <th><i class="fa fa-money-bill"></i> Unit Price</th>
                <th><i class="fa fa-calculator"></i> Total</th>
                <th><i class="fa fa-calendar"></i> Date Issued</th>
                <th><i class="fa fa-calendar-check"></i> Due Date</th>
                <th><i class="fa fa-flag"></i> Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $total_credit = 0;
              foreach($credits as $credit): 
                $total_credit += $credit['total_price'];
                $status_class = match($credit['status']) {
                  'pending' => 'warning',
                  'active' => 'info',
                  'overdue' => 'danger',
                  'approved' => 'success',
                  'paid' => 'success',
                  default => 'secondary'
                };
              ?>
                <tr>
                  <td><?= htmlspecialchars($credit['credit_id']) ?></td>
                  <td><?= htmlspecialchars($credit['product_name'] ?? 'N/A') ?></td>
                  <td><?= htmlspecialchars($credit['quantity']) ?></td>
                  <td>RWF <?= number_format($credit['unit_price'], 2) ?></td>
                  <td><strong>RWF <?= number_format($credit['total_price'], 2) ?></strong></td>
                  <td><?= htmlspecialchars($credit['date_issued']) ?></td>
                  <td><?= htmlspecialchars($credit['due_date']) ?></td>
                  <td>
                    <span class="badge bg-<?= $status_class ?>">
                      <?= ucfirst(htmlspecialchars($credit['status'])) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="4" class="text-end">Total Credit:</th>
                <th colspan="4" class="text-start">RWF <?= number_format($total_credit, 2) ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
