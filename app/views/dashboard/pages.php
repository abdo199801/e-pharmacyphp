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
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/products">
                        <i class="fas fa-pills me-2"></i>Products
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/blogs">
                        <i class="fas fa-blog me-2"></i>Blog Posts
                    </a>
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>dashboard/pages">
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
                    <h1 class="h3">Manage Pages</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPageModal">
                        <i class="fas fa-plus me-2"></i>Add New Page
                    </button>
                </div>

                <!-- Pages Table -->
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($pages)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pages as $page): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo $page['title']; ?></strong>
                                                <?php if ($page['content']): ?>
                                                    <br><small class="text-muted"><?php echo substr(strip_tags($page['content']), 0, 50) . '...'; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo ucfirst($page['page_type']); ?></span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($page['created_at'])); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>dashboard/pages?delete_page=<?php echo $page['id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this page?')">
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
                                <i class="fas fa-file fa-3x text-muted mb-3"></i>
                                <h4>No Pages Yet</h4>
                                <p class="text-muted">Create custom pages for your pharmacy website.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPageModal">
                                    <i class="fas fa-plus me-2"></i>Create Your First Page
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Page Modal -->
    <div class="modal fade" id="createPageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?php echo BASE_URL; ?>dashboard/pages">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Page Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="page_type" class="form-label">Page Type *</label>
                            <select class="form-control" id="page_type" name="page_type" required>
                                <option value="home">Home</option>
                                <option value="about">About</option>
                                <option value="services">Services</option>
                                <option value="blog">Blog</option>
                                <option value="contact">Contact</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="create_page" class="btn btn-primary">Create Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>