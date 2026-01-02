<?php
class Product extends Model {
    public function all(){
        return $this->db->query('SELECT * FROM products ORDER BY name')->fetchAll();
    }
    public function findByName($name){
        $stmt = $this->db->prepare('SELECT * FROM products WHERE LOWER(name) = LOWER(?) LIMIT 1');
        $stmt->execute([$name]);
        return $stmt->fetch();
    }
    public function find($id){
        $stmt = $this->db->prepare('SELECT * FROM products WHERE product_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($supplier_id, $name, $quantity, $unit_price){
        $total_price = $quantity * $unit_price;
        $stmt = $this->db->prepare('INSERT INTO products (supplier_id, name, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$supplier_id, $name, $quantity, $unit_price, $total_price]);
        return $this->db->lastInsertId();
    }
    public function bySupplier($supplier_id){
        $stmt = $this->db->prepare('SELECT * FROM products WHERE supplier_id = ?');
        $stmt->execute([$supplier_id]);
        return $stmt->fetchAll();
    }
}
