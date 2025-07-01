<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-water me-1"></i>
                    <?= $title ?>
                </div>
                <div>
                    <a href="<?= base_url('admin/dive-spots/new') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="diveSpotsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Depth Range</th>
                        <th>Current</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diveSpots as $index => $spot): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <img src="<?= $spot['image_url'] ?>" alt="<?= $spot['name'] ?>" 
                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                        </td>
                        <td><?= $spot['name'] ?></td>
                        <td><?= $spot['location'] ?></td>
                        <td><?= $spot['depth_range'] ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $spot['current_level'] == 'low' ? 'success' : 
                                ($spot['current_level'] == 'medium' ? 'warning' : 'danger')
                            ?>">
                                <?= ucfirst($spot['current_level']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/dive-spots/edit/' . $spot['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="<?= $spot['id'] ?>"
                                data-name="<?= esc($spot['name']) ?>">
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the dive spot: <strong id="diveSpotName"></strong>?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete Dive Spot</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#diveSpotsTable').DataTable();
    
    // Delete button click handler
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        // Set modal content
        $('#diveSpotName').text(name);
        $('#confirmDelete').attr('href', '<?= base_url('admin/dive-spots/delete/') ?>' + id);
        
        // Show modal
        $('#deleteModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>