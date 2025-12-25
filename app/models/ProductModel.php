<?php
class ProductModel extends Model {      
    
    // Get all products with optional filters
    public function getAllProducts($filters = []) {
        try {
            $sql = "SELECT p.*, c.name as category_name, ph.pharmacy_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE p.deleted_at IS NULL";
            
            $params = [];
            
            // Apply filters
            if (isset($filters['status']) && $filters['status'] !== 'all') {
                $sql .= " AND p.status = ?";
                $params[] = $filters['status'];
            } else {
                $sql .= " AND p.status = 'active'";
            }
            
            if (isset($filters['category_id']) && !empty($filters['category_id'])) {
                $sql .= " AND p.category_id = ?";
                $params[] = $filters['category_id'];
            }
            
            if (isset($filters['pharmacy_id']) && !empty($filters['pharmacy_id'])) {
                $sql .= " AND d.client_id = ?";
                $params[] = $filters['pharmacy_id'];
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)";
                $searchTerm = "%{$filters['search']}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            if (isset($filters['limit'])) {
                $sql .= " LIMIT ?";
                $params[] = (int)$filters['limit'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get products for a specific client with filters and pagination
    public function getClientProducts($clientId, $includeInactive = false, $filters = []) {
        try {
            $sql = "SELECT p.*, c.name as category_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL";
            
            $params = [$clientId];
            
            // Status filter
            if (!$includeInactive && empty($filters['status'])) {
                $sql .= " AND p.status = 'active'";
            } elseif (isset($filters['status']) && !empty($filters['status'])) {
                $sql .= " AND p.status = ?";
                $params[] = $filters['status'];
            }
            
            // Category filter
            if (isset($filters['category_id']) && !empty($filters['category_id'])) {
                $sql .= " AND p.category_id = ?";
                $params[] = $filters['category_id'];
            }
            
            // Search filter
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
                $searchTerm = "%{$filters['search']}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            // Pagination
            if (isset($filters['limit'])) {
                $sql .= " LIMIT ?";
                $params[] = (int)$filters['limit'];
                
                if (isset($filters['offset'])) {
                    $sql .= " OFFSET ?";
                    $params[] = (int)$filters['offset'];
                }
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log("Client products error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get client products count
    public function getClientProductsCount($clientId, $filters = []) {
        try {
            $sql = "SELECT COUNT(*) as count 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL";
            
            $params = [$clientId];
            
            // Apply filters
            if (isset($filters['status']) && !empty($filters['status'])) {
                $sql .= " AND p.status = ?";
                $params[] = $filters['status'];
            }
            
            if (isset($filters['category_id']) && !empty($filters['category_id'])) {
                $sql .= " AND p.category_id = ?";
                $params[] = $filters['category_id'];
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
                $searchTerm = "%{$filters['search']}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['count'] ?? 0;
            
        } catch (Exception $e) {
            error_log("Product count error: " . $e->getMessage());
            return 0;
        }
    }
    
    // Get featured products for home page
    public function getFeaturedProducts($limit = 8) {
        try {
            $sql = "SELECT p.*, c.name as category_name, ph.pharmacy_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE p.deleted_at IS NULL AND p.status = 'active'
                    ORDER BY p.created_at DESC 
                    LIMIT ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get products by category
    public function getProductsByCategory($categoryId) {
        try {
            $sql = "SELECT p.*, c.name as category_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    WHERE p.category_id = ? AND p.deleted_at IS NULL AND p.status = 'active'
                    ORDER BY p.name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$categoryId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get products by pharmacy
    public function getProductsByPharmacy($pharmacyId) {
        try {
            $sql = "SELECT p.*, c.name as category_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL AND p.status = 'active'
                    ORDER BY p.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pharmacyId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Search products
    public function searchProducts($searchTerm) {
        try {
            $sql = "SELECT p.*, c.name as category_name, ph.pharmacy_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?) 
                    AND p.deleted_at IS NULL AND p.status = 'active'
                    ORDER BY p.name";
            $stmt = $this->db->prepare($sql);
            $searchParam = "%$searchTerm%";
            $stmt->execute([$searchParam, $searchParam, $searchParam]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get all categories
    public function getAllCategories() {
        try {
            $sql = "SELECT * FROM categories WHERE deleted_at IS NULL AND status = 'active' ORDER BY name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get categories with product counts
    public function getCategoriesWithCounts() {
        try {
            $sql = "SELECT c.*, COUNT(p.id) as product_count 
                    FROM categories c 
                    LEFT JOIN products p ON c.id = p.category_id AND p.deleted_at IS NULL AND p.status = 'active'
                    WHERE c.deleted_at IS NULL AND c.status = 'active'
                    GROUP BY c.id 
                    ORDER BY c.name";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get product by ID
    public function getProductById($productId) {
        try {
            $sql = "SELECT p.*, c.name as category_name, d.client_id 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE p.id = ? AND p.deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    // Get product with complete details
    public function getProductWithDetails($productId) {
        try {
            $sql = "SELECT p.*, c.name as category_name, c.description as category_description,
                           ph.pharmacy_name, ph.address as pharmacy_address, ph.city as pharmacy_city, 
                           ph.country as pharmacy_country, ph.phone as pharmacy_phone, ph.website as pharmacy_website,
                           cl.firstname, cl.lastname, cl.email as client_email, cl.phone as client_phone,
                           d.name as dashboard_name
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE p.id = ? AND p.deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return null;
        }
    }
    
    // Create product
    public function createProduct($data) {
        try {
            $sql = "INSERT INTO products (id, name, price, description, category_id, dashboard_id, image_url, stock_quantity, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $id = $this->generateUUID();
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $id, 
                $data['name'], 
                floatval($data['price']), 
                $data['description'] ?? '', 
                $data['category_id'], 
                $data['dashboard_id'], 
                $data['image_url'] ?? null, 
                intval($data['stock_quantity']),
                $data['status'] ?? 'active'
            ]);
            
            if ($result) {
                $this->logAudit('products', $id, 'CREATE', null, $data);
                return $id;
            }
            return false;
            
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Update product
    public function updateProduct($productId, $data) {
        try {
            // Get old values for audit
            $oldProduct = $this->getProductById($productId);
            
            $sql = "UPDATE products SET name = ?, price = ?, description = ?, category_id = ?, 
                    image_url = ?, stock_quantity = ?, status = ?, updated_at = NOW() 
                    WHERE id = ? AND deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $data['name'], 
                floatval($data['price']), 
                $data['description'] ?? '', 
                $data['category_id'], 
                $data['image_url'] ?? null, 
                intval($data['stock_quantity']),
                $data['status'] ?? 'active',
                $productId
            ]);
            
            if ($result) {
                $this->logAudit('products', $productId, 'UPDATE', $oldProduct, $data);
                return true;
            }
            return false;
            
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Delete product (soft delete)
    public function deleteProduct($productId) {
        try {
            $oldProduct = $this->getProductById($productId);
            
            $sql = "UPDATE products SET deleted_at = NOW(), status = 'deleted' WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$productId]);
            
            if ($result) {
                $this->logAudit('products', $productId, 'DELETE', $oldProduct, null);
                return true;
            }
            return false;
            
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Toggle product status
    public function toggleProductStatus($productId, $status) {
        try {
            $oldProduct = $this->getProductById($productId);
            $action = $status === 'active' ? 'ACTIVATE' : 'DEACTIVATE';
            
            $sql = "UPDATE products SET status = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$status, $productId]);
            
            if ($result) {
                $this->logAudit('products', $productId, $action, $oldProduct, ['status' => $status]);
                return true;
            }
            return false;
            
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Check if user owns the product
    public function isProductOwner($productId, $clientId) {
        try {
            $sql = "SELECT p.id 
                    FROM products p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE p.id = ? AND d.client_id = ? AND p.deleted_at IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId, $clientId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return false;
        }
    }
    
    // Get products count by client
    public function getProductsCountByClient($clientId) {
        try {
            $sql = "SELECT COUNT(*) as count 
                    FROM products p 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL AND p.status = 'active'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$clientId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return 0;
        }
    }
    
    // Get recent products
    public function getRecentProducts($clientId = null, $limit = 5) {
        try {
            $sql = "SELECT p.*, c.name as category_name, ph.pharmacy_name 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE p.deleted_at IS NULL AND p.status = 'active'";
            
            $params = [];
            
            if ($clientId) {
                $sql .= " AND d.client_id = ?";
                $params[] = $clientId;
            }
            
            $sql .= " ORDER BY p.created_at DESC LIMIT ?";
            $params[] = (int)$limit;
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Get product statistics
    public function getProductStatistics($clientId = null) {
        try {
            $stats = [];
            
            // Base query
            $sql = "SELECT 
                    COUNT(*) as total_products,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_products,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive_products,
                    SUM(CASE WHEN stock_quantity = 0 THEN 1 ELSE 0 END) as out_of_stock,
                    SUM(CASE WHEN stock_quantity > 0 AND stock_quantity <= 10 THEN 1 ELSE 0 END) as low_stock,
                    AVG(price) as average_price,
                    MAX(price) as max_price,
                    MIN(price) as min_price
                    FROM products p";
            
            $params = [];
            
            if ($clientId) {
                $sql .= " JOIN dashboards d ON p.dashboard_id = d.id WHERE d.client_id = ?";
                $params[] = $clientId;
            }
            
            $sql .= " AND p.deleted_at IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get products by category
            $categorySql = "SELECT c.name, COUNT(p.id) as count 
                           FROM categories c 
                           LEFT JOIN products p ON c.id = p.category_id AND p.deleted_at IS NULL AND p.status = 'active'";
            
            if ($clientId) {
                $categorySql .= " JOIN dashboards d ON p.dashboard_id = d.id WHERE d.client_id = ?";
            }
            
            $categorySql .= " GROUP BY c.id, c.name ORDER BY count DESC";
            
            $categoryStmt = $this->db->prepare($categorySql);
            $categoryStmt->execute($clientId ? [$clientId] : []);
            $stats['categories'] = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
            
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [
                'total_products' => 0,
                'active_products' => 0,
                'inactive_products' => 0,
                'out_of_stock' => 0,
                'low_stock' => 0,
                'average_price' => 0,
                'max_price' => 0,
                'min_price' => 0,
                'categories' => []
            ];
        }
    }
    
    // Get products by pharmacy with details
    public function getProductsByPharmacyWithDetails($pharmacyId, $filters = []) {
        try {
            $sql = "SELECT p.*, c.name as category_name, c.description as category_description,
                           ph.pharmacy_name, ph.address as pharmacy_address, ph.city as pharmacy_city,
                           cl.firstname, cl.lastname
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    JOIN dashboards d ON p.dashboard_id = d.id 
                    JOIN clients cl ON d.client_id = cl.id 
                    LEFT JOIN pharmacy_business_information ph ON cl.id = ph.client_id 
                    WHERE d.client_id = ? AND p.deleted_at IS NULL";
            
            $params = [$pharmacyId];
            
            if (isset($filters['status']) && $filters['status'] !== 'all') {
                $sql .= " AND p.status = ?";
                $params[] = $filters['status'];
            } else {
                $sql .= " AND p.status = 'active'";
            }
            
            if (isset($filters['limit'])) {
                $sql .= " LIMIT ?";
                $params[] = (int)$filters['limit'];
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ProductModel Error: " . $e->getMessage());
            return [];
        }
    }
    
    // Audit logging method
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