<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Resort</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/resorts') ?>">Resorts</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-hotel me-1"></i>
            Resort Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/resorts/update/' . $resort['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Resort Name*</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name', $resort['name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location*</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= old('location', $resort['location']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description', $resort['description']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="price_range" class="form-label">Price Range (IDR)*</label>
                        <input type="text" class="form-control" id="price_range" name="price_range" 
                               value="<?= old('price_range', $resort['price_range']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_phone" class="form-label">Contact Phone*</label>
                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                               value="<?= old('contact_phone', $resort['contact_phone']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="contact_email" class="form-label">Contact Email*</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" 
                               value="<?= old('contact_email', $resort['contact_email']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="facilities" class="form-label">Facilities*</label>
                    <textarea class="form-control" id="facilities" name="facilities" rows="2" required><?= old('facilities', $resort['facilities']) ?></textarea>
                    <small class="text-muted">Separate with commas (e.g., Pool, Spa, Restaurant)</small>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="website" name="website" 
                               value="<?= old('website', $resort['website']) ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?= old('is_featured', $resort['is_featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Resort
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Resort Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-muted">Leave empty to keep current image (Max 2MB, JPG/PNG)</small>
                    
                    <?php if ($resort['image_url']): ?>
                        <div class="mt-2">
                            <img src="<?= $resort['image_url'] ?>" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Image</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Resort</button>
                    <a href="<?= base_url('admin/resorts') ?>" class="btn btn-secondary">Cancel</a>
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