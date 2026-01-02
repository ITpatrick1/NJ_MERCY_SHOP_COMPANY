<div class="container mt-4" style="max-width:440px;">
  <!-- Summary Card -->
  <div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body d-flex align-items-center gap-3">
      <div><i class="fa fa-money-bill-wave fa-2x text-success"></i></div>
      <div>
        <div class="fw-bold">Record a New Expense</div>
        <div class="text-muted small">Fill in the details below to add a new expense. All fields are required.</div>
      </div>
    </div>
  </div>
  <div class="card p-4 shadow-sm border-0">
    <h2 class="mb-3 text-primary"><i class="fa fa-money-bill-wave"></i> New Expense</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <form method="post" id="expenseForm" data-validate-form>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-money-bill"></i> Amount <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the amount spent for this expense."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
          <input type="number" 
                 name="amount" 
                 step="0.01" 
                 min="0.01"
                 class="form-control" 
                 placeholder="Enter amount"
                 data-validate="required|positiveNumber|min:0.01"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-comment-dots"></i> Reason <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Describe the reason for this expense."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-comment-dots"></i></span>
          <input type="text" 
                 name="reason" 
                 class="form-control" 
                 placeholder="Enter reason"
                 data-validate="required|minLength:3|maxLength:255"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-calendar"></i> Date <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Select the date of this expense."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          <input type="date" 
                 name="expense_date" 
                 class="form-control" 
                 data-validate="required|date|pastDate"
                 value="<?= date('Y-m-d') ?>"
                 max="<?= date('Y-m-d') ?>"
                 required>
        </div>
        <div class="invalid-feedback"></div>
        <small class="text-muted"><i class="fa fa-info-circle"></i> Cannot be a future date</small>
      </div>
      <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save"></i> Save Expense</button>
    </form>
  </div>
<style>
.form-control::placeholder {
  color: #6c757d;
  opacity: 1;
  transition: color 0.2s;
}
body.dark-mode .form-control::placeholder {
  color: #bfc9d1;
  opacity: 1;
}
.was-validated .form-control:invalid, .form-control.is-invalid {
  border-color: #dc3545;
  box-shadow: 0 0 0 0.2rem rgba(220,53,69,.08);
}
.was-validated .form-control:valid, .form-control.is-valid {
  border-color: #198754;
  box-shadow: 0 0 0 0.2rem rgba(25,135,84,.08);
}
</style>
<script>
// Bootstrap tooltips
window.onload = function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
};
// Real-time validation feedback
document.getElementById('expenseForm').addEventListener('submit', function(event) {
  if (!this.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
  }
  this.classList.add('was-validated');
});
</script>
</div>
