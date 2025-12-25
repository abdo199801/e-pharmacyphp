USE pharmacy_platform;

-- Clear existing data (optional - be careful in production)
-- DELETE FROM purchases;
-- DELETE FROM products;
-- DELETE FROM pages;
-- DELETE FROM dashboards;
-- DELETE FROM subscriptions;
-- DELETE FROM pharmacy_business_information;
-- DELETE FROM blogs;
-- DELETE FROM clients;
-- DELETE FROM categories;
-- DELETE FROM pack_abonnement;

-- Insert subscription packs
INSERT INTO pack_abonnement (id, name, description, price, duration_months, status) VALUES
(UUID(), 'Basic Plan', 'Essential features for small pharmacies', 49.99, 1, 'active'),
(UUID(), 'Professional Plan', 'Advanced features for growing pharmacies', 99.99, 1, 'active'),
(UUID(), 'Enterprise Plan', 'Complete solution for large pharmacies', 199.99, 1, 'active');

-- Insert categories
INSERT INTO categories (id, name, description) VALUES
(UUID(), 'Medicines', 'Prescription and over-the-counter medicines'),
(UUID(), 'Beauty Products', 'Cosmetics and skincare products'),
(UUID(), 'Baby Care', 'Products for baby care and hygiene'),
(UUID(), 'Vitamins & Supplements', 'Nutritional supplements and vitamins'),
(UUID(), 'Medical Devices', 'Home medical equipment and devices'),
(UUID(), 'Personal Care', 'Personal hygiene and care products');

-- Insert admin user (password: admin123)
INSERT INTO clients (id, firstname, lastname, email, password, role, phone, address) VALUES
(UUID(), 'Admin', 'User', 'admin@pharmacy.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMINISTRATORCLIENT', '+1234567890', '123 Admin Street, City, Country');

-- Insert pharmacy clients (password: password123)
INSERT INTO clients (id, firstname, lastname, email, password, role, phone, address) VALUES
(UUID(), 'John', 'Doe', 'pharmacy1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMINISTRATORCLIENT', '+1234567891', '456 Pharmacy Ave, New York, USA'),
(UUID(), 'Jane', 'Smith', 'pharmacy2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMINISTRATORCLIENT', '+1234567892', '789 Health St, Los Angeles, USA'),
(UUID(), 'Mike', 'Johnson', 'pharmacy3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMINISTRATORCLIENT', '+1234567893', '321 Wellness Blvd, Chicago, USA');

-- Get client IDs for reference
SET @client1_id = (SELECT id FROM clients WHERE email = 'pharmacy1@example.com');
SET @client2_id = (SELECT id FROM clients WHERE email = 'pharmacy2@example.com');
SET @client3_id = (SELECT id FROM clients WHERE email = 'pharmacy3@example.com');
SET @basic_pack_id = (SELECT id FROM pack_abonnement WHERE name = 'Basic Plan');
SET @pro_pack_id = (SELECT id FROM pack_abonnement WHERE name = 'Professional Plan');

-- Insert pharmacy business information
INSERT INTO pharmacy_business_information (id, pharmacy_name, address, city, country, license_number, phone, client_id, latitude, longitude) VALUES
(UUID(), 'City Pharmacy', '456 Pharmacy Ave', 'New York', 'USA', 'LIC123456', '+1234567891', @client1_id, 40.7128, -74.0060),
(UUID(), 'Health Plus Pharmacy', '789 Health St', 'Los Angeles', 'USA', 'LIC789012', '+1234567892', @client2_id, 34.0522, -118.2437),
(UUID(), 'Wellness Center', '321 Wellness Blvd', 'Chicago', 'USA', 'LIC345678', '+1234567893', @client3_id, 41.8781, -87.6298);

-- Insert subscriptions
INSERT INTO subscriptions (id, client_id, pack_id, start_date, end_date, status) VALUES
(UUID(), @client1_id, @basic_pack_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 'active'),
(UUID(), @client2_id, @pro_pack_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 'active'),
(UUID(), @client3_id, @basic_pack_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 'active');

-- Insert dashboards
INSERT INTO dashboards (id, name, description, pack_id, client_id) VALUES
(UUID(), 'City Pharmacy Dashboard', 'Dashboard for City Pharmacy', @basic_pack_id, @client1_id),
(UUID(), 'Health Plus Dashboard', 'Dashboard for Health Plus Pharmacy', @pro_pack_id, @client2_id),
(UUID(), 'Wellness Center Dashboard', 'Dashboard for Wellness Center', @basic_pack_id, @client3_id);

-- Get dashboard IDs
SET @dashboard1_id = (SELECT id FROM dashboards WHERE client_id = @client1_id);
SET @dashboard2_id = (SELECT id FROM dashboards WHERE client_id = @client2_id);
SET @dashboard3_id = (SELECT id FROM dashboards WHERE client_id = @client3_id);

-- Get category IDs
SET @medicines_id = (SELECT id FROM categories WHERE name = 'Medicines');
SET @beauty_id = (SELECT id FROM categories WHERE name = 'Beauty Products');
SET @vitamins_id = (SELECT id FROM categories WHERE name = 'Vitamins & Supplements');
SET @personal_care_id = (SELECT id FROM categories WHERE name = 'Personal Care');
SET @medical_devices_id = (SELECT id FROM categories WHERE name = 'Medical Devices');
SET @baby_care_id = (SELECT id FROM categories WHERE name = 'Baby Care');

-- Insert products for City Pharmacy
INSERT INTO products (id, name, price, description, category_id, dashboard_id, image_url, stock_quantity) VALUES
(UUID(), 'Paracetamol 500mg', 5.99, 'Pain reliever and fever reducer', @medicines_id, @dashboard1_id, 'https://via.placeholder.com/300x200/4CAF50/white?text=Paracetamol', 100),
(UUID(), 'Vitamin C 1000mg', 12.99, 'Immune system support', @vitamins_id, @dashboard1_id, 'https://via.placeholder.com/300x200/2196F3/white?text=Vitamin+C', 50),
(UUID(), 'Face Moisturizer', 8.99, 'Daily face moisturizer for all skin types', @beauty_id, @dashboard1_id, 'https://via.placeholder.com/300x200/E91E63/white?text=Moisturizer', 75);

-- Insert products for Health Plus Pharmacy
INSERT INTO products (id, name, price, description, category_id, dashboard_id, image_url, stock_quantity) VALUES
(UUID(), 'Blood Pressure Monitor', 49.99, 'Digital blood pressure monitor', @medical_devices_id, @dashboard2_id, 'https://via.placeholder.com/300x200/FF9800/white?text=BP+Monitor', 25),
(UUID(), 'Baby Diapers Size 3', 19.99, 'Ultra-absorbent baby diapers', @baby_care_id, @dashboard2_id, 'https://via.placeholder.com/300x200/9C27B0/white?text=Diapers', 60),
(UUID(), 'Hand Sanitizer 500ml', 4.99, 'Alcohol-based hand sanitizer', @personal_care_id, @dashboard2_id, 'https://via.placeholder.com/300x200/795548/white?text=Sanitizer', 120),
(UUID(), 'Multivitamin Complex', 24.99, 'Complete daily multivitamin', @vitamins_id, @dashboard2_id, 'https://via.placeholder.com/300x200/607D8B/white?text=Multivitamin', 40);

-- Insert products for Wellness Center
INSERT INTO products (id, name, price, description, category_id, dashboard_id, image_url, stock_quantity) VALUES
(UUID(), 'Ibuprofen 200mg', 6.99, 'Anti-inflammatory pain reliever', @medicines_id, @dashboard3_id, 'https://via.placeholder.com/300x200/F44336/white?text=Ibuprofen', 80),
(UUID(), 'Vitamin D3 5000IU', 15.99, 'High potency vitamin D3', @vitamins_id, @dashboard3_id, 'https://via.placeholder.com/300x200/FFC107/white?text=Vitamin+D3', 35),
(UUID(), 'Shampoo for Dry Hair', 7.99, 'Moisturizing shampoo for dry hair', @personal_care_id, @dashboard3_id, 'https://via.placeholder.com/300x200/8BC34A/white?text=Shampoo', 90);

-- Insert pages
INSERT INTO pages (id, title, content, dashboard_id, page_type) VALUES
(UUID(), 'Welcome to City Pharmacy', '<h2>About Our Pharmacy</h2><p>We have been serving the community for over 20 years with quality healthcare products and services.</p>', @dashboard1_id, 'about'),
(UUID(), 'Our Services', '<h2>Pharmacy Services</h2><ul><li>Prescription filling</li><li>Health consultations</li><li>Home delivery</li></ul>', @dashboard1_id, 'services'),
(UUID(), 'Health Plus Services', '<h2>Comprehensive Healthcare</h2><p>We offer a wide range of healthcare services and products.</p>', @dashboard2_id, 'services');

-- Insert blogs
INSERT INTO blogs (id, title, content, client_id, status, image_url) VALUES
(UUID(), 'The Importance of Vitamin D', '<h2>Why Vitamin D Matters</h2><p>Vitamin D is essential for bone health and immune function. Learn how to maintain adequate levels...</p>', @client1_id, 'published', 'https://via.placeholder.com/600x300/4CAF50/white?text=Vitamin+D'),
(UUID(), 'Cold and Flu Season Tips', '<h2>Staying Healthy During Flu Season</h2><p>Practical tips to protect yourself and your family during cold and flu season...</p>', @client2_id, 'published', 'https://via.placeholder.com/600x300/2196F3/white?text=Flu+Season'),
(UUID(), 'Skin Care Routine for Winter', '<h2>Winter Skin Care</h2><p>Keep your skin healthy and moisturized during the cold winter months with these tips...</p>', @client3_id, 'published', 'https://via.placeholder.com/600x300/E91E63/white?text=Skin+Care');

-- Insert sample purchases
INSERT INTO purchases (id, client_id, product_id, quantity, total) VALUES
(UUID(), @client1_id, (SELECT id FROM products WHERE name = 'Vitamin C 1000mg' LIMIT 1), 2, 25.98),
(UUID(), @client2_id, (SELECT id FROM products WHERE name = 'Blood Pressure Monitor' LIMIT 1), 1, 49.99),
(UUID(), @client3_id, (SELECT id FROM products WHERE name = 'Ibuprofen 200mg' LIMIT 1), 3, 20.97);

SELECT 'Sample data inserted successfully!' as message;