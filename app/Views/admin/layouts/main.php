<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - Raja Ampat Tourism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/style.css') ?>">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark text-white">
            <div class="sidebar-header p-3 text-center">
                <h4>Raja Ampat Tourism</h4>
                <p class="mb-0">Admin Dashboard</p>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="<?= base_url('admin/dashboard') ?>" class="text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#destinationsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white"><i class="bi bi-map me-2"></i> Destinations</a>
                    <ul class="collapse list-unstyled" id="destinationsSubmenu">
                        <li>
                            <a href="<?= base_url('admin/destinations') ?>" class="text-white">All Destinations</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/destinations/new') ?>" class="text-white">Add New</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#diveSpotsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white"><i class="bi bi-water me-2"></i> Dive Spots</a>
                    <ul class="collapse list-unstyled" id="diveSpotsSubmenu">
                        <li>
                            <a href="<?= base_url('admin/dive-spots') ?>" class="text-white">All Dive Spots</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/dive-spots/new') ?>" class="text-white">Add New</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('admin/galleries') ?>" class="text-white"><i class="bi bi-images me-2"></i> Galleries</a>
                </li>
                <li>
                    <a href="<?= base_url('admin/guides') ?>" class="text-white"><i class="bi bi-people me-2"></i> Guides</a>
                </li>
                <li>
                    <a href="<?= base_url('admin/resorts') ?>" class="text-white"><i class="bi bi-building me-2"></i> Resorts</a>
                </li>
                <li>
                    <a href="<?= base_url('admin/sliders') ?>" class="text-white"><i class="bi bi-sliders me-2"></i> Sliders</a>
                </li>
                <li>
                    <a href="<?= base_url('admin/testimonials') ?>" class="text-white"><i class="bi bi-chat-square-quote me-2"></i> Testimonials</a>
                </li>
                <li>
                    <a href="<?= base_url('admin/tour-packages') ?>" class="text-white"><i class="bi bi-briefcase me-2"></i> Tour Packages</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="ms-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= base_url('assets/admin/img/' . (session('admin_profile_picture') ?: 'default-profile.jpg')) ?>" class="rounded-circle me-1" width="30" height="30">
                                    <?= session('admin_full_name') ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/admin/js/main.js') ?>"></script>
    
    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>
</html>