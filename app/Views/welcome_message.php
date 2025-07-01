<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Chezlespapous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        .welcome-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }
        .welcome-header {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .welcome-body {
            padding: 2rem;
            background-color: white;
        }
        .logo {
            width: 80px;
            margin-bottom: 1rem;
        }
        .btn-login {
            background-color: #6a11cb;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #5a0cb0;
            transform: translateY(-2px);
        }
        .welcome-footer {
            text-align: center;
            padding: 1rem;
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-card">
            <div class="welcome-header">
                <img src="<?= base_url('assets/img/logo-white.png') ?>" alt="Chezlespapous Logo" class="logo">
                <h2>Admin Portal</h2>
                <p class="mb-0">Selamat datang di sistem administrasi</p>
            </div>
            <div class="welcome-body">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock" style="font-size: 3rem; color: #6a11cb;"></i>
                </div>
                <p class="text-center mb-4">Silakan login untuk mengakses dashboard administrasi Chezlespapous.</p>
                <a href="<?= base_url('admin/login') ?>" class="btn btn-primary btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login Admin
                </a>
            </div>
            <div class="welcome-footer">
                &copy; <?= date('Y') ?> Chezlespapous. All rights reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>