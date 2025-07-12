<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <i class="fas fa-users me-1"></i>
                    <?= $title ?>
                </div>
                <div>
                    <a href="<?= base_url('admin/local-guides/new') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Languages</th>
                        <th>Price/Day</th>
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guides as $guide): ?>
                    <tr>
                        <td><?= $guide['id'] ?></td>
                        <td>
                            <img src="<?= $guide['photo_url'] ?>" alt="<?= $guide['full_name'] ?>" 
                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td><?= $guide['full_name'] ?></td>
                        <td><?= ucfirst($guide['specialization']) ?></td>
                        <td><?= $guide['languages'] ?></td>
                        <td>Rp<?= number_format($guide['price_per_day'], 2) ?></td>
                        <td>
                            <?php if ($guide['is_verified']): ?>
                                <span class="badge bg-success">Verified</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/local-guides/edit/' . $guide['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $guide['id'] ?>, 'local-guides')" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>