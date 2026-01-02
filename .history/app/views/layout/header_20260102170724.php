<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>NJ MERCH SHOP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
  <style>
    /* Animated Background Images */
    body {
      position: relative;
      overflow-x: hidden;
      background: #f7fafc;
    }

    body.dark-mode { background: #181a1b !important; color: #e0e0e0 !important; }

    .animated-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .animated-bg img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      animation: fade 12s infinite;
    }

    .animated-bg img:nth-child(1) { animation-delay: 0s; }
    .animated-bg img:nth-child(2) { animation-delay: 4s; }
    .animated-bg img:nth-child(3) { animation-delay: 8s; }

    @keyframes fade {
      0% { opacity: 0; }
      10% { opacity: 1; }
      33% { opacity: 1; }
      43% { opacity: 0; }
      100% { opacity: 0; }
    }

    /* Universal dark mode for cards, tables, forms */
    body.dark-mode .card { background: #23272b !important; color: #e0e0e0 !important; border-color: #444 !important; }
    body.dark-mode .form-control, body.dark-mode .form-select { background: #181a1b !important; color: #e0e0e0 !important; border-color: #444 !important; }
    body.dark-mode .form-control:focus, body.dark-mode .form-select:focus { background: #23272b !important; color: #fff !important; border-color: #0d6efd !important; }
    body.dark-mode .table, body.dark-mode .table-bordered, body.dark-mode .table-striped { background: #23272b !important; color: #e0e0e0 !important; }
    body.dark-mode th, body.dark-mode td { background: #23272b !important; color: #e0e0e0 !important; border-color: #444 !important; }
    body.dark-mode .btn-outline-secondary { color: #e0e0e0 !important; border-color: #888 !important; }
    body.dark-mode .btn-outline-secondary:hover { background: #e0e0e0 !important; color: #23272b !important; }

    /* Navbar styling */
    .navbar, .navbar.bg-primary { background: #212529 !important; }
    .navbar-dark .navbar-nav .nav-link, .navbar-dark .navbar-brand { color: #fff !important; }
    .navbar .container-fluid { display: flex !important; flex-direction: row; align-items: center; justify-content: center; position: relative; }
    .navbar .navbar-brand { position: absolute; left: 0; top: 50%; transform: translateY(-50%); margin: 0; display: flex; align-items: center; justify-content: flex-start; font-size: 1.3rem; z-index: 2; }
    .navbar .navbar-collapse { width: 100%; display: flex !important; flex-direction: row; align-items: center; justify-content: center; }
    .navbar-nav.me-auto { margin-left: 0 !important; margin-right: 0 !important; flex: 1; justify-content: center; display: flex; }
    .navbar-nav.mb-2 { flex-shrink: 0; }
    .nav-link.active { font-weight: bold; color: #0d6efd !important; }

    /* Main content bottom padding */
    #main-content { padding-bottom: 70px; }

    /* Responsive fix for mobile nav */
    @media (max-width: 991.98px) {
      .navbar .container-fluid { flex-direction: row; align-items: stretch; justify-content: flex-start; }
      .navbar .navbar-brand { position: static; transform: none; margin-right: 1rem; }
      .navbar .navbar-collapse { flex-direction: column; align-items: stretch; justify-content: flex-start; }
      .navbar-nav.me-auto { justify-content: flex-start; }
    }
  </style>

  <script>
    // Dark mode toggle
    document.addEventListener('DOMContentLoaded', function() {
      if(localStorage.getItem('darkMode') === 'on') {
        document.body.classList.add('dark-mode');
      }

      document.getElementById('darkModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        if(document.body.classList.contains('dark-mode')) {
          localStorage.setItem('darkMode', 'on');
        } else {
          localStorage.setItem('darkMode', 'off');
        }
      });
    });
  </script>

</head>
<body>

  <!-- Animated Background -->
  <div class="animated-bg">
    <img src="https://source.unsplash.com/1600x900/?shopping,store" alt="bg1">
    <img src="https://source.unsplash.com/1600x900/?products" alt="bg2">
    <img src="https://source.unsplash.com/1600x900/?merchandise" alt="bg3">
  </div>

  <!-- Navbar -->
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
          <li class="nav-item"><a class="nav-link" href="?r=dashboard/index"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="?r=credit/index"><i class="fa fa-credit-card"></i> Credits</a></li>
          <li class="nav-item"><a class="nav-link" href="?r=purchase/index"><i class="fa fa-shopping-cart"></i> Purchases</a></li>
          <li class="nav-item"><a class="nav-link" href="?r=expense/index"><i class="fa fa-money-bill-wave"></i> Expenses</a></li>
          <li class="nav-item"><a class="nav-link" href="?r=product/index"><i class="fa fa-box"></i> Products</a></li>
          <li class="nav-item"><a class="nav-link" href="?r=client/index"><i class="fa fa-users"></i> Clients</a></li>
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0 align-items-center gap-2">
          <li class="nav-item ms-2">
            <button id="darkModeToggle" class="btn btn-sm btn-outline-light"><i class="fa fa-moon"></i></button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-4" id="main-content">
    <div class="card p-4 shadow-sm">
      <h3>Welcome to NJ MERCH SHOP</h3>
      <p>Start adding products, managing clients, and track sales efficiently with our professional system.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
