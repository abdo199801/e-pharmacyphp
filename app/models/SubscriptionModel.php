<?php
class SubscriptionModel extends Model {
    public function getDefaultPack() {
        try {
            $sql = "SELECT * FROM pack_abonnement WHERE status = 'active' ORDER BY price ASC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("SubscriptionModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function createSubscription($data) {
        try {
            $sql = "INSERT INTO subscriptions (id, client_id, pack_id, start_date, end_date, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $id,
                $data['client_id'],
                $data['pack_id'],
                $data['start_date'],
                $data['end_date'],
                $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("SubscriptionModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getClientSubscription($clientId) {
        try {
            $sql = "SELECT s.*, p.name as pack_name, p.price, p.duration_months 
                    FROM subscriptions s 
                    JOIN pack_abonnement p ON s.pack_id = p.id 
                    WHERE s.client_id = ? AND s.status = 'active' 
                    ORDER BY s.created_at DESC 
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("SubscriptionModel Error: " . $e->getMessage());
            return null;
        }
    }
}