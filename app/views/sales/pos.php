<div class="container mt-4" style="max-width:400px;">
  <div class="card p-4 shadow-sm">
    <h2 class="mb-3 text-primary"><i class="fa fa-cash-register"></i> Record Daily Sales</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Total Sales Amount</label>
        <input type="number" name="amount" step="0.01" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save"></i> Save Sales</button>
    </form>
  </div>
</div>
