<?= $this->extend('admin/layout/auth') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">
                    <img src="<?= base_url('assets/admin/img/logo.png') ?>" alt="Logo" height="40">
                    <span class="d-block mt-2">Forgot Password</span>
                </h3>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                
                <div class="small mb-3 text-muted">
                    Enter your email address and we will send you a link to reset your password.
                </div>
                
                <form action="<?= base_url('admin/forgot-password') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email" 
                               placeholder="name@example.com" required />
                        <label for="email">Email address</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="<?= base_url('admin/login') ?>">Return to login</a>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="<?= base_url('admin/register') ?>">Need an account? Sign up!</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>