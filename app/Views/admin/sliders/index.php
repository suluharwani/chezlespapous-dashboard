<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Sliders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Homepage Sliders</li>
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
                    <i class="fas fa-sliders-h me-1"></i>
                    All Sliders
                </div>
                <div>
                    <a href="<?= base_url('admin/sliders/new') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="slidersTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php foreach ($sliders as $slider): ?>
                        <tr data-id="<?= $slider['id'] ?>">
                            <td class="sortable-handle text-center" style="cursor: move;">
                                <i class="fas fa-arrows-alt"></i>
                            </td>
                            <td>
                                <img src="<?= $slider['image_url'] ?>" alt="<?= esc($slider['title']) ?>" 
                                     class="img-thumbnail" style="width: 150px; height: 80px; object-fit: cover;">
                            </td>
                            <td><?= esc($slider['title']) ?></td>
                            <td><?= esc($slider['subtitle']) ?></td>
                            <td>
                                <?php if ($slider['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/sliders/edit/' . $slider['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-btn" 
                                    data-id="<?= $slider['id'] ?>"
                                    data-name="<?= esc($slider['title']) ?>">
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
                <p>Are you sure you want to delete the slider: <strong id="sliderName"></strong>?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    // $('#slidersTable').DataTable({
    //     columnDefs: [
    //         { orderable: false, targets: [0, 1, 5] }
    //     ]
    // });
    
    // Delete button click handler
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        // Set modal content
        $('#sliderName').text(name);
        $('#confirmDelete').attr('href', '<?= base_url('admin/sliders/delete/') ?>' + id);
        
        // Show modal
        $('#deleteModal').modal('show');
    });

    // Initialize sortable
    const sortable = new Sortable(document.getElementById('sortable'), {
        handle: '.sortable-handle',
        animation: 150,
        onEnd: function() {
            const order = [];
            $('#sortable tr').each(function() {
                order.push($(this).data('id'));
            });
            
            $.ajax({
                url: '<?= base_url('admin/sliders/update-order') ?>',
                type: 'POST',
                data: { order: order },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Slider order updated successfully');
                    }
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.sortable-handle {
    cursor: move;
}
.sortable-ghost {
    background-color: #f8f9fa;
}
</style>
<?= $this->endSection() ?>