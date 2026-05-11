<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Layanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f5f5;
    font-family: 'Segoe UI', sans-serif;
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

/* TABLE */
.table tbody tr:hover {
    background: #fafafa;
}

/* BUTTON */
.btn {
    border-radius: 8px;
}

/* BADGE */
.badge {
    padding: 6px 10px;
    font-weight: 500;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>ADMIN HONDA</h5>

    <a href="<?= base_url('admin/dashboard') ?>"> Dashboard</a>
    <a href="<?= base_url('admin/booking') ?>"> Booking</a>
    <a href="<?= base_url('admin/layanan') ?>" class="active"> Layanan</a>

    <hr>

    <a href="<?= base_url('logout') ?>"> Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h3 class="mb-1">Kelola Layanan</h3>
    <p class="text-muted mb-4">Semua layanan bengkel</p>

    <div class="card-box">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Daftar Layanan</h5>

            <a href="<?= base_url('admin/layanan/tambah') ?>" class="btn btn-primary">
                + Tambah Layanan
            </a>
        </div>

        <!-- NOTIF -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if(empty($layanan)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Belum ada layanan
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach($layanan as $l): ?>
                    <tr>

                        <td>
                            <strong><?= esc($l['nama_layanan']) ?></strong>
                        </td>

                        <td>
                            <span class="badge bg-success">
                                Rp <?= number_format($l['harga']) ?>
                            </span>
                        </td>

                        <td>

                            <!-- EDIT -->
                            <a href="<?= base_url('admin/layanan/edit/'.$l['id_layanan']) ?>" 
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <!-- HAPUS -->
                            <a href="<?= base_url('admin/layanan/hapus/'.$l['id_layanan']) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus layanan ini?')">
                                Hapus
                            </a>

                        </td>

                    </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>

    </div>

</div>

</body>
</html>