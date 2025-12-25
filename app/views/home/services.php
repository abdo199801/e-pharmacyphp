<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Our Services - PharmaPlatform'; ?></title>
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
        
        .service-card {
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.3s;
            background-color: white;
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .service-card:hover::before {
            transform: scaleX(1);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(26, 115, 232, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 2rem;
            transition: all 0.3s;
        }
        
        .service-card:hover .service-icon {
            background-color: var(--primary);
            color: white;
            transform: scale(1.1);
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin-top: 1.5rem;
        }
        
        .feature-list li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
        }
        
        .feature-list li i {
            color: var(--secondary);
            margin-right: 10px;
            margin-top: 4px;
            flex-shrink: 0;
        }
        
        .pricing-card {
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.3s;
            background-color: white;
            position: relative;
        }
        
        .pricing-card.popular {
            border-color: var(--primary);
            box-shadow: 0 10px 25px rgba(26, 115, 232, 0.15);
            transform: scale(1.05);
        }
        
        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-5px);
        }
        
        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }
        
        .price-period {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .testimonial-card {
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2rem;
            background-color: white;
            transition: all 0.3s;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }
        
        .process-step {
            position: relative;
            padding-left: 80px;
            margin-bottom: 3rem;
        }
        
        .step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .step-line {
            position: absolute;
            left: 30px;
            top: 60px;
            width: 2px;
            height: calc(100% + 3rem);
            background-color: var(--border);
        }
        
        .process-step:last-child .step-line {
            display: none;
        }
        
        .faq-item {
            border-radius: 8px;
            border: 1px solid var(--border);
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 1.5rem;
            background-color: white;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .faq-question:hover {
            background-color: var(--light);
        }
        
        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .faq-item.active .faq-answer {
            padding: 0 1.5rem 1.5rem;
            max-height: 500px;
        }
        
        .faq-item.active .fa-chevron-down {
            transform: rotate(180deg);
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
            
            .process-step {
                padding-left: 0;
                padding-top: 70px;
            }
            
            .step-number {
                top: 0;
                left: 0;
            }
            
            .step-line {
                left: 30px;
                top: 60px;
                height: calc(100% + 3rem);
            }
            
            .pricing-card.popular {
                transform: scale(1);
            }
            
            .pricing-card.popular:hover {
                transform: translateY(-5px);
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
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>home/services">Services</a>
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
                    <h1 class="display-4 fw-bold mb-4">Our Services</h1>
                    <p class="lead mb-0">Comprehensive digital solutions designed to transform pharmacy operations and enhance patient care.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center mb-5">
                    <h2 class="section-title">Comprehensive Pharmacy Solutions</h2>
                    <p>We offer a complete suite of services designed to meet the evolving needs of modern pharmacies and their customers.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-store"></i>
                        </div>
                        <h4>Digital Storefront</h4>
                        <p>Create a professional online presence with customizable e-commerce storefronts that showcase your products and services.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Customizable product catalogs</li>
                            <li><i class="fas fa-check"></i> Secure payment processing</li>
                            <li><i class="fas fa-check"></i> Mobile-responsive design</li>
                            <li><i class="fas fa-check"></i> Brand customization options</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Inventory Management</h4>
                        <p>Streamline your pharmacy operations with intelligent inventory tracking and automated reordering systems.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Real-time stock monitoring</li>
                            <li><i class="fas fa-check"></i> Automated low-stock alerts</li>
                            <li><i class="fas fa-check"></i> Supplier management</li>
                            <li><i class="fas fa-check"></i> Expiration date tracking</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4>Patient Management</h4>
                        <p>Enhance patient care with comprehensive profiles, medication history, and personalized health insights.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Patient profile management</li>
                            <li><i class="fas fa-check"></i> Medication history tracking</li>
                            <li><i class="fas fa-check"></i> Automated refill reminders</li>
                            <li><i class="fas fa-check"></i> Health insights and analytics</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-prescription"></i>
                        </div>
                        <h4>E-Prescription Services</h4>
                        <p>Streamline prescription management with secure digital prescribing and fulfillment workflows.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Digital prescription processing</li>
                            <li><i class="fas fa-check"></i> Physician connectivity</li>
                            <li><i class="fas fa-check"></i> Prescription status tracking</li>
                            <li><i class="fas fa-check"></i> Compliance monitoring</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Business Analytics</h4>
                        <p>Make data-driven decisions with comprehensive reporting and performance analytics tailored for pharmacies.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Sales performance tracking</li>
                            <li><i class="fas fa-check"></i> Customer behavior insights</li>
                            <li><i class="fas fa-check"></i> Inventory turnover analysis</li>
                            <li><i class="fas fa-check"></i> Custom report generation</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon mx-auto">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Customer Support</h4>
                        <p>Provide exceptional customer service with integrated communication tools and dedicated support channels.</p>
                        <ul class="feature-list text-start">
                            <li><i class="fas fa-check"></i> Multi-channel communication</li>
                            <li><i class="fas fa-check"></i> Automated appointment scheduling</li>
                            <li><i class="fas fa-check"></i> Medication consultation tools</li>
                            <li><i class="fas fa-check"></i> 24/7 customer support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-5">How It Works</h2>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-line"></div>
                        <h4>Register Your Pharmacy</h4>
                        <p>Create your account and complete your pharmacy profile. Our onboarding team will guide you through the setup process and help you configure your digital storefront.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-line"></div>
                        <h4>Upload Your Inventory</h4>
                        <p>Use our intuitive dashboard to add your products, set pricing, and manage inventory levels. Our bulk upload tools make it easy to get started quickly.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-line"></div>
                        <h4>Configure Your Services</h4>
                        <p>Set up your delivery options, prescription services, and customer communication preferences. Customize your workflows to match your pharmacy's operations.</p>
                    </div>
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <div class="step-line"></div>
                        <h4>Go Live & Grow</h4>
                        <p>Launch your digital pharmacy and start serving customers online. Use our analytics and marketing tools to grow your business and reach more patients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">Simple, Transparent Pricing</h2>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="pricing-card text-center">
                        <h4>Starter</h4>
                        <p class="text-muted">Ideal for small pharmacies</p>
                        <div class="my-4">
                            <span class="price">$49</span>
                            <span class="price-period">/month</span>
                        </div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Basic online storefront</li>
                            <li><i class="fas fa-check"></i> Up to 500 products</li>
                            <li><i class="fas fa-check"></i> Inventory management</li>
                            <li><i class="fas fa-check"></i> Email support</li>
                            <li><i class="fas fa-times text-muted"></i> E-prescription services</li>
                            <li><i class="fas fa-times text-muted"></i> Advanced analytics</li>
                        </ul>
                        <a href="#" class="btn btn-outline-primary w-100 mt-3">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="pricing-card text-center popular">
                        <div class="popular-badge">Most Popular</div>
                        <h4>Professional</h4>
                        <p class="text-muted">Perfect for growing pharmacies</p>
                        <div class="my-4">
                            <span class="price">$99</span>
                            <span class="price-period">/month</span>
                        </div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Advanced online storefront</li>
                            <li><i class="fas fa-check"></i> Unlimited products</li>
                            <li><i class="fas fa-check"></i> Inventory management</li>
                            <li><i class="fas fa-check"></i> Priority support</li>
                            <li><i class="fas fa-check"></i> E-prescription services</li>
                            <li><i class="fas fa-check"></i> Basic analytics</li>
                        </ul>
                        <a href="#" class="btn btn-primary w-100 mt-3">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="pricing-card text-center">
                        <h4>Enterprise</h4>
                        <p class="text-muted">For large pharmacy chains</p>
                        <div class="my-4">
                            <span class="price">$199</span>
                            <span class="price-period">/month</span>
                        </div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Custom storefront</li>
                            <li><i class="fas fa-check"></i> Unlimited products</li>
                            <li><i class="fas fa-check"></i> Advanced inventory</li>
                            <li><i class="fas fa-check"></i> 24/7 dedicated support</li>
                            <li><i class="fas fa-check"></i> E-prescription services</li>
                            <li><i class="fas fa-check"></i> Advanced analytics & reporting</li>
                        </ul>
                        <a href="#" class="btn btn-outline-primary w-100 mt-3">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-5">What Our Partners Say</h2>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Sarah Johnson" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <p class="text-muted mb-0">Owner, HealthPlus Pharmacy</p>
                            </div>
                        </div>
                        <p class="mb-0">"PharmaPlatform transformed our pharmacy operations. Our online sales have increased by 40% since we started using their services. The inventory management system alone has saved us hours each week."</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Michael Chen" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Michael Chen</h5>
                                <p class="text-muted mb-0">Manager, MedLife Pharmacy</p>
                            </div>
                        </div>
                        <p class="mb-0">"The e-prescription service has been a game-changer for our pharmacy. We've reduced prescription errors and improved turnaround time. Our patients appreciate the convenience of digital refills."</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Emily Rodriguez" class="testimonial-avatar">
                            <div>
                                <h5 class="mb-0">Emily Rodriguez</h5>
                                <p class="text-muted mb-0">Pharmacist, CareFirst Pharmacy</p>
                            </div>
                        </div>
                        <p class="mb-0">"The analytics dashboard provides insights I never had before. I can now track which products are performing best and make data-driven decisions about our inventory. The customer support team is incredibly responsive."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">Frequently Asked Questions</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>How long does it take to set up my pharmacy on PharmaPlatform?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Most pharmacies can be fully set up and operational within 2-3 business days. The exact timeline depends on the size of your inventory and how quickly you can provide the necessary information. Our onboarding team will guide you through each step.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Is my patient data secure on your platform?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we take data security extremely seriously. Our platform uses end-to-end encryption, complies with HIPAA regulations, and undergoes regular security audits. We never share patient data with third parties without explicit consent.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Can I integrate with my existing pharmacy management system?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We offer integrations with most major pharmacy management systems. During onboarding, our technical team will assess your current system and implement the appropriate integration to ensure seamless data flow between platforms.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>What kind of support do you offer?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We provide comprehensive support through multiple channels including phone, email, and live chat. Our support team is available 24/7 for urgent issues, and we offer dedicated account managers for our Professional and Enterprise plan customers.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Can I customize the appearance of my online store?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Absolutely. Our platform offers extensive customization options including color schemes, logos, banner images, and layout options. For Enterprise customers, we can even create completely custom designs to match your brand identity.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold">Ready to Transform Your Pharmacy?</h2>
            <p class="mb-4 fs-5">Join thousands of pharmacies already using PharmaPlatform to streamline operations and grow their business.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-light btn-lg px-5 py-3 fw-semibold">
                    Start Your Free Trial <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>contact" class="btn btn-outline-light btn-lg px-5 py-3 fw-semibold">
                    Schedule a Demo <i class="fas fa-calendar ms-2"></i>
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
    <script>
        // FAQ toggle functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });
    </script>
</body>
</html>