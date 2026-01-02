<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>NJ MERCH SHOP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <script src="app/views/layout/validation.js" defer></script>
  <style>
        /* Animated Background */
        body {
          position: relative;
          overflow-x: hidden;
        }
        body::before {
          content: '';
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
          background-size: 400% 400%;
          animation: gradientShift 15s ease infinite;
          opacity: 0.15;
          z-index: -1;
        }
        body.dark-mode::before {
          background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #533483 75%, #1a1a2e 100%);
          background-size: 400% 400%;
          animation: gradientShift 15s ease infinite;
          opacity: 0.3;
        }
        @keyframes gradientShift {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }
        
        /* Universal dark mode for all cards, tables, and forms */
        body.dark-mode .card {
          background: #23272b !important;
          color: #e0e0e0 !important;
          border-color: #444 !important;
        }
        body.dark-mode .form-control,
        body.dark-mode .form-select {
          background: #181a1b !important;
          color: #e0e0e0 !important;
          border-color: #444 !important;
        }
        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
          background: #23272b !important;
          color: #fff !important;
          border-color: #0d6efd !important;
        }
        body.dark-mode .table,
        body.dark-mode .table-bordered,
        body.dark-mode .table-striped {
          background: #23272b !important;
          color: #e0e0e0 !important;
        }
        body.dark-mode .table-light {
          background: #181a1b !important;
          color: #e0e0e0 !important;
        }
        body.dark-mode th, body.dark-mode td {
          background: #23272b !important;
          color: #e0e0e0 !important;
          border-color: #444 !important;
        }
        body.dark-mode .btn-outline-secondary {
          color: #e0e0e0 !important;
          border-color: #888 !important;
        }
        body.dark-mode .btn-outline-secondary:hover {
          background: #e0e0e0 !important;
          color: #23272b !important;
        }
        body.dark-mode .alert-danger {
          background: #3a2323 !important;
          color: #ffb4b4 !important;
          border-color: #b71c1c !important;
        }
        body.dark-mode .alert-success {
          background: #1b3a23 !important;
          color: #b9f6ca !important;
          border-color: #388e3c !important;
        }
    body { background: #f7fafc; }
    body.dark-mode { background: #181a1b !important; color: #e0e0e0 !important; }
    .navbar, .navbar.bg-primary { background: #212529 !important; }
    .navbar-dark .navbar-nav .nav-link, .navbar-dark .navbar-brand { color: #fff !important; }
    .card { box-shadow: 0 2px 8px rgba(0,0,0,0.07); border-radius: 10px; background: #fff; }
    body.dark-mode .card { background: #23272b; color: #e0e0e0; }
    table th, table td { vertical-align: middle !important; }
    .nav-link.active { font-weight: bold; color: #0d6efd !important; }
    body.dark-mode .bg-light, body.dark-mode .bg-white, body.dark-mode .footer, body.dark-mode .table { background: #23272b !important; color: #e0e0e0 !important; }
    body.dark-mode .dropdown-menu { background: #23272b !important; color: #e0e0e0 !important; border-color: #444 !important; }
    body.dark-mode .dropdown-item { background: #23272b !important; color: #e0e0e0 !important; }
    body.dark-mode .dropdown-item:hover, body.dark-mode .dropdown-item:focus { background: #0d6efd !important; color: #fff !important; }
    body.dark-mode .btn-outline-light { border-color: #e0e0e0; color: #e0e0e0; }
    body.dark-mode .btn-outline-light:hover { background: #e0e0e0; color: #23272b; }
    body.dark-mode input, body.dark-mode select, body.dark-mode textarea { background: #23272b; color: #e0e0e0; border-color: #444; }
    body.dark-mode input:focus, body.dark-mode select:focus, body.dark-mode textarea:focus { background: #23272b; color: #fff; border-color: #0d6efd; }
    /* Center navbar content using flexbox */
    .navbar .container-fluid {
      display: flex !important;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .navbar .navbar-brand {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      font-size: 1.3rem;
      z-index: 2;
    }
    .navbar .navbar-collapse {
      width: 100%;
      display: flex !important;
      flex-direction: row;
      align-items: center;
      justify-content: center;
    }
    .navbar-nav.me-auto {
      margin-left: 0 !important;
      margin-right: 0 !important;
      flex: 1;
      justify-content: center;
      display: flex;
    }
    .navbar-nav.mb-2 {
      flex-shrink: 0;
    }
    /* Ensure main content has bottom padding for fixed footer */
    #main-content { padding-bottom: 70px; }
    /* Responsive fix for mobile nav */
    @media (max-width: 991.98px) {
      .navbar .container-fluid {
        flex-direction: row;
        align-items: stretch;
        justify-content: flex-start;
      }
      .navbar .navbar-brand {
        position: static;
        transform: none;
        margin-right: 1rem;
      }
      .navbar .navbar-collapse {
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;
      }
      .navbar-nav.me-auto {
        justify-content: flex-start;
      }
    }
  </style>
  <script>
    // On page load, apply dark mode if set in localStorage
    document.addEventListener('DOMContentLoaded', function() {
      if(localStorage.getItem('darkMode') === 'on') {
        document.body.classList.add('dark-mode');
      }
    });
  </script>
  <!-- Main Navigation Bar with Dark Mode Toggle -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="?r=dashboard/index">
      <i class="fa fa-store fa-lg"></i>
      <span class="fw-bold">NJ MERCH SHOP</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
        <li class="nav-item">
          <a class="nav-link" href="?r=dashboard/index" title="Dashboard"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?r=credit/index" title="Credits"><i class="fa fa-credit-card"></i> Credits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?r=purchase/index" title="Purchases"><i class="fa fa-shopping-cart"></i> Purchases</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?r=expense/index" title="Expenses"><i class="fa fa-money-bill-wave"></i> Expenses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?r=product/index" title="Products"><i class="fa fa-box"></i> Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?r=client/index" title="Clients"><i class="fa fa-users"></i> Clients</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-chart-bar"></i> Reports</a>
          <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
            <li><a class="dropdown-item" href="?r=report/creditSales"><i class="fa fa-file-invoice-dollar"></i> Credit Sales</a></li>
            <li><a class="dropdown-item" href="?r=report/profit"><i class="fa fa-chart-line"></i> Financial Report</a></li>
            <li><a class="dropdown-item" href="?r=report/supplierPurchases"><i class="fa fa-truck"></i> Supplier Purchases</a></li>
            <li><a class="dropdown-item" href="?r=report/overdueCredits"><i class="fa fa-exclamation-triangle text-danger"></i> Overdue Credits</a></li>
            <li><a class="dropdown-item" href="?r=report/purchaseReport"><i class="fa fa-receipt"></i> Purchase Report</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0 align-items-center gap-2">
        <!-- Notification Bell -->
        <li class="nav-item dropdown">
          <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
            <i class="fa fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.7em;">1</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:260px;">
            <li><span class="dropdown-item-text text-muted small"><i class="fa fa-info-circle text-primary"></i> 1 overdue credit needs attention</span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="?r=credit/index"><i class="fa fa-credit-card"></i> View Credits</a></li>
          </ul>
        </li>
        <!-- User Profile Dropdown -->
        <?php if(!empty($_SESSION['user'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user-circle"></i> <?=htmlspecialchars($_SESSION['user']['full_name'])?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="?r=dashboard/index"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
              <li><a class="dropdown-item" href="?r=product/index"><i class="fa fa-box"></i> Products</a></li>
              <li><a class="dropdown-item" href="?r=client/index"><i class="fa fa-users"></i> Clients</a></li>
              <li><a class="dropdown-item" href="?r=credit/index"><i class="fa fa-credit-card"></i> Credits</a></li>
              <li><a class="dropdown-item" href="?r=purchase/index"><i class="fa fa-shopping-cart"></i> Purchases</a></li>
              <li><a class="dropdown-item" href="?r=expense/index"><i class="fa fa-money-bill-wave"></i> Expenses</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="?r=auth/logout"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </li>
        <?php endif; ?>
        <!-- Dark Mode Toggle -->
        <li class="nav-item ms-2">
          <button id="darkModeToggle" class="btn btn-sm btn-outline-light" title="Toggle dark mode"><i class="fa fa-moon"></i></button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4" id="main-content">
