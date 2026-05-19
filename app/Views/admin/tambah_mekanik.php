<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Mekanik</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    
    background:
        linear-gradient(
            rgba(255,255,255,0.85),
            rgba(255,255,255,0.85)
        ),
        url('<?= base_url('assets/images/bengkel.png') ?>');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    height:100vh;
    background:white;
    position:fixed;
    top:0;
    left:0;
    padding:20px;
    border-right:1px solid #eee;
}

.sidebar h5{
    color:#e60012;
    font-weight:bold;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:12px;
    margin-bottom:10px;
    border-radius:14px;
    text-decoration:none;
    color:#333;
    transition:0.2s;
}

.sidebar a:hover{
    background:#fff1f1;
}

.sidebar a.active{
    background:#ffe5e5;
    color:#e60012;
    font-weight:600;
}

/* CONTENT */
.content{
    margin-left:240px;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

/* CARD */
.form-card{
    width:100%;
    max-width:650px;
    background:white;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
}

/* HEADER */
.form-header{
    background:linear-gradient(135deg, #e60012, #ff3b4d);
    padding:35px;
    color:white;
}

.form-header h2{
    margin:0;
    font-weight:700;
}

.form-header p{
    margin-top:8px;
    opacity:0.9;
}

/* BODY */
.form-body{
    padding:35px;
}

/* INPUT */
.form-label{
    font-weight:600;
    margin-bottom:8px;
}

.form-control{
    border-radius:14px;
    padding:14px;
    border:1px solid #ddd;
    transition:0.2s;
}

.form-control:focus{
    border-color:#e60012;
    box-shadow:0 0 0 0.15rem rgba(230,0,18,0.15);
}

/* ICON BOX */
.input-group-text{
    border-radius:14px 0 0 14px;
    background:#fff5f5;
    border:1px solid #ddd;
}

/* BUTTON */
.btn-honda{
    background:#e60012;
    color:white;
    border:none;
    border-radius:14px;
    padding:12px 20px;
    font-weight:600;
    transition:0.2s;
}

.btn-honda:hover{
    background:#c4000f;
    color:white;
    transform:translateY(-2px);
}

.btn-back{
    border-radius:14px;
    padding:12px 20px;
}

/* FOOTER */
.footer-note{
    margin-top:20px;
    font-size:13px;
    color:#888;
    text-align:center;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h5>ADMIN HONDA</h5>

    <a href="<?= base_url('admin/dashboard') ?>">
         Dashboard
    </a>

    <a href="<?= base_url('admin/booking') ?>">
         Booking
    </a>

    <a href="<?= base_url('admin/mekanik') ?>" class="active">
         Mekanik
    </a>

    <a href="<?= base_url('admin/layanan') ?>">
         Layanan
    </a>

    <hr>

    <a href="<?= base_url('logout') ?>">
         Logout
    </a>

</div>

<!-- CONTENT -->
<div class="content">

    <div class="form-card">

        <!-- HEADER -->
        <div class="form-header">

            <h2>Tambah Mekanik</h2>

            <p>
                Tambahkan data mekanik baru untuk bengkel Honda
            </p>

        </div>

        <!-- BODY -->
        <div class="form-body">

            <form action="<?= base_url('admin/mekanik/simpan') ?>" method="post">

                <!-- NAMA -->
                <div class="mb-4">

                    <label class="form-label">
                        Nama Mekanik
                    </label>

                    <div class="input-group">

                        <input type="text"
                               name="nama_mekanik"
                               class="form-control"
                               placeholder="Masukkan nama mekanik"
                               required>

                    </div>

                </div>

                <!-- NO HP -->
                <div class="mb-4">

                    <label class="form-label">
                        Nomor HP
                    </label>

                    <div class="input-group">

                        <input type="text"
                               name="no_hp"
                               class="form-control"
                               placeholder="Masukkan nomor HP"
                               required>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-3">

                    <button class="btn btn-honda">

                         Simpan Mekanik

                    </button>

                    <a href="<?= base_url('admin/mekanik') ?>"
                       class="btn btn-secondary btn-back">

                        Kembali

                    </a>

                </div>

            </form>

            <!-- FOOTER -->
            <div class="footer-note">

                Pastikan data mekanik diisi dengan benar

            </div>

        </div>

    </div>

</div>

</body>
</html>