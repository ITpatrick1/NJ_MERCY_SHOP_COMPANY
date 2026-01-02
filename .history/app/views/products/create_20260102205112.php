<div class="container mt-4" style="max-width:540px;">
  <!-- Summary Card -->
  <div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body d-flex align-items-center gap-3">
      <div><i class="fa fa-box-open fa-2x text-primary"></i></div>
      <div>
        <div class="fw-bold">Add a New Product</div>
        <div class="text-muted small">Fill in the details below to add a new product to your inventory. All fields are required.</div>
      </div>
    </div>
  </div>
  <div class="card p-4 shadow-sm border-0">
    <h2 class="mb-3 text-primary"><i class="fa fa-plus"></i> Add Product</h2>
    <form method="post" id="productForm" data-validate-form>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-truck"></i> Supplier ID <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the supplier's ID for this product."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-truck"></i></span>
          <input name="supplier_id" 
                 class="form-control" 
                 placeholder="Supplier ID"
                 data-validate="required|positiveNumber"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-box"></i> Name <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the product name."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-box"></i></span>
          <input name="name" 
                 class="form-control" 
                 placeholder="Product Name"
                 data-validate="required|minLength:2|maxLength:100"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-sort-numeric-up"></i> Quantity <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the quantity in stock."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-sort-numeric-up"></i></span>
          <input name="quantity" 
                 type="number" 
                 min="1" 
                 class="form-control" 
                 placeholder="Quantity"
                 data-validate="required|positiveNumber|min:1"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-money-bill"></i> Unit Price <span class="text-danger">*</span>
          <i class="fa fa-info-circle text-info ms-1" data-bs-toggle="tooltip" title="Enter the unit price for this product."></i>
        </label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
          <input name="unit_price" 
                 type="number" 
                 step="0.01" 
                 min="0.01"
                 class="form-control" 
                 placeholder="Unit Price"
                 data-validate="required|positiveNumber|min:0.01"
                 required>
        </div>
        <div class="invalid-feedback"></div>
      </div>
      <button class="btn btn-success w-100" type="submit"><i class="fa fa-save"></i> Save Product</button>
    </form>
  </div>
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
document.getElementById('productForm').addEventListener('submit', function(event) {
  if (!this.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
  }
  this.classList.add('was-validated');
});
</script>
