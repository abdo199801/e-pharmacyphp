<?php
class DashboardModel extends Model {
    public function getClientDashboard($clientId) {
        try {
            $sql = "SELECT d.*, p.name as pack_name 
                    FROM dashboards d 
                    JOIN subscriptions s ON d.client_id = s.client_id 
                    JOIN pack_abonnement p ON s.pack_id = p.id 
                    WHERE d.client_id = ? AND s.status = 'active'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DashboardModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function getClientDashboardId($clientId) {
        try {
            $sql = "SELECT id FROM dashboards WHERE client_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : null;
        } catch (PDOException $e) {
            error_log("DashboardModel Error: " . $e->getMessage());
            return null;
        }
    }
    public function createDashboard($data) {
    try {
        // Handle case where pack_id might not be provided
        if (isset($data['pack_id'])) {
            $sql = "INSERT INTO dashboards (id, name, description, pack_id, client_id) 
                    VALUES (?, ?, ?, ?, ?)";
            $params = [
                $this->generateUUID(),
                $data['name'],
                $data['description'],
                $data['pack_id'],
                $data['client_id']
            ];
        } else {
            $sql = "INSERT INTO dashboards (id, name, description, client_id) 
                    VALUES (?, ?, ?, ?)";
            $params = [
                $this->generateUUID(),
                $data['name'],
                $data['description'],
                $data['client_id']
            ];
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("DashboardModel Error: " . $e->getMessage());
        return false;
    }
}

}