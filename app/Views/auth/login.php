<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
        }

        .left {
            width: 50%;
            background: url('<?= base_url('assets/images/bengkel.png') ?>') center/cover;
            position: relative;
            color: white;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
        }

        .left-content {
            position: absolute;
            bottom: 60px;
            left: 60px;
        }

        .left img {
            width: 120px;
            margin-bottom: 20px;
        }

        .left h1 {
            font-size: 40px;
            line-height: 1.2;
        }

        .left p {
            margin-top: 10px;
            opacity: 0.9;
        }

        .right {
            width: 50%;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #f8fafc;
            padding: 40px;
            border-radius: 20px;
            width: 360px;
            text-align: center;
        }

        .logo {
            width: 80px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 10px 0;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .forgot {
            text-align: right;
            font-size: 13px;
            color: red;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #e60012;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .bottom {
            margin-top: 15px;
            font-size: 14px;
        }

        .bottom a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="left">
    <div class="overlay"></div>
    <div class="left-content">
        <img src="<?= base_url('assets/images/honda.jpg') ?>">
        <h1>Reservasi<br>Bengkel Honda</h1>
        <p>Servis mudah, cepat, dan terpercaya untuk pengalaman terbaik Anda.</p>
    </div>
</div>

<div class="right">
    <div class="card">
        <img src="<?= base_url('assets/images/honda.jpg') ?>" class="logo">

        <h2>Selamat Datang</h2>
        <p class="subtitle">Masuk untuk melanjutkan reservasi bengkel Honda</p>

        <form action="/login" method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <div class="forgot">
                <a href="/lupa-password">Lupa Password?</a>
            </div>

            <button>MASUK</button>
        </form>

        <div class="bottom">
            Belum punya akun? <a href="/register">Daftar</a>
        </div>
    </div>
</div>

</body>
</html>