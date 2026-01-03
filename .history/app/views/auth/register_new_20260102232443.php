<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NJ Mercy Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 0;
        }

        .register-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .register-icon {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .register-header h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-body {
            padding: 35px 30px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-google {
            width: 100%;
            padding: 14px;
            background: white;
            border: 2px solid #e0e0e0;
            color: #333;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-google:hover {
            border-color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.98);
            padding: 0 20px;
            position: relative;
            color: #999;
            font-size: 13px;
            font-weight: 600;
        }

        .form-floating {
            margin-bottom: 18px;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-floating .form-control:focus,
        .form-floating .form-select:focus {
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .form-floating label {
            padding: 16px;
            color: #666;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #10b981;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            margin-top: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e8e8e8;
        }

        .login-link p {
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #10b981;
            text-decoration: none;
            font-weight: 700;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #28a745;
        }

        .invalid-feedback {
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .form-control.is-invalid ~ .invalid-feedback,
        .form-select.is-invalid ~ .invalid-feedback {
            display: block;
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 15px;
            }
            .register-header {
                padding: 30px 20px;
            }
            .register-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">
                    <i class="fas fa-user-plus fa-3x"></i>
                </div>
                <h3>Create Account</h3>
                <p>Join us today! Please fill in your details below.</p>
            </div>
            <div class="register-body">
                <?php if (isset($_SESSION['flash'])): ?>
                    <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?= $_SESSION['flash']['type'] === 'danger' ? 'exclamation-circle' : 'check-circle' ?> me-2"></i>
                        <?= $_SESSION['flash']['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Google Sign Up -->
                <a href="?r=auth/google" class="btn btn-google">
                    <img src="https://www.google.com/favicon.ico" width="22" height="22" alt="Google">
                    <span>Sign up with Google</span>
                </a>

                <div class="divider">
                    <span>OR</span>
                </div>

                <form method="POST" action="?r=auth/register" id="registerForm" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       placeholder="Full Name" required minlength="3">
                                <label for="full_name"><i class="fas fa-user me-2"></i>Full Name</label>
                                <div class="invalid-feedback">Full name must be at least 3 characters</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       placeholder="Phone Number" required>
                                <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                <div class="invalid-feedback">Please enter a valid phone number</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Email" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="manager">Manager</option>
                                    <option value="staff">Staff</option>
                                </select>
                                <label for="role"><i class="fas fa-user-tag me-2"></i>Role</label>
                                <div class="invalid-feedback">Please select a role</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating position-relative">
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Password" required minlength="6">
                                <label for="password"><i class="fas fa-key me-2"></i>Password</label>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('password')" id="password-toggle"></i>
                                <div class="invalid-feedback">Password must be at least 6 characters</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating position-relative">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       placeholder="Confirm Password" required minlength="6">
                                <label for="confirm_password"><i class="fas fa-key me-2"></i>Confirm Password</label>
                                <i class="fas fa-eye password-toggle" onclick="togglePassword('confirm_password')" id="confirm_password-toggle"></i>
                                <div class="invalid-feedback">Passwords must match</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register" id="submitBtn">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </button>
                </form>

                <div class="login-link">
                    <p>Already have an account? 
                        <a href="?r=auth/login">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-toggle');
            
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

        // Enhanced form validation
        const form = document.getElementById('registerForm');
        const inputs = {
            full_name: document.getElementById('full_name'),
            phone: document.getElementById('phone'),
            email: document.getElementById('email'),
            role: document.getElementById('role'),
            password: document.getElementById('password'),
            confirm_password: document.getElementById('confirm_password')
        };
        const submitBtn = document.getElementById('submitBtn');

        // Create error banner
        function showErrorBanner(message) {
            const existingBanner = document.getElementById('validation-error-banner');
            if (existingBanner) {
                existingBanner.remove();
            }

            const banner = document.createElement('div');
            banner.id = 'validation-error-banner';
            banner.className = 'alert alert-danger alert-dismissible fade show';
            banner.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            
            const registerBody = document.querySelector('.register-body');
            const firstChild = registerBody.firstElementChild;
            registerBody.insertBefore(banner, firstChild);
            
            banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function removeErrorBanner() {
            const banner = document.getElementById('validation-error-banner');
            if (banner) {
                banner.remove();
            }
        }

        // Validation functions
        function validateFullName() {
            const value = inputs.full_name.value.trim();
            if (value.length < 3) {
                inputs.full_name.classList.add('is-invalid');
                inputs.full_name.classList.remove('is-valid');
                return false;
            }
            inputs.full_name.classList.remove('is-invalid');
            inputs.full_name.classList.add('is-valid');
            return true;
        }

        function validatePhone() {
            const value = inputs.phone.value.trim();
            const phoneRegex = /^[0-9+\-\s()]+$/;
            if (!phoneRegex.test(value) || value.length < 10) {
                inputs.phone.classList.add('is-invalid');
                inputs.phone.classList.remove('is-valid');
                return false;
            }
            inputs.phone.classList.remove('is-invalid');
            inputs.phone.classList.add('is-valid');
            return true;
        }

        function validateEmail() {
            const value = inputs.email.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                inputs.email.classList.add('is-invalid');
                inputs.email.classList.remove('is-valid');
                return false;
            }
            inputs.email.classList.remove('is-invalid');
            inputs.email.classList.add('is-valid');
            return true;
        }

        function validateRole() {
            if (!inputs.role.value) {
                inputs.role.classList.add('is-invalid');
                inputs.role.classList.remove('is-valid');
                return false;
            }
            inputs.role.classList.remove('is-invalid');
            inputs.role.classList.add('is-valid');
            return true;
        }

        function validatePassword() {
            const value = inputs.password.value;
            if (value.length < 6) {
                inputs.password.classList.add('is-invalid');
                inputs.password.classList.remove('is-valid');
                return false;
            }
            inputs.password.classList.remove('is-invalid');
            inputs.password.classList.add('is-valid');
            return true;
        }

        function validateConfirmPassword() {
            const password = inputs.password.value;
            const confirmPassword = inputs.confirm_password.value;
            if (password !== confirmPassword || confirmPassword.length < 6) {
                inputs.confirm_password.classList.add('is-invalid');
                inputs.confirm_password.classList.remove('is-valid');
                return false;
            }
            inputs.confirm_password.classList.remove('is-invalid');
            inputs.confirm_password.classList.add('is-valid');
            return true;
        }

        // Real-time validation
        inputs.full_name.addEventListener('input', () => { validateFullName(); removeErrorBanner(); });
        inputs.phone.addEventListener('input', () => { validatePhone(); removeErrorBanner(); });
        inputs.email.addEventListener('input', () => { validateEmail(); removeErrorBanner(); });
        inputs.role.addEventListener('change', () => { validateRole(); removeErrorBanner(); });
        inputs.password.addEventListener('input', () => { validatePassword(); validateConfirmPassword(); removeErrorBanner(); });
        inputs.confirm_password.addEventListener('input', () => { validateConfirmPassword(); removeErrorBanner(); });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const validations = [
                { fn: validateFullName, name: 'Full Name' },
                { fn: validatePhone, name: 'Phone Number' },
                { fn: validateEmail, name: 'Email' },
                { fn: validateRole, name: 'Role' },
                { fn: validatePassword, name: 'Password' },
                { fn: validateConfirmPassword, name: 'Confirm Password' }
            ];

            const errors = [];
            validations.forEach(v => {
                if (!v.fn()) {
                    errors.push(v.name);
                }
            });

            if (errors.length > 0) {
                showErrorBanner('Please fix the errors before submitting: ' + errors.join(', '));
                return false;
            }

            removeErrorBanner();
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
            form.submit();
        });
    </script>
</body>
</html>
