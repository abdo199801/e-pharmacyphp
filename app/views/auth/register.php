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
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .brand-text {
            color: #667eea;
            font-weight: bold;
        }
        .pharmacy-section {
            border-left: 4px solid #667eea;
            background: #f8f9fa;
        }
        .nav-pills .nav-link {
            color: #667eea;
        }
        .nav-pills .nav-link.active {
            background-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="register-card p-4 p-md-5">
                    <!-- Brand Header -->
                    <div class="text-center mb-4">
                        <i class="fas fa-clinic-medical fa-3x brand-text mb-3"></i>
                        <h2 class="brand-text">Join PharmaPlatform</h2>
                        <p class="text-muted">Create your account to get started</p>
                    </div>

                    <!-- Account Type Selection -->
                    <ul class="nav nav-pills nav-fill mb-4" id="accountTypeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="pill" data-bs-target="#personal" type="button" role="tab">
                                <i class="fas fa-user me-2"></i>Personal Account
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pharmacy-tab" data-bs-toggle="pill" data-bs-target="#pharmacy" type="button" role="tab">
                                <i class="fas fa-clinic-medical me-2"></i>Pharmacy Account
                            </button>
                        </li>
                    </ul>

                    <!-- Success/Error Messages -->
                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $errors['general']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Registration Form -->
                    <form method="POST" action="<?php echo BASE_URL; ?>auth/register">
                        <div class="tab-content">
                            <!-- Personal Account Tab -->
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                <!-- Personal account fields will be shown by default -->
                                <input type="hidden" name="account_type" value="personal">
                            </div>

                            <!-- Pharmacy Account Tab -->
                            <div class="tab-pane fade" id="pharmacy" role="tabpanel">
                                <div class="pharmacy-section p-3 mb-4">
                                    <h5 class="text-primary"><i class="fas fa-clinic-medical me-2"></i>Pharmacy Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="pharmacy_name" class="form-label">Pharmacy Name *</label>
                                            <input type="text" 
                                                   class="form-control <?php echo !empty($errors['pharmacy_name']) ? 'is-invalid' : ''; ?>" 
                                                   id="pharmacy_name" 
                                                   name="pharmacy_name" 
                                                   value="<?php echo htmlspecialchars($old_input['pharmacy_name'] ?? ''); ?>">
                                            <?php if (!empty($errors['pharmacy_name'])): ?>
                                                <div class="invalid-feedback d-block"><?php echo $errors['pharmacy_name']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="license_number" class="form-label">License Number *</label>
                                            <input type="text" 
                                                   class="form-control <?php echo !empty($errors['license_number']) ? 'is-invalid' : ''; ?>" 
                                                   id="license_number" 
                                                   name="license_number" 
                                                   value="<?php echo htmlspecialchars($old_input['license_number'] ?? ''); ?>">
                                            <?php if (!empty($errors['license_number'])): ?>
                                                <div class="invalid-feedback d-block"><?php echo $errors['license_number']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text" 
                                                   class="form-control <?php echo !empty($errors['city']) ? 'is-invalid' : ''; ?>" 
                                                   id="city" 
                                                   name="city" 
                                                   value="<?php echo htmlspecialchars($old_input['city'] ?? ''); ?>">
                                            <?php if (!empty($errors['city'])): ?>
                                                <div class="invalid-feedback d-block"><?php echo $errors['city']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="country" class="form-label">Country *</label>
                                            <input type="text" 
                                                   class="form-control <?php echo !empty($errors['country']) ? 'is-invalid' : ''; ?>" 
                                                   id="country" 
                                                   name="country" 
                                                   value="<?php echo htmlspecialchars($old_input['country'] ?? ''); ?>">
                                            <?php if (!empty($errors['country'])): ?>
                                                <div class="invalid-feedback d-block"><?php echo $errors['country']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <h5 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">First Name *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" 
                                           class="form-control <?php echo !empty($errors['firstname']) ? 'is-invalid' : ''; ?>" 
                                           id="firstname" 
                                           name="firstname" 
                                           value="<?php echo htmlspecialchars($old_input['firstname'] ?? ''); ?>" 
                                           required>
                                </div>
                                <?php if (!empty($errors['firstname'])): ?>
                                    <div class="invalid-feedback d-block"><?php echo $errors['firstname']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Last Name *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" 
                                           class="form-control <?php echo !empty($errors['lastname']) ? 'is-invalid' : ''; ?>" 
                                           id="lastname" 
                                           name="lastname" 
                                           value="<?php echo htmlspecialchars($old_input['lastname'] ?? ''); ?>" 
                                           required>
                                </div>
                                <?php if (!empty($errors['lastname'])): ?>
                                    <div class="invalid-feedback d-block"><?php echo $errors['lastname']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" 
                                           class="form-control <?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>" 
                                           id="email" 
                                           name="email" 
                                           value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" 
                                           required>
                                </div>
                                <?php if (!empty($errors['email'])): ?>
                                    <div class="invalid-feedback d-block"><?php echo $errors['email']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?php echo htmlspecialchars($old_input['phone'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <textarea class="form-control" 
                                          id="address" 
                                          name="address" 
                                          rows="2"><?php echo htmlspecialchars($old_input['address'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <h5 class="text-primary mb-3"><i class="fas fa-lock me-2"></i>Security</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" 
                                           class="form-control <?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>" 
                                           id="password" 
                                           name="password" 
                                           required>
                                </div>
                                <?php if (!empty($errors['password'])): ?>
                                    <div class="invalid-feedback d-block"><?php echo $errors['password']; ?></div>
                                <?php endif; ?>
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" 
                                           class="form-control <?php echo !empty($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           required>
                                </div>
                                <?php if (!empty($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback d-block"><?php echo $errors['confirm_password']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Create Account
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="<?php echo BASE_URL; ?>auth/login" class="text-decoration-none">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle account type selection
        document.addEventListener('DOMContentLoaded', function() {
            const pharmacyTab = document.getElementById('pharmacy-tab');
            const personalTab = document.getElementById('personal-tab');
            
            // Make pharmacy fields required when pharmacy tab is active
            pharmacyTab.addEventListener('click', function() {
                makePharmacyFieldsRequired(true);
            });
            
            personalTab.addEventListener('click', function() {
                makePharmacyFieldsRequired(false);
            });
            
            function makePharmacyFieldsRequired(required) {
                const pharmacyFields = ['pharmacy_name', 'license_number', 'city', 'country'];
                pharmacyFields.forEach(field => {
                    const element = document.getElementById(field);
                    if (element) {
                        element.required = required;
                    }
                });
            }
            
            // Set initial state
            makePharmacyFieldsRequired(false);
        });
    </script>
</body>
</html>