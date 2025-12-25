<?php
class ClientModel extends Model {
    
    // Get client by email
    public function getClientByEmail($email) {
        try {
            $sql = "SELECT * FROM clients WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    // Get client by ID
    public function getClientById($id) {
        try {
            $sql = "SELECT * FROM clients WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    // Create new client
    public function createClient($data) {
        try {
            $sql = "INSERT INTO clients (id, firstname, lastname, email, password, phone, address, role) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $id, 
                $data['firstname'], 
                $data['lastname'], 
                $data['email'], 
                $data['password'], 
                $data['phone'], 
                $data['address'],
                $data['role'] ?? 'NORMALCLIENT'
            ]);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // ============ MISSING OTP METHODS - ADD THESE ============
    
    /**
     * Update client with OTP data
     * This is the method that's missing and causing the OTP not to save
     */
    public function updateClientOTP($clientId, $otpCode, $expiresAt, $isVerified = 0) {
        try {
            $sql = "UPDATE clients SET otp_code = ?, otp_expires_at = ?, is_verified = ?, updated_at = NOW() 
                    WHERE id = ?";
            
            error_log("🔄 ClientModel: Updating OTP for client $clientId");
            error_log("🔄 OTP: $otpCode, Expires: $expiresAt, Verified: $isVerified");
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$otpCode, $expiresAt, $isVerified, $clientId]);
            
            error_log("🔄 OTP Update Result: " . ($result ? 'SUCCESS' : 'FAILED'));
            
            if ($result) {
                error_log("✅ Rows affected: " . $stmt->rowCount());
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("❌ OTP Update Error: " . implode(', ', $errorInfo));
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("❌ ClientModel OTP Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify OTP and mark user as verified
     */
    public function verifyClientOTP($clientId) {
        try {
            $sql = "UPDATE clients SET is_verified = 1, otp_code = NULL, otp_expires_at = NULL, updated_at = NOW() 
                    WHERE id = ?";
            
            error_log("🔄 ClientModel: Verifying client $clientId");
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$clientId]);
            
            error_log("🔄 Verify OTP Result: " . ($result ? 'SUCCESS' : 'FAILED'));
            return $result;
            
        } catch (PDOException $e) {
            error_log("❌ ClientModel Verify Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * General update method that handles any fields dynamically
     * This replaces your current updateClient method
     */
    public function updateClient($clientId, $data) {
        try {
            // Build dynamic update query
            $setParts = [];
            $params = [];
            
            foreach ($data as $key => $value) {
                $setParts[] = "$key = ?";
                $params[] = $value;
            }
            
            // Add updated_at
            $setParts[] = "updated_at = NOW()";
            
            // Add client ID for WHERE clause
            $params[] = $clientId;
            
            $setClause = implode(', ', $setParts);
            $sql = "UPDATE clients SET $setClause WHERE id = ?";
            
            error_log("🔄 ClientModel: Dynamic update for client $clientId");
            error_log("🔄 SQL: $sql");
            error_log("🔄 Data: " . print_r($data, true));
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($params);
            
            error_log("🔄 Update Result: " . ($result ? 'SUCCESS' : 'FAILED'));
            
            if ($result) {
                error_log("✅ Rows affected: " . $stmt->rowCount());
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("❌ Update Error: " . implode(', ', $errorInfo));
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("❌ ClientModel Update Error: " . $e->getMessage());
            return false;
        }
    }
    
    // ============ END OF MISSING OTP METHODS ============
    
    // Get last inserted client ID
    public function getLastInsertId() {
        try {
            $sql = "SELECT id FROM clients ORDER BY created_at DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : null;
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    // Get all pharmacies (simple version)
    public function getAllPharmacies() {
        try {
            $sql = "SELECT c.*, pbi.* 
                    FROM clients c 
                    LEFT JOIN pharmacy_business_information pbi ON c.id = pbi.client_id 
                    WHERE c.role = 'ADMINISTRATORCLIENT'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get all pharmacies with details (simplified version for HomeController)
    public function getAllPharmaciesWithDetails($filters = []) {
        try {
            $sql = "SELECT c.*, pbi.*
                    FROM clients c 
                    LEFT JOIN pharmacy_business_information pbi ON c.id = pbi.client_id 
                    WHERE c.role = 'ADMINISTRATORCLIENT'";
            
            $params = [];
            
            if (isset($filters['limit'])) {
                $sql .= " LIMIT ?";
                $params[] = (int)$filters['limit'];
            }
            
            $sql .= " ORDER BY pbi.pharmacy_name";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get client statistics (simplified version)
    public function getClientStatistics() {
        try {
            $sql = "SELECT 
                    COUNT(*) as total_clients,
                    SUM(CASE WHEN role = 'ADMINISTRATORCLIENT' THEN 1 ELSE 0 END) as pharmacy_clients,
                    SUM(CASE WHEN role = 'NORMALCLIENT' THEN 1 ELSE 0 END) as normal_clients,
                    MIN(created_at) as first_client_date,
                    MAX(created_at) as latest_client_date
                    FROM clients";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return [
                'total_clients' => 0,
                'pharmacy_clients' => 0,
                'normal_clients' => 0,
                'first_client_date' => null,
                'latest_client_date' => null
            ];
        }
    }
    
    // Update client information (keep this for backward compatibility)
    public function updateClientProfile($clientId, $data) {
        try {
            $sql = "UPDATE clients SET firstname = ?, lastname = ?, phone = ?, address = ?, updated_at = NOW() 
                    WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['firstname'],
                $data['lastname'],
                $data['phone'],
                $data['address'],
                $clientId
            ]);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Change client password
    public function changePassword($clientId, $newPassword) {
        try {
            $sql = "UPDATE clients SET password = ?, updated_at = NOW() 
                    WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                password_hash($newPassword, PASSWORD_DEFAULT),
                $clientId
            ]);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Check if email exists
    public function emailExists($email, $excludeClientId = null) {
        try {
            $sql = "SELECT id FROM clients WHERE email = ?";
            $params = [$email];
            
            if ($excludeClientId) {
                $sql .= " AND id != ?";
                $params[] = $excludeClientId;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Search clients
    public function searchClients($searchTerm) {
        try {
            $sql = "SELECT c.*, ph.pharmacy_name 
                    FROM clients c 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    WHERE (c.firstname LIKE ? OR c.lastname LIKE ? OR c.email LIKE ? OR ph.pharmacy_name LIKE ?) 
                    ORDER BY c.created_at DESC";
            
            $searchParam = "%$searchTerm%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get recent clients
    public function getRecentClients($limit = 10) {
        try {
            $sql = "SELECT c.*, ph.pharmacy_name 
                    FROM clients c 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    ORDER BY c.created_at DESC 
                    LIMIT ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ClientModel Error: " . $e->getMessage());
            return [];
        }
    }
}
?>