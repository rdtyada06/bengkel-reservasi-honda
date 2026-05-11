<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Mekanik</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f5f5f5;
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
    background:linear-gradient(135deg, #ff9800, #ffb74d);
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
}

.form-control:focus{
    border-color:#ff9800;
    box-shadow:0 0 0 0.15rem rgba(255,152,0,0.15);
}

/* INPUT GROUP */
.input-group-text{
    border-radius:14px 0 0 14px;
    background:#fff8f0;
    border:1px solid #ddd;
}

/* BUTTON */
.btn-update{
    background:#ff9800;
    color:white;
    border:none;
    border-radius:14px;
    padding:12px 20px;
    font-weight:600;
    transition:0.2s;
}

.btn-update:hover{
    background:#e68900;
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

            <h2>Edit Mekanik</h2>

            <p>
                Perbarui data mekanik bengkel Honda
            </p>

        </div>

        <!-- BODY -->
        <div class="form-body">

            <form action="<?= base_url('admin/mekanik/update/'.$mekanik['id_mekanik']) ?>" 
                  method="post">

                <!-- NAMA -->
                <div class="mb-4">

                    <label class="form-label">
                        Nama Mekanik
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            👨‍🔧
                        </span>

                        <input type="text"
                               name="nama_mekanik"
                               class="form-control"
                               value="<?= esc($mekanik['nama_mekanik']) ?>"
                               required>

                    </div>

                </div>

                <!-- NO HP -->
                <div class="mb-4">

                    <label class="form-label">
                        Nomor HP
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            📞
                        </span>

                        <input type="text"
                               name="no_hp"
                               class="form-control"
                               value="<?= esc($mekanik['no_hp']) ?>"
                               required>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-3">

                    <button class="btn btn-update">

                        ✏ Update Mekanik

                    </button>

                    <a href="<?= base_url('admin/mekanik') ?>"
                       class="btn btn-secondary btn-back">

                        ← Kembali

                    </a>

                </div>

            </form>

            <!-- FOOTER -->
            <div class="footer-note">

                Pastikan data mekanik sudah benar sebelum diupdate

            </div>

        </div>

    </div>

</div>

</body>
</html>