<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('<?= base_url("assets/images/bengkel.png") ?>') no-repeat center center/cover;
}

/* overlay */
body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,0.85);
    z-index: -1;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: white;
    position: fixed;
    padding: 20px;
    border-right: 1px solid #eee;
}

.sidebar h5 {
    color: #e60012;
    font-weight: bold;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    padding: 10px;
    border-radius: 10px;
    color: #333;
    text-decoration: none;
    margin-bottom: 10px;
}

.sidebar a.active {
    background: #ffe5e5;
    color: #e60012;
    font-weight: bold;
}

.sidebar a:hover {
    background: #f1f1f1;
}

/* CONTENT */
.content {
    margin-left: 240px;
    padding: 30px;
}

/* TOPBAR */
.topbar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    background: white;
    padding: 12px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* BANNER */
.banner {
    background: #e60012;
    color: white;
    border-radius: 15px;
    padding: 25px;
}

/* CARD */
.card-ui {
    background: white;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* MENU */
.menu-card {
    border-radius: 15px;
    padding: 20px;
    background: white;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.menu-card:hover {
    transform: translateY(-5px);
}

/* RIWAYAT */
.riwayat-card {
    background: white;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* STATUS */
.status {
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 20px;
    display: inline-block;
}

.status-menunggu { background: orange; color: white; }
.status-selesai { background: green; color: white; }
.status-batal { background: red; color: white; }

/* ================= MOBILE ================= */
@media(max-width: 768px){

    /* SIDEBAR */
    .sidebar{
        width: 100%;
        height: auto;
        position: relative;
        display: flex;
        overflow-x: auto;
        gap: 10px;
        border-right: none;
        border-bottom: 1px solid #eee;
        padding: 15px;
    }

    .sidebar h5{
        display: none;
    }

    .sidebar hr{
        display: none;
    }

    .sidebar a{
        margin-bottom: 0;
        white-space: nowrap;
        font-size: 14px;
    }

    /* CONTENT */
    .content{
        margin-left: 0;
        padding: 15px;
    }

    /* TOPBAR */
    .topbar{
        flex-direction: column;
        gap: 10px;
    }

    /* BANNER */
    .banner{
        padding: 20px;
    }

    .banner h4{
        font-size: 20px;
    }

    /* CARD */
    .card-ui{
        padding: 15px;
    }

    /* MENU */
    .menu-card{
        padding: 18px;
        font-size: 14px;
    }

    /* RIWAYAT */
    .riwayat-card{
        padding: 15px;
    }

    /* TEXT */
    h3{
        font-size: 24px;
    }

}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>HONDA</h5>

    <a href="<?= base_url('user/dashboard') ?>" class="active"> Beranda</a>
    <a href="<?= base_url('user/reservasi') ?>"> Reservasi</a>
    <a href="<?= base_url('user/riwayat') ?>"> Riwayat</a>
    <a href="<?= base_url('user/kendaraan') ?>"> Kendaraan</a>

    <hr>

    <a href="<?= base_url('logout') ?>"> Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <small>Lokasi Bengkel</small><br>
            <strong>AHASS Maju Motor</strong>
        </div>

        <div>
            👤 <?= esc(session()->get('nama_user')) ?>
        </div>
    </div>

    <!-- GREETING -->
    <h3>Halo, <?= esc(session()->get('nama_user')) ?> </h3>
    <p>Apa yang bisa kami bantu hari ini?</p>

    <!-- BANNER -->
    <div class="banner mt-3 mb-4">
        <h4>Reservasi Bengkel Honda Jadi Lebih Mudah</h4>
        <p>Pilih waktu layanan tanpa antre</p>
        <a href="<?= base_url('user/reservasi') ?>" class="btn btn-light">Reservasi Sekarang</a>
    </div>

    <!-- STATISTIK -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card-ui">
                <h4><?= $total_booking ?></h4>
                <small>Total Booking</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">
                <h4><?= $menunggu ?></h4>
                <small>Menunggu</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">
                <h4><?= $selesai ?></h4>
                <small>Selesai</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">
                <h4><?= $kendaraan ?></h4>
                <small>Kendaraan</small>
            </div>
        </div>

    </div>

    <!-- MENU -->
    <h5>Menu Cepat</h5>
    <div class="row g-3 mt-2">

        <div class="col-md-4">
            <a href="<?= base_url('user/reservasi') ?>" class="text-decoration-none text-dark">
                <div class="menu-card"><br>Reservasi</div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('user/riwayat') ?>" class="text-decoration-none text-dark">
                <div class="menu-card"><br>Riwayat</div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('user/kendaraan') ?>" class="text-decoration-none text-dark">
                <div class="menu-card"><br>Kendaraan</div>
            </a>
        </div>

    </div>

    <!-- RIWAYAT -->
    <div class="mt-5">
        <h5>Riwayat Terbaru</h5>

        <?php if(!empty($riwayat)): ?>
            <div class="row g-3 mt-2">

                <?php foreach($riwayat as $r): ?>
                    <div class="col-md-4">
                        <div class="riwayat-card">

                            <strong><?= esc($r['no_polisi']) ?></strong><br>

                            <small class="text-muted">
                                <?= esc($r['tanggal']) ?> • <?= esc($r['jam']) ?>
                            </small>

                            <div class="mt-2">
                                <span class="status 
                                    <?= $r['status']=='menunggu' ? 'status-menunggu' : ($r['status']=='selesai' ? 'status-selesai' : 'status-batal') ?>">
                                    <?= ucfirst($r['status']) ?>
                                </span>
                            </div>

                            <div class="mt-2">
                                <strong>Rp <?= number_format($r['total_bayar'], 0, ',', '.') ?></strong>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">
                Belum ada riwayat booking
            </div>
        <?php endif; ?>

    </div>

</div>

</body>
</html>