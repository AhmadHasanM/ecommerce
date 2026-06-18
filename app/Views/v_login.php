<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SINNA STORE - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 20px;
    }
    .login-card {
      background: #fff;
      border-radius: 16px;
      padding: 40px 32px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 20px 60px rgba(0,0,0,.3);
    }
    .logo-area {
      text-align: center;
      margin-bottom: 28px;
    }
    .logo-area .brand-icon {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
    }
    .logo-area .brand-icon i {
      font-size: 28px;
      color: #fff;
    }
    .logo-area h4 {
      font-weight: 700;
      color: #1a1a2e;
      margin-bottom: 4px;
    }
    .logo-area p {
      font-size: 14px;
      color: #6c757d;
      margin: 0;
    }
    .input-icon {
      position: relative;
    }
    .input-icon .form-control {
      padding-left: 40px;
      height: 46px;
    }
    .input-icon .icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
      font-size: 18px;
      z-index: 5;
      pointer-events: none;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="logo-area">
    <div class="brand-icon">
      <i class="bi bi-shop"></i>
    </div>
    <h4>SINNA STORE</h4>
    <p>Masuk untuk melanjutkan</p>
  </div>

  <?php
  if (session()->getFlashData('failed')) {
  ?>
  <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
    <div><?= session()->getFlashData('failed') ?></div>
  </div>
  <?php
  }
  ?>

  <?= form_open('login') ?>
  <div class="mb-3 input-icon">
    <i class="bi bi-person icon"></i>
    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required minlength="6">
  </div>
  <div class="mb-3 input-icon">
    <i class="bi bi-lock icon"></i>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required minlength="7">
  </div>
  <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
    <i class="bi bi-box-arrow-in-right me-1"></i> Login
  </button>
  <?= form_close() ?>

  <hr class="my-3">
  <p class="text-center text-muted mb-3">atau login dengan</p>

  <a href="<?= base_url('auth/google') ?>" class="btn btn-outline-danger w-100 mb-2 d-flex align-items-center justify-content-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
      <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
      <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
      <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
      <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
    </svg>
    Login dengan Google
  </a>

  <a href="<?= base_url('auth/facebook') ?>" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
    <i class="bi bi-facebook"></i>
    Login dengan Facebook
  </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
