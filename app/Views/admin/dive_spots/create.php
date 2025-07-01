<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Dive Spot</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dive-spots') ?>">Dive Spots</a></li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif ?>
    
    <?= $this->include('admin/dive_spots/form') ?>
</div>
<?= $this->endSection() ?>