<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Gallery Item</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/galleries') ?>">Gallery</a></li>
        <li class="breadcrumb-item active">New</li>
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
            <i class="fas fa-plus me-1"></i>
            Gallery Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/galleries/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title*</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?= old('title') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2"><?= old('description') ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category*</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat ?>" <?= old('category') == $cat ? 'selected' : '' ?>>
                                    <?= ucfirst($cat) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= old('location') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" 
                               value="<?= old('display_order') ?>" min="0">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Item
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image*</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                    <small class="text-muted">Max size 2MB (JPG, PNG, JPEG)</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Item</button>
                    <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">Cancel</a>
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