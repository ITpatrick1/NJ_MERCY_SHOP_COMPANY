<?php require_once __DIR__ . '/../layout/header.php'; ?>

<style>
.edit-profile-container {
  max-width: 900px;
  margin: 0 auto;
}

.edit-profile-header {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border-radius: 16px;
  padding: 2rem;
  color: white;
  margin-bottom: 2rem;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.profile-upload-area {
  text-align: center;
  padding: 2rem;
  border: 3px dashed #d1d5db;
  border-radius: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  background: #f9fafb;
}

.profile-upload-area:hover {
  border-color: #10b981;
  background: #ecfdf5;
}

.profile-preview {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto 1rem;
  border: 4px solid #10b981;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.form-section {
  background: #ffffff;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-section h5 {
  color: #1f2937;
  font-weight: 700;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #e5e7eb;
}

.section-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 0.75rem;
}

body.dark-mode .form-section {
  background: #23272b !important;
  border: 1px solid #4a5568;
}

body.dark-mode .form-section h5 {
  color: #e5e7eb !important;
  border-bottom-color: #4a5568;
}

body.dark-mode .profile-upload-area {
  background: #1a1d23;
  border-color: #4a5568;
}

body.dark-mode .profile-upload-area:hover {
  border-color: #10b981;
  background: #1f2937;
}

body.dark-mode .form-control,
body.dark-mode .form-select {
  background: #1a1d23 !important;
  border-color: #4a5568 !important;
  color: #e5e7eb !important;
}

body.dark-mode .form-control:focus,
body.dark-mode .form-select:focus {
  background: #23272b !important;
  border-color: #10b981 !important;
  color: #e5e7eb !important;
}
</style>

<div class="container my-4 edit-profile-container">
  <!-- Header -->
  <div class="edit-profile-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h2 class="fw-bold mb-1">
          <i class="fa fa-user-edit"></i> Edit Profile
        </h2>
        <p class="mb-0 opacity-75">Update your personal information and settings</p>
      </div>
      <a href="?r=profile/index" class="btn btn-light btn-lg">
        <i class="fa fa-arrow-left"></i> Back to Profile
      </a>
    </div>
  </div>

  <form method="post" enctype="multipart/form-data">
    <!-- Profile Picture Section -->
    <div class="form-section">
      <h5>
        <div class="section-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
          <i class="fa fa-camera text-white"></i>
        </div>
        Profile Picture
      </h5>
      
      <div class="profile-upload-area" onclick="document.getElementById('profile_picture').click()">
        <img 
          id="preview" 
          src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&size=150&background=10b981&color=fff' ?>" 
          alt="Profile Preview" 
          class="profile-preview"
        >
        <div>
          <i class="fa fa-cloud-upload-alt fa-2x text-success mb-2"></i>
          <p class="fw-bold mb-1">Click to upload profile picture</p>
          <small class="text-muted">Supported formats: JPG, PNG, GIF (Max 5MB)</small>
        </div>
      </div>
      <input 
        type="file" 
        id="profile_picture" 
        name="profile_picture" 
        class="d-none" 
        accept="image/*"
        onchange="previewImage(this)"
      >
    </div>

    <!-- Personal Information Section -->
    <div class="form-section">
      <h5>
        <div class="section-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
          <i class="fa fa-user text-white"></i>
        </div>
        Personal Information
      </h5>
      
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">
            <i class="fa fa-user-circle text-primary"></i> Full Name *
          </label>
          <input 
            type="text" 
            name="full_name" 
            class="form-control form-control-lg" 
            value="<?= htmlspecialchars($user['full_name']) ?>" 
            required
          >
        </div>
        
        <div class="col-md-6">
          <label class="form-label fw-bold">
            <i class="fa fa-phone text-success"></i> Phone Number
          </label>
          <input 
            type="tel" 
            name="phone" 
            class="form-control form-control-lg" 
            value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
          >
        </div>
        
        <div class="col-12">
          <label class="form-label fw-bold">
            <i class="fa fa-envelope text-warning"></i> Email Address
          </label>
          <input 
            type="email" 
            name="email" 
            class="form-control form-control-lg" 
            value="<?= htmlspecialchars($user['email'] ?? '') ?>"
          >
        </div>
        
        <div class="col-12">
          <label class="form-label fw-bold">
            <i class="fa fa-map-marker-alt text-danger"></i> Address
          </label>
          <input 
            type="text" 
            name="address" 
            class="form-control form-control-lg" 
            value="<?= htmlspecialchars($user['address'] ?? '') ?>"
            placeholder="Enter your address"
          >
        </div>
      </div>
    </div>

    <!-- Bio Section -->
    <div class="form-section">
      <h5>
        <div class="section-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
          <i class="fa fa-info-circle text-white"></i>
        </div>
        About Me
      </h5>
      
      <label class="form-label fw-bold">
        <i class="fa fa-comment-alt text-info"></i> Bio / Description
      </label>
      <textarea 
        name="bio" 
        class="form-control" 
        rows="4" 
        placeholder="Tell us about yourself..."
      ><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
      <small class="text-muted">This will be displayed on your profile page</small>
    </div>

    <!-- Account Information (Read-only) -->
    <div class="form-section">
      <h5>
        <div class="section-icon" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%);">
          <i class="fa fa-shield-alt text-white"></i>
        </div>
        Account Information (Read-only)
      </h5>
      
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">
            <i class="fa fa-id-badge text-secondary"></i> User ID
          </label>
          <input 
            type="text" 
            class="form-control" 
            value="#<?= $user['user_id'] ?>" 
            readonly
          >
        </div>
        
        <div class="col-md-6">
          <label class="form-label fw-bold">
            <i class="fa fa-shield-alt text-secondary"></i> Role
          </label>
          <input 
            type="text" 
            class="form-control" 
            value="<?= ucfirst($user['role']) ?>" 
            readonly
          >
        </div>
        
        <div class="col-12">
          <label class="form-label fw-bold">
            <i class="fa fa-calendar-alt text-secondary"></i> Member Since
          </label>
          <input 
            type="text" 
            class="form-control" 
            value="<?= date('F d, Y \a\t h:i A', strtotime($user['created_at'])) ?>" 
            readonly
          >
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-3 justify-content-end">
      <a href="?r=profile/index" class="btn btn-secondary btn-lg">
        <i class="fa fa-times"></i> Cancel
      </a>
      <button type="submit" class="btn btn-success btn-lg">
        <i class="fa fa-save"></i> Save Changes
      </button>
    </div>
  </form>
</div>

<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('preview').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
