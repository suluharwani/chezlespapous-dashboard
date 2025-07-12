<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Local Guide</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/local-guides') ?>">Local Guides</a></li>
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
            <i class="fas fa-user-edit me-1"></i>
            Edit Guide Information
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/local-guides/update/' . $guide['id']) ?>" method="post" enctype="multipart/form-data">
                <div class="row mb-3"> 
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name*</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= old('full_name', $guide['full_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', $guide['email']) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone*</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?= old('phone', $guide['phone']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="years_experience" class="form-label">Years of Experience*</label>
                        <input type="number" class="form-control" id="years_experience" name="years_experience" 
                               value="<?= old('years_experience', $guide['years_experience']) ?>" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address*</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required><?= old('address', $guide['address']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="experience" class="form-label">Experience Details*</label>
                    <textarea class="form-control" id="experience" name="experience" rows="3" required><?= old('experience', $guide['experience']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="languages" class="form-label">Languages Spoken*</label>
                        <input type="text" class="form-control" id="languages" name="languages" 
                               value="<?= old('languages', $guide['languages']) ?>" required>
                        <small class="text-muted">Separate with commas (e.g., English, Indonesian, Japanese)</small>
                    </div>
                    <div class="col-md-6">
                        <label for="price_per_day" class="form-label">Price Per Day (IDR)*</label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" 
                               value="<?= old('price_per_day', $guide['price_per_day']) ?>" min="0" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="specialization" class="form-label">Specialization*</label>
                        <select class="form-select" id="specialization" name="specialization" required>
                            <option value="">Select Specialization</option>
                            <?php foreach ($specializations as $spec): ?>
                                <option value="<?= $spec ?>" <?= old('specialization', $guide['specialization']) == $spec ? 'selected' : '' ?>>
                                    <?= ucfirst($spec) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <input type="number" class="form-control" id="rating" name="rating" 
                               value="<?= old('rating', $guide['rating'] ?? 5) ?>" min="1" max="5" step="0.1">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" value="1" 
                               <?= old('is_verified', $guide['is_verified']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_verified">
                            Verified Guide
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Guide Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <small class="text-muted">Leave empty to keep current photo (Max 2MB, JPG/PNG)</small>
                    
                    <?php if ($guide['photo_url']): ?>
                        <div class="mt-2">
                            <img src="<?= $guide['photo_url'] ?>" alt="Current Photo" class="img-thumbnail" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Photo</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Guide</button>
                    <a href="<?= base_url('admin/local-guides') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.createElement('div');
            preview.className = 'mt-2';
            preview.innerHTML = `
                <img src="${event.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                <p class="text-muted mt-1">New Photo Preview</p>
            `;
            
            const existingPreview = document.querySelector('#photo ~ div');
            if (existingPreview) {
                existingPreview.replaceWith(preview);
            } else {
                document.getElementById('photo').after(preview);
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?= $this->endSection() ?>