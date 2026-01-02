<style>
  /* Stat Card Animations */
  .stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border: 2px solid transparent;
    overflow: hidden;
    position: relative;
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
  
  /* Info Panel */
  .card-info-panel {
    position: absolute;
    bottom: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 260px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;
    pointer-events: none;
  }
  .stat-card:hover .card-info-panel {
    bottom: -190px;
    opacity: 1;
    pointer-events: auto;
  }
  .card-info-panel:hover {
    bottom: -190px;
    opacity: 1;
    transform: translateX(-50%) scale(1);
  }
  .info-panel-header {
    font-weight: bold;
    font-size: 0.95rem;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 2px solid rgba(255,255,255,0.3);
  }
  .info-panel-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 8px;
    margin: 3px 0;
    background: rgba(255,255,255,0.1);
    border-radius: 6px;
    font-size: 0.85rem;
    transition: background 0.2s;
  }
  .info-panel-item:hover {
    background: rgba(255,255,255,0.2);
  }
  .info-panel-footer {
    margin-top: 8px;
    padding-top: 6px;
    border-top: 1px solid rgba(255,255,255,0.2);
    font-size: 0.8rem;
    text-align: center;
    opacity: 0.9;
  }
  
  /* Real-time update indicator */
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }
  .live-indicator {
    animation: pulse 2s infinite;
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #4caf50;
    border-radius: 50%;
    margin-right: 5px;
  }
</style>

<div class="mb-4">
  <h2 class="fw-bold mb-2">
    <i class="fa fa-tachometer-alt text-primary"></i> Welcome, <span class="text-success"><?=htmlspecialchars($_SESSION['user']['full_name'] ?? 'Manager')?></span>!
    <small class="text-muted fs-6 d-block mt-1">
      <span class="live-indicator"></span>
      <span id="lastUpdated" class="text-success">Last updated: <span id="currentTime"></span></span>
    </small>
  </h2>
  <p class="lead">Here's a quick overview of your shop's performance and actions.</p>
</div>

<?php if (!empty($showOverdueAlert)): ?>
  <div class="alert alert-danger shadow-sm"><b><i class="fa fa-exclamation-triangle"></i> Attention:</b> There are <?= (int)$overdueCount ?> overdue credits! Please review and take action.</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-money-bill-wave fa-2x text-danger"></i></div>
        <h5 class="card-title">Today's Expenses</h5>
        <div class="display-6 fw-bold text-danger">RWF <?= number_format($summary['todayExpenses'],2) ?></div>
        <small class="text-muted">Money taken from business</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-money-bill-wave"></i> Expenses Today
          </div>
          <div class="info-panel-item">
            <span>💸 Amount:</span>
            <strong>RWF <?= number_format($summary['todayExpenses'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Type:</span>
            <strong>Daily Expenses</strong>
          </div>
          <div class="info-panel-footer">
            💡 Track business costs
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-shopping-cart fa-2x text-primary"></i></div>
        <h5 class="card-title">Today's Purchases</h5>
        <div class="display-6 fw-bold text-primary">RWF <?= number_format($summary['todayPurchases'],2) ?></div>
        <small class="text-muted">Money spent to buy items</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-shopping-cart"></i> Purchases Today
          </div>
          <div class="info-panel-item">
            <span>🛒 Amount:</span>
            <strong>RWF <?= number_format($summary['todayPurchases'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-item">
            <span>📦 Type:</span>
            <strong>Inventory Buys</strong>
          </div>
          <div class="info-panel-footer">
            💡 Stock investment
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-credit-card fa-2x text-success"></i></div>
        <h5 class="card-title">Today's Credit Sales</h5>
        <div class="display-6 fw-bold text-success">RWF <?= number_format($summary['todayCreditSales'],2) ?></div>
        <small class="text-muted"><?= (int)$summary['todayCreditCount'] ?> credit sale(s)</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-credit-card"></i> Credits Today
          </div>
          <div class="info-panel-item">
            <span>💰 Amount:</span>
            <strong>RWF <?= number_format($summary['todayCreditSales'],2) ?></strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Count:</span>
            <strong><?= (int)$summary['todayCreditCount'] ?> sales</strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-footer">
            💡 Sales on credit
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
        <h5 class="card-title">Active Credits</h5>
        <div class="display-6 fw-bold text-warning"><?= (int)$summary['activeCredits'] ?></div>
        <small class="text-muted"><?= (int)$summary['totalClients'] ?> total clients</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-clock"></i> Active Credits
          </div>
          <div class="info-panel-item">
            <span>⏰ Active:</span>
            <strong><?= (int)$summary['activeCredits'] ?> credits</strong>
          </div>
          <div class="info-panel-item">
            <span>👥 Clients:</span>
            <strong><?= (int)$summary['totalClients'] ?> total</strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Status:</span>
            <strong>Pending Payment</strong>
          </div>
          <div class="info-panel-footer">
            💡 Outstanding credits
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="mb-4">
  <div class="card p-3 shadow-sm border-0">
    <h5 class="text-center mb-3"><i class="fa fa-bolt text-warning"></i> Quick Actions</h5>
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <a href="?r=purchase/create" class="btn btn-primary"><i class="fa fa-cart-plus"></i> New Purchase</a>
      <a href="?r=expense/create" class="btn btn-danger"><i class="fa fa-money-bill-wave"></i> New Expense</a>
      <a href="?r=credit/create" class="btn btn-success"><i class="fa fa-credit-card"></i> New Credit Sale</a>
      <a href="?r=product/create" class="btn btn-secondary"><i class="fa fa-box"></i> New Product</a>
      <a href="?r=report/profit" class="btn btn-dark"><i class="fa fa-chart-line"></i> Financial Report</a>
      <a href="?r=credit/index" class="btn btn-warning"><i class="fa fa-list"></i> View Credits</a>
    </div>
  </div>
</div>

<!-- Charts & Trends -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0"><i class="fa fa-chart-bar text-primary"></i> Sales & Purchases Trend (Last 7 Days)</h5>
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary active" onclick="updateChartView('both')">Both</button>
            <button type="button" class="btn btn-outline-success" onclick="updateChartView('sales')">Sales</button>
            <button type="button" class="btn btn-outline-info" onclick="updateChartView('purchases')">Purchases</button>
          </div>
        </div>
        
        <!-- Chart Container -->
        <div style="position: relative; height: 300px;">
          <canvas id="trendChart"></canvas>
        </div>
        
        <!-- Legend & Stats -->
        <div class="row mt-3 text-center">
          <div class="col-6">
            <div class="p-2 bg-success bg-opacity-10 rounded">
              <i class="fa fa-arrow-up text-success"></i>
              <strong class="text-success">Total Sales:</strong>
              <span id="totalSales">RWF <?=number_format(array_sum(array_column($trendData, 'sales')), 2)?></span>
            </div>
          </div>
          <div class="col-6">
            <div class="p-2 bg-primary bg-opacity-10 rounded">
              <i class="fa fa-shopping-cart text-primary"></i>
              <strong class="text-primary">Total Purchases:</strong>
              <span id="totalPurchases">RWF <?=number_format(array_sum(array_column($trendData, 'purchases')), 2)?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h5 class="card-title mb-3">
          <i class="fa fa-bell text-warning"></i> Notifications
          <?php if(!empty($notifications)): ?>
            <span class="badge bg-danger ms-2"><?= count($notifications) ?></span>
          <?php endif; ?>
        </h5>
        <style>
          .notification-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            cursor: pointer;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
          }
          .notification-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
          }
          .notification-item.danger {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0e0 100%);
          }
          .notification-item.warning {
            border-left-color: #ffc107;
            background: linear-gradient(135deg, #fffef5 0%, #fff4d9 100%);
          }
          .notification-item.info {
            border-left-color: #17a2b8;
            background: linear-gradient(135deg, #f0faff 0%, #d9f2ff 100%);
          }
          .notification-item.success {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #f0fff4 0%, #d4edda 100%);
          }
          .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
          }
          .notification-icon.danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
          }
          .notification-icon.warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #000;
          }
          .notification-icon.info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
          }
          .notification-icon.success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            color: white;
          }
          .notification-content {
            flex: 1;
            padding-left: 12px;
          }
          .notification-title {
            font-weight: 600;
            margin-bottom: 2px;
            font-size: 14px;
          }
          .notification-message {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
          }
          .notification-time {
            font-size: 11px;
            color: #adb5bd;
          }
          .notification-action {
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
          }
          .notification-action:hover {
            text-decoration: underline;
          }
          .notification-empty {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
          }
          .notification-empty i {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 12px;
            display: block;
          }
          .notifications-container {
            max-height: 400px;
            overflow-y: auto;
          }
          .notifications-container::-webkit-scrollbar {
            width: 6px;
          }
          .notifications-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
          }
          .notifications-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
          }
          .notifications-container::-webkit-scrollbar-thumb:hover {
            background: #555;
          }
          
          /* Dark Mode Styles */
          body.dark-mode .notification-item.danger {
            background: linear-gradient(135deg, #4a1f23 0%, #3d1a1e 100%);
            border-left-color: #ea868f;
          }
          
          body.dark-mode .notification-item.warning {
            background: linear-gradient(135deg, #4a3f1f 0%, #3d341a 100%);
            border-left-color: #ffc107;
          }
          
          body.dark-mode .notification-item.info {
            background: linear-gradient(135deg, #1a3d4a 0%, #163440 100%);
            border-left-color: #6dd5ed;
          }
          
          body.dark-mode .notification-item.success {
            background: linear-gradient(135deg, #1a3d2e 0%, #163429 100%);
            border-left-color: #4ade80;
          }
          
          body.dark-mode .notification-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
          }
          
          body.dark-mode .notification-title {
            color: #e0e0e0;
          }
          
          body.dark-mode .notification-message {
            color: #9ca3af;
          }
          
          body.dark-mode .notification-time {
            color: #6b7280;
          }
          
          body.dark-mode .notification-empty {
            color: #9ca3af;
          }
          
          body.dark-mode .notification-empty i {
            color: #4ade80;
          }
          
          body.dark-mode .notifications-container::-webkit-scrollbar-track {
            background: #2d3748;
          }
          
          body.dark-mode .notifications-container::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
          }
          
          body.dark-mode .notifications-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
          }
        </style>
        <div class="notifications-container">
          <?php if(!empty($notifications)): ?>
            <?php foreach($notifications as $notification): ?>
              <div class="notification-item <?= $notification['type'] ?> p-2">
                <div class="d-flex align-items-start">
                  <div class="notification-icon <?= $notification['type'] ?>">
                    <i class="fa <?= $notification['icon'] ?>"></i>
                  </div>
                  <div class="notification-content">
                    <div class="notification-title"><?= $notification['title'] ?></div>
                    <div class="notification-message"><?= $notification['message'] ?></div>
                    <div class="notification-time">
                      <i class="fa fa-clock"></i> <?= $notification['time'] ?>
                    </div>
                    <?php if(!empty($notification['action'])): ?>
                      <a href="<?= $notification['action'] ?>" class="notification-action text-<?= $notification['type'] ?>">
                        View Details <i class="fa fa-arrow-right"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="notification-empty">
              <i class="fa fa-check-circle"></i>
              <div class="fw-bold">All Caught Up!</div>
              <small>No pending notifications at the moment.</small>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Overdue Credits Section -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="fa fa-exclamation-triangle"></i> Overdue Credits
        <?php if(!empty($overdue)): ?>
          <span class="badge bg-danger ms-2"><?= count($overdue) ?></span>
        <?php endif; ?>
      </h5>
      <?php if(!empty($overdue)): ?>
        <span class="badge bg-white text-danger">
          Total: RWF <?= number_format(array_sum(array_column($overdue, 'balance')), 2) ?>
        </span>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-body">
    <style>
      .overdue-empty {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f0fff4 0%, #d4edda 100%);
        border-radius: 12px;
        border: 2px dashed #28a745;
      }
      body.dark-mode .overdue-empty {
        background: linear-gradient(135deg, #1a3d2e 0%, #2d4a3e 100%);
        border-color: #4ade80;
      }
      .overdue-empty i {
        font-size: 64px;
        color: #28a745;
        margin-bottom: 16px;
        display: block;
      }
      body.dark-mode .overdue-empty i {
        color: #4ade80;
      }
      body.dark-mode .overdue-empty .h4 {
        color: #4ade80 !important;
      }
      body.dark-mode .overdue-empty p {
        color: #9ca3af !important;
      }
      .overdue-row {
        transition: all 0.3s ease;
        cursor: pointer;
      }
      .overdue-row:hover {
        background-color: #fff5f5 !important;
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
      }
      body.dark-mode .overdue-row:hover {
        background-color: #3d2a2e !important;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
      }
      body.dark-mode .table-hover tbody tr:hover {
        background-color: #2d3748 !important;
      }
      .days-overdue {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
      }
      .days-overdue.critical {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        animation: pulse 2s infinite;
      }
      .days-overdue.warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #000;
      }
      body.dark-mode .days-overdue.warning {
        color: #1a1a1a;
      }
      .days-overdue.moderate {
        background: linear-gradient(135deg, #fd7e14 0%, #dc6502 100%);
        color: white;
      }
      @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
      }
      .action-btn-group {
        display: flex;
        gap: 6px;
      }
      .balance-indicator {
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 13px;
      }
      .balance-high {
        background: #ffe0e0;
        color: #dc3545;
      }
      body.dark-mode .balance-high {
        background: #4a1f23;
        color: #ff6b6b;
      }
      .balance-medium {
        background: #fff4d9;
        color: #e0a800;
      }
      body.dark-mode .balance-medium {
        background: #4a3f1f;
        color: #fbbf24;
      }
      .balance-low {
        background: #d9f2ff;
        color: #138496;
      }
      body.dark-mode .balance-low {
        background: #1a3a4a;
        color: #6dd5ed;
      }
      body.dark-mode .card-header.bg-gradient {
        opacity: 0.95;
      }
      body.dark-mode .table-light {
        background: #2d3748 !important;
      }
      body.dark-mode .table-light th {
        color: #e0e0e0 !important;
      }
      body.dark-mode .modal-content {
        background: #23272b !important;
        color: #e0e0e0 !important;
      }
      body.dark-mode .modal-header {
        border-bottom-color: #444 !important;
      }
      body.dark-mode .modal-footer {
        border-top-color: #444 !important;
      }
      body.dark-mode .alert-info {
        background: #1a3d4a !important;
        color: #6dd5ed !important;
        border-color: #2a5d6a !important;
      }
    </style>

    <?php if(empty($overdue)): ?>
      <div class="overdue-empty">
        <i class="fa fa-check-circle"></i>
        <div class="h4 fw-bold text-success mb-2">Excellent!</div>
        <p class="text-muted mb-0">No overdue credits at the moment. All payments are on track.</p>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th><i class="fa fa-hashtag"></i> ID</th>
              <th><i class="fa fa-user"></i> Client</th>
              <th><i class="fa fa-phone"></i> Contact</th>
              <th><i class="fa fa-money-bill"></i> Total Price</th>
              <th><i class="fa fa-check-circle"></i> Paid</th>
              <th><i class="fa fa-exclamation-circle"></i> Balance</th>
              <th><i class="fa fa-calendar-times"></i> Due Date</th>
              <th><i class="fa fa-clock"></i> Days Overdue</th>
              <th><i class="fa fa-cog"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($overdue as $cr): 
            $dueDate = new DateTime($cr['due_date']);
            $today = new DateTime();
            $daysOverdue = $today->diff($dueDate)->days;
            $daysClass = $daysOverdue > 30 ? 'critical' : ($daysOverdue > 14 ? 'moderate' : 'warning');
            
            $balance = $cr['balance'] ?? ($cr['total_price'] - ($cr['amount_paid'] ?? 0));
            $balanceClass = $balance > 50000 ? 'balance-high' : ($balance > 20000 ? 'balance-medium' : 'balance-low');
          ?>
            <tr class="overdue-row">
              <td class="fw-bold">#<?= $cr['credit_id'] ?></td>
              <td>
                <div class="fw-bold"><?= htmlspecialchars($cr['client_name'] ?? $cr['name'] ?? '') ?></div>
                <small class="text-muted">ID: <?= $cr['client_id'] ?></small>
              </td>
              <td>
                <i class="fa fa-phone-alt text-primary"></i>
                <?= htmlspecialchars($cr['phone']) ?>
              </td>
              <td class="fw-bold">RWF <?= number_format($cr['total_price'], 2) ?></td>
              <td class="text-success">
                <i class="fa fa-check-circle"></i>
                RWF <?= number_format($cr['amount_paid'] ?? 0, 2) ?>
              </td>
              <td>
                <span class="balance-indicator <?= $balanceClass ?>">
                  RWF <?= number_format($balance, 2) ?>
                </span>
              </td>
              <td>
                <i class="fa fa-calendar text-danger"></i>
                <?= date('M d, Y', strtotime($cr['due_date'])) ?>
              </td>
              <td>
                <span class="days-overdue <?= $daysClass ?>">
                  <i class="fa fa-exclamation-triangle"></i>
                  <?= $daysOverdue ?> day<?= $daysOverdue > 1 ? 's' : '' ?>
                </span>
              </td>
              <td>
                <div class="action-btn-group">
                  <a href="?r=credits/view&id=<?= $cr['credit_id'] ?>" class="btn btn-sm btn-primary" title="View Details">
                    <i class="fa fa-eye"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-success" 
                          data-bs-toggle="modal" 
                          data-bs-target="#paymentModal<?= $cr['credit_id'] ?>"
                          title="Record Payment">
                    <i class="fa fa-money-bill-wave"></i>
                  </button>
                  <a href="tel:<?= htmlspecialchars($cr['phone']) ?>" class="btn btn-sm btn-warning" title="Call Client">
                    <i class="fa fa-phone"></i>
                  </a>
                </div>

                <!-- Payment Modal -->
                <div class="modal fade" id="paymentModal<?= $cr['credit_id'] ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                          <i class="fa fa-money-bill-wave"></i> Record Payment
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                      </div>
                      <form method="POST" action="?r=payment/record">
                        <div class="modal-body">
                          <input type="hidden" name="credit_id" value="<?= $cr['credit_id'] ?>">
                          <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                          
                          <div class="alert alert-info">
                            <strong>Client:</strong> <?= htmlspecialchars($cr['client_name'] ?? '') ?><br>
                            <strong>Total Price:</strong> RWF <?= number_format($cr['total_price'], 2) ?><br>
                            <strong>Already Paid:</strong> RWF <?= number_format($cr['amount_paid'] ?? 0, 2) ?><br>
                            <strong>Balance:</strong> RWF <?= number_format($balance, 2) ?>
                          </div>

                          <div class="mb-3">
                            <label class="form-label">Payment Amount <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="amount" 
                                   class="form-control" 
                                   step="0.01" 
                                   min="0.01" 
                                   max="<?= $balance ?>"
                                   required
                                   placeholder="Enter amount (max: RWF <?= number_format($balance, 2) ?>)">
                          </div>

                          <div class="mb-3">
                            <label class="form-label">Remarks (Optional)</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="Add any notes about this payment..."></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Cancel
                          </button>
                          <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Record Payment
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot class="table-light">
            <tr class="fw-bold">
              <td colspan="3" class="text-end">TOTALS:</td>
              <td>RWF <?= number_format(array_sum(array_column($overdue, 'total_price')), 2) ?></td>
              <td class="text-success">RWF <?= number_format(array_sum(array_column($overdue, 'amount_paid')), 2) ?></td>
              <td class="text-danger">RWF <?= number_format(array_sum(array_map(function($cr) {
                return $cr['balance'] ?? ($cr['total_price'] - ($cr['amount_paid'] ?? 0));
              }, $overdue)), 2) ?></td>
              <td colspan="3"></td>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Recent Activity -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-gradient text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="fa fa-history me-2 pulse-icon"></i> Recent Activity
        <span class="live-pulse ms-2"></span>
      </h5>
      <div class="d-flex gap-2 align-items-center">
        <span class="badge bg-white text-primary fw-bold px-3">
          <i class="fa fa-list"></i> <?= count($recentActivity) ?> activities
        </span>
        <button class="btn btn-sm btn-light" onclick="refreshActivity()" title="Refresh">
          <i class="fa fa-sync-alt" id="refreshIcon"></i>
        </button>
      </div>
    </div>
    <!-- Animated background wave -->
    <div class="wave-background"></div>
  </div>
  
  <!-- Filter Tabs -->
  <div class="activity-filters bg-light border-bottom">
    <div class="btn-group w-100" role="group">
      <button type="button" class="btn btn-sm btn-outline-primary filter-btn active" data-filter="all">
        <i class="fa fa-globe"></i> All
      </button>
      <button type="button" class="btn btn-sm btn-outline-success filter-btn" data-filter="success">
        <i class="fa fa-check-circle"></i> Success
      </button>
      <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-filter="primary">
        <i class="fa fa-credit-card"></i> Sales
      </button>
      <button type="button" class="btn btn-sm btn-outline-warning filter-btn" data-filter="warning">
        <i class="fa fa-box"></i> Products
      </button>
      <button type="button" class="btn btn-sm btn-outline-danger filter-btn" data-filter="danger">
        <i class="fa fa-exclamation-circle"></i> Critical
      </button>
    </div>
  </div>
  
  <div class="card-body p-0">
    <style>
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      @keyframes slideInRight {
        from {
          opacity: 0;
          transform: translateX(-30px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
      @keyframes pulseIcon {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
      }
      @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
      }
      @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
      }
      @keyframes wave {
        0% { transform: translateX(0) translateZ(0) scaleY(1); }
        50% { transform: translateX(-25%) translateZ(0) scaleY(0.55); }
        100% { transform: translateX(-50%) translateZ(0) scaleY(1); }
      }
      
      .pulse-icon {
        animation: pulseIcon 2s ease-in-out infinite;
      }
      
      .live-pulse {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #4ade80;
        border-radius: 50%;
        animation: pulse 2s infinite;
        box-shadow: 0 0 10px #4ade80;
      }
      
      .wave-background {
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: wave 8s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite;
      }
      
      .activity-filters {
        padding: 10px;
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(10px);
      }
      
      body.dark-mode .activity-filters {
        background: #2d3748 !important;
        border-bottom-color: #4a5568 !important;
      }
      
      .filter-btn {
        transition: all 0.3s ease;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 600;
        color: inherit !important;
      }
      
      .filter-btn.btn-outline-primary {
        color: #0d6efd !important;
      }
      
      .filter-btn.btn-outline-success {
        color: #198754 !important;
      }
      
      .filter-btn.btn-outline-warning {
        color: #ffc107 !important;
      }
      
      .filter-btn.btn-outline-danger {
        color: #dc3545 !important;
      }
      
      body.dark-mode .filter-btn.btn-outline-primary {
        color: #6ea8fe !important;
      }
      
      body.dark-mode .filter-btn.btn-outline-success {
        color: #75b798 !important;
      }
      
      body.dark-mode .filter-btn.btn-outline-warning {
        color: #ffc107 !important;
      }
      
      body.dark-mode .filter-btn.btn-outline-danger {
        color: #ea868f !important;
      }
      
      .filter-btn:hover {
        transform: translateY(-2px);
        opacity: 0.9;
      }
      
      .filter-btn.active {
        background: white;
        border-bottom-color: currentColor;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      
      body.dark-mode .filter-btn.active {
        background: #1a202c !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      }
      
      .activity-timeline {
        position: relative;
        padding: 0;
        margin: 0;
        list-style: none;
        max-height: 600px;
        overflow-y: auto;
      }
      
      .activity-timeline::-webkit-scrollbar {
        width: 8px;
      }
      
      .activity-timeline::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
      }
      
      .activity-timeline::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
      }
      
      .activity-timeline::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
      }
      
      .activity-item {
        position: relative;
        padding: 20px 20px 20px 70px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
        opacity: 0;
      }
      
      .activity-item:nth-child(1) { animation-delay: 0.05s; }
      .activity-item:nth-child(2) { animation-delay: 0.1s; }
      .activity-item:nth-child(3) { animation-delay: 0.15s; }
      .activity-item:nth-child(4) { animation-delay: 0.2s; }
      .activity-item:nth-child(5) { animation-delay: 0.25s; }
      
      .activity-item:last-child {
        border-bottom: none;
      }
      
      .activity-item:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, #ffffff 100%);
        transform: translateX(10px) scale(1.01);
        box-shadow: -5px 0 20px rgba(102, 126, 234, 0.1);
        border-left: 4px solid #667eea;
      }
      
      body.dark-mode .activity-item {
        border-bottom-color: #374151;
      }
      
      body.dark-mode .activity-item:hover {
        background: linear-gradient(90deg, rgba(139, 92, 246, 0.1) 0%, #23272b 100%);
        box-shadow: -5px 0 20px rgba(139, 92, 246, 0.2);
        border-left-color: #a78bfa;
      }
      
      .activity-item.hidden {
        display: none;
      }
      
      .activity-icon-wrapper {
        position: absolute;
        left: 20px;
        top: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: all 0.4s ease;
        z-index: 1;
      }
      
      .activity-icon-wrapper::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: inherit;
        animation: pulse 2s infinite;
        z-index: -1;
      }
      
      .activity-item:hover .activity-icon-wrapper {
        transform: scale(1.2) rotate(10deg);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      }
      
      .activity-icon-wrapper.info {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      }
      .activity-icon-wrapper.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }
      .activity-icon-wrapper.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      }
      .activity-icon-wrapper.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      }
      .activity-icon-wrapper.danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      }
      .activity-icon-wrapper.secondary {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
      }
      
      .activity-content {
        flex: 1;
        position: relative;
      }
      
      .activity-action {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        font-size: 15px;
        transition: all 0.3s ease;
      }
      
      body.dark-mode .activity-action {
        color: #e0e0e0;
      }
      
      .activity-item:hover .activity-action {
        color: #667eea;
      }
      
      body.dark-mode .activity-item:hover .activity-action {
        color: #a78bfa;
      }
      
      .activity-description {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-family: 'Courier New', monospace;
      }
      
      body.dark-mode .activity-description {
        color: #9ca3af;
      }
      
      .activity-meta {
        font-size: 12px;
        color: #9ca3af;
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
      }
      
      body.dark-mode .activity-meta {
        color: #6b7280;
      }
      
      .activity-user {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: #f3f4f6;
        border-radius: 20px;
        transition: all 0.3s ease;
        color: #374151;
      }
      
      body.dark-mode .activity-user {
        background: #374151;
        color: #d1d5db;
      }
      
      .activity-item:hover .activity-user {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.05);
      }
      
      body.dark-mode .activity-item:hover .activity-user {
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
      }
      
      .activity-time {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: #fef3c7;
        border-radius: 20px;
        color: #92400e;
        font-weight: 500;
      }
      
      body.dark-mode .activity-time {
        background: #4a3f1f;
        color: #fbbf24;
      }
      
      .activity-time i {
        animation: pulse 2s infinite;
      }
      
      .activity-empty {
        text-align: center;
        padding: 80px 40px;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 20px;
        margin: 20px;
        position: relative;
        overflow: hidden;
      }
      
      .activity-empty::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        animation: shimmer 3s infinite;
      }
      
      .activity-empty i {
        font-size: 80px;
        color: #667eea;
        margin-bottom: 20px;
        display: block;
        animation: float 3s ease-in-out infinite;
      }
      
      body.dark-mode .activity-empty i {
        color: #a78bfa;
      }
      
      .activity-empty .h5 {
        color: #6b7280;
      }
      
      body.dark-mode .activity-empty .h5 {
        color: #9ca3af;
      }
      
      .activity-empty p {
        color: #9ca3af;
      }
      
      body.dark-mode .activity-empty p {
        color: #6b7280;
      }
      
      .user-role-badge {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
      }
      
      .activity-item:hover .user-role-badge {
        transform: scale(1.1);
      }
      
      .role-manager {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #78350f;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
      }
      
      .role-staff {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
      }
      
      .refresh-spin {
        animation: spin 0.5s linear;
      }
      
      @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
      }
    </style>
    
    <script>
      function refreshActivity() {
        const icon = document.getElementById('refreshIcon');
        icon.classList.add('refresh-spin');
        setTimeout(() => {
          location.reload();
        }, 500);
      }
      
      document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const activityItems = document.querySelectorAll('.activity-item');
        
        filterBtns.forEach(btn => {
          btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            activityItems.forEach(item => {
              if (filter === 'all') {
                item.classList.remove('hidden');
              } else {
                const iconWrapper = item.querySelector('.activity-icon-wrapper');
                if (iconWrapper && iconWrapper.classList.contains(filter)) {
                  item.classList.remove('hidden');
                } else {
                  item.classList.add('hidden');
                }
              }
            });
          });
        });
      });
    </script>

    <?php if(empty($recentActivity)): ?>
      <div class="activity-empty">
        <i class="fa fa-inbox"></i>
        <div class="h5 fw-bold text-muted mb-2">No Activity Yet</div>
        <p class="text-muted mb-0">System activities will appear here as they happen.</p>
      </div>
    <?php else: ?>
      <ul class="activity-timeline">
        <?php foreach($recentActivity as $activity): 
          $timeAgo = '';
          $timestamp = strtotime($activity['created_at']);
          $diff = time() - $timestamp;
          
          if ($diff < 60) {
            $timeAgo = 'Just now';
          } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            $timeAgo = $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
          } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            $timeAgo = $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
          } elseif ($diff < 172800) {
            $timeAgo = 'Yesterday at ' . date('g:i A', $timestamp);
          } else {
            $timeAgo = date('M d, Y • g:i A', $timestamp);
          }
        ?>
          <li class="activity-item">
            <div class="activity-icon-wrapper <?= $activity['color'] ?>">
              <i class="fa <?= $activity['icon'] ?>"></i>
            </div>
            <div class="activity-content">
              <div class="activity-action"><?= htmlspecialchars($activity['action']) ?></div>
              <?php if(!empty($activity['description'])): ?>
                <div class="activity-description"><?= htmlspecialchars($activity['description']) ?></div>
              <?php endif; ?>
              <div class="activity-meta">
                <span class="activity-user">
                  <i class="fa fa-user"></i>
                  <strong><?= htmlspecialchars($activity['user_name']) ?></strong>
                  <span class="user-role-badge role-<?= strtolower($activity['user_role']) ?>">
                    <?= $activity['user_role'] ?>
                  </span>
                </span>
                <span class="activity-time">
                  <i class="fa fa-clock"></i>
                  <?= $timeAgo ?>
                </span>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Trend data from PHP
const trendData = <?=json_encode($trendData)?>;
const labels = trendData.map(d => d.day + ' ' + d.date.substring(5));
const salesData = trendData.map(d => parseFloat(d.sales));
const purchasesData = trendData.map(d => parseFloat(d.purchases));

// Chart configuration
const ctx = document.getElementById('trendChart').getContext('2d');
let trendChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Credit Sales (RWF)',
        data: salesData,
        borderColor: '#28a745',
        backgroundColor: 'rgba(40, 167, 69, 0.1)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: '#28a745',
        pointBorderColor: '#fff',
        pointBorderWidth: 2
      },
      {
        label: 'Purchases (RWF)',
        data: purchasesData,
        borderColor: '#007bff',
        backgroundColor: 'rgba(0, 123, 255, 0.1)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: '#007bff',
        pointBorderColor: '#fff',
        pointBorderWidth: 2
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
      mode: 'index',
      intersect: false
    },
    plugins: {
      legend: {
        display: true,
        position: 'top',
        labels: {
          usePointStyle: true,
          padding: 15,
          font: {
            size: 12,
            weight: 'bold'
          }
        }
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.8)',
        padding: 12,
        titleFont: {
          size: 14,
          weight: 'bold'
        },
        bodyFont: {
          size: 13
        },
        callbacks: {
          label: function(context) {
            let label = context.dataset.label || '';
            if (label) {
              label += ': ';
            }
            label += 'RWF ' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            return label;
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function(value) {
            return 'RWF ' + value.toLocaleString();
          },
          font: {
            size: 11
          }
        },
        grid: {
          color: 'rgba(0, 0, 0, 0.05)'
        }
      },
      x: {
        grid: {
          display: false
        },
        ticks: {
          font: {
            size: 11
          }
        }
      }
    }
  }
});

// Update chart view
function updateChartView(view) {
  // Update button states
  const buttons = document.querySelectorAll('.btn-group button');
  buttons.forEach(btn => btn.classList.remove('active'));
  event.target.classList.add('active');
  
  // Update chart visibility
  if (view === 'both') {
    trendChart.data.datasets[0].hidden = false;
    trendChart.data.datasets[1].hidden = false;
  } else if (view === 'sales') {
    trendChart.data.datasets[0].hidden = false;
    trendChart.data.datasets[1].hidden = true;
  } else if (view === 'purchases') {
    trendChart.data.datasets[0].hidden = true;
    trendChart.data.datasets[1].hidden = false;
  }
  
  trendChart.update();
}

// Function to update time
function updateTime() {
  const now = new Date();
  const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
  document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
}

// Set initial time immediately
updateTime();

// Auto-refresh timestamp every minute
setInterval(updateTime, 60000);
</script>
