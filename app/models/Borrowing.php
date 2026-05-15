<?php

class Borrowing extends Model {
    protected $table = 'borrowings';

    public function getAllWithDetails() {
        $query = "SELECT b.*, u.name as user_name, u.nim_nip 
                  FROM {$this->table} b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  ORDER BY b.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByUserId($userId) {
        $query = "SELECT b.*, u.name as user_name 
                  FROM {$this->table} b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  WHERE b.user_id = :user_id 
                  ORDER BY b.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByStatus($status) {
        $query = "SELECT b.*, u.name as user_name, u.nim_nip 
                  FROM {$this->table} b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  WHERE b.status = :status 
                  ORDER BY b.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status, $notes = null) {
        $query = "UPDATE {$this->table} 
                  SET status = :status, notes = :notes, updated_at = NOW() 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':notes', $notes);
        return $stmt->execute();
    }

    public function getPendingCount() {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function getActiveBorrowings() {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'borrowed'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
