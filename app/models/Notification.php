<?php

class Notification extends Model {
    protected $table = 'notifications';

    public function getByUserId($userId, $limit = 10) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC 
                  LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUnreadCount($userId) {
        $query = "SELECT COUNT(*) as total FROM {$this->table} 
                  WHERE user_id = :user_id AND is_read = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function markAsRead($id) {
        $query = "UPDATE {$this->table} SET is_read = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function markAllAsRead($userId) {
        $query = "UPDATE {$this->table} SET is_read = 1 WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
}
