<?php
class HomeController extends Controller {
    private $productModel;
    private $blogModel;
    private $clientModel;
    private $categoryModel;
    
    public function __construct() {
        parent::__construct();
        
        try {
            $this->productModel = $this->loadModel('ProductModel');
            $this->blogModel = $this->loadModel('BlogModel');
            $this->clientModel = $this->loadModel('ClientModel');
            $this->categoryModel = $this->loadModel('ProductModel'); // Reuse ProductModel for categories
        } catch (Exception $e) {
            error_log("Error loading models: " . $e->getMessage());
            $this->productModel = null;
            $this->blogModel = null;
            $this->clientModel = null;
            $this->categoryModel = null;
        }
    }
    
    public function index() {
        // Fetch all data for home page
        $featured_products = [];
        $recent_blogs = [];
        $categories = [];
        $pharmacies = [];
        $stats = [];
        
        if ($this->productModel) {
            try {
                $featured_products = $this->productModel->getAllProducts([
                    'limit' => 8,
                    'status' => 'active'
                ]);
                
                $categories = $this->categoryModel->getCategoriesWithCounts();
                
                // Get product statistics
                $stats['products'] = $this->productModel->getProductStatistics();
            } catch (Exception $e) {
                error_log("Error getting products: " . $e->getMessage());
            }
        }
        
        if ($this->blogModel) {
            try {
                $recent_blogs = $this->blogModel->getRecentBlogs(3);
                $stats['blogs'] = $this->blogModel->getBlogStatistics();
            } catch (Exception $e) {
                error_log("Error getting blogs: " . $e->getMessage());
            }
        }
        
        if ($this->clientModel) {
            try {
                $pharmacies = $this->clientModel->getAllPharmaciesWithDetails(['limit' => 6]);
                $stats['pharmacies'] = $this->clientModel->getClientStatistics();
            } catch (Exception $e) {
                error_log("Error getting pharmacies: " . $e->getMessage());
            }
        }
        
        $data = [
            'title' => 'Pharmacy Platform - Home',
            'featured_products' => $featured_products,
            'recent_blogs' => $recent_blogs,
            'categories' => $categories,
            'pharmacies' => $pharmacies,
            'stats' => $stats
        ];
        
        $this->view->render('home/index', $data);
    }
    
    public function products() {
        $filters = [
            'status' => 'active',
            'search' => $_GET['q'] ?? '',
            'category_id' => $_GET['category'] ?? ''
        ];
        
        $products = [];
        $categories = [];
        $stats = [];
        
        if ($this->productModel) {
            try {
                $products = $this->productModel->getAllProducts($filters);
                $categories = $this->categoryModel->getCategoriesWithCounts();
                $stats = $this->productModel->getProductStatistics();
            } catch (Exception $e) {
                error_log("Error getting products: " . $e->getMessage());
            }
        }
        
        $data = [
            'title' => 'All Products - Pharmacy Platform',
            'products' => $products,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => $filters,
            'searchTerm' => $filters['search']
        ];
        
        $this->view->render('home/products', $data);
    }
    
    public function productDetail($productId) {
        $product = null;
        $related_products = [];
        
        if ($this->productModel) {
            try {
                $product = $this->productModel->getProductWithDetails($productId);
                
                if ($product) {
                    $related_products = $this->productModel->getAllProducts([
                        'category_id' => $product['category_id'],
                        'limit' => 4,
                        'status' => 'active'
                    ]);
                }
            } catch (Exception $e) {
                error_log("Error getting product details: " . $e->getMessage());
            }
        }
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            header('Location: ' . BASE_URL . 'home/products');
            exit;
        }
        
        $data = [
            'title' => $product['name'] . ' - Pharmacy Platform',
            'product' => $product,
            'related_products' => $related_products
        ];
        
        $this->view->render('home/product_detail', $data);
    }
    
    public function pharmacies() {
        $filters = [
            'city' => $_GET['city'] ?? '',
            'country' => $_GET['country'] ?? ''
        ];
        
        $pharmacies = [];
        $stats = [];
        $cities = [];
        $countries = [];
        
        if ($this->clientModel) {
            try {
                $pharmacies = $this->clientModel->getAllPharmaciesWithDetails($filters);
                $stats = $this->clientModel->getClientStatistics();
                
                // Extract unique cities and countries for filters
                $cities = array_unique(array_column($pharmacies, 'city'));
                $countries = array_unique(array_column($pharmacies, 'country'));
                sort($cities);
                sort($countries);
                
            } catch (Exception $e) {
                error_log("Error getting pharmacies: " . $e->getMessage());
            }
        }
        
        $data = [
            'title' => 'Our Pharmacy Partners - Pharmacy Platform',
            'pharmacies' => $pharmacies,
            'stats' => $stats,
            'cities' => $cities,
            'countries' => $countries,
            'filters' => $filters
        ];
        
        $this->view->render('home/pharmacies', $data);
    }
    
    public function pharmacyDetail($pharmacyId) {
        $pharmacy = null;
        $products = [];
        $blogs = [];
        
        if ($this->clientModel && $this->productModel && $this->blogModel) {
            try {
                $pharmacy = $this->clientModel->getClientWithDetails($pharmacyId);
                
                if ($pharmacy) {
                    $products = $this->productModel->getProductsByPharmacyWithDetails($pharmacyId, [
                        'limit' => 8,
                        'status' => 'active'
                    ]);
                    
                    $blogs = $this->blogModel->getAllBlogs([
                        'author_id' => $pharmacyId,
                        'limit' => 3,
                        'status' => 'published'
                    ]);
                }
            } catch (Exception $e) {
                error_log("Error getting pharmacy details: " . $e->getMessage());
            }
        }
        
        if (!$pharmacy) {
            $_SESSION['error'] = 'Pharmacy not found.';
            header('Location: ' . BASE_URL . 'home/pharmacies');
            exit;
        }
        
        $data = [
            'title' => $pharmacy['pharmacy_name'] . ' - Pharmacy Platform',
            'pharmacy' => $pharmacy,
            'products' => $products,
            'blogs' => $blogs
        ];
        
        $this->view->render('home/pharmacy_detail', $data);
    }
    
    public function blogs() {
        $filters = [
            'status' => 'published',
            'search' => $_GET['q'] ?? ''
        ];
        
        $blogs = [];
        $stats = [];
        $recent_blogs = [];
        
        if ($this->blogModel) {
            try {
                $blogs = $this->blogModel->getAllBlogs($filters);
                $stats = $this->blogModel->getBlogStatistics();
                $recent_blogs = $this->blogModel->getRecentBlogs(5);
            } catch (Exception $e) {
                error_log("Error getting blogs: " . $e->getMessage());
            }
        }
        
        $data = [
            'title' => 'Health Blog - Pharmacy Platform',
            'blogs' => $blogs,
            'recent_blogs' => $recent_blogs,
            'stats' => $stats,
            'searchTerm' => $filters['search']
        ];
        
        $this->view->render('home/blogs', $data);
    }
    
    public function blogDetail($blogId) {
        $blog = null;
        $recent_blogs = [];
        
        if ($this->blogModel) {
            try {
                $blog = $this->blogModel->getBlogWithDetails($blogId);
                $recent_blogs = $this->blogModel->getRecentBlogs(5);
            } catch (Exception $e) {
                error_log("Error getting blog details: " . $e->getMessage());
            }
        }
        
        if (!$blog) {
            $_SESSION['error'] = 'Blog post not found.';
            header('Location: ' . BASE_URL . 'home/blogs');
            exit;
        }
        
        $data = [
            'title' => $blog['title'] . ' - Pharmacy Platform',
            'blog' => $blog,
            'recent_blogs' => $recent_blogs
        ];
        
        $this->view->render('home/blog_detail', $data);
    }
    
    public function category($categoryId = null) {
        $products = [];
        $categories = [];
        $currentCategory = null;
        
        if ($this->productModel) {
            try {
                $categories = $this->categoryModel->getCategoriesWithCounts();
                
                if ($categoryId) {
                    $products = $this->productModel->getAllProducts([
                        'category_id' => $categoryId,
                        'status' => 'active'
                    ]);
                    
                    // Find current category
                    foreach ($categories as $category) {
                        if ($category['id'] == $categoryId) {
                            $currentCategory = $category;
                            break;
                        }
                    }
                }
            } catch (Exception $e) {
                error_log("Error getting category products: " . $e->getMessage());
            }
        }
        
        $data = [
            'title' => $currentCategory ? $currentCategory['name'] . ' Products' : 'Browse Categories',
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $currentCategory
        ];
        
        $this->view->render('home/category', $data);
    }
    
    public function search() {
        $searchTerm = $_GET['q'] ?? '';
        $products = [];
        $blogs = [];
        $pharmacies = [];
        
        if (!empty($searchTerm)) {
            if ($this->productModel) {
                $products = $this->productModel->getAllProducts([
                    'search' => $searchTerm,
                    'status' => 'active'
                ]);
            }
            
            if ($this->blogModel) {
                $blogs = $this->blogModel->getAllBlogs([
                    'search' => $searchTerm,
                    'status' => 'published'
                ]);
            }
            
            if ($this->clientModel) {
                $pharmacies = $this->clientModel->getAllClients([
                    'search' => $searchTerm,
                    'role' => 'ADMINISTRATORCLIENT'
                ]);
            }
        }
        
        $data = [
            'title' => 'Search Results',
            'products' => $products,
            'blogs' => $blogs,
            'pharmacies' => $pharmacies,
            'searchTerm' => $searchTerm,
            'total_results' => count($products) + count($blogs) + count($pharmacies)
        ];
        
        $this->view->render('home/search', $data);
    }
    
    // ... Your existing about and services methods
}