<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dive-spots') ?>">Dive Spots</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-<?= isset($diveSpot) ? 'edit' : 'plus' ?> me-1"></i>
            Dive Spot Form
        </div>
        <div class="card-body">
            <form action="<?= isset($diveSpot) ? base_url('admin/dive-spots/update/' . $diveSpot['id']) : base_url('admin/dive-spots/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name', $diveSpot['name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location*</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= old('location', $diveSpot['location'] ?? '') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description', $diveSpot['description'] ?? '') ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="depth_range" class="form-label">Depth Range*</label>
                        <input type="text" class="form-control" id="depth_range" name="depth_range" 
                               value="<?= old('depth_range', $diveSpot['depth_range'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="current_level" class="form-label">Current Level*</label>
                        <select class="form-select" id="current_level" name="current_level" required>
                            <option value="">Select Level</option>
                            <option value="low" <?= old('current_level', $diveSpot['current_level'] ?? '') == 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="medium" <?= old('current_level', $diveSpot['current_level'] ?? '') == 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="high" <?= old('current_level', $diveSpot['current_level'] ?? '') == 'high' ? 'selected' : '' ?>>High</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="best_time" class="form-label">Best Time to Dive</label>
                        <input type="text" class="form-control" id="best_time" name="best_time" 
                               value="<?= old('best_time', $diveSpot['best_time'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="marine_life" class="form-label">Marine Life</label>
                    <textarea class="form-control" id="marine_life" name="marine_life" rows="2"><?= old('marine_life', $diveSpot['marine_life'] ?? '') ?></textarea>
                    <small class="text-muted">Separate with commas (e.g., turtles, clownfish, coral)</small>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image<?= !isset($diveSpot) ? '*' : '' ?></label>
                    <input type="file" class="form-control" id="image" name="image" <?= !isset($diveSpot) ? 'required' : '' ?>>
                    <small class="text-muted">Max size 2MB (JPEG, PNG, JPG)</small>
                    
                    <?php if (isset($diveSpot) && $diveSpot['image_url']): ?>
                        <div class="mt-2">
                            <img src="<?= $diveSpot['image_url'] ?>" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Image</p>
                        </div>
                    <?php endif ?>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="<?= base_url('admin/dive-spots') ?>" class="btn btn-secondary">Cancel</a>
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