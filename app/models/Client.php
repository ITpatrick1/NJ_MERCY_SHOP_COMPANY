<?php

class Client extends Model {
    public function findByPhone($phone){
        $stmt = $this->db->prepare('SELECT * FROM clients WHERE phone = ? LIMIT 1');
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }
    
    public function create($name, $phone, $tin_number = null){
        $stmt = $this->db->prepare('INSERT INTO clients (name, phone, tin_number) VALUES (?, ?, ?)');
        $stmt->execute([$name, $phone, $tin_number]);
        return $this->db->lastInsertId();
    }
    
    public function update($client_id, $name, $phone, $tin_number = null){
        $stmt = $this->db->prepare('UPDATE clients SET name = ?, phone = ?, tin_number = ? WHERE client_id = ?');
        return $stmt->execute([$name, $phone, $tin_number, $client_id]);
    }
    
    public function find($id){
        $stmt = $this->db->prepare('SELECT * FROM clients WHERE client_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getOutstandingDebt($client_id){
        $stmt = $this->db->prepare('
            SELECT SUM(balance) as total_debt 
            FROM credit_sales 
            WHERE client_id = ? 
              AND status IN ("pending", "active", "overdue", "partial_paid")
              AND balance > 0
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetchColumn() ?? 0;
    }
    
    public function getUnpaidCredits($client_id){
        $stmt = $this->db->prepare('
            SELECT cs.*, p.name as product_name 
            FROM credit_sales cs
            JOIN products p ON cs.product_id = p.product_id
            WHERE cs.client_id = ? 
              AND cs.status IN ("pending", "active", "overdue", "partial_paid")
              AND cs.balance > 0
            ORDER BY cs.due_date ASC
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll();
    }
    
    public function all(){
        $stmt = $this->db->query('SELECT * FROM clients ORDER BY name ASC');
        return $stmt->fetchAll();
    }
}
