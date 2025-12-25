<?php
class BlogModel extends Model {
    
    public function getRecentBlogs($limit = 3) {
        try {
            $sql = "SELECT b.*, c.firstname, c.lastname 
                    FROM blogs b 
                    JOIN clients c ON b.client_id = c.id 
                    WHERE b.status = 'published' AND b.deleted_at IS NULL
                    ORDER BY b.created_at DESC 
                    LIMIT ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getClientBlogs($clientId, $includeInactive = false) {
        try {
            $sql = "SELECT * FROM blogs WHERE client_id = ? AND deleted_at IS NULL";
            
            if (!$includeInactive) {
                $sql .= " AND status = 'published'";
            }
            
            $sql .= " ORDER BY created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function createBlog($data) {
        try {
            $sql = "INSERT INTO blogs (id, title, content, image_url, client_id, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $id, 
                $data['title'], 
                $data['content'], 
                $data['image_url'] ?? null, 
                $data['client_id'], 
                $data['status']
            ]);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getBlogsCountByClient($clientId) {
        try {
            $sql = "SELECT COUNT(*) as count FROM blogs WHERE client_id = ? AND deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getBlogById($blogId) {
        try {
            $sql = "SELECT * FROM blogs WHERE id = ? AND deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$blogId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function deleteBlog($blogId) {
        try {
            $sql = "UPDATE blogs SET deleted_at = NOW(), status = 'deleted' WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$blogId]);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateBlog($blogId, $data) {
        try {
            $sql = "UPDATE blogs SET title = ?, content = ?, image_url = ?, status = ?, updated_at = NOW() 
                    WHERE id = ? AND deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['title'],
                $data['content'],
                $data['image_url'] ?? null,
                $data['status'],
                $blogId
            ]);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function toggleBlogStatus($blogId, $status) {
        try {
            $sql = "UPDATE blogs SET status = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $blogId]);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // New comprehensive methods for data fetching
    public function getAllBlogs($filters = []) {
        try {
            $sql = "SELECT b.*, 
                           c.firstname, c.lastname, c.email as author_email,
                           ph.pharmacy_name, ph.address as pharmacy_address
                    FROM blogs b 
                    JOIN clients c ON b.client_id = c.id 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    WHERE b.deleted_at IS NULL";
            
            $params = [];
            
            // Apply filters
            if (isset($filters['status']) && $filters['status'] !== 'all') {
                $sql .= " AND b.status = ?";
                $params[] = $filters['status'];
            } else {
                $sql .= " AND b.status = 'published'";
            }
            
            if (isset($filters['author_id']) && !empty($filters['author_id'])) {
                $sql .= " AND b.client_id = ?";
                $params[] = $filters['author_id'];
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (b.title LIKE ? OR b.content LIKE ?)";
                $searchTerm = "%{$filters['search']}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $sql .= " ORDER BY b.created_at DESC";
            
            if (isset($filters['limit'])) {
                $sql .= " LIMIT ?";
                $params[] = (int)$filters['limit'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getBlogWithDetails($blogId) {
        try {
            $sql = "SELECT b.*, 
                           c.firstname, c.lastname, c.email as author_email, c.phone as author_phone,
                           ph.pharmacy_name, ph.address as pharmacy_address, ph.city as pharmacy_city,
                           ph.country as pharmacy_country, ph.phone as pharmacy_phone, ph.website as pharmacy_website
                    FROM blogs b 
                    JOIN clients c ON b.client_id = c.id 
                    LEFT JOIN pharmacy_business_information ph ON c.id = ph.client_id 
                    WHERE b.id = ? AND b.deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$blogId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function getBlogStatistics($clientId = null) {
        try {
            $sql = "SELECT 
                    COUNT(*) as total_blogs,
                    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published_blogs,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft_blogs,
                    MIN(created_at) as first_blog_date,
                    MAX(created_at) as latest_blog_date
                    FROM blogs WHERE deleted_at IS NULL";
            
            $params = [];
            
            if ($clientId) {
                $sql .= " AND client_id = ?";
                $params[] = $clientId;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("BlogModel Error: " . $e->getMessage());
            return [];
        }
    }
}