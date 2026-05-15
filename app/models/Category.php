<?php

class Category extends Model {
    protected $table = 'categories';

    public function getWithAssetCount() {
        $query = "SELECT c.id, c.name, c.description, c.created_at, c.updated_at, 
                  COUNT(a.id) as asset_count 
                  FROM {$this->table} c 
                  LEFT JOIN assets a ON c.id = a.category_id 
                  GROUP BY c.id, c.name, c.description, c.created_at, c.updated_at
                  ORDER BY c.name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete($id) {
        // When category is deleted, assets will have category_id set to NULL (ON DELETE SET NULL)
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
