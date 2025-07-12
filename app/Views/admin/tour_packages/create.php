<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Tour Package</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/tour-packages') ?>">Tour Packages</a></li>
        <li class="breadcrumb-item active">New</li>
    </ol>
    
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= session('error') ?>
        <?php if (config('CI_ENVIRONMENT') !== 'production' && session()->has('debug_error')): ?>
            <div class="mt-2 p-2 bg-light">
                <small>Debug info: <?= session('debug_error') ?></small>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Package Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/tour-packages/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Package Name*</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration*</label>
                        <input type="text" class="form-control" id="duration" name="duration" 
                               value="<?= old('duration') ?>" placeholder="e.g., 3 Days 2 Nights" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description') ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="price" class="form-label">Price (IDR)*</label>
                        <input type="number" class="form-control" id="price" name="price" 
                               value="<?= old('price') ?>" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="discount" class="form-label">Discount (IDR)</label>
                        <input type="number" class="form-control" id="discount" name="discount" 
                               value="<?= old('discount') ?>" min="0">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Package
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="includes" class="form-label">What's Included*</label>
                    <textarea class="form-control" id="includes" name="includes" rows="2" required><?= old('includes') ?></textarea>
                    <small class="text-muted">Separate items with commas (e.g., Hotel, Meals, Transport)</small>
                </div>

                <div class="mb-3">
                    <label for="itinerary" class="form-label">Itinerary*</label>
                    <textarea class="form-control" id="itinerary" name="itinerary" rows="4" required><?= old('itinerary') ?></textarea>
                    <small class="text-muted">Describe daily activities in detail</small>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Package Image*</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <small class="text-muted">Max size 2MB (JPG, PNG, JPEG)</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Package</button>
                    <a href="<?= base_url('admin/tour-packages') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.createElement('div');
            preview.className = 'mt-2';
            preview.innerHTML = `
                <img src="${event.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                <p class="text-muted mt-1">Image Preview</p>
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