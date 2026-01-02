<?php
class Credit extends Model {
    public function create($client_id, $product, $quantity, $unit_price, $recorded_by, $due_date = null) {
        // $product can be product_id (int) or product_name (string)
        if (is_numeric($product)) {
            $product_id = $product;
        } else {
            // Try to find product by name (case-insensitive)
            $stmt = $this->db->prepare('SELECT * FROM products WHERE LOWER(name) = LOWER(?) LIMIT 1');
            $stmt->execute([$product]);
            $row = $stmt->fetch();
            if ($row) {
                $product_id = $row['product_id'];
            } else {
                // Use a valid supplier_id and quantity > 0 to satisfy constraints
                require_once __DIR__ . '/Supplier.php';
                $supplierModel = new Supplier();
                $supplier_id = $supplierModel->getDefaultSupplierId();
                $qty = max(1, (int)$quantity); // ensure at least 1
                $total_price = $qty * $unit_price;
                $stmt2 = $this->db->prepare('INSERT INTO products (supplier_id, name, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)');
                $stmt2->execute([$supplier_id, $product, $qty, $unit_price, $total_price]);
                $product_id = $this->db->lastInsertId();
            }
        }
        $date_issued = date('Y-m-d');
        if (!$due_date) {
            $due_date = date('Y-m-d', strtotime($date_issued . ' +3 days'));
        }
        $total_price = $quantity * $unit_price;
        $stmt = $this->db->prepare('INSERT INTO credit_sales (client_id, product_id, quantity, unit_price, total_price, date_issued, due_date, status, recorded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$client_id, $product_id, $quantity, $unit_price, $total_price, $date_issued, $due_date, 'pending', $recorded_by]);
        return $this->db->lastInsertId();
    }
    public function all() {
        $stmt = $this->db->prepare("SELECT cs.*, c.name as client_name, c.phone, p.name as product_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id JOIN products p ON cs.product_id = p.product_id ORDER BY cs.date_issued DESC, cs.credit_id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function all() {
        $stmt = $this->db->prepare("SELECT cs.*, c.name as client_name, c.phone, p.name as product_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id JOIN products p ON cs.product_id = p.product_id ORDER BY cs.date_issued DESC, cs.credit_id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function overdue() {
        $stmt = $this->db->prepare("SELECT cs.*, c.name as client_name, c.phone FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id WHERE cs.due_date < CURDATE() AND cs.status IN ('active','overdue') ORDER BY cs.due_date ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM credit_sales WHERE credit_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function markApproved($credit_id, $approved_by, $remarks = '') {
        $stmt = $this->db->prepare("UPDATE credit_sales SET status='approved', approved_by = ?, approved_at = NOW() WHERE credit_id = ?");
        return $stmt->execute([$approved_by, $credit_id]);
    }
    
    public function rejectCredit($credit_id, $approved_by, $reason = '') {
        $stmt = $this->db->prepare("UPDATE credit_sales SET status='rejected', approved_by = ?, approved_at = NOW(), rejection_reason = ? WHERE credit_id = ?");
        return $stmt->execute([$approved_by, $reason, $credit_id]);
    }
    
    public function editCreditStatus($credit_id) {
        $stmt = $this->db->prepare("UPDATE credit_sales SET status='pending', approved_by = NULL, approved_at = NULL, rejection_reason = NULL WHERE credit_id = ?");
        return $stmt->execute([$credit_id]);
    }

    public function updateOverdueStatuses() {
        $stmt = $this->db->prepare("UPDATE credit_sales SET status='overdue' WHERE due_date < CURDATE() AND status='active'");
        return $stmt->execute();
    }

    public function findByClient($client_id) {
        $stmt = $this->db->prepare('SELECT cs.*, c.name as client_name, c.phone, c.tin_number, p.name as product_name FROM credit_sales cs JOIN clients c ON cs.client_id = c.client_id JOIN products p ON cs.product_id = p.product_id WHERE cs.client_id = ? ORDER BY cs.date_issued DESC, cs.credit_id DESC');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll();
    }
    
    public function getClientSummary($client_id) {
        $stmt = $this->db->prepare('
            SELECT 
                COUNT(*) as total_credits,
                SUM(total_price) as total_amount,
                SUM(amount_paid) as total_paid,
                SUM(balance) as total_balance
            FROM credit_sales 
            WHERE client_id = ? 
              AND status IN ("pending", "active", "overdue", "partial_paid", "approved")
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetch();
    }
}
