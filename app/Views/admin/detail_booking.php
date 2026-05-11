<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f5f5;
    font-family: 'Segoe UI', sans-serif;
}

/* CONTAINER */
.container-box {
    background: white;
    padding: 25px;
    border-radius: 15px;
    margin-top: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* STATUS */
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: white;
}

.menunggu { background: orange; }
.diproses { background: blue; }
.selesai { background: green; }
.batal { background: red; }
</style>

</head>
<body>

<div class="container">

    <div class="container-box">

        <h3>Detail Booking</h3>

        <hr>

        <!-- INFO BOOKING -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p><b>No Polisi:</b> <?= esc($booking['no_polisi']) ?></p>
                <p><b>User:</b> <?= esc($booking['nama_user']) ?></p>
                <p><b>Mekanik:</b> <?= esc($booking['nama_mekanik']) ?></p>
            </div>

            <div class="col-md-6">
                <p><b>Tanggal:</b> <?= esc($booking['tanggal']) ?></p>
                <p><b>Jam:</b> <?= esc($booking['jam']) ?></p>
                <p>
                    <b>Status:</b> 
                    <span class="status <?= $booking['status'] ?>">
                        <?= ucfirst($booking['status']) ?>
                    </span>
                </p>
            </div>
        </div>

        <hr>

        <!-- LAYANAN -->
        <h5>Layanan</h5>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama Layanan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($layanan as $l): ?>
                <tr>
                    <td><?= esc($l['nama_layanan']) ?></td>
                    <td>Rp <?= number_format($l['harga'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- TOTAL -->
        <div class="text-end mt-3">
            <h5>Total: Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></h5>
        </div>

        <!-- BUTTON -->
        <div class="mt-4">
            <a href="<?= base_url('admin/booking') ?>" class="btn btn-secondary">Kembali</a>
        </div>

    </div>

</div>

</body>
</html>