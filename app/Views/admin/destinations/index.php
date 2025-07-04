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
                    <i class="fas fa-table me-1"></i>
                    <?= $title ?>
                </div>
                <div>
                    <a href="<?= base_url('admin/destinations/new') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="destinationsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($destinations as $index => $destination): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <img src="<?= $destination['image_url'] ?>" alt="<?= $destination['name'] ?>" 
                                 class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                        </td>
                        <td><?= $destination['name'] ?></td>
                        <td><?= $destination['location'] ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $destination['category'] == 'diving' ? 'primary' : 
                                ($destination['category'] == 'beach' ? 'info' : 
                                ($destination['category'] == 'island' ? 'success' : 
                                ($destination['category'] == 'viewpoint' ? 'warning' : 'secondary')))
                            ?>">
                                <?= ucfirst($destination['category']) ?>
                            </span>
                        </td>
                        <td><?= $destination['price_range'] ? 'Rp' . number_format($destination['price_range'], 2) : 'Free' ?></td>
                        <td>
                            <a href="<?= base_url('admin/destinations/edit/' . $destination['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                             <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="<?= $destination['id'] ?>"
                                data-name="<?= esc($destination['name']) ?>">
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the destination: <strong id="destinationName"></strong>?</p>
                <p class="text-danger"><strong>This action cannot be undone!</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete Destination</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

    window.confirmDelete = function(id, type) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/${type}/delete/${id}`;
            }
        });
    };

    
    // Delete button click handler
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        // Set modal content
        $('#destinationName').text(name);
        $('#confirmDelete').attr('href', '<?= base_url('admin/destinations/delete/') ?>' + id);
        
        // Show modal
        $('#deleteModal').modal('show');
    });
});

</script>
<?= $this->endSection() ?>