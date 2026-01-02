<?php
// Simple audit logger for user actions
class AuditLog extends Model {
    public function log($user_id, $action, $details = null) {
        $stmt = $this->db->prepare('INSERT INTO audit_logs (user_id, action, description, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$user_id, $action, $details]);
    }
}
