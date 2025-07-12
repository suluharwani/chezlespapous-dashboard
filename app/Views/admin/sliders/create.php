<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Slider</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/sliders') ?>">Sliders</a></li>
        <li class="breadcrumb-item active">New</li>
    </ol>
    
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> <?= session('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Slider Content
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/sliders/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= old('title') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="display_order" class="form-label">Display Order*</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="<?= old('display_order', $next_display_order) ?>" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" 
                           value="<?= old('subtitle') ?>">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="button_text" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" 
                               value="<?= old('button_text') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="button_link" class="form-label">Button Link</label>
                        <input type="url" class="form-control" id="button_link" name="button_link" 
                               value="<?= old('button_link') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               <?= old('is_active') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">
                            Active Slider
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Slider Image*</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <small class="text-muted">Recommended size: 1920x1080px, Max size 2MB (JPG, PNG)</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Slider</button>
                    <a href="<?= base_url('admin/sliders') ?>" class="btn btn-secondary">Cancel</a>
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