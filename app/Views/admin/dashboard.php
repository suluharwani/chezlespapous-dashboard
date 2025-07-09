<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Overview</li>
    </ol>
    
    <!-- Quick Stats Row -->
    <div class="row">
        <!-- Destinations Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Destinations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $destinationCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/destinations') ?>" class="btn btn-sm btn-primary me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/destinations/new') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dive Spots Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Dive Spots
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $diveSpotCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-water fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/dive-spots') ?>" class="btn btn-sm btn-info me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/dive-spots/new') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Local Guides Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Local Guides
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $guideCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/local-guides') ?>" class="btn btn-sm btn-success me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/local-guides/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resorts Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Resorts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $resortCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/resorts') ?>" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/resorts/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Second Row of Stats -->
    <div class="row">
        <!-- Tour Packages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-danger border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tour Packages
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $packageCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-suitcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/tour-packages') ?>" class="btn btn-sm btn-danger me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/tour-packages/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Galleries Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-secondary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Gallery Items
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $galleryCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/galleries') ?>" class="btn btn-sm btn-secondary me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/galleries/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Testimonials Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-dark border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Testimonials
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $testimonialCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-sm btn-dark me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/testimonials/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sliders Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Sliders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sliderCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sliders-h fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('admin/sliders') ?>" class="btn btn-sm btn-info me-1">
                            <i class="fas fa-list"></i> View All
                        </a>
                        <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Items Section -->
    <div class="row">
        <!-- Recent Destinations -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Destinations</h6>
                    <a href="<?= base_url('admin/destinations') ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recentDestinations as $destination): ?>
                        <a href="<?= base_url('admin/destinations/edit/' . $destination['id']) ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= $destination['name'] ?></h6>
                                <small><?= time_ago($destination['created_at']) ?></small>
                            </div>
                            <p class="mb-1"><?= character_limiter($destination['description'], 50) ?></p>
                            <small class="text-muted"><?= $destination['location'] ?></small>
                        </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Guides -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Recent Local Guides</h6>
                    <a href="<?= base_url('admin/local-guides') ?>" class="btn btn-sm btn-success">View All</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recentGuides as $guide): ?>
                        <a href="<?= base_url('admin/local-guides/edit/' . $guide['id']) ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= $guide['full_name'] ?></h6>
                                <small><?= time_ago($guide['created_at']) ?></small>
                            </div>
                            <p class="mb-1">Specialization: <?= ucfirst($guide['specialization']) ?></p>
                            <small class="text-muted"><?= $guide['languages'] ?></small>
                        </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Packages -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">Recent Tour Packages</h6>
                    <a href="<?= base_url('admin/tour-packages') ?>" class="btn btn-sm btn-danger">View All</a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recentPackages as $package): ?>
                        <a href="<?= base_url('admin/tour-packages/edit/' . $package['id']) ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= $package['name'] ?></h6>
                                <small><?= time_ago($package['created_at']) ?></small>
                            </div>
                            <p class="mb-1">Duration: <?= $package['duration'] ?></p>
                            <small class="text-muted">Price: Rp<?= number_format($package['price'], 2) ?></small>
                        </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Dashboard -->
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .border-start {
        border-left-width: 4px !important;
    }
    .list-group-item {
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection() ?>