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
    <i class="fa fa-tachometer-alt text-primary"></i> Welcome, <span class="text-success"><?=htmlspecialchars($_SESSION['user']['full_name'] ?? 'Staff')?></span>!
    <small class="text-muted fs-6 d-block mt-1">
      <span class="live-indicator"></span>
      <span id="lastUpdated">Last updated: <?=date('M d, Y h:i A')?></span>
    </small>
  </h2>
  <p class="lead">Here's your daily summary and quick actions.</p>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-credit-card fa-2x text-success"></i></div>
        <h5 class="card-title">Today's Credit Sales</h5>
        <div class="display-6 fw-bold text-success">RWF <?= number_format($summary['todayCreditSales'],2) ?></div>
        <small class="text-muted"><?= (int)$summary['todayCreditCount'] ?> sale(s)</small>
        
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
            💡 Today's credit sales
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-clock fa-2x text-warning"></i></div>
        <h5 class="card-title">Active Credits</h5>
        <div class="display-6 fw-bold text-warning"><?= (int)$summary['activeCredits'] ?></div>
        <small class="text-muted">Pending payments</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-clock"></i> Active Credits
          </div>
          <div class="info-panel-item">
            <span>⏰ Active:</span>
            <strong><?= (int)$summary['activeCredits'] ?> credits</strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Status:</span>
            <strong>Pending Payment</strong>
          </div>
          <div class="info-panel-item">
            <span>📅 Date:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-footer">
            💡 Outstanding credits
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card text-center border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="mb-2"><i class="fa fa-users fa-2x text-info"></i></div>
        <h5 class="card-title">Total Clients</h5>
        <div class="display-6 fw-bold text-info"><?= (int)$summary['totalClients'] ?></div>
        <small class="text-muted">In database</small>
        
        <div class="card-info-panel">
          <div class="info-panel-header">
            <i class="fa fa-users"></i> Client Database
          </div>
          <div class="info-panel-item">
            <span>👥 Total:</span>
            <strong><?= (int)$summary['totalClients'] ?> clients</strong>
          </div>
          <div class="info-panel-item">
            <span>📊 Status:</span>
            <strong>Registered</strong>
          </div>
          <div class="info-panel-item">
            <span>📅 As of:</span>
            <strong><?=date('M d, Y')?></strong>
          </div>
          <div class="info-panel-footer">
            💡 All registered clients
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
      <a href="?r=credit/create" class="btn btn-success"><i class="fa fa-credit-card"></i> New Credit Sale</a>
      <a href="?r=credit/index" class="btn btn-primary"><i class="fa fa-list"></i> View Credits</a>
      <a href="?r=product/index" class="btn btn-secondary"><i class="fa fa-box"></i> View Products</a>
      <a href="?r=client/index" class="btn btn-info"><i class="fa fa-users"></i> View Clients</a>
    </div>
  </div>
</div>

<!-- Charts & Trends -->
<div class="row g-3 mb-4">
  <div class="col-md-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0"><i class="fa fa-chart-bar text-primary"></i> Sales Trend (Last 7 Days)</h5>
          <button type="button" class="btn btn-sm btn-outline-success">
            <i class="fa fa-sync"></i> Refresh
          </button>
        </div>
        
        <!-- Chart Container -->
        <div style="position: relative; height: 300px;">
          <canvas id="salesTrendChart"></canvas>
        </div>
        
        <!-- Legend & Stats -->
        <div class="row mt-3 text-center">
          <div class="col-12">
            <div class="p-2 bg-success bg-opacity-10 rounded">
              <i class="fa fa-arrow-up text-success"></i>
              <strong class="text-success">Total Credit Sales (7 Days):</strong>
              <span id="totalSales">RWF <?=number_format(array_sum(array_column($trendData, 'sales')), 2)?></span>
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

<!-- Assigned Sales Table (Placeholder) -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
    <h5 class="card-title mb-3"><i class="fa fa-list text-primary"></i> Assigned Sales</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr><th>ID</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th></tr>
        </thead>
        <tbody>
        <!-- TODO: Populate with assigned sales -->
        <tr><td colspan="5" class="text-center text-muted">No sales assigned.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Recent Activity -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="fa fa-history"></i> Recent Activity
      </h5>
      <span class="badge bg-white text-info">
        Last <?= count($recentActivity) ?> actions
      </span>
    </div>
  </div>
  <div class="card-body p-0">
    <style>
      .activity-timeline {
        position: relative;
        padding: 0;
        margin: 0;
        list-style: none;
      }
      .activity-item {
        position: relative;
        padding: 16px 20px 16px 60px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
      }
      .activity-item:last-child {
        border-bottom: none;
      }
      .activity-item:hover {
        background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%);
        transform: translateX(5px);
      }
      .activity-icon-wrapper {
        position: absolute;
        left: 20px;
        top: 16px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      }
      .activity-icon-wrapper.info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
      }
      .activity-icon-wrapper.primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
      }
      .activity-icon-wrapper.success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
      }
      .activity-icon-wrapper.warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
      }
      .activity-icon-wrapper.danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      }
      .activity-icon-wrapper.secondary {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
      }
      .activity-content {
        flex: 1;
      }
      .activity-action {
        font-weight: 600;
        color: #212529;
        margin-bottom: 4px;
      }
      .activity-description {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 4px;
      }
      .activity-meta {
        font-size: 11px;
        color: #adb5bd;
        display: flex;
        gap: 12px;
        align-items: center;
      }
      .activity-user {
        display: inline-flex;
        align-items: center;
        gap: 4px;
      }
      .activity-time {
        display: inline-flex;
        align-items: center;
        gap: 4px;
      }
      .activity-empty {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        margin: 20px;
      }
      .activity-empty i {
        font-size: 64px;
        color: #6c757d;
        margin-bottom: 16px;
        display: block;
        opacity: 0.5;
      }
      .user-role-badge {
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
      }
      .role-manager {
        background: #ffc107;
        color: #000;
      }
      .role-staff {
        background: #17a2b8;
        color: white;
      }
    </style>

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

// Chart configuration
const ctx = document.getElementById('salesTrendChart').getContext('2d');
let salesTrendChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Credit Sales (RWF)',
        data: salesData,
        borderColor: '#28a745',
        backgroundColor: 'rgba(40, 167, 69, 0.2)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 6,
        pointHoverRadius: 8,
        pointBackgroundColor: '#28a745',
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
            size: 13,
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

// Auto-refresh timestamp every minute
setInterval(() => {
  const now = new Date();
  const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
  document.getElementById('lastUpdated').innerHTML = '<span class="live-indicator"></span>Last updated: ' + now.toLocaleDateString('en-US', options);
}, 60000);
</script>
