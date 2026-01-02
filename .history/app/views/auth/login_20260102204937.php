<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card p-4 mt-4 shadow-lg border-0" style="border-radius: 16px;">
      <div class="text-center mb-4">
        <div class="login-icon mb-3">
          <i class="fa fa-lock fa-3x text-primary"></i>
        </div>
        <h3 class="fw-bold text-primary"><i class="fa fa-sign-in-alt"></i> Login</h3>
        <p class="text-muted">Welcome back! Please login to your account.</p>
      </div>
      <?php if(!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fa fa-exclamation-triangle"></i> <?=htmlspecialchars($error)?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <form method="post" autocomplete="on" id="loginForm" data-validate-form>
        <div class="mb-3 text-center">
          <a href="?r=auth/google" class="btn btn-danger w-100 py-2" style="background:#ea4335;border:none;border-radius:8px;">
            <i class="fab fa-google me-2"></i> Sign in with Google
          </a>
        </div>
        <div class="position-relative text-center my-3">
          <hr>
          <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted" style="font-size: 0.875rem;">OR</span>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label fw-600">
            <i class="fa fa-phone"></i> Phone Number <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa fa-phone"></i></span>
            <input id="phone" 
                   name="phone" 
                   type="text" 
                   class="form-control" 
                   placeholder="e.g., 0783086909"
                   data-validate="required|phone"
                   required>
          </div>
          <div class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label fw-600">
            <i class="fa fa-key"></i> Password <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa fa-key"></i></span>
            <input id="password" 
                   name="password" 
                   type="password" 
                   class="form-control" 
                   placeholder="Enter your password"
                   data-validate="required|minLength:6"
                   required>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
              <i class="fa fa-eye" id="password-toggle-icon"></i>
            </button>
          </div>
          <div class="invalid-feedback"></div>
        </div>
        <div class="d-grid gap-2 mb-3">
          <button class="btn btn-primary btn-lg py-2" type="submit" style="border-radius:8px;">
            <i class="fa fa-sign-in-alt me-2"></i> Login
          </button>
        </div>
        <div class="text-center">
          <p class="text-muted mb-0">Don't have an account?</p>
          <a href="?r=auth/register" class="btn btn-outline-secondary mt-2 w-100" style="border-radius:8px;">
            <i class="fa fa-user-plus me-2"></i> Create Account
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.login-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.form-label.fw-600 {
  font-weight: 600;
  color: #374151;
}

body.dark-mode .form-label.fw-600 {
  color: #e0e0e0;
}

.input-group-text {
  background: #667eea;
  color: white;
  border: 2px solid #667eea;
  font-weight: 600;
}

body.dark-mode .input-group-text {
  background: #a78bfa;
  border-color: #a78bfa;
}

.form-control {
  border: 2px solid #e5e7eb;
  border-left: none;
  padding: 0.75rem 1rem;
  border-radius: 0 8px 8px 0;
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

body.dark-mode .form-control {
  border-color: #4a5568;
}

body.dark-mode .form-control:focus {
  border-color: #a78bfa;
  box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.1);
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
