<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Slider</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/sliders') ?>">Sliders</a></li>
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
            Edit Slider Content
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/sliders/update/' . $slider['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= old('title', $slider['title']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="display_order" class="form-label">Display Order*</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="<?= old('display_order', $slider['display_order']) ?>" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" 
                           value="<?= old('subtitle', $slider['subtitle']) ?>">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="button_text" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" 
                               value="<?= old('button_text', $slider['button_text']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="button_link" class="form-label">Button Link</label>
                        <input type="url" class="form-control" id="button_link" name="button_link" 
                               value="<?= old('button_link', $slider['button_link']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                               <?= old('is_active', $slider['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">
                            Active Slider
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Slider Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-muted">Leave empty to keep current image (Recommended size: 1920x1080px, Max size 2MB)</small>
                    
                    <?php if ($slider['image_url']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($slider['image_url']) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Image</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Slider</button>
                    <a href="<?= base_url('admin/sliders') ?>" class="btn btn-secondary">Cancel</a>
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