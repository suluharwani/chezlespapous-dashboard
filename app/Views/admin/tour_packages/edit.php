<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Tour Package</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/tour-packages') ?>">Tour Packages</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    
    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Package Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/tour-packages/update/' . $package['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Package Name*</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name', $package['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration*</label>
                        <input type="text" class="form-control" id="duration" name="duration" 
                               value="<?= old('duration', $package['duration']) ?>" placeholder="e.g., 3 Days 2 Nights" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description', $package['description']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="price" class="form-label">Price (IDR)*</label>
                        <input type="number" class="form-control" id="price" name="price" 
                               value="<?= old('price', $package['price']) ?>" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="discount" class="form-label">Discount (IDR)</label>
                        <input type="number" class="form-control" id="discount" name="discount" 
                               value="<?= old('discount', $package['discount']) ?>" min="0">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?= old('is_featured', $package['is_featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Package
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="includes" class="form-label">What's Included*</label>
                    <textarea class="form-control" id="includes" name="includes" rows="2" required><?= old('includes', $package['includes']) ?></textarea>
                    <small class="text-muted">Separate items with commas</small>
                </div>

                <div class="mb-3">
                    <label for="itinerary" class="form-label">Itinerary*</label>
                    <textarea class="form-control" id="itinerary" name="itinerary" rows="4" required><?= old('itinerary', $package['itinerary']) ?></textarea>
                    <small class="text-muted">Describe daily activities in detail</small>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Package Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-muted">Leave empty to keep current image (Max 2MB, JPG/PNG)</small>
                    
                    <?php if ($package['image_url']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($package['image_url']) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Image</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Package</button>
                    <a href="<?= base_url('admin/tour-packages') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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