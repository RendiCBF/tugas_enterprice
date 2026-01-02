<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: #f4f7f6; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
            transition: transform 0.3s;
        }
        .error-card:hover {
            transform: translateY(-5px);
        }
        .icon-lock {
            font-size: 80px;
            color: #e74a3b;
            margin-bottom: 20px;
            animation: shake 0.5s infinite alternate;
        }
        .error-code { 
            font-size: 72px; 
            color: #5a5c69; 
            font-weight: 800;
            line-height: 1;
        }
        .message { 
            font-size: 20px; 
            color: #3a3b45; 
            font-weight: 700;
            margin-top: 15px;
        }
        .sub-message {
            color: #858796;
            margin-bottom: 30px;
        }
        .btn-back { 
            padding: 12px 30px; 
            background: #4e73df; 
            color: white; 
            text-decoration: none; 
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
            border: none;
        }
        .btn-back:hover { 
            background: #2e59d9; 
            color: white;
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
        /* Animasi Gembok Goyang */
        @keyframes shake {
            0% { transform: rotate(-5deg); }
            100% { transform: rotate(5deg); }
        }
    </style>
</head>
<body>

    <div class="error-card">
        <div class="icon-lock">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="error-code">403</div>
        <div class="message">Akses Terbatas!</div>
        <p class="sub-message">Ups! Akun Anda (<b><?= session()->get('role') ?></b>) tidak diizinkan masuk ke wilayah ini.</p>
        
        <a href="<?= base_url('dashboard') ?>" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

</body>
</html>