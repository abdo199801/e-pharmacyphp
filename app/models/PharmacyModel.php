<?php
class PharmacyModel extends Model {
    public function createPharmacyInfo($data) {
        try {
            $sql = "INSERT INTO pharmacy_business_information 
                    (id, pharmacy_name, address, city, country, license_number, phone, client_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $id,
                $data['pharmacy_name'],
                $data['address'],
                $data['city'],
                $data['country'],
                $data['license_number'],
                $data['phone'],
                $data['client_id']
            ]);
        } catch (PDOException $e) {
            error_log("PharmacyModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPharmacyByClientId($clientId) {
        try {
            $sql = "SELECT * FROM pharmacy_business_information WHERE client_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PharmacyModel Error: " . $e->getMessage());
            return null;
        }
    }

    public function updatePharmacyInfo($clientId, $data) {
    try {
        $sql = "UPDATE pharmacy_business_information 
                SET pharmacy_name = ?, address = ?, city = ?, country = ?, 
                    license_number = ?, phone = ?, website = ?, updated_at = NOW() 
                WHERE client_id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['pharmacy_name'],
            $data['address'],
            $data['city'],
            $data['country'],
            $data['license_number'],
            $data['phone'],
            $data['website'],
            $clientId
        ]);
    } catch (PDOException $e) {
        error_log("PharmacyModel Error: " . $e->getMessage());
        return false;
    }
}
}