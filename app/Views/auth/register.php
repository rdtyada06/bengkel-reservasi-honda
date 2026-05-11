<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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

        input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #e60012;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
        }

        .bottom {
            margin-top: 15px;
        }

        .bottom a {
            color: red;
        }
    </style>
</head>
<body>

<div class="left">
    <div class="overlay"></div>
    <div class="left-content">
        <img src="<?= base_url('assets/images/honda.jpg') ?>">
        <h1>Reservasi<br>Bengkel Honda</h1>
    </div>
</div>

<div class="right">
    <div class="card">
        <img src="<?= base_url('assets/images/honda.jpg') ?>" class="logo">

        <h2>Buat Akun</h2>
        <p>Daftar untuk mulai reservasi</p>

        <form action="/register" method="post">
            <input type="text" name="nama_user" placeholder="Nama Lengkap">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button>DAFTAR</button>
        </form>

        <div class="bottom">
            Sudah punya akun? <a href="/login">Login</a>
        </div>
    </div>
</div>

</body>
</html>