<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI', sans-serif;
        }

        body{
            display:flex;
            height:100vh;
            overflow:hidden;
        }

        /* LEFT */
        .left{
            width:50%;
            position:relative;
            color:white;
            background-size:cover;
            background-position:center;
        }

        .overlay{
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.5);
        }

        .left-content{
            position:absolute;
            bottom:50px;
            left:50px;
            z-index:2;
        }

        .left h1{
            font-size:42px;
            margin-bottom:10px;
            font-weight:bold;
        }

        .left p{
            font-size:15px;
            opacity:0.9;
        }

        /* RIGHT */
        .right{
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#f3f4f6;
        }

        .card-reset{
            background:white;
            padding:40px;
            border-radius:20px;
            width:380px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .logo{
            width:90px;
            margin-bottom:15px;
        }

        h2{
            margin-bottom:10px;
            font-weight:bold;
        }

        .subtitle{
            font-size:14px;
            color:#666;
            margin-bottom:25px;
        }

        input{
            width:100%;
            padding:13px;
            margin:10px 0;
            border-radius:10px;
            border:1px solid #ddd;
            outline:none;
        }

        input:focus{
            border-color:#e60012;
        }

        button{
            width:100%;
            padding:13px;
            background:#e60012;
            color:white;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#c4000f;
        }

        .link{
            margin-top:18px;
            font-size:14px;
        }

        .link a{
            color:#e60012;
            text-decoration:none;
            font-weight:600;
        }

        /* OTP INPUT */
        .otp-input{
            font-size:22px;
            letter-spacing:5px;
            font-weight:bold;
        }

        /* RESPONSIVE */
        @media(max-width:768px){

            .left{
                display:none;
            }

            .right{
                width:100%;
                padding:20px;
            }

            .card-reset{
                width:100%;
            }
        }

    </style>
</head>

<body>

<!-- LEFT -->
<div class="left"
     style="background-image:url('<?= base_url('assets/images/bengkel.png') ?>');">

    <div class="overlay"></div>

    <div class="left-content">

        <img src="<?= base_url('assets/images/honda.jpg') ?>"
             width="120">

        <br><br>

        <h1>Reservasi Bengkel Honda</h1>

        <p>
            Servis mudah, cepat, dan terpercaya
            untuk pengalaman berkendara terbaik Anda.
        </p>

    </div>

</div>

<!-- RIGHT -->
<div class="right">

    <div class="card-reset">

        <img src="<?= base_url('assets/images/honda.jpg') ?>"
             class="logo">

        <h2>Reset Password</h2>

        <p class="subtitle">
            Masukkan email untuk menerima kode OTP
        </p>

        <!-- ALERT -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM EMAIL -->
        <form action="<?= base_url('kirim-otp') ?>" method="post">

            <input type="email"
                   name="email"
                   placeholder="Masukkan Email"
                   required>

            <button type="submit">
                Kirim OTP
            </button>

        </form>

        <div class="link">
            Kembali ke <a href="<?= base_url('login') ?>">Login</a>
        </div>

    </div>

</div>

<!-- OTP MODAL -->
<div class="modal fade"
     id="otpModal"
     tabindex="-1"
     aria-labelledby="otpModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold"
                    id="otpModalLabel">

                    Verifikasi OTP

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p class="text-muted text-center mb-3">
                    Masukkan kode OTP yang dikirim ke email
                </p>

                <form action="<?= base_url('cek-otp') ?>"
                      method="post">

                    <input type="text"
                           name="otp"
                           class="form-control form-control-lg text-center otp-input"
                           placeholder="000000"
                           maxlength="6"
                           required>

                    <button type="submit"
                            class="btn btn-danger w-100 mt-3">

                        Verifikasi OTP

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AUTO SHOW OTP MODAL -->
<?php if(session()->getFlashdata('showOtpModal')): ?>

<script>

document.addEventListener('DOMContentLoaded', function(){

    var otpModal = new bootstrap.Modal(
        document.getElementById('otpModal')
    );

    otpModal.show();

});

</script>

<?php endif; ?>

<!-- RESET PASSWORD MODAL -->
<div class="modal fade"
     id="resetPasswordModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">
                    Password Baru
                </h5>

            </div>

            <div class="modal-body">

                <form action="<?= base_url('simpan-password-baru') ?>"
                      method="post">

                    <input type="password"
                           name="password"
                           class="form-control form-control-lg"
                           placeholder="Masukkan Password Baru"
                           required>

                    <button type="submit"
                            class="btn btn-danger w-100 mt-3">

                        Simpan Password

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<?php if(session()->getFlashdata('showResetModal')): ?>

<script>

document.addEventListener('DOMContentLoaded', function(){

    var resetModal = new bootstrap.Modal(
        document.getElementById('resetPasswordModal')
    );

    resetModal.show();

});

</script>

<?php endif; ?>
</body>
</html>