<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Project Rendi</title>
    
    <style>
        /* Variabel Warna Uiverse */
        :root {
            --bg-light: #efefef;
            --bg-dark: #707070;
            --clr: #58bc82;
            --clr-alpha: #9c9c9c60;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: var(--bg-light);
            font-family: 'Poppins', sans-serif;
        }

        /* Container Pesan Error */
        .alert-container {
            position: absolute;
            top: 20px;
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        /* Styling Form Utama */
        .form {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.2rem;
            width: 100%;
            max-width: 350px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .form .input-span {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form input[type="email"],
        .form input[type="password"] {
            border-radius: 0.5rem;
            padding: 1rem 0.75rem;
            width: 100%;
            border: none;
            background-color: var(--clr-alpha);
            outline: 2px solid transparent;
            transition: all 0.3s ease;
            box-sizing: border-box; /* Penting agar padding tidak merusak lebar */
        }

        .form input[type="email"]:focus,
        .form input[type="password"]:focus {
            outline: 2px solid var(--clr);
            background-color: #fff;
        }

        .label {
            align-self: flex-start;
            color: var(--clr);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form .submit {
            margin-top: 10px;
            padding: 1rem;
            width: 100%;
            border-radius: 3rem;
            background-color: var(--bg-dark);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 300ms;
            font-weight: 600;
            font-size: 1rem;
        }

        .form .submit:hover {
            background-color: var(--clr);
            transform: translateY(-2px);
        }

        .span {
            font-size: 0.85rem;
            text-decoration: none;
            color: var(--bg-dark);
        }

        .span a {
            color: var(--clr);
            font-weight: 600;
            text-decoration: none;
        }

        .span a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="alert-container">
        <?php if(session()->getFlashdata('errors')): ?>
            <div style="color: #d93025; font-size: 0.8rem; margin-bottom: 5px;">
                <?= implode('<br>', session()->getFlashdata('errors')) ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div style="color: #f29900; font-size: 0.8rem;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
    </div>

    <form class="form" action="<?= base_url('auth/login') ?>" method="post">
        <?= csrf_field() ?> <h2 style="color: var(--bg-dark); margin-bottom: 10px;">Login</h2>

        <span class="input-span">
            <label for="email" class="label">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>" placeholder="Masukkan email..." required />
        </span>
        
        <span class="input-span">
            <label for="password" class="label">Password</label>
            <input type="password" name="password" id="password" placeholder="********" required />
        </span>
        
        <!-- <span class="span"><a href="#">Forgot password?</a></span> -->
        
        <input class="submit" type="submit" value="Sign In" />
        
        <!-- <span class="span">Don't have an account? <a href="#">Sign up</a></span> -->
    </form>

</body>
</html>