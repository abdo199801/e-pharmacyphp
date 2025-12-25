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
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>dashboard/products">
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">Manage Products</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </button>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($products)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $product['image_url'] ?: 'https://via.placeholder.com/50x50/6c757d/ffffff?text=No+Image'; ?>" 
                                                     alt="<?php echo $product['name']; ?>" 
                                                     style="width: 50px; height: 50px; object-fit: cover;" 
                                                     class="rounded">
                                            </td>
                                            <td>
                                                <strong><?php echo $product['name']; ?></strong>
                                                <?php if ($product['description']): ?>
                                                    <br><small class="text-muted"><?php echo substr($product['description'], 0, 50) . '...'; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                                            <td><?php echo $product['category_name']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $product['stock_quantity'] > 0 ? 'success' : 'danger'; ?>">
                                                    <?php echo $product['stock_quantity']; ?> in stock
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>dashboard/products?delete_product=<?php echo $product['id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                                <h4>No Products Yet</h4>
                                <p class="text-muted">Get started by adding your first product.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                    <i class="fas fa-plus me-2"></i>Add Your First Product
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Product Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?php echo BASE_URL; ?>dashboard/products" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="create_product" class="btn btn-primary">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>