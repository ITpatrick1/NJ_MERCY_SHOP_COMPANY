<?php
class ProfileController extends Controller {
    private function ensure(){ 
        if(empty($_SESSION['user'])) redirect('?r=auth/login'); 
    }

    public function index() {
        $this->ensure();
        $userModel = $this->model('User');
        $user = $userModel->findById($_SESSION['user']['user_id']);
        
        $this->view('profile/index', ['user' => $user]);
    }

    public function edit() {
        $this->ensure();
        $userModel = $this->model('User');
        $user = $userModel->findById($_SESSION['user']['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            
            // Validation
            if (empty($full_name)) {
                $this->setFlash('Full name is required', 'danger');
                $this->view('profile/edit', ['user' => $user]);
                return;
            }
            
            // Handle profile picture upload
            $profile_picture = $user['profile_picture'] ?? null;
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['profile_picture']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    // Create uploads directory if it doesn't exist
                    $upload_dir = 'uploads/profiles/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    // Generate unique filename
                    $new_filename = 'profile_' . $_SESSION['user']['user_id'] . '_' . time() . '.' . $ext;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                        // Delete old profile picture if exists
                        if ($profile_picture && file_exists($profile_picture)) {
                            unlink($profile_picture);
                        }
                        $profile_picture = $upload_path;
                    }
                }
            }
            
            // Update user profile
            $updated = $userModel->updateProfile(
                $_SESSION['user']['user_id'],
                $full_name,
                $phone,
                $email,
                $address,
                $bio,
                $profile_picture
            );
            
            if ($updated) {
                // Update session data
                $_SESSION['user']['full_name'] = $full_name;
                
                $this->setFlash('Profile updated successfully!', 'success');
                redirect('?r=profile/index');
            } else {
                $this->setFlash('Failed to update profile', 'danger');
            }
        }
        
        $this->view('profile/edit', ['user' => $user]);
    }

    public function changePassword() {
        $this->ensure();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            $userModel = $this->model('User');
            $user = $userModel->findById($_SESSION['user']['user_id']);
            
            // Verify current password
            if (!password_verify($current_password, $user['password_hash'])) {
                $this->setFlash('Current password is incorrect', 'danger');
                redirect('?r=profile/index');
                return;
            }
            
            // Validate new password
            if (strlen($new_password) < 6) {
                $this->setFlash('New password must be at least 6 characters', 'danger');
                redirect('?r=profile/index');
                return;
            }
            
            if ($new_password !== $confirm_password) {
                $this->setFlash('New passwords do not match', 'danger');
                redirect('?r=profile/index');
                return;
            }
            
            // Update password
            $updated = $userModel->updatePassword($_SESSION['user']['user_id'], $new_password);
            
            if ($updated) {
                $this->setFlash('Password changed successfully!', 'success');
            } else {
                $this->setFlash('Failed to change password', 'danger');
            }
        }
        
        redirect('?r=profile/index');
    }
}
