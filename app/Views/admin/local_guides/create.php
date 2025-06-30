<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/local-guides') ?>">Local Guides</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            Guide Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/local-guides/create') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= old('full_name') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="<?= old('phone') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="specialization" class="form-label">Specialization</label>
                        <select class="form-select" id="specialization" name="specialization" required>
                            <option value="">Select Specialization</option>
                            <?php foreach ($specializations as $spec): ?>
                                <option value="<?= $spec ?>" <?= old('specialization') == $spec ? 'selected' : '' ?>>
                                    <?= ucfirst($spec) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required><?= old('address') ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="languages" class="form-label">Languages (comma separated)</label>
                        <input type="text" class="form-control" id="languages" name="languages" 
                               value="<?= old('languages') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="price_per_day" class="form-label">Price Per Day (IDR)</label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" 
                               value="<?= old('price_per_day') ?>" step="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <label for="years_experience" class="form-label">Years Experience</label>
                        <input type="number" class="form-control" id="years_experience" name="years_experience" 
                               value="<?= old('years_experience', 1) ?>" min="1" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="experience" class="form-label">Experience Description</label>
                    <textarea class="form-control" id="experience" name="experience" rows="3" required><?= old('experience') ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" required>
                        <div class="mt-2">
                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-5)</label>
                            <input type="number" class="form-control" id="rating" name="rating" 
                                   value="<?= old('rating', 5.0) ?>" min="1" max="5" step="0.1">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" value="1">
                            <label class="form-check-label" for="is_verified">Verified Guide</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Guide</button>
                    <a href="<?= base_url('admin/local-guides') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('imagePreview').src = event.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?= $this->endSection() ?>