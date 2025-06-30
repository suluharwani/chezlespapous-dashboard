<?= $this->extend('admin/layout/auth') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">
                    <img src="<?= base_url('assets/admin/img/logo.png') ?>" alt="Logo" height="40">
                    <span class="d-block mt-2">Create Admin Account</span>
                </h3>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                
                <form action="<?= base_url('admin/register') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="username" name="username" type="text" 
                                       placeholder="Enter your username" value="<?= old('username') ?>" required />
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="full_name" name="full_name" type="text" 
                                       placeholder="Enter your full name" value="<?= old('full_name') ?>" required />
                                <label for="full_name">Full Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email" 
                               placeholder="name@example.com" value="<?= old('email') ?>" required />
                        <label for="email">Email address</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="password" name="password" type="password" 
                                       placeholder="Create a password" required />
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="confirm_password" name="confirm_password" 
                                       type="password" placeholder="Confirm password" required />
                                <label for="confirm_password">Confirm Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small">
                    <a href="<?= base_url('admin/login') ?>">Have an account? Go to login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>