<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'About Us - PharmaPlatform'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --secondary: #34a853;
            --accent: #fbbc05;
            --dark: #202124;
            --light: #f8f9fa;
            --gray: #5f6368;
            --border: #dadce0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--gray) !important;
            transition: color 0.3s;
            margin: 0 0.5rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }
        
        .page-hero {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,160C960,139,1056,117,1152,122.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .section-title {
            font-weight: 600;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
        }
        
        .about-image {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.5s;
        }
        
        .about-image:hover {
            transform: scale(1.02);
        }
        
        .mission-card, .value-card {
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2rem;
            height: 100%;
            transition: all 0.3s;
            background-color: white;
        }
        
        .mission-card:hover, .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: var(--primary);
        }
        
        .value-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: rgba(26, 115, 232, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .stats-section {
            background-color: var(--light);
            padding: 80px 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            color: var(--gray);
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        .team-card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
            background-color: white;
        }
        
        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .team-image {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        
        .team-social {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
            border-top: 1px solid var(--border);
        }
        
        .team-social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(26, 115, 232, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .team-social a:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-links h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--primary);
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
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icons a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            margin-top: 3rem;
        }
        
        @media (max-width: 768px) {
            .page-hero {
                padding: 80px 0 60px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
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
                        <a class="nav-link" href="<?php echo BASE_URL; ?>home">Home</a>
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
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>home/about">About</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <!-- Show when user is logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
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
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?php echo BASE_URL; ?>auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">About PharmaPlatform</h1>
                    <p class="lead mb-0">Revolutionizing pharmacy management through innovative digital solutions that connect pharmacies with customers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="section-title">Our Story</h2>
                    <p class="mb-4">Founded in 2020, PharmaPlatform emerged from a simple observation: the pharmacy industry was ripe for digital transformation. While other sectors had embraced technology to improve customer experiences and operational efficiency, pharmacies remained largely bound by traditional methods.</p>
                    <p class="mb-4">Our founders, with backgrounds in healthcare, technology, and business, set out to create a comprehensive platform that would empower pharmacies to thrive in the digital age while providing customers with convenient access to healthcare products and services.</p>
                    <p>Today, we serve thousands of pharmacies and millions of customers across the country, continually innovating to meet the evolving needs of the healthcare ecosystem.</p>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Pharmacy Team" class="img-fluid about-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="mission-card">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="text-center mb-3">Our Mission</h3>
                        <p class="text-center">To empower pharmacies with cutting-edge digital tools that streamline operations, enhance customer engagement, and drive business growth while ensuring patients have convenient access to healthcare products and services.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-card">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="text-center mb-3">Our Vision</h3>
                        <p class="text-center">To become the leading digital ecosystem for pharmacy management, creating a seamless connection between pharmacies, patients, and healthcare providers that transforms how healthcare products are accessed and managed.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Partner Pharmacies</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Products Listed</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number">1M+</span>
                        <span class="stat-label">Customers Served</span>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Support Available</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Our Values</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Patient-Centric</h4>
                        <p>We prioritize patient well-being and convenience in every solution we develop, ensuring healthcare remains accessible to all.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Trust & Security</h4>
                        <p>We maintain the highest standards of data security and privacy, protecting sensitive health information with advanced encryption.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation</h4>
                        <p>We continuously evolve our platform with cutting-edge technologies to stay ahead of industry trends and customer needs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Collaboration</h4>
                        <p>We believe in the power of partnership, working closely with pharmacies, healthcare providers, and industry stakeholders.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Excellence</h4>
                        <p>We strive for excellence in every aspect of our service, from platform performance to customer support and user experience.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Community</h4>
                        <p>We're committed to strengthening the pharmacy community through knowledge sharing, networking, and mutual support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Our Leadership Team</h2>
            <p class="text-center mb-5 max-w-3 mx-auto">Our diverse team brings together decades of experience in healthcare, technology, and business to drive innovation in pharmacy management.</p>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card text-center">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Dr. Sarah Johnson" class="team-image">
                        <div class="p-4">
                            <h5 class="mb-1">Dr. Sarah Johnson</h5>
                            <p class="text-muted mb-3">CEO & Co-Founder</p>
                            <p class="small text-muted">Former pharmacy owner with 15+ years of healthcare experience.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card text-center">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Michael Chen" class="team-image">
                        <div class="p-4">
                            <h5 class="mb-1">Michael Chen</h5>
                            <p class="text-muted mb-3">CTO & Co-Founder</p>
                            <p class="small text-muted">Technology entrepreneur with expertise in SaaS platforms and healthcare IT.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card text-center">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Emily Rodriguez" class="team-image">
                        <div class="p-4">
                            <h5 class="mb-1">Emily Rodriguez</h5>
                            <p class="text-muted mb-3">Chief Product Officer</p>
                            <p class="small text-muted">Product management leader with background in healthcare technology solutions.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card text-center">
                        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="David Thompson" class="team-image">
                        <div class="p-4">
                            <h5 class="mb-1">David Thompson</h5>
                            <p class="text-muted mb-3">Head of Pharmacy Relations</p>
                            <p class="small text-muted">Former pharmacy chain executive with deep industry connections.</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold">Join the PharmaPlatform Community</h2>
            <p class="mb-4 fs-5">Whether you're a pharmacy looking to expand your reach or a customer seeking convenient healthcare solutions, we're here to help.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-light btn-lg px-5 py-3 fw-semibold">
                    Register Your Pharmacy <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>home/products" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold">
                    Browse Products <i class="fas fa-search ms-2"></i>
                </a>
            </div>
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
</body>
</html>