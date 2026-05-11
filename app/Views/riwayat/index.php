<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Booking</title>

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

/* CARD */
.card-box {
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* HEADER */
.header-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* ITEM */
.riwayat-item {
    background: white;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    transition: 0.25s;
}

.riwayat-item:hover {
    transform: translateY(-4px);
}

/* STATUS */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

.status-menunggu {
    background: orange;
}

.status-proses {
    background: #0d6efd;
}

.status-selesai {
    background: green;
}

.status-batal {
    background: red;
}

/* FOOTER */
.footer-box {
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
        <div class="header-box mb-4">
            <h4 class="mb-0">Riwayat Booking</h4>

            <a href="<?= base_url('user/dashboard') ?>" 
               class="btn btn-outline-dark btn-sm">
                ← Dashboard
            </a>
        </div>

        <!-- ALERT -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- DATA -->
        <?php if(empty($booking)): ?>

            <div class="alert alert-info text-center">
                Belum ada riwayat booking
            </div>

        <?php else: ?>

            <?php foreach($booking as $b): ?>

                <div class="riwayat-item">

                    <!-- TOP -->
                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <strong><?= esc($b['no_polisi']) ?></strong><br>

                            <small class="text-muted">
                                <?= esc($b['tanggal']) ?> • <?= esc($b['jam']) ?>
                            </small>
                        </div>

                        <!-- STATUS -->
                        <div>

                            <?php if($b['status'] == 'menunggu'): ?>

                                <span class="status status-menunggu">
                                    Menunggu
                                </span>

                            <?php elseif($b['status'] == 'proses'): ?>

                                <span class="status status-proses">
                                    Proses
                                </span>

                            <?php elseif($b['status'] == 'selesai'): ?>

                                <span class="status status-selesai">
                                    Selesai
                                </span>

                            <?php else: ?>

                                <span class="status status-batal">
                                    Batal
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                    <!-- TOTAL -->
                    <div class="mt-3">
                        <strong>
                            Total: 
                            Rp <?= number_format($b['total_bayar'], 0, ',', '.') ?>
                        </strong>
                    </div>

                    <!-- ACTION -->
                    <div class="footer-box mt-3">

                        <div>

                            <a href="<?= base_url('user/riwayat/detail/'.$b['id_booking']) ?>" 
                               class="btn btn-sm btn-outline-dark">
                                Detail
                            </a>

                            <?php if($b['status'] == 'menunggu'): ?>

                                <a href="<?= base_url('user/riwayat/batal/'.$b['id_booking']) ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Yakin ingin membatalkan booking?')">

                                    Batal

                                </a>

                            <?php endif; ?>

                        </div>

                        <!-- INFO STATUS -->
                        <div>

                            <?php if($b['status'] == 'menunggu'): ?>

                                <span class="text-muted" style="font-size:12px;">
                                    Menunggu konfirmasi admin
                                </span>

                            <?php elseif($b['status'] == 'proses'): ?>

                                <span class="text-primary" style="font-size:12px;">
                                    Kendaraan sedang diservis
                                </span>

                            <?php elseif($b['status'] == 'selesai'): ?>

                                <span class="text-success" style="font-size:12px;">
                                    Servis selesai
                                </span>

                            <?php else: ?>

                                <span class="text-danger" style="font-size:12px;">
                                    Booking dibatalkan
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>
</div>

</body>
</html>