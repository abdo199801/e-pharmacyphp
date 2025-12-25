<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --primary-light: #e8f0fe;
            --secondary: #34a853;
            --accent: #fbbc05;
            --accent-light: #fef7e0;
            --dark: #202124;
            --light: #f8f9fa;
            --gray: #5f6368;
            --border: #dadce0;
            --gradient-primary: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            --gradient-secondary: linear-gradient(135deg, #34a853 0%, #1e8e3e 100%);
            --gradient-accent: linear-gradient(135deg, #fbbc05 0%, #f29900 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.15);
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: var(--shadow-md);
        }
        
        .navbar-brand {
            font-weight: 800;
            color: var(--primary) !important;
            font-size: 1.75rem;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--gray) !important;
            transition: color 0.3s;
            margin: 0 0.5rem;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(26, 115, 232, 0.4);
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-light {
            background: white;
            color: var(--primary);
            border: none;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .btn-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            background: white;
            color: var(--primary);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.2);
        }
        
        .hero-section {
            background: var(--gradient-primary);
            color: white;
            padding: 160px 0 120px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,160C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
            animation: wave 20s linear infinite;
        }
        
        @keyframes wave {
            0% { transform: translateX(0); }
            50% { transform: translateX(-30px); }
            100% { transform: translateX(0); }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-section h1 {
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 3.5rem;
            line-height: 1.2;
        }
        
        .hero-section p {
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }
        
        .section-title.center::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-subtitle {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 4rem;
        }
        
        .product-card {
            transition: all 0.4s ease;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            background: white;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        
        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .product-card:hover .card-img-top {
            transform: scale(1.08);
        }
        
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--gradient-secondary);
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
        }
        
        .category-card {
            transition: all 0.3s;
            border-radius: 16px;
            text-align: center;
            padding: 2rem 1rem;
            background-color: white;
            border: 1px solid var(--border);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }
        
        .category-card:hover::before {
            transform: scaleX(1);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 2rem;
            transition: all 0.3s;
        }
        
        .category-card:hover .category-icon {
            background: var(--gradient-primary);
            color: white;
            transform: scale(1.1);
        }
        
        .pharmacy-card {
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            height: 100%;
            background: white;
            overflow: hidden;
        }
        
        .pharmacy-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }
        
        .pharmacy-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .blog-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
            height: 100%;
            background: white;
        }
        
        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
        }
        
        .blog-image {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .blog-card:hover .blog-image {
            transform: scale(1.08);
        }
        
        .blog-date {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .stats-section {
            background: var(--gradient-primary);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,160C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }
        
        .stat-item {
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .feature-section {
            padding: 100px 0;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-card {
            padding: 2.5rem 1.5rem;
            border-radius: 16px;
            height: 100%;
            transition: all 0.3s;
            background: white;
            border: 1px solid var(--border);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }
        
        .testimonial-section {
            background: var(--light);
            padding: 100px 0;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            height: 100%;
            position: relative;
        }
        
        .testimonial-card::before {
            content: """;
            position: absolute;
            top: 20px;
            left: 25px;
            font-size: 4rem;
            color: var(--primary-light);
            font-family: Georgia, serif;
            line-height: 1;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }
        
        .cta-section {
            background: var(--gradient-primary);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,160C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 5rem 0 2rem;
        }
        
        .footer-links h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
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
            padding-left: 5px;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            background: var(--gradient-primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            margin-top: 3rem;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            
            .hero-section {
                padding: 120px 0 80px;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
        
        /* Animation classes */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home/products">Products</a>
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
                
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <!-- Show when user is logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                    <i class="fas fa-user text-white" style="font-size: 0.9rem;"></i>
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
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary" href="<?php echo BASE_URL; ?>auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="floating-elements">
            <div class="floating-element" style="width: 80px; height: 80px; top: 10%; left: 10%;"></div>
            <div class="floating-element" style="width: 60px; height: 60px; top: 70%; left: 80%;"></div>
            <div class="floating-element" style="width: 100px; height: 100px; top: 40%; left: 85%;"></div>
            <div class="floating-element" style="width: 50px; height: 50px; top: 80%; left: 15%;"></div>
            <div class="floating-element" style="width: 70px; height: 70px; top: 20%; left: 75%;"></div>
        </div>
        <div class="container hero-content">
            <span class="hero-badge animate__animated animate__fadeInDown">Trusted by 500+ Pharmacies Nationwide</span>
            <h1 class="animate__animated animate__fadeInUp">Professional Pharmacy Management Platform</h1>
            <p class="animate__animated animate__fadeInUp animate__delay-1s">Streamline your pharmacy operations, connect with customers, and grow your business with our comprehensive digital solution</p>
            <div class="animate__animated animate__fadeInUp animate__delay-2s">
                <?php if (!isset($_SESSION['logged_in'])): ?>
                    <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-light btn-lg px-5 py-3 fw-semibold me-3">
                        Get Started <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="<?php echo BASE_URL; ?>home/services" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold">
                        Learn More
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>dashboard" class="btn btn-light btn-lg px-5 py-3 fw-semibold">
                        Go to Dashboard <i class="fas fa-tachometer-alt ms-2"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="500">0</span>
                        <span class="stat-label">Partner Pharmacies</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="10000">0</span>
                        <span class="stat-label">Products Available</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="250000">0</span>
                        <span class="stat-label">Customers Served</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number" data-count="50">0</span>
                        <span class="stat-label">Cities Covered</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center center">Product Categories</h2>
            <p class="section-subtitle text-center">Browse our wide range of pharmaceutical products organized by category for easy navigation</p>
            <div class="row">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                    <div class="col-lg-2 col-md-4 col-6 mb-4">
                        <a href="<?php echo BASE_URL; ?>home/category/<?php echo $category['id']; ?>" 
                           class="category-card text-decoration-none text-dark animate-on-scroll">
                            <div class="category-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h6 class="fw-semibold mb-0"><?php echo $category['name']; ?></h6>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">No categories available yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-section">
        <div class="container">
            <h2 class="section-title text-center center">Why Choose PharmaPlatform?</h2>
            <p class="section-subtitle text-center">Our platform offers comprehensive solutions designed specifically for modern pharmacy needs</p>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Streamlined Operations</h4>
                        <p class="text-muted">Automate inventory management, prescription processing, and customer management with our intuitive dashboard.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Business Growth</h4>
                        <p class="text-muted">Expand your customer base with our integrated marketing tools and online presence solutions.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Secure & Compliant</h4>
                        <p class="text-muted">Stay compliant with healthcare regulations with our secure, HIPAA-compliant platform.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Mobile-Friendly</h4>
                        <p class="text-muted">Manage your pharmacy on the go with our responsive design that works on all devices.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Customer Engagement</h4>
                        <p class="text-muted">Build lasting relationships with customers through personalized communication and loyalty programs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="fw-bold mb-3">24/7 Support</h4>
                        <p class="text-muted">Get assistance whenever you need it with our round-the-clock customer support team.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="section-title">Featured Products</h2>
                <a href="<?php echo BASE_URL; ?>home/products" class="btn btn-outline-primary">View All Products</a>
            </div>
            <div class="row">
                <?php if (!empty($featured_products)): ?>
                    <?php foreach ($featured_products as $product): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card product-card h-100 animate-on-scroll">
                            <span class="badge category-badge"><?php echo $product['category_name']; ?></span>
                            <img src="<?php echo $product['image_url'] ?: 'https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image'; ?>" 
                                 class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold"><?php echo $product['name']; ?></h5>
                                <p class="card-text text-muted small flex-grow-1"><?php echo $product['description'] ?: 'No description available'; ?></p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0 fw-bold">$<?php echo number_format($product['price'], 2); ?></span>
                                        <small class="text-muted">Stock: <?php echo $product['stock_quantity']; ?></small>
                                    </div>
                                    <?php if (isset($product['pharmacy_name'])): ?>
                                        <small class="text-muted d-block mt-1">By: <?php echo $product['pharmacy_name']; ?></small>
                                    <?php endif; ?>
                                    <button class="btn btn-primary w-100 mt-3">
                                        <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No products available yet. Products will appear here once pharmacies add them to the system.</p>
                        <?php if (!isset($_SESSION['logged_in'])): ?>
                            <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-primary mt-2">Start Selling Today</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section">
        <div class="container">
            <h2 class="section-title text-center center">What Our Partners Say</h2>
            <p class="section-subtitle text-center">Hear from pharmacies that have transformed their business with PharmaPlatform</p>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card animate-on-scroll">
                        <p class="mb-4">"Since implementing PharmaPlatform, our prescription processing time has decreased by 40% and customer satisfaction has significantly improved."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson" class="testimonial-avatar">
                            <div>
                                <h6 class="fw-bold mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Owner, HealthPlus Pharmacy</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card animate-on-scroll">
                        <p class="mb-4">"The inventory management features have saved us countless hours each week. We can now focus more on patient care rather than paperwork."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="testimonial-avatar">
                            <div>
                                <h6 class="fw-bold mb-0">Michael Chen</h6>
                                <small class="text-muted">Pharmacist, MedCare Solutions</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card animate-on-scroll">
                        <p class="mb-4">"Our online sales have increased by 65% since joining PharmaPlatform. The platform's marketing tools have been invaluable for growth."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Lisa Rodriguez" class="testimonial-avatar">
                            <div>
                                <h6 class="fw-bold mb-0">Lisa Rodriguez</h6>
                                <small class="text-muted">Manager, Community Drugstore</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Blogs -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center center">Latest Health Insights</h2>
            <p class="section-subtitle text-center">Stay informed with the latest news and insights from the healthcare industry</p>
            <div class="row">
                <?php if (!empty($recent_blogs)): ?>
                    <?php foreach ($recent_blogs as $blog): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card blog-card h-100 animate-on-scroll">
                            <div class="position-relative overflow-hidden">
                                <img src="<?php echo $blog['image_url'] ?: 'https://via.placeholder.com/600x300/6c757d/ffffff?text=Blog+Image'; ?>" 
                                     class="blog-image w-100" alt="<?php echo $blog['title']; ?>">
                                <div class="blog-date">
                                    <?php echo date('M j', strtotime($blog['created_at'])); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-semibold"><?php echo $blog['title']; ?></h5>
                                <p class="card-text text-muted"><?php echo substr(strip_tags($blog['content']), 0, 100) . '...'; ?></p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i><?php echo $blog['firstname'] . ' ' . $blog['lastname']; ?>
                                    </small>
                                    <a href="#" class="text-primary text-decoration-none small fw-semibold">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No blog posts available yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Pharmacy Locations -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center center">Our Partner Pharmacies</h2>
            <p class="section-subtitle text-center">Connect with trusted pharmacies in your area for all your healthcare needs</p>
            <div class="row">
                <?php if (!empty($pharmacies)): ?>
                    <?php foreach ($pharmacies as $pharmacy): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card pharmacy-card h-100 animate-on-scroll">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="pharmacy-icon me-3">
                                        <i class="fas fa-clinic-medical"></i>
                                    </div>
                                    <h5 class="card-title mb-0 fw-semibold"><?php echo $pharmacy['pharmacy_name'] ?? 'Pharmacy'; ?></h5>
                                </div>
                                <div class="text-muted">
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i> 
                                        <?php echo $pharmacy['address'] ?? 'Address not available'; ?>
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i> 
                                        <?php echo $pharmacy['phone'] ?? 'Phone not available'; ?>
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-city text-info me-2"></i> 
                                        <?php echo $pharmacy['city'] ?? ''; ?>, <?php echo $pharmacy['country'] ?? ''; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                                <a href="#" class="btn btn-sm btn-primary ms-2">Get Directions</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-clinic-medical fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No pharmacies registered yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container cta-content">
            <h2 class="mb-4 fw-bold">Ready to Transform Your Pharmacy Business?</h2>
            <p class="mb-4 fs-5">Join thousands of pharmacies already using PharmaPlatform to streamline operations and grow their customer base.</p>
            <?php if (!isset($_SESSION['logged_in'])): ?>
                <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-light btn-lg px-5 py-3 fw-semibold me-3">
                    Get Started Today <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>home/services" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold">
                    Schedule a Demo
                </a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>dashboard" class="btn btn-light btn-lg px-5 py-3 fw-semibold">
                    Go to Dashboard <i class="fas fa-tachometer-alt ms-2"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>

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
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animate on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.classList.add('animated');
                }
            });
        }

        // Initialize animation on load
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);

        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;
            
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const increment = target / speed;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounters, 1);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            });
        }

        // Initialize counter animation when stats section is in view
        const statsSection = document.querySelector('.stats-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>