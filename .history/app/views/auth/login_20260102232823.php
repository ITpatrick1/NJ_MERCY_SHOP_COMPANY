<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NJ Mercy Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.1); }
        }

        .login-container {
            max-width: 480px;
            width: 100%;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 100px rgba(102, 126, 234, 0.2);
            overflow: hidden;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.5);
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

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: ripple 8s linear infinite;
        }

        @keyframes ripple {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-icon {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-header h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            font-size: 15px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .login-body {
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
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .btn-google::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-google:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-google:hover {
            background: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-google img {
            position: relative;
            z-index: 1;
        }

        .btn-google span {
            position: relative;
            z-index: 1;
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
            letter-spacing: 1px;
        }

        .form-floating {
            margin-bottom: 18px;
            position: relative;
        }

        .form-floating .form-control {
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            padding: 1rem 0.75rem;
            height: calc(3.5rem + 2px);
            line-height: 1.25;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-floating .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 2px solid transparent;
            transform-origin: 0 0;
            transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
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
            color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            margin-top: 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e8e8e8;
        }

        .register-link p {
            color: #666;
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        /* Form validation feedback */
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        .form-control.is-valid {
            border-color: #28a745;
            background-image: none;
        }

        .invalid-feedback, .valid-feedback {
            font-size: 13px;
            margin-top: 6px;
        }

        /* Loading state */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            right: 20px;
            margin-top: -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spinner 0.6s linear infinite;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 576px) {
            .login-container {
                padding: 15px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 25px 20px;
            }

            .login-header h3 {
                font-size: 24px;
            }

            .login-icon {
                width: 75px;
                height: 75px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-lock fa-3x"></i>
                </div>
                <h3>Welcome Back</h3>
                <p>Sign in to continue to NJ Mercy Shop</p>
            </div>
            <div class="login-body">
                <?php if (isset($_SESSION['flash'])): ?>
                    <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?= $_SESSION['flash']['type'] === 'danger' ? 'exclamation-circle' : 'check-circle' ?> me-2"></i>
                        <?= $_SESSION['flash']['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Google Sign In -->
                <a href="?r=auth/google" class="btn btn-google">
                    <img src="https://www.google.com/favicon.ico" width="22" height="22" alt="Google">
                    <span>Sign in with Google</span>
                </a>

                <div class="divider">
                    <span>OR</span>
                </div>

                <!-- Login Form -->
                <form method="POST" action="?r=auth/login" id="loginForm" novalidate>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="phone" name="phone" 
                               placeholder="Phone Number" required>
                        <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number</label>
                        <div class="invalid-feedback">Please enter a valid phone number</div>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required minlength="6">
                        <label for="password"><i class="fas fa-key me-2"></i>Password</label>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()" id="toggleIcon"></i>
                        <div class="invalid-feedback">Password must be at least 6 characters</div>
                    </div>

                    <button type="submit" class="btn btn-login" id="submitBtn">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </form>

                <div class="register-link">
                    <p>Don't have an account? 
                        <a href="?r=auth/register">Create one now</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Enhanced form validation
        const form = document.getElementById('loginForm');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');

        // Create error banner
        function showErrorBanner(message) {
            // Remove existing error banner
            const existingBanner = document.getElementById('validation-error-banner');
            if (existingBanner) {
                existingBanner.remove();
            }

            const banner = document.createElement('div');
            banner.id = 'validation-error-banner';
            banner.className = 'alert alert-danger alert-dismissible fade show';
            banner.style.marginBottom = '20px';
            banner.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            
            const loginBody = document.querySelector('.login-body');
            const firstChild = loginBody.firstElementChild;
            loginBody.insertBefore(banner, firstChild);
            
            // Scroll to top
            banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function removeErrorBanner() {
            const banner = document.getElementById('validation-error-banner');
            if (banner) {
                banner.remove();
            }
        }

        // Real-time validation
        phoneInput.addEventListener('input', function() {
            validatePhone();
            removeErrorBanner();
        });

        passwordInput.addEventListener('input', function() {
            validatePassword();
            removeErrorBanner();
        });

        function validatePhone() {
            const phone = phoneInput.value.trim();
            if (phone.length === 0) {
                phoneInput.classList.remove('is-valid', 'is-invalid');
                return false;
            }
            
            // Basic phone validation (can be customized)
            const phoneRegex = /^[0-9+\-\s()]+$/;
            if (phoneRegex.test(phone) && phone.length >= 10) {
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.add('is-valid');
                return true;
            } else {
                phoneInput.classList.remove('is-valid');
                phoneInput.classList.add('is-invalid');
                return false;
            }
        }

        function validatePassword() {
            const password = passwordInput.value;
            if (password.length === 0) {
                passwordInput.classList.remove('is-valid', 'is-invalid');
                return false;
            }
            
            if (password.length >= 6) {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                return true;
            } else {
                passwordInput.classList.remove('is-valid');
                passwordInput.classList.add('is-invalid');
                return false;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const isPhoneValid = validatePhone();
            const isPasswordValid = validatePassword();

            if (!isPhoneValid || !isPasswordValid) {
                // Show validation errors
                const errors = [];
                
                if (!isPhoneValid) {
                    phoneInput.classList.add('is-invalid');
                    errors.push('valid phone number');
                }
                if (!isPasswordValid) {
                    passwordInput.classList.add('is-invalid');
                    errors.push('valid password');
                }
                
                showErrorBanner('Please fix the errors before submitting. Required: ' + errors.join(', '));
                return false;
            }

            // Remove error banner if exists
            removeErrorBanner();

            // Add loading state
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';

            // Submit the form
            form.submit();
        });

        // Remove validation on focus
        phoneInput.addEventListener('focus', function() {
            if (this.value.length === 0) {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });

        passwordInput.addEventListener('focus', function() {
            if (this.value.length === 0) {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });
    </script>
</body>
</html>
