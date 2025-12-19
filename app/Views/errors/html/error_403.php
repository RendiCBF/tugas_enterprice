<!DOCTYPE html>
<html lang="en">
<head>
    <title>Akses Ditolak!</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fc; text-align: center; padding: 50px; }
        .error-code { font-size: 100px; color: #e74a3b; font-weight: bold; }
        .message { font-size: 24px; color: #5a5c69; }
        .btn { margin-top: 20px; display: inline-block; padding: 10px 20px; background: #4e73df; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="error-code">403</div>
    <div class="message">Oops! Anda tidak memiliki izin untuk mengakses halaman ini.</div>
    <p>Silakan hubungi Administrator jika ini adalah kesalahan.</p>
    <a href="<?= base_url('dashboard') ?>" class="btn">Kembali ke Dashboard</a>
</body>
</html>