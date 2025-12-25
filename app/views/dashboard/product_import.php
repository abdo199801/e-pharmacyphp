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
                    <h1 class="h3">Import Products</h1>
                    <a href="<?php echo BASE_URL; ?>dashboard/products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Upload File</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo BASE_URL; ?>dashboard/products?action=import" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="import_file" class="form-label">Select File</label>
                                        <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv,.xlsx,.xls" required>
                                        <div class="form-text">
                                            Supported formats: CSV, Excel (.xlsx, .xls). Max file size: 10MB
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing" checked>
                                            <label class="form-check-label" for="update_existing">
                                                Update existing products with same name
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-2"></i>Import Products
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">File Format</h5>
                            </div>
                            <div class="card-body">
                                <p>Your file should have the following columns:</p>
                                <ul>
                                    <li><strong>name</strong> (required) - Product name</li>
                                    <li><strong>price</strong> (required) - Product price</li>
                                    <li><strong>description</strong> - Product description</li>
                                    <li><strong>category_id</strong> (required) - Category ID</li>
                                    <li><strong>stock_quantity</strong> - Stock quantity</li>
                                    <li><strong>status</strong> - active/inactive</li>
                                </ul>
                                
                                <hr>
                                
                                <p class="mb-2">
                                    <a href="<?php echo BASE_URL; ?>dashboard/products?action=export&format=csv&template=1" 
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i>Download Template
                                    </a>
                                </p>
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