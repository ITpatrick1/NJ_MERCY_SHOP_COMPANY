<?php
class User extends Model {
        public function findByEmail($email){
            $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            return $stmt->fetch();
        }
    public function findByPhone($phone){
        $stmt = $this->db->prepare('SELECT * FROM users WHERE phone = ? LIMIT 1');
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }
    public function findById($id){
        $stmt = $this->db->prepare('SELECT * FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($full_name,$phone,$role,$password,$email){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('INSERT INTO users (full_name,phone,role,password_hash,email) VALUES (?,?,?,?,?)');
        $stmt->execute([$full_name,$phone,$role,$hash,$email]);
        return $this->db->lastInsertId();
    }
    
    public function updateProfile($user_id, $full_name, $phone, $email, $address, $bio, $profile_picture) {
        $stmt = $this->db->prepare('UPDATE users SET full_name = ?, phone = ?, email = ?, address = ?, bio = ?, profile_picture = ? WHERE user_id = ?');
        return $stmt->execute([$full_name, $phone, $email, $address, $bio, $profile_picture, $user_id]);
    }
    
    public function updatePassword($user_id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('UPDATE users SET password_hash = ? WHERE user_id = ?');
        return $stmt->execute([$hash, $user_id]);
    }
}

