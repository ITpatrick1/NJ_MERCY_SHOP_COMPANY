<div class="container my-4">
  <div class="mb-4">
    <a href="?r=client/index" class="btn btn-outline-secondary mb-3">
      <i class="fa fa-arrow-left"></i> Back to Clients
    </a>
    <h2 class="fw-bold"><i class="fa fa-user-plus text-success"></i> Create New Client</h2>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Summary Card -->
  <div class="row mb-4">
    <div class="col-md-8 offset-md-2">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="text-center mb-3">
            <i class="fa fa-users fa-3x text-success"></i>
            <h5 class="mt-2">Client Information</h5>
            <p class="text-muted">Add a new client to the system</p>
          </div>

          <form method="post" id="clientCreateForm" data-validate-form>
            <div class="mb-3">
              <label class="form-label">
                <i class="fa fa-user text-success"></i> Client Name <span class="text-danger">*</span>
                <i class="fa fa-info-circle text-muted" data-bs-toggle="tooltip" title="Enter the full name of the client"></i>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input 
                  type="text" 
                  name="name" 
                  class="form-control" 
                  placeholder="e.g., John Doe" 
                  data-validate="required|minLength:3|maxLength:100"
                  required
                  value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                >
              </div>
              <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="fa fa-phone text-primary"></i> Phone Number <span class="text-danger">*</span>
                <i class="fa fa-info-circle text-muted" data-bs-toggle="tooltip" title="Enter a unique phone number for this client"></i>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                <input 
                  type="tel" 
                  name="phone" 
                  class="form-control" 
                  placeholder="e.g., 0783086909" 
                  data-validate="required|phone"
                  required
                  value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                >
              </div>
              <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="fa fa-envelope text-info"></i> Email
                <i class="fa fa-info-circle text-muted" data-bs-toggle="tooltip" title="Optional email address"></i>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input 
                  type="email" 
                  name="email" 
                  class="form-control" 
                  placeholder="e.g., client@example.com" 
                  data-validate="email"
                  value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
              </div>
              <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="fa fa-id-card text-warning"></i> TIN (Tax ID)
                <i class="fa fa-info-circle text-muted" data-bs-toggle="tooltip" title="Optional 9-digit Tax Identification Number"></i>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                <input 
                  type="text" 
                  name="tin" 
                  class="form-control" 
                  placeholder="e.g., 123456789 (9 digits)" 
                  data-validate="tin"
                  maxlength="9"
                  value="<?= htmlspecialchars($_POST['tin'] ?? '') ?>"
                >
              </div>
              <div class="invalid-feedback"></div>
              <small class="text-muted"><i class="fa fa-info-circle"></i> Must be exactly 9 digits if provided</small>
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="fa fa-map-marker-alt text-danger"></i> Address
                <i class="fa fa-info-circle text-muted" data-bs-toggle="tooltip" title="Optional physical address"></i>
              </label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                <textarea 
                  name="address" 
                  class="form-control" 
                  placeholder="e.g., KG 123 St, Kigali"
                  rows="2"
                  data-validate="maxLength:255"
                ><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
              </div>
              <div class="invalid-feedback"></div>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success btn-lg">
                <i class="fa fa-save"></i> Create Client
              </button>
              <a href="?r=client/index" class="btn btn-outline-secondary">
                <i class="fa fa-times"></i> Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Placeholder compatibility for dark/light modes */
body.dark-mode .form-control::placeholder {
  color: #bfc9d1;
  opacity: 1;
}
body:not(.dark-mode) .form-control::placeholder {
  color: #6c757d;
  opacity: 1;
}
</style>

<script>
// Initialize tooltips
window.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});

// Form validation
(function() {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
