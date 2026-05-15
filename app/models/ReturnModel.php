<?php

class ReturnModel extends Model {
    protected $table = 'returns';

    public function getAllWithDetails() {
        $query = "SELECT r.*, b.borrow_code, u.name as user_name 
                  FROM {$this->table} r 
                  LEFT JOIN borrowings b ON r.borrowing_id = b.id 
                  LEFT JOIN users u ON b.user_id = u.id 
                  ORDER BY r.return_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByBorrowingId($borrowingId) {
        $query = "SELECT * FROM {$this->table} WHERE borrowing_id = :borrowing_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':borrowing_id', $borrowingId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPendingReturns() {
        $query = "SELECT r.*, b.borrow_code, u.name as user_name, u.nim_nip
                  FROM {$this->table} r 
                  LEFT JOIN borrowings b ON r.borrowing_id = b.id 
                  LEFT JOIN users u ON b.user_id = u.id 
                  WHERE r.status = 'pending_return'
                  ORDER BY r.return_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReturnHistory() {
        $query = "SELECT r.*, b.borrow_code, u.name as user_name, u.nim_nip,
                  v.name as verified_by_name
                  FROM {$this->table} r 
                  LEFT JOIN borrowings b ON r.borrowing_id = b.id 
                  LEFT JOIN users u ON b.user_id = u.id 
                  LEFT JOIN users v ON r.verified_by = v.id
                  WHERE r.status IN ('returned', 'rejected')
                  ORDER BY r.verified_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status, $verifiedBy, $rejectionReason = null) {
        $query = "UPDATE {$this->table} 
                  SET `status` = :status, 
                      `verified_by` = :verified_by, 
                      `verified_at` = :verified_at,
                      `rejection_reason` = :rejection_reason
                  WHERE `id` = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':verified_by', $verifiedBy);
        $verifiedAt = date('Y-m-d H:i:s');
        $stmt->bindParam(':verified_at', $verifiedAt);
        $stmt->bindParam(':rejection_reason', $rejectionReason);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getReturnWithDetails($id) {
        $query = "SELECT r.*, b.borrow_code, b.user_id, u.name as user_name, u.nim_nip
                  FROM {$this->table} r 
                  LEFT JOIN borrowings b ON r.borrowing_id = b.id 
                  LEFT JOIN users u ON b.user_id = u.id 
                  WHERE r.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
