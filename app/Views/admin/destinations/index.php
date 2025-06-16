<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Destinations</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/destinations/new') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Add New Destination
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Location</th>
                <th>Category</th>
                <th>Price Range</th>
                <th>Best Season</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($destinations as $index => $destination): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td>
                    <img src="<?= base_url('assets/admin/uploads/destinations/' . $destination['image_url']) ?>" alt="<?= $destination['name'] ?>" class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                </td>
                <td><?= $destination['name'] ?></td>
                <td><?= $destination['location'] ?></td>
                <td><?= ucfirst($destination['category']) ?></td>
                <td><?= $destination['price_range'] ? 'Rp' . number_format($destination['price_range'], 2) : '-' ?></td>
                <td><?= $destination['best_season'] ?: '-' ?></td>
                <td>
                    <a href="<?= base_url('admin/destinations/' . $destination['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $destination['id'] ?>)">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('admin/destinations') ?>/" + id + "/delete";
        }
    });
}
</script>
<?= $this->endSection() ?>