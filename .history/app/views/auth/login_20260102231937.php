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
            padding: 14px 16px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-floating .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
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
