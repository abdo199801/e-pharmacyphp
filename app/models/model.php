<?php
class Model {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    protected function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    protected function logAudit($tableName, $recordId, $action, $oldValues = null, $newValues = null) {
        try {
            $clientId = $_SESSION['client_id'] ?? 'system';
            $sql = "INSERT INTO audit_logs (id, table_name, record_id, action, old_values, new_values, client_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->generateUUID(),
                $tableName,
                $recordId,
                $action,
                $oldValues ? json_encode($oldValues) : null,
                $newValues ? json_encode($newValues) : null,
                $clientId
            ]);
        } catch (Exception $e) {
            error_log("Audit log error: " . $e->getMessage());
            return false;
        }
    }
}