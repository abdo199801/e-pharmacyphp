<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - PharmaPlatform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --secondary: #34a853;
            --accent: #fbbc05;
            --dark: #202124;
            --light: #f8f9fa;
            --gray: #5f6368;
            --border: #dadce0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--gray) !important;
            transition: color 0.3s;
            margin: 0 0.5rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .page-hero {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 80px 0 60px;
            margin-bottom: 2rem;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        
        .sidebar-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border);
        }
        
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-item {
            margin-bottom: 0.5rem;
        }
        
        .category-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .category-link:hover, .category-link.active {
            background-color: rgba(26, 115, 232, 0.1);
            color: var(--primary);
        }
        
        .category-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        
        .filter-section {
            margin-top: 2rem;
        }
        
        .filter-title {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        .form-check {
            margin-bottom: 0.5rem;
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .price-range {
            margin-top: 1rem;
        }
        
        .price-inputs {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .price-input {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        
        .products-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .sort-options {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sort-select {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.9rem;
            background-color: white;
        }
        
        .view-options {
            display: flex;
            gap: 5px;
        }
        
        .view-btn {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            transition: all 0.3s;
        }
        
        .view-btn:hover, .view-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .product-card {
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s;
            background-color: white;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }
        
        .product-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--secondary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .product-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.7);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        
        .product-body {
            padding: 1.5rem;
        }
        
        .product-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            line-height: 1.4;
        }
        
        .product-description {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .product-pharmacy {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .product-stock {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .stock-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .stock-in {
            background-color: rgba(52, 168, 83, 0.1);
            color: var(--secondary);
        }
        
        .stock-low {
            background-color: rgba(251, 188, 5, 0.1);
            color: #f57c00;
        }
        
        .stock-out {
            background-color: rgba(234, 67, 53, 0.1);
            color: #ea4335;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-add-cart {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-wishlist {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            transition: all 0.3s;
        }
        
        .btn-wishlist:hover {
            background-color: rgba(234, 67, 53, 0.1);
            color: #ea4335;
            border-color: rgba(234, 67, 53, 0.2);
        }
        
        .pagination {
            margin-top: 3rem;
            justify-content: center;
        }
        
        .page-link {
            color: var(--primary);
            border: 1px solid var(--border);
            padding: 0.5rem 1rem;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .no-products {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .no-products-icon {
            font-size: 4rem;
            color: var(--border);
            margin-bottom: 1.5rem;
        }
        
        .search-box {
            max-width: 400px;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer-links h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--primary);
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: #bdc1c6;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            margin-top: 3rem;
        }
        
        @media (max-width: 768px) {
            .page-hero {
                padding: 60px 0 40px;
            }
            
            .products-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .sort-options {
                width: 100%;
                justify-content: space-between;
            }
            
            .sidebar {
                position: static;
            }
        }
        
        /* Grid vs List view styles */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .products-list .product-card {
            display: flex;
            flex-direction: row;
            height: auto;
        }
        
        .products-list .product-image-container {
            width: 200px;
            flex-shrink: 0;
        }
        
        .products-list .product-image {
            height: 100%;
            border-radius: 12px 0 0 12px;
        }
        
        .products-list .product-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        @media (max-width: 576px) {
            .products-list .product-card {
                flex-direction: column;
            }
            
            .products-list .product-image-container {
                width: 100%;
            }
            
            .products-list .product-image {
                border-radius: 12px 12px 0 0;
                height: 200px;
            }
        }

        /* Loading animation */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-clinic-medical me-2"></i>PharmaPlatform
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>home/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home/pharmacies">Pharmacies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home/about">About</a>
                    </li>
                </ul>

                <!-- Search Box -->
                <div class="search-box me-3">
                    <form action="<?php echo BASE_URL; ?>home/search" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control" placeholder="Search products..." 
                               value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <!-- Show when user is logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                </div>
                                <?php echo $_SESSION['client_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>profile"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>orders"><i class="fas fa-shopping-bag me-2"></i>My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Show when user is not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?php echo BASE_URL; ?>auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-hero">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold">Pharmacy Products</h1>
            <p class="lead mb-0">Discover our wide range of healthcare products from trusted pharmacies</p>
        </div>
    </section>

    <!-- Statistics Section -->
    <?php if (isset($stats) && !empty($stats)): ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="stats-card">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stats-number"><?php echo $stats['total_products'] ?? 0; ?></div>
                            <div class="stats-label">Total Products</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stats-number"><?php echo $stats['active_products'] ?? 0; ?></div>
                            <div class="stats-label">Active Products</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stats-number"><?php echo $stats['categories_count'] ?? count($categories); ?></div>
                            <div class="stats-label">Categories</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stats-number">$<?php echo number_format($stats['average_price'] ?? 0, 2); ?></div>
                            <div class="stats-label">Average Price</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Sidebar with filters -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <h3 class="sidebar-title">Categories</h3>
                    <ul class="category-list">
                        <li class="category-item">
                            <a href="<?php echo BASE_URL; ?>home/products" class="category-link <?php echo empty($currentCategory) ? 'active' : ''; ?>">
                                <div class="category-icon">
                                    <i class="fas fa-th-large"></i>
                                </div>
                                All Categories
                                <span class="badge bg-primary ms-auto"><?php echo count($products); ?></span>
                            </a>
                        </li>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                            <li class="category-item">
                                <a href="<?php echo BASE_URL; ?>home/category/<?php echo $category['id']; ?>" 
                                   class="category-link <?php echo (isset($currentCategory) && $currentCategory['id'] == $category['id']) ? 'active' : ''; ?>">
                                    <div class="category-icon">
                                        <i class="fas fa-pills"></i>
                                    </div>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                    <?php if (isset($category['product_count'])): ?>
                                        <span class="badge bg-secondary ms-auto"><?php echo $category['product_count']; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="category-item">
                                <div class="text-muted p-2">No categories available</div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                    <!-- Dynamic Pharmacy Filters -->
                    <?php if (!empty($pharmacies)): ?>
                    <div class="filter-section">
                        <h4 class="filter-title">Filter by Pharmacy</h4>
                        <?php foreach (array_slice($pharmacies, 0, 5) as $pharmacy): ?>
                            <?php if (!empty($pharmacy['pharmacy_name'])): ?>
                            <div class="form-check">
                                <input class="form-check-input pharmacy-filter" type="checkbox" value="<?php echo $pharmacy['id']; ?>" id="pharmacy_<?php echo $pharmacy['id']; ?>">
                                <label class="form-check-label" for="pharmacy_<?php echo $pharmacy['id']; ?>">
                                    <?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?>
                                </label>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="filter-section">
                        <h4 class="filter-title">Price Range</h4>
                        <div class="price-range">
                            <input type="range" class="form-range" min="0" max="1000" step="10" id="priceRange" value="500">
                            <div class="price-inputs">
                                <input type="number" class="price-input" placeholder="Min" id="minPrice" value="0">
                                <input type="number" class="price-input" placeholder="Max" id="maxPrice" value="500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <h4 class="filter-title">Availability</h4>
                        <div class="form-check">
                            <input class="form-check-input availability-filter" type="checkbox" value="in_stock" id="inStock" checked>
                            <label class="form-check-label" for="inStock">
                                In Stock
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input availability-filter" type="checkbox" value="low_stock" id="lowStock">
                            <label class="form-check-label" for="lowStock">
                                Low Stock
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input availability-filter" type="checkbox" value="out_of_stock" id="outOfStock">
                            <label class="form-check-label" for="outOfStock">
                                Out of Stock
                            </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-100 mt-3" id="applyFilters">Apply Filters</button>
                    <button class="btn btn-outline-secondary w-100 mt-2" id="resetFilters">Reset Filters</button>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="products-header">
                    <div>
                        <h2 class="mb-0">
                            <?php if (isset($currentCategory)): ?>
                                <?php echo htmlspecialchars($currentCategory['name']); ?> Products
                            <?php elseif (!empty($searchTerm)): ?>
                                Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"
                            <?php else: ?>
                                All Products
                            <?php endif; ?>
                        </h2>
                        <p class="text-muted mb-0">
                            Showing <?php echo count($products); ?> product<?php echo count($products) !== 1 ? 's' : ''; ?>
                            <?php if (!empty($searchTerm)): ?>
                                for "<?php echo htmlspecialchars($searchTerm); ?>"
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="sort-options">
                            <span class="text-muted">Sort by:</span>
                            <select class="sort-select" id="sortSelect">
                                <option value="newest">Newest First</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="name">Name A-Z</option>
                                <option value="popular">Most Popular</option>
                            </select>
                        </div>
                        <div class="view-options">
                            <button class="view-btn active" id="gridView" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" id="listView" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="products-grid" id="productsContainer">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): 
                            // Determine stock status for styling
                            $stockClass = 'stock-in';
                            $stockText = 'In Stock';
                            $stockQuantity = $product['stock_quantity'] ?? 0;
                            
                            if ($stockQuantity == 0) {
                                $stockClass = 'stock-out';
                                $stockText = 'Out of Stock';
                            } elseif ($stockQuantity < 10) {
                                $stockClass = 'stock-low';
                                $stockText = 'Low Stock';
                            }
                        ?>
                        <div class="product-card" data-price="<?php echo $product['price']; ?>" 
                             data-stock="<?php echo $stockQuantity; ?>" 
                             data-pharmacy="<?php echo $product['client_id'] ?? ''; ?>">
                            <div class="position-relative">
                                <img src="<?php echo !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image'; ?>" 
                                     class="product-image" alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     onerror="this.src='https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image'">
                                <?php if ($stockQuantity < 10 && $stockQuantity > 0): ?>
                                    <span class="product-badge">Almost Gone</span>
                                <?php endif; ?>
                                <span class="product-category"><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></span>
                            </div>
                            <div class="product-body">
                                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="product-description"><?php echo !empty($product['description']) ? htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : '') : 'No description available'; ?></p>
                                
                                <div class="product-meta">
                                    <div class="product-pharmacy">
                                        <i class="fas fa-clinic-medical"></i>
                                        <span><?php echo htmlspecialchars($product['pharmacy_name'] ?? 'PharmaPlatform'); ?></span>
                                    </div>
                                    <div class="product-stock">
                                        <span class="stock-badge <?php echo $stockClass; ?>"><?php echo $stockText; ?></span>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                                    <div class="text-muted small"><?php echo $stockQuantity; ?> available</div>
                                </div>
                                
                                <div class="product-actions">
                                    <button class="btn btn-primary btn-add-cart" 
                                            <?php echo $stockQuantity == 0 ? 'disabled' : ''; ?>
                                            data-product-id="<?php echo $product['id']; ?>"
                                            data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                                        <i class="fas fa-cart-plus"></i>
                                        <?php echo $stockQuantity == 0 ? 'Out of Stock' : 'Add to Cart'; ?>
                                    </button>
                                    <button class="btn-wishlist" data-product-id="<?php echo $product['id']; ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="no-products">
                                <div class="no-products-icon">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <h3>No Products Found</h3>
                                <p class="text-muted mb-4">
                                    <?php if (!empty($searchTerm)): ?>
                                        No products found matching "<?php echo htmlspecialchars($searchTerm); ?>". Try different keywords.
                                    <?php elseif (isset($currentCategory)): ?>
                                        No products found in this category yet.
                                    <?php else: ?>
                                        No products available at the moment. Please check back later.
                                    <?php endif; ?>
                                </p>
                                <?php if (!empty($searchTerm)): ?>
                                    <a href="<?php echo BASE_URL; ?>home/products" class="btn btn-primary">View All Products</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if (!empty($products) && count($products) > 12): ?>
                <nav aria-label="Product pagination" class="mt-5">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold">PharmaPlatform</h5>
                    <p class="text-muted mt-3">Your trusted digital pharmacy solution for modern healthcare management and customer engagement.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 footer-links">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>home">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/products">Products</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/pharmacies">Pharmacies</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/services">Services</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/about">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 footer-links">
                    <h5>Resources</h5>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>blog">Blog</a></li>
                        <li><a href="<?php echo BASE_URL; ?>help">Help Center</a></li>
                        <li><a href="<?php echo BASE_URL; ?>faq">FAQs</a></li>
                        <li><a href="<?php echo BASE_URL; ?>support">Support</a></li>
                        <li><a href="<?php echo BASE_URL; ?>contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 footer-links">
                    <h5>Contact Info</h5>
                    <ul>
                        <li class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i> 123 Healthcare Ave, Medical District
                        </li>
                        <li class="text-muted mb-2">
                            <i class="fas fa-phone me-2"></i> +1 (555) 123-4567
                        </li>
                        <li class="text-muted">
                            <i class="fas fa-envelope me-2"></i> info@pharmaplatform.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="copyright text-center text-muted">
                <p class="mb-0">&copy; 2024 PharmaPlatform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Grid/List view toggle
        document.getElementById('gridView').addEventListener('click', function() {
            document.getElementById('productsContainer').classList.remove('products-list');
            document.getElementById('productsContainer').classList.add('products-grid');
            document.getElementById('gridView').classList.add('active');
            document.getElementById('listView').classList.remove('active');
            localStorage.setItem('productView', 'grid');
        });
        
        document.getElementById('listView').addEventListener('click', function() {
            document.getElementById('productsContainer').classList.remove('products-grid');
            document.getElementById('productsContainer').classList.add('products-list');
            document.getElementById('listView').classList.add('active');
            document.getElementById('gridView').classList.remove('active');
            localStorage.setItem('productView', 'list');
        });

        // Load saved view preference
        const savedView = localStorage.getItem('productView') || 'grid';
        if (savedView === 'list') {
            document.getElementById('listView').click();
        }
        
        // Price range synchronization
        const priceRange = document.getElementById('priceRange');
        const minPrice = document.getElementById('minPrice');
        const maxPrice = document.getElementById('maxPrice');
        
        priceRange.addEventListener('input', function() {
            maxPrice.value = this.value;
        });
        
        maxPrice.addEventListener('input', function() {
            priceRange.value = this.value;
        });
        
        // Initialize max price with range value
        maxPrice.value = priceRange.value;

        // Filter functionality
        document.getElementById('applyFilters').addEventListener('click', function() {
            applyFilters();
        });

        document.getElementById('resetFilters').addEventListener('click', function() {
            resetFilters();
        });

        // Sort functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            sortProducts(this.value);
        });

        function applyFilters() {
            const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseFloat(document.getElementById('maxPrice').value) || 1000;
            const selectedPharmacies = Array.from(document.querySelectorAll('.pharmacy-filter:checked')).map(cb => cb.value);
            const availabilityFilters = Array.from(document.querySelectorAll('.availability-filter:checked')).map(cb => cb.value);

            const productCards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            productCards.forEach(card => {
                const price = parseFloat(card.dataset.price);
                const stock = parseInt(card.dataset.stock);
                const pharmacy = card.dataset.pharmacy;

                let show = true;

                // Price filter
                if (price < minPrice || price > maxPrice) {
                    show = false;
                }

                // Pharmacy filter
                if (selectedPharmacies.length > 0 && !selectedPharmacies.includes(pharmacy)) {
                    show = false;
                }

                // Availability filter
                if (availabilityFilters.length > 0) {
                    let stockMatch = false;
                    if (availabilityFilters.includes('in_stock') && stock > 10) stockMatch = true;
                    if (availabilityFilters.includes('low_stock') && stock > 0 && stock <= 10) stockMatch = true;
                    if (availabilityFilters.includes('out_of_stock') && stock === 0) stockMatch = true;
                    
                    if (!stockMatch) show = false;
                }

                if (show) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update product count
            document.querySelector('.products-header p').textContent = `Showing ${visibleCount} product${visibleCount !== 1 ? 's' : ''}`;
        }

        function resetFilters() {
            document.getElementById('minPrice').value = 0;
            document.getElementById('maxPrice').value = 500;
            document.getElementById('priceRange').value = 500;
            
            document.querySelectorAll('.pharmacy-filter').forEach(cb => cb.checked = false);
            document.querySelectorAll('.availability-filter').forEach((cb, index) => {
                cb.checked = index === 0; // Only check "In Stock" by default
            });
            
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = 'block';
            });
            
            document.querySelector('.products-header p').textContent = `Showing <?php echo count($products); ?> product<?php echo count($products) !== 1 ? 's' : ''; ?>`;
        }

        function sortProducts(sortBy) {
            const container = document.getElementById('productsContainer');
            const products = Array.from(container.querySelectorAll('.product-card'));

            products.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);
                const nameA = a.querySelector('.product-title').textContent.toLowerCase();
                const nameB = b.querySelector('.product-title').textContent.toLowerCase();

                switch (sortBy) {
                    case 'price_low':
                        return priceA - priceB;
                    case 'price_high':
                        return priceB - priceA;
                    case 'name':
                        return nameA.localeCompare(nameB);
                    case 'popular':
                        // For now, sort by stock (assuming higher stock = more popular)
                        const stockA = parseInt(a.dataset.stock);
                        const stockB = parseInt(b.dataset.stock);
                        return stockB - stockA;
                    default: // newest
                        return 0; // Keep original order for newest
                }
            });

            // Reappend sorted products
            products.forEach(product => container.appendChild(product));
        }
        
        // Add to cart functionality
        document.querySelectorAll('.btn-add-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productCard = this.closest('.product-card');
                
                // Show temporary feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Added!';
                this.disabled = true;
                
                // Add to cart animation
                productCard.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    productCard.style.transform = '';
                }, 300);
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
                
                // In a real application, you would make an AJAX call to add the product to the cart
                console.log(`Added ${productName} (ID: ${productId}) to cart`);
                
                // Show notification
                showNotification(`${productName} added to cart!`, 'success');
            });
        });
        
        // Wishlist toggle
        document.querySelectorAll('.btn-wishlist').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const icon = this.querySelector('i');
                const isAdding = icon.classList.contains('far');
                
                if (isAdding) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.backgroundColor = 'rgba(234, 67, 53, 0.1)';
                    this.style.color = '#ea4335';
                    this.style.borderColor = 'rgba(234, 67, 53, 0.2)';
                    showNotification('Product added to wishlist!', 'success');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.backgroundColor = '';
                    this.style.color = '';
                    this.style.borderColor = '';
                    showNotification('Product removed from wishlist!', 'info');
                }
                
                // In a real application, you would make an AJAX call to update the wishlist
                console.log(`${isAdding ? 'Added' : 'Removed'} product ${productId} from wishlist`);
            });
        });

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>