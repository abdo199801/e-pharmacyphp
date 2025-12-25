<?php
class PageModel extends Model {
    
    public function getClientPages($clientId, $includeInactive = false) {
        try {
            $sql = "SELECT p.* 
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL";
            
            if (!$includeInactive) {
                $sql .= " AND p.status = 'active'";
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getPagesCountByClient($clientId) {
        try {
            $sql = "SELECT COUNT(*) as count 
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function createPage($data) {
        try {
            $sql = "INSERT INTO pages (id, title, content, dashboard_id, page_type, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $id, 
                $data['title'], 
                $data['content'], 
                $data['dashboard_id'], 
                $data['page_type'] ?? 'blog',
                $data['status'] ?? 'active'
            ]);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function isPageOwner($pageId, $clientId) {
        try {
            $sql = "SELECT p.id 
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE p.id = ? AND d.client_id = ? AND p.deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pageId, $clientId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletePage($pageId) {
        try {
            $sql = "UPDATE pages SET deleted_at = NOW(), status = 'deleted' WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$pageId]);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPageById($pageId) {
        try {
            $sql = "SELECT p.*, d.client_id 
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE p.id = ? AND p.deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pageId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function updatePage($pageId, $data) {
        try {
            $sql = "UPDATE pages SET title = ?, content = ?, page_type = ?, status = ?, updated_at = NOW() 
                    WHERE id = ? AND deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['title'],
                $data['content'],
                $data['page_type'] ?? 'blog',
                $data['status'] ?? 'active',
                $pageId
            ]);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function togglePageStatus($pageId, $status) {
        try {
            $sql = "UPDATE pages SET status = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $pageId]);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // New comprehensive methods
    public function getAllPages($filters = []) {
        try {
            $sql = "SELECT p.*, 
                           d.name as dashboard_name,
                           c.firstname, c.lastname,
                           ph.pharmacy_name
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients c ON d.client_id = c.id 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    WHERE p.deleted_at IS NULL";
            
            $params = [];
            
            if (isset($filters['status']) && $filters['status'] !== 'all') {
                $sql .= " AND p.status = ?";
                $params[] = $filters['status'];
            } else {
                $sql .= " AND p.status = 'active'";
            }
            
            if (isset($filters['client_id']) && !empty($filters['client_id'])) {
                $sql .= " AND d.client_id = ?";
                $params[] = $filters['client_id'];
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getPageWithDetails($pageId) {
        try {
            $sql = "SELECT p.*, 
                           d.name as dashboard_name, d.description as dashboard_description,
                           c.firstname, c.lastname, c.email,
                           ph.pharmacy_name, ph.address as pharmacy_address
                    FROM pages p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients c ON d.client_id = c.id 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    WHERE p.id = ? AND p.deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pageId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PageModel Error: " . $e->getMessage());
            return null;
        }
    }
}