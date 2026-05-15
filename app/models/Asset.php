<?php

class Asset extends Model {
    protected $table = 'assets';

    public function getAllWithCategory() {
        $query = "SELECT a.*, c.name as category_name 
                  FROM {$this->table} a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  ORDER BY a.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAvailableAssets() {
        $query = "SELECT a.*, c.name as category_name 
                  FROM {$this->table} a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE a.available_quantity > 0 
                  ORDER BY a.name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStock($assetId, $quantity, $operation = 'decrease') {
        if ($operation === 'decrease') {
            $query = "UPDATE {$this->table} 
                      SET available_quantity = available_quantity - :quantity 
                      WHERE id = :id AND available_quantity >= :quantity";
        } else {
            $query = "UPDATE {$this->table} 
                      SET available_quantity = available_quantity + :quantity 
                      WHERE id = :id";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $assetId);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function updateConditionOnReturn($assetId, $quantity, $condition) {
        switch ($condition) {
            case 'rusak ringan':
                // Masuk available (masih bisa dipinjam), pindah dari qty_good ke qty_minor_damage
                $query = "UPDATE {$this->table}
                          SET available_quantity = available_quantity + :quantity,
                              qty_good           = GREATEST(qty_good - :quantity, 0),
                              qty_minor_damage   = qty_minor_damage + :quantity
                          WHERE id = :id";
                break;
            case 'rusak berat':
                // TIDAK masuk available (tidak bisa dipinjam), pindah dari qty_good ke qty_major_damage
                $query = "UPDATE {$this->table}
                          SET qty_good         = GREATEST(qty_good - :quantity, 0),
                              qty_major_damage = qty_major_damage + :quantity
                          WHERE id = :id";
                break;
            default: // baik
                $query = "UPDATE {$this->table}
                          SET available_quantity = available_quantity + :quantity
                          WHERE id = :id";
                break;
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $assetId);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function getTotalAssets() {
        $query = "SELECT SUM(total_quantity) as total FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function getAvailableCount() {
        $query = "SELECT SUM(available_quantity) as total FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function getBorrowedCount() {
        $query = "SELECT SUM(total_quantity - available_quantity) as total FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
