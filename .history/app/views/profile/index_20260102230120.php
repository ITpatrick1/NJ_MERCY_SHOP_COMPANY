<?php require_once __DIR__ . '/../layout/header.php'; ?>

<style>
.profile-container {
  max-width: 1200px;
  margin: 0 auto;
}

.profile-header {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  border-radius: 16px;
  padding: 2rem;
  color: white;
  margin-bottom: 2rem;
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.profile-avatar-large {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 5px solid white;
  object-fit: cover;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.profile-card {
  background: #ffffff;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.profile-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.profile-info-item {
  padding: 1rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.profile-info-item:last-child {
  border-bottom: none;
}

.profile-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.badge-role {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-weight: 600;
  font-size: 0.875rem;
  text-transform: uppercase;
}

.badge-manager {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
}

.badge-staff {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
}

body.dark-mode .profile-card {
  background: #23272b !important;
  border: 1px solid #4a5568;
  color: #e5e7eb;
}

body.dark-mode .profile-info-item {
  border-bottom-color: #4a5568;
}

body.dark-mode .profile-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
</style>

<div class="container my-4 profile-container">
  <!-- Profile Header -->
  <div class="profile-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="d-flex align-items-center gap-4">
        <img 
          src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&size=120&background=8b5cf6&color=fff' ?>" 
          alt="Profile Picture" 
          class="profile-avatar-large"
        >
        <div>
          <h2 class="fw-bold mb-2"><?= htmlspecialchars($user['full_name']) ?></h2>
          <span class="badge-role <?= $user['role'] === 'manager' ? 'badge-manager' : 'badge-staff' ?>">
            <i class="fa fa-shield-alt"></i> <?= ucfirst($user['role']) ?>
          </span>
          <p class="mb-0 mt-2 opacity-75">
            <i class="fa fa-calendar-alt"></i> Member since <?= date('F d, Y', strtotime($user['created_at'])) ?>
          </p>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="?r=profile/edit" class="btn btn-light btn-lg">
          <i class="fa fa-edit"></i> Edit Profile
        </a>
        <a href="?r=dashboard/index" class="btn btn-outline-light btn-lg">
          <i class="fa fa-arrow-left"></i> Dashboard
        </a>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Personal Information -->
    <div class="col-md-6">
      <div class="profile-card">
        <h5 class="fw-bold mb-4">
          <div class="d-inline-flex align-items-center">
            <div class="profile-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
              <i class="fa fa-user text-white"></i>
            </div>
            Personal Information
          </div>
        </h5>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-id-card text-primary fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">User ID</small>
              <strong>#<?= $user['user_id'] ?></strong>
            </div>
          </div>
        </div>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-user-circle text-success fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Full Name</small>
              <strong><?= htmlspecialchars($user['full_name']) ?></strong>
            </div>
          </div>
        </div>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-phone text-info fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Phone Number</small>
              <strong><?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></strong>
            </div>
          </div>
        </div>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-envelope text-warning fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Email Address</small>
              <strong><?= htmlspecialchars($user['email'] ?? 'Not provided') ?></strong>
            </div>
          </div>
        </div>
        
        <?php if (!empty($user['address'])): ?>
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-map-marker-alt text-danger fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Address</small>
              <strong><?= htmlspecialchars($user['address']) ?></strong>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Account Settings -->
    <div class="col-md-6">
      <div class="profile-card">
        <h5 class="fw-bold mb-4">
          <div class="d-inline-flex align-items-center">
            <div class="profile-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
              <i class="fa fa-cog text-white"></i>
            </div>
            Account Settings
          </div>
        </h5>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-shield-alt text-primary fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Account Role</small>
              <strong><?= ucfirst($user['role']) ?></strong>
            </div>
          </div>
          <span class="badge-role <?= $user['role'] === 'manager' ? 'badge-manager' : 'badge-staff' ?>">
            <?= ucfirst($user['role']) ?>
          </span>
        </div>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center">
            <i class="fa fa-calendar-check text-success fa-lg me-3"></i>
            <div>
              <small class="text-muted d-block">Account Created</small>
              <strong><?= date('M d, Y \a\t h:i A', strtotime($user['created_at'])) ?></strong>
            </div>
          </div>
        </div>
        
        <div class="profile-info-item">
          <div class="d-flex align-items-center flex-grow-1">
            <i class="fa fa-lock text-warning fa-lg me-3"></i>
            <div class="flex-grow-1">
              <small class="text-muted d-block">Password</small>
              <strong>••••••••</strong>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="fa fa-key"></i> Change
          </button>
        </div>
      </div>

      <!-- Bio Section -->
      <?php if (!empty($user['bio'])): ?>
      <div class="profile-card">
        <h5 class="fw-bold mb-3">
          <div class="d-inline-flex align-items-center">
            <div class="profile-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
              <i class="fa fa-info-circle text-white"></i>
            </div>
            About Me
          </div>
        </h5>
        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;">
        <h5 class="modal-title"><i class="fa fa-key"></i> Change Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="?r=profile/changePassword">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-lock"></i> Current Password
            </label>
            <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-lock"></i> New Password
            </label>
            <input type="password" name="new_password" class="form-control" minlength="6" required>
            <small class="text-muted">Minimum 6 characters</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-check-circle"></i> Confirm New Password
            </label>
            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Update Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
