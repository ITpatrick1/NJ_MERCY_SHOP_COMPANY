<?php require_once __DIR__ . '/../layout/header.php'; ?>

<style>
      /* Animated Card Styles */
      .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
      }
      
      .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
      }
      
      .stat-card:hover::before {
        left: 100%;
      }
      
      .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
      }
      
      .stat-card.active {
        border-color: #0d6efd;
        box-shadow: 0 8px 16px rgba(13,110,253,0.3) !important;
      }
      
      .stat-card .card-body {
        position: relative;
        z-index: 1;
      }
      
      /* Pulse Animation for Numbers */
      @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
      }
      
      .stat-number {
        animation: pulse 2s infinite;
        transition: all 0.3s;
      }
      
      .stat-card:hover .stat-number {
        animation: none;
        transform: scale(1.1);
        color: #0d6efd;
      }
      
      /* Enhanced Info Panel Styles */
      .card-info-panel {
        position: absolute;
        bottom: -180px;
        left: 50%;
        transform: translateX(-50%) scale(0.9);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 12px;
        font-size: 13px;
        width: 280px;
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
      }
      
      .stat-card:hover .card-info-panel {
        bottom: -170px;
        opacity: 1;
        transform: translateX(-50%) scale(1);
      }
      
      .info-panel-header {
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 12px;
        border-bottom: 2px solid rgba(255,255,255,0.3);
        padding-bottom: 8px;
      }
      
      .info-panel-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        padding: 6px;
        background: rgba(255,255,255,0.1);
        border-radius: 4px;
      }
      
      .info-panel-item:hover {
        background: rgba(255,255,255,0.2);
      }
      
      .info-panel-footer {
        margin-top: 12px;
        padding-top: 8px;
        border-top: 2px solid rgba(255,255,255,0.3);
        text-align: center;
        font-size: 11px;
        font-style: italic;
      }
      
      /* Table Row Fade In */
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
      }
      
      .table tbody tr {
        animation: fadeIn 0.5s ease-out;
      }
      
      /* Loading Spinner */
      .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
      }
      
      .loading-overlay.active {
        display: flex;
      }
      
      .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #0d6efd;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
      }
      
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      
      /* Filter Badge */
      .filter-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #0d6efd;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s;
      }
      
      .stat-card.active .filter-badge {
        opacity: 1;
      }
      
      /* Progress Bar */
      .progress-bar-custom {
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #0dcaf0);
        border-radius: 2px;
        margin-top: 8px;
        position: relative;
        overflow: hidden;
      }
      
      .progress-bar-custom::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: shimmer 2s infinite;
      }
      
      @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
      }
      
      /* Icon Rotation */
      .stat-card:hover .fa {
        animation: rotateIcon 0.6s ease-in-out;
      }
      
      @keyframes rotateIcon {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(15deg); }
      }
      
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
      }
      .badge.bg-warning:hover {
        background: #ff9800 !important;
        color: #fff !important;
        box-shadow: 0 4px 16px #ff980055;
      }
      .badge.bg-info {
        background: #29b6f6 !important;
        color: #212529 !important;
        box-shadow: 0 2px 8px #29b6f633;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      }
      .badge.bg-info:hover {
        background: #0288d1 !important;
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
      
      /* Table row hover selection color */
      .table-hover tbody tr:hover {
        background-color: #f5f5f5 !important;
        transition: background 0.2s;
      }
</style>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="spinner"></div>
</div>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0">
      <i class="fa fa-file-invoice-dollar"></i> Credit Sales Report
      <small class="text-muted fs-6" id="lastUpdated">Last updated: <?=date('M d, Y h:i A')?></small>
    </h2>
    <div class="d-flex gap-2">
      <button class="btn btn-success" onclick="exportData('csv')">
        <i class="fa fa-file-csv"></i> Export CSV
      </button>
      <button class="btn btn-danger" onclick="exportData('pdf')">
        <i class="fa fa-file-pdf"></i> Export PDF
      </button>
      <button class="btn btn-primary" onclick="refreshData()">
        <i class="fa fa-sync"></i> Refresh
      </button>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card stat-card text-center border-0 shadow-sm h-100" data-filter="all" onclick="filterTable('all')">
        <div class="card-body">
          <div class="filter-badge">ACTIVE</div>
          <div class="mb-2"><i class="fa fa-credit-card fa-2x text-warning"></i></div>
          <h5 class="card-title">Total Credit Sales</h5>
          <div class="display-6 fw-bold stat-number"><?=$totalCount?></div>
          <p class="text-muted mb-0">RWF <?=number_format($totalAmount, 2)?></p>
          <div class="progress-bar-custom" style="width: 100%"></div>
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-info-circle"></i> Total Credit Sales Summary
            </div>
            <div class="info-panel-item">
              <span>📊 Total Transactions:</span>
              <strong><?=$totalCount?></strong>
            </div>
            <div class="info-panel-item">
              <span>💰 Total Amount:</span>
              <strong>RWF <?=number_format($totalAmount, 2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📈 Average per Sale:</span>
              <strong>RWF <?=number_format($totalCount > 0 ? $totalAmount/$totalCount : 0, 2)?></strong>
            </div>
            <div class="info-panel-footer">
              💡 Click to view all credit sales
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card text-center border-0 shadow-sm h-100" data-filter="pending" onclick="filterTable('pending')">
        <div class="card-body">
          <div class="filter-badge">ACTIVE</div>
          <div class="mb-2"><i class="fa fa-hourglass-half fa-2x text-info"></i></div>
          <h5 class="card-title">Not Approved</h5>
          <div class="display-6 fw-bold stat-number"><?=$notApprovedCount?></div>
          <p class="text-muted mb-0">RWF <?=number_format($notApprovedAmount, 2)?></p>
          <div class="progress-bar-custom" style="width: <?=($totalCount > 0) ? round(($notApprovedCount/$totalCount)*100) : 0?>%"></div>
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-hourglass-half"></i> Not Approved Credits
            </div>
            <div class="info-panel-item">
              <span>⏳ Pending Count:</span>
              <strong><?=$notApprovedCount?></strong>
            </div>
            <div class="info-panel-item">
              <span>💵 Pending Amount:</span>
              <strong>RWF <?=number_format($notApprovedAmount, 2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📊 Percentage:</span>
              <strong><?=($totalCount > 0) ? round(($notApprovedCount/$totalCount)*100) : 0?>% of total</strong>
            </div>
            <div class="info-panel-footer">
              💡 Click to filter not approved credits
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card text-center border-0 shadow-sm h-100" data-filter="approved" onclick="filterTable('approved')">
        <div class="card-body">
          <div class="filter-badge">ACTIVE</div>
          <div class="mb-2"><i class="fa fa-thumbs-up fa-2x text-primary"></i></div>
          <h5 class="card-title">Approved</h5>
          <div class="display-6 fw-bold stat-number"><?=$approvedCount?></div>
          <p class="text-muted mb-0">RWF <?=number_format($approvedAmount, 2)?></p>
          <div class="progress-bar-custom" style="width: <?=($totalCount > 0) ? round(($approvedCount/$totalCount)*100) : 0?>%"></div>
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-thumbs-up"></i> Approved Credits Summary
            </div>
            <div class="info-panel-item">
              <span>✅ Approved Count:</span>
              <strong><?=$approvedCount?></strong>
            </div>
            <div class="info-panel-item">
              <span>💰 Approved Amount:</span>
              <strong>RWF <?=number_format($approvedAmount, 2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📊 Percentage:</span>
              <strong><?=($totalCount > 0) ? round(($approvedCount/$totalCount)*100) : 0?>% of total</strong>
            </div>
            <div class="info-panel-footer">
              💡 Click to filter approved credits only
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card stat-card text-center border-0 shadow-sm h-100" data-filter="overdue" onclick="filterTable('overdue')">
        <div class="card-body">
          <div class="filter-badge">ACTIVE</div>
          <div class="mb-2"><i class="fa fa-exclamation-triangle fa-2x text-danger"></i></div>
          <h5 class="card-title">Overdue Credits</h5>
          <div class="display-6 fw-bold stat-number"><?=$overdueCount?></div>
          <p class="text-muted mb-0">RWF <?=number_format($overdueAmount, 2)?></p>
          <div class="progress-bar-custom" style="width: <?=($totalCount > 0) ? round(($overdueCount/$totalCount)*100) : 0?>%"></div>
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-exclamation-triangle"></i> Overdue Credits Alert
            </div>
            <div class="info-panel-item">
              <span>⚠️ Overdue Count:</span>
              <strong><?=$overdueCount?></strong>
            </div>
            <div class="info-panel-item">
              <span>💸 Overdue Amount:</span>
              <strong>RWF <?=number_format($overdueAmount, 2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📊 Percentage:</span>
              <strong><?=($totalCount > 0) ? round(($overdueCount/$totalCount)*100) : 0?>% of total</strong>
            </div>
            <div class="info-panel-footer">
              ⚡ Requires immediate attention! Click to view
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card stat-card text-center border-0 shadow-sm h-100" data-filter="settled" onclick="filterTable('settled')">
        <div class="card-body">
          <div class="filter-badge">ACTIVE</div>
          <div class="mb-2"><i class="fa fa-check-circle fa-2x text-success"></i></div>
          <h5 class="card-title">Settled Credits</h5>
          <div class="display-6 fw-bold stat-number"><?=$settledCount?></div>
          <p class="text-muted mb-0">RWF <?=number_format($settledAmount, 2)?></p>
          <div class="progress-bar-custom" style="width: <?=($totalCount > 0) ? round(($settledCount/$totalCount)*100) : 0?>%"></div>
          <div class="card-info-panel">
            <div class="info-panel-header">
              <i class="fa fa-check-circle"></i> Settled Credits Summary
            </div>
            <div class="info-panel-item">
              <span>✔️ Settled Count:</span>
              <strong><?=$settledCount?></strong>
            </div>
            <div class="info-panel-item">
              <span>💵 Settled Amount:</span>
              <strong>RWF <?=number_format($settledAmount, 2)?></strong>
            </div>
            <div class="info-panel-item">
              <span>📊 Percentage:</span>
              <strong><?=($totalCount > 0) ? round(($settledCount/$totalCount)*100) : 0?>% of total</strong>
            </div>
            <div class="info-panel-footer">
              🎉 Successfully completed! Click to view
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Active Filter Display -->
  <div id="activeFilterBanner" class="alert alert-info alert-dismissible fade show d-none mb-3" role="alert">
    <i class="fa fa-filter"></i> <strong>Filter Active:</strong> Showing <span id="filterName"></span> credits only.
    <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="filterTable('all')">Clear Filter</button>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="filterTable('all')"></button>
  </div>

  <!-- Credit Sales Table -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle mb-0" id="creditSalesTable">
        <thead class="table-primary">
          <tr>
            <th><i class="fa fa-hashtag"></i> ID</th>
            <th><i class="fa fa-user"></i> Client</th>
            <th><i class="fa fa-box"></i> Product</th>
            <th><i class="fa fa-sort-numeric-up"></i> Qty</th>
            <th><i class="fa fa-money-bill"></i> Unit Price</th>
            <th><i class="fa fa-calculator"></i> Total</th>
            <th><i class="fa fa-wallet"></i> Amount Paid</th>
            <th><i class="fa fa-hand-holding-usd"></i> Balance</th>
            <th><i class="fa fa-calendar-plus"></i> Date Issued</th>
            <th><i class="fa fa-calendar-check"></i> Due Date</th>
            <th><i class="fa fa-info-circle"></i> Status</th>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager'): ?>
            <th><i class="fa fa-cog"></i> Actions</th>
            <?php endif; ?>
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
        
        if (empty($grouped_sales)):
        ?>
          <tr>
            <td colspan="<?=isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? '10' : '9'?>" class="text-center text-muted py-4">No credit sales found.</td>
          </tr>
        <?php else: ?>
          <?php foreach($grouped_sales as $group): ?>
            <!-- Client Header Row -->
            <tr class="client-header-row" style="background-color: #e3f2fd; border-left: 4px solid #1976d2;">
              <td colspan="<?=isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? '12' : '11'?>" class="fw-bold" style="color: #1565c0;">
                👤 <?=htmlspecialchars($group['client_name'])?> (<?=htmlspecialchars($group['client_phone'])?>)
              </td>
            </tr>
            <?php foreach($group['sales'] as $s):
              $rowClass = '';
              $badge = '';
              $status = strtolower(trim($s['status']));
              
              // Calculate balance
              $amountPaid = $s['amount_paid'] ?? 0;
              $balance = $s['total_price'] - $amountPaid;
              
              if ($status === 'overdue') {
                $badge = '<span class="badge rounded-pill bg-danger px-3 py-2"><i class="fa fa-exclamation-triangle me-1"></i> Overdue</span>';
              } elseif ($status === 'settled' || $status === 'paid') {
                $badge = '<span class="badge rounded-pill bg-success px-3 py-2"><i class="fa fa-check-circle me-1"></i> Paid</span>';
              } elseif ($status === 'partial_paid') {
                $badge = '<span class="badge rounded-pill bg-info text-dark px-3 py-2"><i class="fa fa-hourglass-half me-1"></i> Partial</span>';
              } elseif ($status === 'pending') {
                $badge = '<span class="badge rounded-pill bg-warning text-dark px-3 py-2"><i class="fa fa-hourglass-half me-1"></i> Pending</span>';
              } elseif ($status === 'approved') {
                $badge = '<span class="badge rounded-pill bg-info text-dark px-3 py-2"><i class="fa fa-thumbs-up me-1"></i> Approved</span>';
              } elseif ($status === 'rejected') {
                $badge = '<span class="badge rounded-pill bg-danger px-3 py-2"><i class="fa fa-times-circle me-1"></i> Rejected</span>';
              } else {
                $badge = '<span class="badge rounded-pill bg-secondary px-3 py-2">'.htmlspecialchars($s['status']).'</span>';
              }
            ?>
            <tr class="sale-row" data-status="<?=$status?>">
              <td><?=$s['credit_id']?></td>
              <td></td>
              <td>
                <i class="fa fa-box text-primary"></i> <?=isset($productNames[$s['product_id']]) ? htmlspecialchars($productNames[$s['product_id']]) : $s['product_id']?>
              </td>
              <td><?=$s['quantity']?></td>
              <td>RWF <?=number_format($s['unit_price'],2)?></td>
              <td>RWF <?=number_format($s['total_price'],2)?></td>
              <td><?=htmlspecialchars($s['date_issued'])?></td>
              <td><?=htmlspecialchars($s['due_date'])?></td>
              <td><?=$badge?></td>
              <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager'): ?>
              <td>
                <?php if($status === 'pending'): ?>
                  <!-- Approve Button -->
                  <a href="?r=credit/approve&id=<?=$s['credit_id']?>&redirect=<?=urlencode($_SERVER['REQUEST_URI'])?>" 
                     class="btn btn-success btn-sm" 
                     onclick="return confirm('Approve this credit sale?')" 
                     title="Approve">
                    <i class="fa fa-check"></i>
                  </a>
                  <!-- Reject Button -->
                  <button type="button" 
                          class="btn btn-danger btn-sm" 
                          data-bs-toggle="modal" 
                          data-bs-target="#rejectModal<?=$s['credit_id']?>" 
                          title="Reject">
                    <i class="fa fa-times"></i>
                  </button>
                  
                  <!-- Reject Modal -->
                  <div class="modal fade" id="rejectModal<?=$s['credit_id']?>" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form method="POST" action="?r=credit/reject">
                          <div class="modal-header">
                            <h5 class="modal-title">Reject Credit #<?=$s['credit_id']?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" name="credit_id" value="<?=$s['credit_id']?>">
                            <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>">
                            <div class="mb-3">
                              <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                              <textarea name="reason" class="form-control" rows="3" required placeholder="Enter reason for rejection..."></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Credit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php elseif($status === 'approved' || $status === 'rejected'): ?>
                  <!-- Edit Status (Reset to Pending) -->
                  <form method="POST" action="?r=credit/editStatus" style="display:inline;">
                    <input type="hidden" name="credit_id" value="<?=$s['credit_id']?>">
                    <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>">
                    <button type="submit" 
                            class="btn btn-warning btn-sm" 
                            onclick="return confirm('Reset this credit to pending status?')" 
                            title="Reset to Pending">
                      <i class="fa fa-edit"></i> Edit
                    </button>
                  </form>
                <?php else: ?>
                  <span class="text-muted small">-</span>
                <?php endif; ?>
              </td>
              <?php endif; ?>
            </tr>
            <?php if($status === 'rejected' && !empty($s['rejection_reason'])): ?>
              <tr class="table-warning sale-row" data-status="<?=$status?>">
                <td colspan="<?=isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? '10' : '9'?>">
                  <small><i class="fa fa-exclamation-circle"></i> <strong>Rejection Reason:</strong> <?=htmlspecialchars($s['rejection_reason'])?></small>
                </td>
              </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            <!-- Client Subtotal Row -->
            <tr class="subtotal-row" style="background-color: #fff3e0; border-left: 4px solid #ef6c00;" data-client="<?=htmlspecialchars($group['client_name'])?>">
              <td colspan="5" class="text-end fw-bold" style="color: #e65100;">🧮 Subtotal for <?=htmlspecialchars($group['client_name'])?>:</td>
              <td class="fw-bold subtotal-amount" style="color: #e65100;" data-original="<?=$group['total']?>">RWF <?=number_format($group['total'],2)?></td>
              <td colspan="<?=isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? '4' : '3'?>"></td>
            </tr>
          <?php endforeach; ?>
          <!-- Grand Total Row -->
          <tr class="grand-total-row" style="background-color: #e8f5e9; border-left: 4px solid #2e7d32;">
            <td colspan="5" class="text-end fw-bold fs-5 grand-total-label" style="color: #1b5e20;">💰 GRAND TOTAL:</td>
            <td class="fw-bold fs-5 grand-total-amount" style="color: #1b5e20;" data-original="<?=$totalAmount?>">RWF <?=number_format($totalAmount,2)?></td>
            <td colspan="<?=isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? '4' : '3'?>"></td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
// Global state
let activeFilter = 'all';

// Filter table by status
function filterTable(status) {
  activeFilter = status;
  
  // Show loading
  document.getElementById('loadingOverlay').classList.add('active');
  
  setTimeout(() => {
    const rows = document.querySelectorAll('.sale-row');
    const headers = document.querySelectorAll('.client-header-row');
    const subtotals = document.querySelectorAll('.subtotal-row');
    const grandTotalRow = document.querySelector('.grand-total-row');
    
    // Update active card
    document.querySelectorAll('.stat-card').forEach(card => {
      card.classList.remove('active');
      if (card.dataset.filter === status) {
        card.classList.add('active');
      }
    });
    
    // Show/hide filter banner
    const banner = document.getElementById('activeFilterBanner');
    const filterName = document.getElementById('filterName');
    
    let grandTotal = 0;
    
    if (status === 'all') {
      banner.classList.add('d-none');
      
      // Show all rows
      rows.forEach(row => row.style.display = '');
      headers.forEach(row => row.style.display = '');
      subtotals.forEach(row => row.style.display = '');
      
      // Reset all subtotals to original
      subtotals.forEach(subtotal => {
        const amountCell = subtotal.querySelector('.subtotal-amount');
        if (amountCell) {
          const originalAmount = parseFloat(amountCell.dataset.original || 0);
          amountCell.textContent = 'RWF ' + originalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
          grandTotal += originalAmount;
        }
      });
      
      // Reset grand total label and amount
      const grandTotalLabel = grandTotalRow.querySelector('.grand-total-label');
      const grandTotalAmount = grandTotalRow.querySelector('.grand-total-amount');
      if (grandTotalLabel) {
        grandTotalLabel.textContent = '💰 GRAND TOTAL:';
      }
      if (grandTotalAmount) {
        const originalTotal = parseFloat(grandTotalAmount.dataset.original || 0);
        grandTotalAmount.textContent = 'RWF ' + originalTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      }
      
    } else {
      banner.classList.remove('d-none');
      filterName.textContent = status.charAt(0).toUpperCase() + status.slice(1);
      
      // Filter rows
      rows.forEach(row => {
        const rowStatus = row.dataset.status;
        let shouldShow = false;
        
        // Handle "pending" filter to show all not-approved statuses
        if (status === 'pending') {
          shouldShow = rowStatus !== 'approved';
        } else {
          shouldShow = rowStatus === status;
        }
        
        row.style.display = shouldShow ? '' : 'none';
      });
      
      // Process each client group
      headers.forEach((header, index) => {
        let clientTotal = 0;
        let hasVisibleRows = false;
        let currentRow = header.nextElementSibling;
        
        // Calculate total for this client's visible rows
        while (currentRow && !currentRow.classList.contains('client-header-row')) {
          if (currentRow.classList.contains('sale-row')) {
            if (currentRow.style.display !== 'none') {
              hasVisibleRows = true;
              // Get amount from the 6th column (Total)
              const cells = currentRow.querySelectorAll('td');
              if (cells.length >= 6) {
                const amountText = cells[5].textContent.trim();
                const amount = parseFloat(amountText.replace(/[^0-9.-]+/g, ''));
                if (!isNaN(amount)) {
                  clientTotal += amount;
                }
              }
            }
          }
          currentRow = currentRow.nextElementSibling;
        }
        
        // Show/hide client header
        header.style.display = hasVisibleRows ? '' : 'none';
        
        // Update subtotal for this client
        const subtotal = subtotals[index];
        if (subtotal) {
          subtotal.style.display = hasVisibleRows ? '' : 'none';
          
          if (hasVisibleRows) {
            const amountCell = subtotal.querySelector('.subtotal-amount');
            if (amountCell) {
              amountCell.textContent = 'RWF ' + clientTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
              grandTotal += clientTotal;
            }
          }
        }
      });
      
      // Update grand total
      const grandTotalLabel = grandTotalRow.querySelector('.grand-total-label');
      const grandTotalAmount = grandTotalRow.querySelector('.grand-total-amount');
      
      if (grandTotalLabel) {
        const statusName = status.charAt(0).toUpperCase() + status.slice(1);
        grandTotalLabel.textContent = '💰 TOTAL (' + statusName + '):';
      }
      
      if (grandTotalAmount) {
        grandTotalAmount.textContent = 'RWF ' + grandTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
      }
    }
    
    // Hide loading
    document.getElementById('loadingOverlay').classList.remove('active');
    
    // Update URL without reload
    const url = new URL(window.location);
    url.searchParams.set('filter', status);
    window.history.pushState({}, '', url);
  }, 300);
}

// Export data
function exportData(format) {
  const filter = activeFilter !== 'all' ? '&filter=' + activeFilter : '';
  
  if (format === 'csv') {
    window.location.href = '?r=report/exportCreditSalesCsv' + filter;
  } else if (format === 'pdf') {
    window.open('?r=report/exportCreditSalesPdf' + filter, '_blank');
  }
}

// Refresh data
function refreshData() {
  document.getElementById('loadingOverlay').classList.add('active');
  
  setTimeout(() => {
    location.reload();
  }, 500);
}

// Auto-refresh every 5 minutes
setInterval(() => {
  const now = new Date();
  document.getElementById('lastUpdated').textContent = 'Last updated: ' + now.toLocaleString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    hour12: true
  });
}, 60000);

// Initialize filter from URL
window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const filter = urlParams.get('filter');
  
  if (filter && filter !== 'all') {
    filterTable(filter);
  }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
