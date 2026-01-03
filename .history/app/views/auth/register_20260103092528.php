<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card p-4 mt-4 shadow-lg border-0" style="border-radius: 16px;">
      <div class="text-center mb-4">
        <div class="register-icon mb-3">
          <i class="fa fa-user-plus fa-3x text-success"></i>
        </div>
        <h3 class="fw-bold text-success"><i class="fa fa-user-plus"></i> Create Account</h3>
        <p class="text-muted">Join us today! Please fill in your details below.</p>
      </div>
      <?php if(!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fa fa-exclamation-triangle"></i> <?=htmlspecialchars($error)?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <?php if(!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fa fa-check-circle"></i> <?=htmlspecialchars($success)?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <form method="post" autocomplete="on" id="registerForm" data-validate-form>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="full_name" class="form-label fw-600">
              <i class="fa fa-user"></i> Full Name <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input id="full_name" 
                     name="full_name" 
                     type="text" 
                     class="form-control" 
                     placeholder="John Doe"
                     data-validate="required|minLength:3|maxLength:100"
                     required>
            </div>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="phone" class="form-label fw-600">
              <i class="fa fa-phone"></i> Phone Number <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-phone"></i></span>
              <input id="phone" 
                     name="phone" 
                     type="text" 
                     class="form-control" 
                     placeholder="0783086909"
                     data-validate="required|phone"
                     required>
            </div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="email" class="form-label fw-600">
              <i class="fa fa-envelope"></i> Email <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-envelope"></i></span>
              <input id="email" 
                     name="email" 
                     type="email" 
                     class="form-control" 
                     placeholder="user@example.com"
                     data-validate="required|email"
                     required>
            </div>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="role" class="form-label fw-600">
              <i class="fa fa-user-tag"></i> Role <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-user-tag"></i></span>
              <select id="role" 
                      name="role" 
                      class="form-select" 
                      style="border-left:none;border-radius:0 8px 8px 0;"
                      data-validate="required"
                      required>
                <option value="">Select Role</option>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
              </select>
            </div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password" class="form-label fw-600">
              <i class="fa fa-key"></i> Password <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-key"></i></span>
              <input id="password" 
                     name="password" 
                     type="password" 
                     class="form-control" 
                     placeholder="Min. 6 characters"
                     data-validate="required|password"
                     required>
              <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                <i class="fa fa-eye" id="password-toggle-icon"></i>
              </button>
            </div>
            <div class="invalid-feedback"></div>
            <small class="text-muted">
              <i class="fa fa-info-circle"></i> At least 6 characters
            </small>
          </div>
          <div class="col-md-6 mb-3">
            <label for="confirm_password" class="form-label fw-600">
              <i class="fa fa-key"></i> Confirm Password <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-key"></i></span>
              <input id="confirm_password" 
                     name="confirm_password" 
                     type="password" 
                     class="form-control" 
                     placeholder="Re-enter password"
                     data-validate="required|match:password"
                     required>
              <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                <i class="fa fa-eye" id="confirm_password-toggle-icon"></i>
              </button>
            </div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="d-grid gap-2 mb-3 mt-4">
          <button class="btn btn-success btn-lg py-2" type="submit" style="border-radius:8px;">
            <i class="fa fa-user-plus me-2"></i> Create Account
          </button>
        </div>
        <div class="text-center">
          <p class="text-muted mb-0">Already have an account?</p>
          <a href="?r=auth/login" class="btn btn-outline-primary mt-2 w-100" style="border-radius:8px;">
            <i class="fa fa-sign-in-alt me-2"></i> Login Here
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.register-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
}

.form-label.fw-600 {
  font-weight: 600;
  color: #374151;
}

body.dark-mode .form-label.fw-600 {
  color: #e0e0e0;
}

.input-group-text {
  background: #10b981;
  color: white;
  border: 2px solid #10b981;
  font-weight: 600;
}

body.dark-mode .input-group-text {
  background: #4ade80;
  border-color: #4ade80;
  color: #1f2937;
}

.form-control, .form-select {
  border: 2px solid #e5e7eb;
  border-left: none;
  padding: 0.75rem 1rem;
  border-radius: 0 8px 8px 0;
}

.form-control:focus, .form-select:focus {
  border-color: #10b981;
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

body.dark-mode .form-control,
body.dark-mode .form-select {
  border-color: #4a5568;
}

body.dark-mode .form-control:focus,
body.dark-mode .form-select:focus {
  border-color: #4ade80;
  box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.1);
}

body.dark-mode .position-relative .bg-white {
  background: #2d3748 !important;
}
</style>

<script>
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const icon = document.getElementById(fieldId + '-toggle-icon');
  
  if (field.type === 'password') {
    field.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    field.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
      <a href="?r=auth/login" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to Login</a>
      <button class="btn" type="submit"><i class="fa fa-user-plus"></i> Register</button>
    </div>
  </form>
</div>
