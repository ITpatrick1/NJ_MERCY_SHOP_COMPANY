<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-money-bill-wave"></i> Payment Management</h2>
    <a href="?r=credits" class="btn btn-secondary">
      <i class="fa fa-arrow-left"></i> Back to Credits
    </a>
  </div>

  <?php if(isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-<?=$_SESSION['flash_type'] ?? 'info'?> alert-dismissible fade show">
      <?=$_SESSION['flash_message']?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
  <?php endif; ?>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <?php
    $total_payments = count($payments);
    $pending = array_filter($payments, fn($p) => $p['status'] === 'pending');
    $approved = array_filter($payments, fn($p) => $p['status'] === 'approved');
    $rejected = array_filter($payments, fn($p) => $p['status'] === 'rejected');
    $total_amount = array_sum(array_column($payments, 'amount_paid'));
    $approved_amount = array_sum(array_column($approved, 'amount_paid'));
    ?>
    <div class="col-md-3">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-file-invoice-dollar fa-2x text-primary"></i></div>
          <h5 class="card-title">Total Payments</h5>
          <div class="display-6 fw-bold"><?=$total_payments?></div>
          <p class="text-muted mb-0">RWF <?=number_format($total_amount, 2)?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
          <h5 class="card-title">Pending</h5>
          <div class="display-6 fw-bold"><?=count($pending)?></div>
          <p class="text-muted mb-0">Awaiting approval</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-check-circle fa-2x text-success"></i></div>
          <h5 class="card-title">Approved</h5>
          <div class="display-6 fw-bold"><?=count($approved)?></div>
          <p class="text-muted mb-0">RWF <?=number_format($approved_amount, 2)?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="mb-2"><i class="fa fa-times-circle fa-2x text-danger"></i></div>
          <h5 class="card-title">Rejected</h5>
          <div class="display-6 fw-bold"><?=count($rejected)?></div>
          <p class="text-muted mb-0">Needs review</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Payments Table -->
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="fa fa-list"></i> All Payments</h5>
    </div>
    <div class="card-body p-0">
      <?php if(empty($payments)): ?>
        <div class="text-center py-5">
          <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
          <p class="text-muted">No payments recorded yet.</p>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Credit ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Recorded By</th>
                <th>Status</th>
                <th>Approved By</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($payments as $payment): ?>
                <tr>
                  <td><?=$payment['payment_id']?></td>
                  <td><?=htmlspecialchars($payment['client_name'])?></td>
                  <td>
                    <a href="?r=credit/view&id=<?=$payment['credit_id']?>" class="text-decoration-none">
                      #<?=$payment['credit_id']?>
                    </a>
                  </td>
                  <td class="fw-bold">RWF <?=number_format($payment['amount_paid'], 2)?></td>
                  <td><?=date('M d, Y', strtotime($payment['payment_date']))?></td>
                  <td><?=htmlspecialchars($payment['recorded_by_name'])?></td>
                  <td>
                    <?php if($payment['status'] === 'pending'): ?>
                      <span class="badge bg-warning text-dark"><i class="fa fa-clock"></i> Pending</span>
                    <?php elseif($payment['status'] === 'approved'): ?>
                      <span class="badge bg-success"><i class="fa fa-check"></i> Approved</span>
                    <?php else: ?>
                      <span class="badge bg-danger"><i class="fa fa-times"></i> Rejected</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($payment['approved_by_name']): ?><?=htmlspecialchars($payment['approved_by_name'])?>
                      <br><small class="text-muted"><?=date('M d, Y', strtotime($payment['approved_at']))?></small>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <?php if($_SESSION['user']['role'] === 'manager'): ?>
                        <?php if($payment['status'] === 'pending'): ?>
                          <!-- Approve Button -->
                          <form method="POST" action="?r=payment/approve" style="display:inline;">
                            <input type="hidden" name="payment_id" value="<?=$payment['payment_id']?>">
                            <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>">
                            <button type="submit" class="btn btn-success btn-sm" title="Approve Payment" onclick="return confirm('Approve this payment?')">
                              <i class="fa fa-check"></i>
                            </button>
                          </form>
                          <!-- Reject Button with Modal -->
                          <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?=$payment['payment_id']?>" title="Reject Payment">
                            <i class="fa fa-times"></i>
                          </button>
                        <?php else: ?>
                          <!-- Edit Status (Reset to Pending) -->
                          <form method="POST" action="?r=payment/editStatus" style="display:inline;">
                            <input type="hidden" name="payment_id" value="<?=$payment['payment_id']?>">
                            <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>">
                            <button type="submit" class="btn btn-warning btn-sm" title="Reset to Pending" onclick="return confirm('Reset this payment to pending status?')">
                              <i class="fa fa-edit"></i> Edit
                            </button>
                          </form>
                        <?php endif; ?>
                      <?php else: ?>
                        <span class="text-muted small">Manager only</span>
                      <?php endif; ?>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal<?=$payment['payment_id']?>" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form method="POST" action="?r=payment/reject">
                            <div class="modal-header">
                              <h5 class="modal-title">Reject Payment #<?=$payment['payment_id']?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="payment_id" value="<?=$payment['payment_id']?>">
                              <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>">
                              <div class="mb-3">
                                <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control" rows="3" required placeholder="Enter reason for rejection..."></textarea>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger">Reject Payment</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php if($payment['status'] === 'rejected' && $payment['rejection_reason']): ?>
                  <tr class="table-warning">
                    <td colspan="9">
                      <small><i class="fa fa-exclamation-circle"></i> <strong>Rejection Reason:</strong> <?=htmlspecialchars($payment['rejection_reason'])?></small>
                    </td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
