<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: #343a40;
            color: white;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            border-bottom: 1px solid #4b545c;
        }
        .sidebar .nav-link:hover {
            background: #495057;
        }
        .sidebar .nav-link.active {
            background: #007bff;
        }
        .stat-card {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-center">PharmaPlatform</h4>
                    <p class="text-center text-muted">Welcome, <?php echo $_SESSION['client_name']; ?></p>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/products">
                        <i class="fas fa-pills me-2"></i>Products
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/blogs">
                        <i class="fas fa-blog me-2"></i>Blog Posts
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/pages">
                        <i class="fas fa-file me-2"></i>Pages
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/settings">
                        <i class="fas fa-cog me-2"></i>Settings
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>auth/logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto p-4">
                <!-- Success/Error Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <h1 class="h3 mb-4">Dashboard Overview</h1>

                <!-- Pharmacy Info Card -->
                <?php if ($pharmacy_info): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-clinic-medical me-2"></i>Pharmacy Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Pharmacy Name:</strong> <?php echo $pharmacy_info['pharmacy_name']; ?></p>
                                <p><strong>Address:</strong> <?php echo $pharmacy_info['address']; ?></p>
                                <p><strong>City:</strong> <?php echo $pharmacy_info['city']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>License Number:</strong> <?php echo $pharmacy_info['license_number']; ?></p>
                                <p><strong>Phone:</strong> <?php echo $pharmacy_info['phone']; ?></p>
                                <p><strong>Country:</strong> <?php echo $pharmacy_info['country']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0"><?php echo $stats['products']; ?></h4>
                                        <p class="mb-0">Products</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-pills fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0"><?php echo $stats['blogs']; ?></h4>
                                        <p class="mb-0">Blog Posts</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-blog fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0"><?php echo $stats['pages']; ?></h4>
                                        <p class="mb-0">Pages</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-file fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">$<?php echo number_format($stats['total_sales'], 2); ?></h4>
                                        <p class="mb-0">Total Sales</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <!-- Recent Products -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Recent Products</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_products)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_products as $product): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1"><?php echo $product['name']; ?></h6>
                                                <small class="text-muted">$<?php echo number_format($product['price'], 2); ?></small>
                                            </div>
                                            <span class="badge bg-<?php echo $product['stock_quantity'] > 0 ? 'success' : 'danger'; ?>">
                                                <?php echo $product['stock_quantity']; ?> in stock
                                            </span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No products yet. <a href="<?php echo BASE_URL; ?>dashboard/products?action=create">Add your first product</a>.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Blog Posts -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Recent Blog Posts</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_blogs)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_blogs as $blog): ?>
                                        <div class="list-group-item">
                                            <h6 class="mb-1"><?php echo $blog['title']; ?></h6>
                                            <small class="text-muted">Created: <?php echo date('M j, Y', strtotime($blog['created_at'])); ?></small>
                                            <span class="badge bg-<?php echo $blog['status'] === 'published' ? 'success' : 'secondary'; ?> float-end">
                                                <?php echo ucfirst($blog['status']); ?>
                                            </span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No blog posts yet. <a href="<?php echo BASE_URL; ?>dashboard/blogs?action=create">Create your first blog post</a>.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo BASE_URL; ?>dashboard/products?action=create" class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-2"></i>Add Product
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo BASE_URL; ?>dashboard/blogs?action=create" class="btn btn-success w-100">
                                    <i class="fas fa-edit me-2"></i>Write Blog
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo BASE_URL; ?>dashboard/pages?action=create" class="btn btn-info w-100">
                                    <i class="fas fa-file me-2"></i>Create Page
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo BASE_URL; ?>dashboard/settings" class="btn btn-warning w-100">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>