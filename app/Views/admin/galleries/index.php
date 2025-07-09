<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Gallery</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Gallery Items</li>
    </ol>
    
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-images me-1"></i>
                    All Gallery Items
                </div>
                <div>
                    <a href="<?= base_url('admin/galleries/new') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($galleries as $gallery): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url($gallery['image_url']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= esc($gallery['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($gallery['title']) ?></h5>
                            <p class="card-text text-muted">
                                <span class="badge bg-<?= 
                                    $gallery['category'] == 'nature' ? 'success' : 
                                    ($gallery['category'] == 'diving' ? 'info' : 
                                    ($gallery['category'] == 'culture' ? 'warning' : 'primary'))
                                ?>">
                                    <?= ucfirst($gallery['category']) ?>
                                </span>
                                <?php if ($gallery['is_featured']): ?>
                                    <span class="badge bg-danger ms-1">Featured</span>
                                <?php endif ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/galleries/edit/' . $gallery['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger delete-btn" 
                                    data-id="<?= $gallery['id'] ?>"
                                    data-name="<?= esc($gallery['title']) ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the gallery item: <strong id="galleryName"></strong>?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete Item</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Delete button click handler
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        // Set modal content
        $('#galleryName').text(name);
        $('#confirmDelete').attr('href', '<?= base_url('admin/galleries/delete/') ?>' + id);
        
        // Show modal
        $('#deleteModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>