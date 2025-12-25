<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-active { color: #28a745; }
        .status-inactive { color: #dc3545; }
        .status-deleted { color: #6c757d; }
        .action-buttons .btn { margin-right: 5px; }
        .bulk-actions { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .export-buttons .btn { margin-right: 5px; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <!-- Your existing sidebar -->
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
                    <div>
                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=import" class="btn btn-success">
                            <i class="fas fa-file-import me-2"></i>Import
                        </a>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="<?php echo BASE_URL; ?>dashboard/products">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="search" placeholder="Search products..." 
                                           value="<?php echo htmlspecialchars($search ?? ''); ?>">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="category">
                                        <option value="">All Categories</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" 
                                                <?php echo ($selected_category ?? '') == $category['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="status">
                                        <option value="all">All Status</option>
                                        <option value="active" <?php echo ($selected_status ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($selected_status ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>Filter
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <div class="export-buttons">
                                        <small class="text-muted d-block mb-1">Export:</small>
                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=export&format=csv&<?php echo http_build_query($_GET); ?>" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-file-csv me-1"></i>CSV
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=export&format=excel&<?php echo http_build_query($_GET); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-excel me-1"></i>Excel
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=export&format=pdf&<?php echo http_build_query($_GET); ?>" 
                                           class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <form method="POST" action="<?php echo BASE_URL; ?>dashboard/products?action=bulk-action" id="bulkForm">
                    <div class="bulk-actions mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <select class="form-control" name="bulk_action" style="width: auto; display: inline-block;">
                                    <option value="">Bulk Actions</option>
                                    <option value="activate">Activate Selected</option>
                                    <option value="deactivate">Deactivate Selected</option>
                                    <option value="delete">Delete Selected</option>
                                </select>
                                <button type="submit" class="btn btn-primary" id="applyBulkAction">
                                    <i class="fas fa-play me-2"></i>Apply
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    Showing <?php echo $pagination['total_items']; ?> products
                                    <?php if ($pagination['total_pages'] > 1): ?>
                                        - Page <?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="card">
                        <div class="card-body">
                            <?php if (!empty($products)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="30">
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Category</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="product_ids[]" value="<?php echo $product['id']; ?>" class="product-checkbox">
                                                </td>
                                                <td>
                                                    <img src="<?php echo $product['image_url'] ?: 'https://via.placeholder.com/50x50/6c757d/ffffff?text=No+Image'; ?>" 
                                                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                         style="width: 50px; height: 50px; object-fit: cover;" 
                                                         class="rounded">
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                                    <?php if ($product['description']): ?>
                                                        <br><small class="text-muted"><?php echo substr(htmlspecialchars($product['description']), 0, 50) . '...'; ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $product['stock_quantity'] > 0 ? 'success' : 'danger'; ?>">
                                                        <?php echo $product['stock_quantity']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="status-<?php echo $product['status']; ?>">
                                                        <i class="fas fa-circle me-1"></i><?php echo ucfirst($product['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                                                <td class="action-buttons">
                                                    <a href="<?php echo BASE_URL; ?>dashboard/products?action=edit&id=<?php echo $product['id']; ?>" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <?php if ($product['status'] === 'active'): ?>
                                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=toggle-status&id=<?php echo $product['id']; ?>&status=inactive" 
                                                           class="btn btn-sm btn-secondary" title="Deactivate">
                                                            <i class="fas fa-pause"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=toggle-status&id=<?php echo $product['id']; ?>&status=active" 
                                                           class="btn btn-sm btn-success" title="Activate">
                                                            <i class="fas fa-play"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?php echo BASE_URL; ?>dashboard/products?action=delete&id=<?php echo $product['id']; ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this product?')"
                                                       title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if ($pagination['total_pages'] > 1): ?>
                                <nav aria-label="Product pagination">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($pagination['current_page'] > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" 
                                                   href="<?php echo BASE_URL; ?>dashboard/products?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] - 1])); ?>">
                                                    Previous
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                            <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                                <a class="page-link" 
                                                   href="<?php echo BASE_URL; ?>dashboard/products?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                            <li class="page-item">
                                                <a class="page-link" 
                                                   href="<?php echo BASE_URL; ?>dashboard/products?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['current_page'] + 1])); ?>">
                                                    Next
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                                <?php endif; ?>

                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                                    <h4>No Products Found</h4>
                                    <p class="text-muted">
                                        <?php echo isset($_GET['search']) ? 'No products match your search criteria.' : 'Get started by adding your first product.'; ?>
                                    </p>
                                    <?php if (!isset($_GET['search'])): ?>
                                        <a href="<?php echo BASE_URL; ?>dashboard/products?action=create" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add Your First Product
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bulk selection
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk action confirmation
        document.getElementById('applyBulkAction').addEventListener('click', function(e) {
            const form = document.getElementById('bulkForm');
            const action = form.bulk_action.value;
            const checked = document.querySelectorAll('.product-checkbox:checked').length;

            if (!action) {
                e.preventDefault();
                alert('Please select a bulk action.');
                return;
            }

            if (checked === 0) {
                e.preventDefault();
                alert('Please select at least one product.');
                return;
            }

            if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${checked} product(s)?`)) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>