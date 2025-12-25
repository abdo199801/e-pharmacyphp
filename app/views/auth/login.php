<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .brand-text {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card p-4 p-md-5">
                    <!-- Brand Header -->
                    <div class="text-center mb-4">
                        <i class="fas fa-clinic-medical fa-3x brand-text mb-3"></i>
                        <h2 class="brand-text">PharmaPlatform</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>

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

                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $errors['general']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="POST" action="<?php echo BASE_URL; ?>auth/login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       class="form-control <?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" 
                                       placeholder="Enter your email" 
                                       required>
                            </div>
                            <?php if (!empty($errors['email'])): ?>
                                <div class="invalid-feedback d-block"><?php echo $errors['email']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" 
                                       class="form-control <?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required>
                            </div>
                            <?php if (!empty($errors['password'])): ?>
                                <div class="invalid-feedback d-block"><?php echo $errors['password']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Sign In
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="<?php echo BASE_URL; ?>auth/register" class="text-decoration-none">Create one here</a>
                            </p>
                        </div>
                    </form>

                    <!-- Demo Accounts -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-center mb-3">Demo Accounts:</h6>
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted d-block">
                                    <strong>Pharmacy Account:</strong> pharmacy1@example.com / password123
                                </small>
                                <small class="text-muted d-block">
                                    <strong>Regular User:</strong> user@example.com / password123
                                </small>
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