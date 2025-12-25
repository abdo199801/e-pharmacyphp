<?php include dirname(__DIR__) . '/partials/header.php'; ?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="section-title">Our Partner Pharmacies</h1>
            <p class="section-subtitle">Find trusted pharmacies in your area with verified products and services</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search pharmacies by name, location, or services..." id="pharmacySearch">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="cityFilter">
                <option value="">All Cities</option>
                <?php 
                $cities = array_unique(array_column($pharmacies ?? [], 'city'));
                foreach ($cities as $city): 
                    if (!empty($city)):
                ?>
                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                <?php 
                    endif;
                endforeach; 
                ?>
            </select>
        </div>
    </div>

    <!-- Pharmacies Grid -->
    <div class="row" id="pharmacyContainer">
        <?php if (!empty($pharmacies)): ?>
            <?php foreach ($pharmacies as $pharmacy): ?>
            <div class="col-lg-4 col-md-6 mb-4 pharmacy-item">
                <div class="card pharmacy-card h-100 animate-on-scroll">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="pharmacy-icon me-3">
                                <i class="fas fa-clinic-medical"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fw-semibold"><?php echo htmlspecialchars($pharmacy['pharmacy_name'] ?? 'Pharmacy'); ?></h5>
                                <?php if (isset($pharmacy['is_verified']) && $pharmacy['is_verified']): ?>
                                    <span class="badge bg-success mt-1">
                                        <i class="fas fa-check-circle me-1"></i>Verified
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="pharmacy-info text-muted mb-3">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i> 
                                <?php echo htmlspecialchars($pharmacy['address'] ?? 'Address not available'); ?>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i> 
                                <?php echo htmlspecialchars($pharmacy['phone'] ?? 'Phone not available'); ?>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-city text-info me-2"></i> 
                                <?php echo htmlspecialchars($pharmacy['city'] ?? ''); ?>, <?php echo htmlspecialchars($pharmacy['country'] ?? ''); ?>
                            </p>
                            <?php if (isset($pharmacy['email'])): ?>
                                <p class="mb-2">
                                    <i class="fas fa-envelope text-warning me-2"></i> 
                                    <?php echo htmlspecialchars($pharmacy['email']); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($pharmacy['services'])): ?>
                            <div class="pharmacy-services mb-3">
                                <h6 class="fw-semibold mb-2">Services:</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php 
                                    $services = is_array($pharmacy['services']) ? $pharmacy['services'] : explode(',', $pharmacy['services']);
                                    foreach (array_slice($services, 0, 3) as $service): 
                                    ?>
                                        <span class="badge bg-light text-dark border"><?php echo trim($service); ?></span>
                                    <?php endforeach; ?>
                                    <?php if (count($services) > 3): ?>
                                        <span class="badge bg-light text-dark border">+<?php echo count($services) - 3; ?> more</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="pharmacy-stats d-flex justify-content-between text-center">
                            <div>
                                <small class="text-muted d-block">Products</small>
                                <strong class="text-primary"><?php echo $pharmacy['product_count'] ?? '0'; ?></strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Rating</small>
                                <strong class="text-warning">
                                    <?php if (isset($pharmacy['rating'])): ?>
                                        <?php echo number_format($pharmacy['rating'], 1); ?> <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Hours</small>
                                <strong class="text-success">24/7</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL; ?>home/pharmacy/<?php echo $pharmacy['id']; ?>" class="btn btn-sm btn-outline-primary flex-fill">
                                View Details
                            </a>
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Get Directions">
                                <i class="fas fa-directions"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-clinic-medical fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Pharmacies Available</h4>
                    <p class="text-muted mb-4">We're working on adding partner pharmacies in your area.</p>
                    <?php if (!isset($_SESSION['logged_in'])): ?>
                        <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-primary">
                            Register Your Pharmacy
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marked-alt me-2"></i>Pharmacy Locations Map
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="pharmacyMap" style="height: 400px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center text-muted">
                            <i class="fas fa-map fa-3x mb-3"></i>
                            <p>Interactive map coming soon</p>
                            <small>We're working on integrating live location services</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('pharmacySearch');
    const cityFilter = document.getElementById('cityFilter');
    const pharmacyItems = document.querySelectorAll('.pharmacy-item');

    function filterPharmacies() {
        const searchTerm = searchInput.value.toLowerCase();
        const cityValue = cityFilter.value.toLowerCase();

        pharmacyItems.forEach(item => {
            const pharmacyName = item.querySelector('.card-title').textContent.toLowerCase();
            const pharmacyAddress = item.querySelector('.pharmacy-info').textContent.toLowerCase();
            const pharmacyCity = item.querySelector('.fa-city').parentElement.textContent.toLowerCase();
            
            const matchesSearch = pharmacyName.includes(searchTerm) || pharmacyAddress.includes(searchTerm);
            const matchesCity = cityValue === '' || pharmacyCity.includes(cityValue);
            
            item.style.display = (matchesSearch && matchesCity) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterPharmacies);
    cityFilter.addEventListener('change', filterPharmacies);

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include dirname(__DIR__) . '/partials/footer.php'; ?>