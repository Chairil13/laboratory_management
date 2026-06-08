<?php

class RegistrationRequest extends Model {
    protected $table = 'registration_requests';

    public function __construct() {
        parent::__construct();
        $this->ensureTable();
    }

    private function ensureTable() {
        $query = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT(11) NOT NULL AUTO_INCREMENT,
            applicant_type ENUM('mahasiswa','dosen') NOT NULL DEFAULT 'mahasiswa',
            name VARCHAR(100) NOT NULL,
            nim VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(30) DEFAULT NULL,
            program_studi VARCHAR(100) NOT NULL,
            semester VARCHAR(20) DEFAULT NULL,
            class_name VARCHAR(50) DEFAULT NULL,
            reason TEXT DEFAULT NULL,
            status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
            admin_notes TEXT DEFAULT NULL,
            reviewed_by INT(11) DEFAULT NULL,
            reviewed_at DATETIME DEFAULT NULL,
            created_user_id INT(11) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_registration_requests_status (status),
            KEY idx_registration_requests_nim (nim),
            KEY idx_registration_requests_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $this->db->exec($query);

        $columns = $this->db->query("SHOW COLUMNS FROM {$this->table} LIKE 'applicant_type'")->fetch();
        if (!$columns) {
            $this->db->exec("ALTER TABLE {$this->table} ADD applicant_type ENUM('mahasiswa','dosen') NOT NULL DEFAULT 'mahasiswa' AFTER id");
        }
    }

    public function existsActive($nim, $email) {
        $query = "SELECT id FROM {$this->table}
                  WHERE (nim = :nim OR email = :email)
                  AND status = 'pending'
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return (bool) $stmt->fetch();
    }

    public function getAllWithReviewer() {
        $query = "SELECT rr.*, u.name AS reviewer_name
                  FROM {$this->table} rr
                  LEFT JOIN users u ON rr.reviewed_by = u.id
                  ORDER BY
                    CASE rr.status
                        WHEN 'pending' THEN 0
                        WHEN 'approved' THEN 1
                        ELSE 2
                    END,
                    rr.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPendingCount() {
        $query = "SELECT COUNT(*) AS total FROM {$this->table} WHERE status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return (int) ($row['total'] ?? 0);
    }

    public function approve($id, $adminId, $createdUserId, $notes = null) {
        $query = "UPDATE {$this->table}
                  SET status = 'approved',
                      admin_notes = :notes,
                      reviewed_by = :admin_id,
                      reviewed_at = NOW(),
                      created_user_id = :created_user_id
                  WHERE id = :id AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':notes', $notes);
        $stmt->bindValue(':admin_id', $adminId);
        $stmt->bindValue(':created_user_id', $createdUserId);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function reject($id, $adminId, $notes = null) {
        $query = "UPDATE {$this->table}
                  SET status = 'rejected',
                      admin_notes = :notes,
                      reviewed_by = :admin_id,
                      reviewed_at = NOW()
                  WHERE id = :id AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':notes', $notes);
        $stmt->bindValue(':admin_id', $adminId);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
