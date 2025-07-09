<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Testimonial</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/testimonials') ?>">Testimonials</a></li>
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
            Edit Testimonial Details
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/testimonials/update/' . $testimonial['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="visitor_name" class="form-label">Visitor Name*</label>
                        <input type="text" class="form-control" id="visitor_name" name="visitor_name" 
                               value="<?= old('visitor_name', $testimonial['visitor_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="origin_country" class="form-label">Country of Origin*</label>
                        <input type="text" class="form-control" id="origin_country" name="origin_country" 
                               value="<?= old('origin_country', $testimonial['origin_country']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="testimonial" class="form-label">Testimonial*</label>
                    <textarea class="form-control" id="testimonial" name="testimonial" rows="3" required><?= old('testimonial', $testimonial['testimonial']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="rating" class="form-label">Rating (1-5)*</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="">Select Rating</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>" <?= old('rating', $testimonial['rating']) == $i ? 'selected' : '' ?>>
                                    <?= $i ?> Star<?= $i > 1 ? 's' : '' ?>
                                </option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="visit_date" class="form-label">Visit Date*</label>
                        <input type="date" class="form-control" id="visit_date" name="visit_date" 
                               value="<?= old('visit_date', $testimonial['visit_date']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?= old('is_featured', $testimonial['is_featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Testimonial
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Visitor Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <small class="text-muted">Leave empty to keep current photo (Max 2MB, JPG/PNG)</small>
                    
                    <?php if ($testimonial['photo_url']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($testimonial['photo_url']) ?>" alt="Current Photo" class="img-thumbnail rounded-circle" style="max-height: 200px;">
                            <p class="text-muted mt-1">Current Photo</p>
                        </div>
                    <?php endif ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
                    <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.createElement('div');
            preview.className = 'mt-2';
            preview.innerHTML = `
                <img src="${event.target.result}" alt="Preview" class="img-thumbnail rounded-circle" style="max-height: 200px;">
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