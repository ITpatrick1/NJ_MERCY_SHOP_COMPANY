<?php require_once __DIR__ . '/../layout/header.php'; ?>

<style>
.google-profile-container {
  max-width: 480px;
  margin: 2rem auto;
}

.profile-card-google {
  background: #ffffff;
  border-radius: 24px;
  padding: 0;
  margin-bottom: 1.5rem;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.profile-header-google {
  background: linear-gradient(135deg, #1a73e8 0%, #4285f4 100%);
  padding: 3rem 2rem 2rem;
  text-align: center;
  color: white;
}

.profile-avatar-google {
  width: 96px;
  height: 96px;
  border-radius: 50%;
  border: 4px solid white;
  object-fit: cover;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
  margin: 0 auto 1rem;
  display: block;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.profile-avatar-google:hover {
  transform: scale(1.05);
}

.profile-name-google {
  font-size: 1.5rem;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.profile-email-google {
  font-size: 0.95rem;
  opacity: 0.9;
  margin-bottom: 1rem;
}

.profile-menu-google {
  padding: 0;
}

.menu-item-google {
  display: flex;
  align-items: center;
  padding: 1rem 1.5rem;
  border: none;
  background: transparent;
  width: 100%;
  text-align: left;
  cursor: pointer;
  transition: background 0.2s ease;
  text-decoration: none;
  color: #202124;
  border-bottom: 1px solid #f1f3f4;
}

.menu-item-google:last-child {
  border-bottom: none;
}

.menu-item-google:hover {
  background: #f8f9fa;
}

.menu-icon-google {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
  font-size: 1.125rem;
}

.menu-text-google {
  flex: 1;
}

.menu-title-google {
  font-size: 0.95rem;
  font-weight: 500;
  margin-bottom: 0.125rem;
  color: #202124;
}

.menu-subtitle-google {
  font-size: 0.8125rem;
  color: #5f6368;
}

.menu-arrow-google {
  color: #5f6368;
  font-size: 1.125rem;
}

.section-title-google {
  font-size: 0.875rem;
  font-weight: 500;
  color: #5f6368;
  padding: 0 1.5rem 0.5rem;
  margin-top: 1.5rem;
}

.manage-account-btn {
  display: block;
  width: calc(100% - 3rem);
  margin: 1.5rem 1.5rem;
  padding: 0.75rem;
  border: 1px solid #dadce0;
  border-radius: 24px;
  background: white;
  color: #1a73e8;
  font-weight: 500;
  font-size: 0.9375rem;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: center;
  text-decoration: none;
}

.manage-account-btn:hover {
  background: #f8f9fa;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  color: #1a73e8;
}

/* Dark Mode */
body.dark-mode .profile-card-google {
  background: #2d2e30 !important;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 2px 8px rgba(0, 0, 0, 0.3);
}

body.dark-mode .menu-item-google {
  color: #e8eaed !important;
  border-bottom-color: #3c4043;
}

body.dark-mode .menu-item-google:hover {
  background: #3c4043 !important;
}

body.dark-mode .menu-title-google {
  color: #e8eaed !important;
}

body.dark-mode .menu-subtitle-google {
  color: #9aa0a6 !important;
}

body.dark-mode .menu-arrow-google {
  color: #9aa0a6 !important;
}

body.dark-mode .section-title-google {
  color: #9aa0a6 !important;
}

body.dark-mode .manage-account-btn {
  background: #2d2e30 !important;
  border-color: #5f6368 !important;
  color: #8ab4f8 !important;
}

body.dark-mode .manage-account-btn:hover {
  background: #3c4043 !important;
}

.badge-role-google {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
  margin-top: 0.5rem;
  text-transform: uppercase;
}

.badge-manager-google {
  background: rgba(255, 255, 255, 0.2);
  color: white;
}
</style>

<div class="container my-4">
  <div class="google-profile-container">
    <!-- Main Profile Card -->
    <div class="profile-card-google">
      <!-- Profile Header -->
      <div class="profile-header-google">
        <img 
          src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&size=96&background=1a73e8&color=fff' ?>" 
          alt="Profile Picture" 
          class="profile-avatar-google"
          onclick="window.location.href='?r=profile/edit'"
          title="Click to edit profile"
        >
        <div class="profile-name-google"><?= htmlspecialchars($user['full_name']) ?></div>
        <div class="profile-email-google"><?= htmlspecialchars($user['email'] ?? 'No email set') ?></div>
        <span class="badge-role-google badge-manager-google">
          <i class="fa fa-shield-alt"></i> <?= ucfirst($user['role']) ?>
        </span>
      </div>

      <!-- Manage Account Button -->
      <a href="?r=profile/edit" class="manage-account-btn">
        <i class="fa fa-user-edit"></i> Manage your account
      </a>

      <!-- Quick Actions Menu -->
      <div class="profile-menu-google">
        <a href="?r=profile/edit" class="menu-item-google">
          <div class="menu-icon-google" style="background: #e8f0fe; color: #1a73e8;">
            <i class="fa fa-user-circle"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Personal info</div>
            <div class="menu-subtitle-google">Update your name, phone, and address</div>
          </div>
          <div class="menu-arrow-google">
            <i class="fa fa-chevron-right"></i>
          </div>
        </a>

        <button type="button" class="menu-item-google" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
          <div class="menu-icon-google" style="background: #fef7e0; color: #f9ab00;">
            <i class="fa fa-lock"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Password & Security</div>
            <div class="menu-subtitle-google">Change your password</div>
          </div>
          <div class="menu-arrow-google">
            <i class="fa fa-chevron-right"></i>
          </div>
        </button>

        <a href="?r=dashboard/index" class="menu-item-google">
          <div class="menu-icon-google" style="background: #e6f4ea; color: #1e8e3e;">
            <i class="fa fa-tachometer-alt"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Dashboard</div>
            <div class="menu-subtitle-google">View your business overview</div>
          </div>
          <div class="menu-arrow-google">
            <i class="fa fa-chevron-right"></i>
          </div>
        </a>
      </div>

      <!-- Account Details Section -->
      <div class="section-title-google">Account details</div>
      <div class="profile-menu-google">
        <div class="menu-item-google" style="cursor: default;">
          <div class="menu-icon-google" style="background: #f3e8fd; color: #9334e9;">
            <i class="fa fa-id-card"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">User ID</div>
            <div class="menu-subtitle-google">#<?= $user['user_id'] ?></div>
          </div>
        </div>

        <div class="menu-item-google" style="cursor: default;">
          <div class="menu-icon-google" style="background: #fce8e6; color: #d93025;">
            <i class="fa fa-phone"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Phone number</div>
            <div class="menu-subtitle-google"><?= htmlspecialchars($user['phone'] ?? 'Not set') ?></div>
          </div>
        </div>

        <div class="menu-item-google" style="cursor: default;">
          <div class="menu-icon-google" style="background: #e8f5e9; color: #1e8e3e;">
            <i class="fa fa-calendar-check"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Member since</div>
            <div class="menu-subtitle-google"><?= date('F d, Y', strtotime($user['created_at'])) ?></div>
          </div>
        </div>

        <?php if (!empty($user['address'])): ?>
        <div class="menu-item-google" style="cursor: default;">
          <div class="menu-icon-google" style="background: #fff3e0; color: #e37400;">
            <i class="fa fa-map-marker-alt"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Address</div>
            <div class="menu-subtitle-google"><?= htmlspecialchars($user['address']) ?></div>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Sign Out Section -->
      <div class="section-title-google">Account actions</div>
      <div class="profile-menu-google">
        <a href="?r=auth/logout" class="menu-item-google">
          <div class="menu-icon-google" style="background: #fce8e6; color: #d93025;">
            <i class="fa fa-sign-out-alt"></i>
          </div>
          <div class="menu-text-google">
            <div class="menu-title-google">Sign out</div>
            <div class="menu-subtitle-google">Sign out of your account</div>
          </div>
          <div class="menu-arrow-google">
            <i class="fa fa-chevron-right"></i>
          </div>
        </a>
      </div>
    </div>

    <?php if (!empty($user['bio'])): ?>
    <!-- About Me Card -->
    <div class="profile-card-google" style="padding: 1.5rem;">
      <h6 class="fw-bold mb-3" style="color: #202124;">
        <i class="fa fa-info-circle" style="color: #1a73e8;"></i> About Me
      </h6>
      <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.6;">
        <?= nl2br(htmlspecialchars($user['bio'])) ?>
      </p>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header" style="background: linear-gradient(135deg, #1a73e8 0%, #4285f4 100%); color: white; border: none;">
        <h5 class="modal-title fw-bold"><i class="fa fa-lock"></i> Change Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="?r=profile/changePassword">
        <div class="modal-body" style="padding: 2rem;">
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-lock text-warning"></i> Current Password
            </label>
            <input type="password" name="current_password" class="form-control form-control-lg" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-key text-primary"></i> New Password
            </label>
            <input type="password" name="new_password" class="form-control form-control-lg" minlength="6" required>
            <small class="text-muted">Minimum 6 characters</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">
              <i class="fa fa-check-circle text-success"></i> Confirm New Password
            </label>
            <input type="password" name="confirm_password" class="form-control form-control-lg" minlength="6" required>
          </div>
        </div>
        <div class="modal-footer" style="border: none; padding: 1rem 2rem 2rem;">
          <button type="button" class="btn btn-light btn-lg" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Update Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
