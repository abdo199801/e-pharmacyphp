<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3"><?php echo $current_action === 'create' ? 'Add New Product' : 'Edit Product'; ?></h1>
                    <a href="<?php echo BASE_URL; ?>dashboard/products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?php echo BASE_URL; ?>dashboard/products?action=<?php echo $current_action; ?><?php echo $current_action === 'edit' ? '&id=' . $product['id'] : ''; ?>" 
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo $product['name'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price *</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           step="0.01" min="0" value="<?php echo $product['price'] ?? ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $product['description'] ?? ''; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" 
                                                <?php echo (isset($product['category_id']) && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                <?php echo $category['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" 
                                           min="0" value="<?php echo $product['stock_quantity'] ?? 0; ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" <?php echo (isset($product['status']) && $product['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo (isset($product['status']) && $product['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="form-text text-muted">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</small>
                                    <?php if (isset($product['image_url']) && $product['image_url']): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo $product['image_url']; ?>" alt="Current image" style="max-width: 100px; max-height: 100px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo BASE_URL; ?>dashboard/products" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $current_action === 'create' ? 'Create Product' : 'Update Product'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>