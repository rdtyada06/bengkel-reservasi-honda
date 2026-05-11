<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: url('<?= base_url("assets/images/bengkel.png") ?>') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* OVERLAY */
.overlay {
    background: rgba(255,255,255,0.9);
    min-height: 100vh;
    padding: 40px 0;
}

/* CARD */
.card-box {
    max-width: 650px;
    margin: auto;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* STATUS */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: white;
    font-weight: 600;
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

/* LAYANAN */
.layanan-item {
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

/* INFO BOX */
.info-box {
    border-radius: 12px;
    padding: 12px;
    margin-top: 15px;
}
</style>

</head>
<body>

<div class="overlay">
<div class="container">

    <div class="card card-box p-4">

        <h4 class="mb-4">Detail Booking</h4>

        <!-- DATA -->
        <p>
            <strong>No Polisi:</strong><br>
            <?= esc($booking['no_polisi']) ?>
        </p>

        <p>
            <strong>Mekanik:</strong><br>
            <?= esc($booking['nama_mekanik']) ?>
        </p>

        <p>
            <strong>Tanggal:</strong><br>
            <?= esc($booking['tanggal']) ?>
        </p>

        <p>
            <strong>Jam:</strong><br>
            <?= esc($booking['jam']) ?>
        </p>

        <!-- STATUS -->
        <p>
            <strong>Status:</strong><br>

            <?php if($booking['status'] == 'menunggu'): ?>

                <span class="status status-menunggu">
                    Menunggu
                </span>

            <?php elseif($booking['status'] == 'proses'): ?>

                <span class="status status-proses">
                    Proses
                </span>

            <?php elseif($booking['status'] == 'selesai'): ?>

                <span class="status status-selesai">
                    Selesai
                </span>

            <?php else: ?>

                <span class="status status-batal">
                    Batal
                </span>

            <?php endif; ?>

        </p>

        <!-- INFO STATUS -->
        <?php if($booking['status'] == 'menunggu'): ?>

            <div class="alert alert-warning info-box">
                Booking sedang menunggu konfirmasi admin
            </div>

        <?php elseif($booking['status'] == 'proses'): ?>

            <div class="alert alert-primary info-box">
                Kendaraan sedang diservis oleh mekanik
            </div>

        <?php elseif($booking['status'] == 'selesai'): ?>

            <div class="alert alert-success info-box">
                Servis selesai, kendaraan siap diambil
            </div>

        <?php else: ?>

            <div class="alert alert-danger info-box">
                Booking telah dibatalkan
            </div>

        <?php endif; ?>

        <hr>

        <!-- LAYANAN -->
        <h5 class="mb-3">Layanan</h5>

        <?php foreach($layanan as $l): ?>

            <div class="layanan-item">

                <?= esc($l['nama_layanan']) ?>

                <span class="float-end text-danger">
                    Rp <?= number_format($l['harga'], 0, ',', '.') ?>
                </span>

            </div>

        <?php endforeach; ?>

        <hr>

        <!-- TOTAL -->
        <h5>
            Total:
            <span class="text-danger">
                Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?>
            </span>
        </h5>

        <!-- BUTTON -->
        <a href="<?= base_url('user/riwayat') ?>" 
           class="btn btn-secondary mt-4">

            ← Kembali

        </a>

    </div>

</div>
</div>

</body>
</html>