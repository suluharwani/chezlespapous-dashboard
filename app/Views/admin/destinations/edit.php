<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Destination</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/destinations') ?>">Destinations</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Destination
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/destinations/update/' . $destination['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name', $destination['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location*</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= old('location', $destination['location']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description', $destination['description']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Category*</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="diving" <?= old('category', $destination['category']) == 'diving' ? 'selected' : '' ?>>Diving</option>
                            <option value="beach" <?= old('category', $destination['category']) == 'beach' ? 'selected' : '' ?>>Beach</option>
                            <option value="island" <?= old('category', $destination['category']) == 'island' ? 'selected' : '' ?>>Island</option>
                            <option value="viewpoint" <?= old('category', $destination['category']) == 'viewpoint' ? 'selected' : '' ?>>Viewpoint</option>
                            <option value="cultural" <?= old('category', $destination['category']) == 'cultural' ? 'selected' : '' ?>>Cultural</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="price_range" class="form-label">Price Range (IDR)</label>
                        <input type="number" class="form-control" id="price_range" name="price_range" 
                               value="<?= old('price_range', $destination['price_range']) ?>" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label for="best_season" class="form-label">Best Season</label>
                        <input type="text" class="form-control" id="best_season" name="best_season" 
                               value="<?= old('best_season', $destination['best_season']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-muted">Leave empty to keep current image (Max 2MB, JPG/PNG)</small>
                    
                    <?php if ($destination['image_url']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($destination['image_url']) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Image</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Destination</button>
                    <a href="<?= base_url('admin/destinations') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.createElement('div');
            preview.className = 'mt-2';
            preview.innerHTML = `
                <img src="${event.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                <p class="text-muted mt-1">New Image Preview</p>
            `;
            
            const existingPreview = document.querySelector('#image ~ div');
            if (existingPreview) {
                existingPreview.replaceWith(preview);
            } else {
                document.getElementById('image').after(preview);
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?= $this->endSection() ?>