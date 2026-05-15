<?php

class BorrowDetail extends Model {
    protected $table = 'borrow_details';

    public function getByBorrowingId($borrowingId) {
        $query = "SELECT bd.*, a.name as asset_name, a.code as asset_code 
                  FROM {$this->table} bd 
                  LEFT JOIN assets a ON bd.asset_id = a.id 
                  WHERE bd.borrowing_id = :borrowing_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':borrowing_id', $borrowingId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createBatch($borrowingId, $items) {
        $query = "INSERT INTO {$this->table} (borrowing_id, asset_id, quantity) 
                  VALUES (:borrowing_id, :asset_id, :quantity)";
        $stmt = $this->db->prepare($query);
        
        foreach ($items as $item) {
            $stmt->bindParam(':borrowing_id', $borrowingId);
            $stmt->bindParam(':asset_id', $item['asset_id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->execute();
        }
        
        return true;
    }
}
