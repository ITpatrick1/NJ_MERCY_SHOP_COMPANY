<style>
.login-form { max-width: 420px; margin: 2.5rem auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(44,62,80,0.08); padding: 2.2rem 2rem 1.5rem 2rem; }
.login-form .logo { display: flex; justify-content: center; margin-bottom: 1.2rem; }
.login-form .logo img { height: 60px; }
.login-form .form-label { font-weight: 500; color: #2a3d66; }
.login-form input, .login-form select { border-radius: 6px; font-size: 1.05rem; }
.login-form input:focus, .login-form select:focus { outline: none; box-shadow: 0 0 0 2px #4e7fff33; border-color: #4e7fff; }
.login-form .password-toggle { position: relative; display: flex; align-items: center; }
.login-form .toggle-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #888; font-size: 1.1rem; }
.login-form .actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; }
.login-form .btn { width: 100%; background: linear-gradient(90deg, #2a3d66 60%, #4e7fff 100%); color: #fff; border: none; border-radius: 6px; padding: 0.8rem; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
.login-form .btn:hover { background: linear-gradient(90deg, #4e7fff 60%, #2a3d66 100%); }
.login-form .links { text-align: center; margin-top: 1.2rem; }
.login-form .links a { color: #4e7fff; text-decoration: none; margin: 0 0.5rem; font-size: 0.98rem; }
.login-form .links a:hover { text-decoration: underline; }
.login-form .error { color: #d32f2f; background: #ffeaea; border: 1px solid #ffcdd2; border-radius: 4px; padding: 0.7rem 1rem; margin-bottom: 1.2rem; text-align: center; font-size: 1rem; }
.login-form .success { color: #388e3c; background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 4px; padding: 0.7rem 1rem; margin-bottom: 1.2rem; text-align: center; font-size: 1rem; }

/* Dark mode support for register form */
body.dark-mode .login-form {
  background: #23272b;
  color: #e0e0e0;
  box-shadow: 0 2px 12px rgba(0,0,0,0.25);
}
body.dark-mode .login-form .form-label {
  color: #e0e0e0;
}
body.dark-mode .login-form input,
body.dark-mode .login-form select {
  background: #181a1b;
  color: #e0e0e0;
  border-color: #444;
}
body.dark-mode .login-form input:focus,
body.dark-mode .login-form select:focus {
  background: #23272b;
  color: #fff;
  border-color: #0d6efd;
}
body.dark-mode .login-form .btn {
  background: linear-gradient(90deg, #23272b 60%, #0d6efd 100%);
  color: #fff;
}
body.dark-mode .login-form .btn:hover {
  background: linear-gradient(90deg, #0d6efd 60%, #23272b 100%);
}
body.dark-mode .login-form .toggle-btn {
  color: #bbb;
}
body.dark-mode .login-form .error {
  color: #ffb4b4;
  background: #3a2323;
  border: 1px solid #b71c1c;
}
body.dark-mode .login-form .success {
  color: #b9f6ca;
  background: #1b3a23;
  border: 1px solid #388e3c;
}
</style>
<div class="login-form">
  <div class="logo">
    <img src="/assets/logo.png" alt="Shop Logo" onerror="this.style.display='none'">
  </div>
  <h3 class="mb-3 text-primary text-center"><i class="fa fa-user-plus"></i> Register New User</h3>
  <form method="post" autocomplete="on">
        <div class="mb-3 text-center">
          <a href="?r=auth/google" class="btn btn-danger w-100" style="background:#ea4335;border:none;"><i class="fab fa-google"></i> Sign up with Google</a>
        </div>
    <?php if(!empty($error)): ?>
      <div class="error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <?php if(!empty($success)): ?>
      <div class="success"><?=htmlspecialchars($success)?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label for="full_name" class="form-label">Full Name</label>
      <input id="full_name" name="full_name" type="text" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Phone Number</label>
      <input id="phone" name="phone" type="text" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email" class="form-control" required placeholder="e.g. user@gmail.com">
    </div>
    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select id="role" name="role" class="form-select" required>
        <option value="manager">Manager</option>
        <option value="staff">Staff</option>
      </select>
    </div>
    <div class="mb-3 password-toggle">
      <label for="password" class="form-label">Password</label>
      <input id="password" name="password" type="password" class="form-control" required>
      <button type="button" class="toggle-btn" tabindex="-1" onclick="const p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.innerHTML=p.type==='password'?'<i class=\'fa fa-eye\'></i>':'<i class=\'fa fa-eye-slash\'></i>';" aria-label="Show/Hide Password"><i class="fa fa-eye"></i></button>
    </div>
    <div class="actions">
      <a href="?r=auth/login" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to Login</a>
      <button class="btn" type="submit"><i class="fa fa-user-plus"></i> Register</button>
    </div>
  </form>
</div>
