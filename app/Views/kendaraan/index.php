<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kendaraan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('<?= base_url("assets/images/bengkel.png") ?>') no-repeat center center/cover;
}

/* OVERLAY */
.overlay {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(4px);
    min-height: 100vh;
    padding: 40px 0;
}

/* CARD WRAPPER */
.card-box {
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* ITEM */
.kendaraan-card {
    background: white;
    border-radius: 15px;
    padding: 15px;
    transition: 0.2s;
}

.kendaraan-card:hover {
    transform: translateY(-3px);
}

/* ICON */
.icon {
    font-size: 30px;
}

/* HEADER */
.header-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

</head>
<body>

<div class="overlay">

<div class="container">

    <div class="card card-box p-4">

        <!-- HEADER -->
        <div class="header-box mb-3">
            <h4 class="mb-0">Kendaraan Saya</h4>
            <a href="<?= base_url('user/dashboard') ?>" class="btn btn-outline-dark btn-sm">
                ← Dashboard
            </a>
        </div>

        <!-- BUTTON TAMBAH -->
        <div class="mb-3">
            <a href="<?= base_url('user/kendaraan/tambah') ?>" class="btn btn-danger btn-sm">
                + Tambah Kendaraan
            </a>
        </div>

        <?php if(empty($kendaraan)): ?>

            <div class="alert alert-info text-center">
                Belum ada kendaraan
            </div>

        <?php else: ?>

            <div class="row g-3">

                <?php foreach($kendaraan as $k): ?>
                    <div class="col-md-4">
                        <div class="kendaraan-card">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <div class="icon"></div>
                                    <strong><?= $k['no_polisi'] ?></strong><br>
                                    <small class="text-muted">
                                        <?= $k['merk'] ?? 'Honda' ?>
                                    </small>
                                </div>

                                <div>
                                    <a href="<?= base_url('user/kendaraan/hapus/'.$k['no_polisi']) ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Yakin hapus?')">
                                       Hapus
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

</div>

</body>
</html>