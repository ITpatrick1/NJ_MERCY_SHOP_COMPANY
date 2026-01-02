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

@keyframes shimmer {
  0% { background-position: -1000px 0; }
  100% { background-position: 1000px 0; }
}

.stats-card {
  animation: fadeInUp 0.5s ease-out;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 16px;
  overflow: hidden;
  position: relative;
}

.stats-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  animation: shimmer 3s infinite;
}

.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(102, 126, 234, 0.3);
}

.stats-card.success {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stats-card.info {
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.stats-card.warning {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

/* Dark mode stats card enhancements */
body.dark-mode .stats-card {
  background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
  box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3);
}

body.dark-mode .stats-card:hover {
  box-shadow: 0 12px 24px rgba(124, 58, 237, 0.4);
}

body.dark-mode .stats-card.success {
  background: linear-gradient(135deg, #059669 0%, #047857 100%);
  box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
}

body.dark-mode .stats-card.success:hover {
  box-shadow: 0 12px 24px rgba(5, 150, 105, 0.4);
}

body.dark-mode .stats-card.info {
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
}

body.dark-mode .stats-card.info:hover {
  box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
}

body.dark-mode .stats-card.warning {
  background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
  box-shadow: 0 8px 24px rgba(234, 88, 12, 0.3);
}

body.dark-mode .stats-card.warning:hover {
  box-shadow: 0 12px 24px rgba(234, 88, 12, 0.4);
}

.search-box {
  border-radius: 12px;
  border: 2px solid #e5e7eb;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.search-box:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

body.dark-mode .search-box {
  background: #23272b;
  border-color: #4a5568;
  color: #e0e0e0;
}

body.dark-mode .search-box:focus {
  border-color: #a78bfa;
  box-shadow: 0 0 0 4px rgba(167, 139, 250, 0.1);
}

.filter-btn {
  border-radius: 20px;
  padding: 0.5rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.filter-btn:hover {
  transform: scale(1.05);
}

.filter-btn.active {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-color: #667eea;
}

body.dark-mode .filter-btn.active {
  background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);
  border-color: #a78bfa;
}

.client-row {
  animation: fadeInUp 0.3s ease-out;
  transition: all 0.2s ease;
}

.client-row:hover {
  background: rgba(102, 126, 234, 0.05);
  transform: scale(1.01);
}

body.dark-mode .client-row:hover {
  background: rgba(167, 139, 250, 0.1);
}

.action-btn {
  border-radius: 8px;
  padding: 0.5rem 1rem;
  transition: all 0.3s ease;
}

.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.page-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
}

body.dark-mode .page-header {
  background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);
}

body.dark-mode .card {
  background: #1a1d23;
  color: #e0e0e0;
}

body.dark-mode .card-header {
  background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%) !important;
}

body.dark-mode .table {
  color: #e0e0e0;
}

body.dark-mode .table-light {
  background: #2a2f38;
  color: #e0e0e0;
}

body.dark-mode .table-hover tbody tr:hover {
  background: rgba(167, 139, 250, 0.15);
}

body.dark-mode .client-badge {
  background: #2a2f38;
  color: #e0e0e0;
  border-color: #4a5568 !important;
}

body.dark-mode .bg-light {
  background: #2a2f38 !important;
}

body.dark-mode .text-dark {
  color: #e0e0e0 !important;
}

body.dark-mode .filter-btn {
  background: #2a2f38;
  color: #e0e0e0;
  border-color: #4a5568;
}

body.dark-mode .filter-btn:hover {
  background: #3a3f48;
  border-color: #a78bfa;
}

body.dark-mode .form-select {
  background: #23272b;
  color: #e0e0e0;
  border-color: #4a5568;
}

body.dark-mode .input-group-text {
  background: #2a2f38 !important;
  color: #e0e0e0;
  border-color: #4a5568;
}

body.dark-mode .empty-state i {
  color: #4a5568;
}

body.dark-mode .badge.bg-warning {
  background: #d97706 !important;
  color: white;
}

.client-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 600;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  animation: fadeInUp 0.5s ease-out;
}

.empty-state i {
  font-size: 4rem;
  color: #cbd5e1;
  margin-bottom: 1rem;
}
</style>

<div class="container my-4">
  <!-- Professional Page Header -->
  <div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="fw-bold mb-2">
          <i class="fa fa-users"></i> Client Management
        </h2>
        <p class="mb-0 opacity-75">
          <i class="fa fa-info-circle"></i> Manage your clients, view details, and create credit sales
        </p>
      </div>
      <a class="btn btn-light btn-lg shadow" href="?r=client/create">
        <i class="fa fa-plus"></i> Add New Client
      </a>
    </div>
  </div>

  <?php if (isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_type'] ?? 'info') ?> alert-dismissible fade show shadow-sm" style="border-radius: 12px; animation: fadeInUp 0.5s ease-out;">
      <i class="fa fa-<?= $_SESSION['flash_type'] === 'success' ? 'check-circle' : ($_SESSION['flash_type'] === 'danger' ? 'exclamation-triangle' : 'info-circle') ?>"></i>
      <?= htmlspecialchars($_SESSION['flash_message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
  <?php endif; ?>

  <!-- Enhanced Statistics Cards -->
  <?php
  $totalClients = count($clients);
  $activeClients = count(array_filter($clients, function($c) { return !empty($c['phone']); }));
  $withEmail = count(array_filter($clients, function($c) { return !empty($c['email']); }));
  $recentClients = count(array_filter($clients, function($c) { 
    return isset($c['created_at']) && strtotime($c['created_at']) > strtotime('-30 days');
  }));
  ?>
  <div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="stats-card shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-users fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Total Clients</h6>
          <div class="display-5 fw-bold"><?= $totalClients ?></div>
          <small class="opacity-75">Registered</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card success shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-check-circle fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">Active Clients</h6>
          <div class="display-5 fw-bold"><?= $activeClients ?></div>
          <small class="opacity-75">With Contact</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card info shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-envelope fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">With Email</h6>
          <div class="display-5 fw-bold"><?= $withEmail ?></div>
          <small class="opacity-75"><?= $totalClients > 0 ? round(($withEmail/$totalClients)*100) : 0 ?>% Coverage</small>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stats-card warning shadow">
        <div class="card-body text-center p-4">
          <div class="mb-3">
            <i class="fa fa-user-plus fa-3x opacity-75"></i>
          </div>
          <h6 class="text-uppercase opacity-75 mb-2">New This Month</h6>
          <div class="display-5 fw-bold"><?= $recentClients ?></div>
          <small class="opacity-75">Last 30 Days</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Search and Filter Section -->
  <div class="card border-0 shadow-lg mb-4" style="border-radius: 16px;">
    <div class="card-body p-4">
      <div class="row g-3 mb-3">
        <div class="col-md-8">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
              <i class="fa fa-search text-muted"></i>
            </span>
            <input type="text" 
                   id="searchClient" 
                   class="form-control border-start-0 search-box" 
                   placeholder="Search clients by name, phone, email, or TIN..."
                   style="border-left: none;">
          </div>
        </div>
        <div class="col-md-4">
          <select id="sortBy" class="form-select search-box" style="border-radius: 12px;">
            <option value="name">Sort by Name</option>
            <option value="recent">Sort by Recent</option>
            <option value="id">Sort by ID</option>
          </select>
        </div>
      </div>
      
      <!-- Filter Buttons -->
      <div class="d-flex flex-wrap gap-2">
        <button class="filter-btn btn btn-outline-secondary active" data-filter="all">
          <i class="fa fa-list"></i> All Clients
        </button>
        <button class="filter-btn btn btn-outline-success" data-filter="with-email">
          <i class="fa fa-envelope"></i> With Email
        </button>
        <button class="filter-btn btn btn-outline-warning" data-filter="no-email">
          <i class="fa fa-envelope-open"></i> No Email
        </button>
      </div>
      
      <div class="mt-3">
        <small class="text-muted">
          <i class="fa fa-info-circle"></i> 
          Showing <strong id="resultCount"><?= $totalClients ?></strong> of <?= $totalClients ?> clients
        </small>
      </div>
    </div>
  </div>

  <!-- Clients Table -->
  <div class="card border-0 shadow-lg" style="border-radius: 16px;">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px 16px 0 0;">
      <h5 class="mb-0">
        <i class="fa fa-table"></i> Clients Directory
      </h5>
    </div>
    <div class="card-body p-0">
      <?php if (empty($clients)): ?>
        <div class="empty-state">
          <i class="fa fa-users"></i>
          <h4 class="text-muted mb-3">No Clients Yet</h4>
          <p class="text-muted mb-4">Start building your client base by adding your first client</p>
          <a href="?r=client/create" class="btn btn-primary btn-lg">
            <i class="fa fa-plus"></i> Add First Client
          </a>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="clientsTable">
            <thead class="table-light">
              <tr>
                <th style="padding: 1rem;"><i class="fa fa-hashtag"></i> ID</th>
                <th><i class="fa fa-user"></i> Client Name</th>
                <th><i class="fa fa-phone"></i> Phone Number</th>
                <th><i class="fa fa-envelope"></i> Email</th>
                <th><i class="fa fa-id-card"></i> TIN</th>
                <th class="text-center"><i class="fa fa-cog"></i> Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($clients as $client): ?>
                <tr class="client-row" data-email="<?= !empty($client['email']) ? 'yes' : 'no' ?>">
                  <td style="padding: 1rem;">
                    <span class="client-badge bg-light text-dark border">
                      #<?= htmlspecialchars($client['client_id']) ?>
                    </span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 40px; height: 40px; font-weight: bold;">
                        <?= strtoupper(substr($client['name'], 0, 1)) ?>
                      </div>
                      <div>
                        <strong class="d-block"><?= htmlspecialchars($client['name']) ?></strong>
                        <?php if (!empty($client['created_at'])): ?>
                          <small class="text-muted">
                            <i class="fa fa-calendar"></i> 
                            Joined <?= date('M d, Y', strtotime($client['created_at'])) ?>
                          </small>
                        <?php endif; ?>
                      </div>
                    </div>
                  </td>
                  <td>
                    <i class="fa fa-phone text-success"></i>
                    <strong><?= htmlspecialchars($client['phone']) ?></strong>
                  </td>
                  <td>
                    <?php if (!empty($client['email'])): ?>
                      <i class="fa fa-envelope text-info"></i>
                      <?= htmlspecialchars($client['email']) ?>
                    <?php else: ?>
                      <span class="text-muted"><i class="fa fa-minus"></i> N/A</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($client['tin'])): ?>
                      <span class="client-badge bg-warning text-dark">
                        <i class="fa fa-id-card"></i> <?= htmlspecialchars($client['tin']) ?>
                      </span>
                    <?php else: ?>
                      <span class="text-muted"><i class="fa fa-minus"></i> N/A</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="?r=client/show/<?= $client['client_id'] ?>" 
                         class="btn btn-sm btn-info action-btn" 
                         title="View Details">
                        <i class="fa fa-eye"></i> View
                      </a>
                      <a href="?r=credit/create" 
                         class="btn btn-sm btn-success action-btn" 
                         title="Create Credit Sale">
                        <i class="fa fa-credit-card"></i> Credit
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
// Enhanced client search with multiple fields
const searchInput = document.getElementById('searchClient');
const sortSelect = document.getElementById('sortBy');
const filterButtons = document.querySelectorAll('.filter-btn');
const tableBody = document.querySelector('#clientsTable tbody');
const resultCount = document.getElementById('resultCount');
let currentFilter = 'all';

// Search functionality
if (searchInput) {
  searchInput.addEventListener('keyup', function() {
    filterAndSearch();
  });
}

// Sort functionality
if (sortSelect) {
  sortSelect.addEventListener('change', function() {
    sortTable(this.value);
  });
}

// Filter button functionality
filterButtons.forEach(btn => {
  btn.addEventListener('click', function() {
    // Update active state
    filterButtons.forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    
    // Set current filter
    currentFilter = this.dataset.filter;
    filterAndSearch();
  });
});

// Combined filter and search function
function filterAndSearch() {
  const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
  const rows = document.querySelectorAll('#clientsTable tbody tr');
  let visibleCount = 0;
  
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const hasEmail = row.dataset.email === 'yes';
    
    // Check search match
    const matchesSearch = text.includes(searchTerm);
    
    // Check filter match
    let matchesFilter = true;
    if (currentFilter === 'with-email') {
      matchesFilter = hasEmail;
    } else if (currentFilter === 'no-email') {
      matchesFilter = !hasEmail;
    }
    
    // Show/hide row
    if (matchesSearch && matchesFilter) {
      row.style.display = '';
      visibleCount++;
    } else {
      row.style.display = 'none';
    }
  });
  
  // Update count
  if (resultCount) {
    resultCount.textContent = visibleCount;
  }
}

// Sort table function
function sortTable(sortBy) {
  if (!tableBody) return;
  
  const rows = Array.from(tableBody.querySelectorAll('tr'));
  
  rows.sort((a, b) => {
    if (sortBy === 'name') {
      const nameA = a.querySelector('strong').textContent.toLowerCase();
      const nameB = b.querySelector('strong').textContent.toLowerCase();
      return nameA.localeCompare(nameB);
    } else if (sortBy === 'id') {
      const idA = parseInt(a.querySelector('.client-badge').textContent.replace('#', ''));
      const idB = parseInt(b.querySelector('.client-badge').textContent.replace('#', ''));
      return idA - idB;
    } else if (sortBy === 'recent') {
      const idA = parseInt(a.querySelector('.client-badge').textContent.replace('#', ''));
      const idB = parseInt(b.querySelector('.client-badge').textContent.replace('#', ''));
      return idB - idA; // Reverse order for recent
    }
    return 0;
  });
  
  // Re-append rows in sorted order
  rows.forEach(row => tableBody.appendChild(row));
}

// Add animation on load
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.stats-card');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
  });
});
</script>
