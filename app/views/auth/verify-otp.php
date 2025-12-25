<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - PharmaPlatform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .otp-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .brand-text {
            color: #667eea;
            font-weight: bold;
        }
        .otp-input {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="otp-card p-4 p-md-5">
                    <!-- Brand Header -->
                    <div class="text-center mb-4">
                        <i class="fas fa-clinic-medical fa-3x brand-text mb-3"></i>
                        <h2 class="brand-text">PharmaPlatform</h2>
                        <p class="text-muted">Verify Your Email</p>
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

                    <!-- Demo OTP Display -->
                    <?php if (isset($_SESSION['demo_otp'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Demo OTP:</strong> <?php echo $_SESSION['demo_otp']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- OTP Form -->
                    <form method="POST" action="<?php echo BASE_URL; ?>auth/verifyOtp">
                        <div class="mb-4">
                            <p class="text-center">
                                We've sent a 6-digit OTP to:<br>
                                <strong><?php echo htmlspecialchars($email ?? ''); ?></strong>
                            </p>
                            
                            <label for="otp" class="form-label">Enter OTP Code</label>
                            <input type="text" 
                                   class="form-control otp-input <?php echo !empty($errors['otp']) ? 'is-invalid' : ''; ?>" 
                                   id="otp" 
                                   name="otp" 
                                   placeholder="000000" 
                                   maxlength="6"
                                   required
                                   pattern="[0-9]{6}">
                            <?php if (!empty($errors['otp'])): ?>
                                <div class="invalid-feedback d-block"><?php echo $errors['otp']; ?></div>
                            <?php endif; ?>
                            
                            <div class="form-text">
                                The OTP will expire in 10 minutes.
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle"></i> Verify OTP
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                Didn't receive the code? 
                                <a href="<?php echo BASE_URL; ?>auth/resendOtp" class="text-decoration-none">Resend OTP</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-format OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>