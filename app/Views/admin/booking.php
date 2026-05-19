<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
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
}

.sidebar a {
    display: block;
    padding: 10px;
    border-radius: 10px;
    color: #333;
    text-decoration: none;
    margin-bottom: 10px;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #ffe5e5;
}

.sidebar a.active {
    background: #ffe5e5;
    color: red;
    font-weight: bold;
}

/* CONTENT */
.content {
    margin-left: 240px;
    padding: 30px;
}

/* CARD */
.card-box {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* STATUS */
.status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    color: white;
    display: inline-block;
    font-weight: 500;
}

.menunggu { background: #f39c12; }
.proses   { background: #0d6efd; }
.selesai  { background: #28a745; }
.batal    { background: #dc3545; }

/* BUTTON */
.btn-update {
    font-size: 12px;
}

/* TABLE */
.table tbody tr:hover {
    background: #fafafa;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>ADMIN HONDA</h5>

    <a href="<?= base_url('admin/dashboard') ?>"> Dashboard</a>
    <a href="<?= base_url('admin/booking') ?>" class="active"> Booking</a>
    <a href="<?= base_url('admin/mekanik') ?>"> Mekanik</a>
    <a href="<?= base_url('admin/layanan') ?>"> Layanan</a>
    <a href="<?= base_url('admin/laporan') ?>"> Laporan</a>

    <hr>

    <a href="<?= base_url('logout') ?>"> Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h3>Kelola Booking</h3>
    <p class="text-muted">Kelola semua reservasi pelanggan</p>

    <!-- NOTIF -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="card-box mt-3">

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>No Polisi</th>
                    <th>User</th>
                    <th>Mekanik</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($booking as $b): ?>
                <tr>

                    <td><strong><?= esc($b['no_polisi']) ?></strong></td>
                    <td><?= esc($b['nama_user']) ?></td>
                    <td><?= esc($b['nama_mekanik']) ?></td>

                    <td>
                        <?= esc($b['tanggal']) ?><br>
                        <small class="text-muted"><?= esc($b['jam']) ?></small>
                    </td>

                    <!-- STATUS -->
                    <td>
                        <?php $status = strtolower(trim($b['status'])); ?>
                        <span class="status <?= $status ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </td>

                    <!-- AKSI -->
                    <td>

                        <!-- DETAIL -->
                        <a href="<?= base_url('admin/booking/'.$b['id_booking']) ?>" 
                           class="btn btn-info btn-sm w-100 mb-2">
                            Detail
                        </a>

                        <!-- UPDATE STATUS -->
                        <form action="<?= base_url('admin/booking/update/'.$b['id_booking']) ?>" method="post">

                            <select name="status" class="form-select form-select-sm mb-2">
                                <option value="menunggu" <?= $status=='menunggu'?'selected':'' ?>>Menunggu</option>
                                <option value="proses" <?= $status=='proses'?'selected':'' ?>>Proses</option>
                                <option value="selesai" <?= $status=='selesai'?'selected':'' ?>>Selesai</option>
                                <option value="batal" <?= $status=='batal'?'selected':'' ?>>Batal</option>
                            </select>

                            <button class="btn btn-primary btn-sm w-100 btn-update">
                                Update Status
                            </button>

                        </form>

                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>

</div>

</body>
</html>