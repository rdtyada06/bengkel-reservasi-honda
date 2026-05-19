<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Mekanik</title>

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
    padding:20px;
    border-right:1px solid #eee;
}

.sidebar h5{
    color:#e60012;
    font-weight:bold;
}

.sidebar a{
    display:block;
    padding:10px;
    margin-bottom:10px;
    border-radius:12px;
    color:#333;
    text-decoration:none;
    transition:0.2s;
}

.sidebar a:hover{
    background:#fff0f0;
}

.sidebar a.active{
    background:#ffe5e5;
    color:#e60012;
    font-weight:600;
}

/* CONTENT */
.content{
    margin-left:240px;
    padding:30px;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

/* CARD */
.card-box{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

/* BUTTON */
.btn-honda{
    background:#e60012;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 18px;
    font-weight:600;
}

.btn-honda:hover{
    background:#c4000f;
    color:white;
}

/* TABLE */
.table{
    vertical-align:middle;
}

.table tbody tr{
    transition:0.2s;
}

.table tbody tr:hover{
    background:#fff7f7;
}

/* ACTION BUTTON */
.btn-action{
    border-radius:10px;
    font-size:13px;
    padding:6px 12px;
}

/* SEARCH */
.search-box{
    max-width:250px;
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

    <a href="<?= base_url('admin/laporan') ?>">
         Laporan
    </a>

    <hr>

    <a href="<?= base_url('logout') ?>">
         Logout
    </a>

</div>

<!-- CONTENT -->
<div class="content">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h3 class="mb-1">Kelola Mekanik</h3>
            <p class="text-muted mb-0">
                Data mekanik bengkel Honda
            </p>
        </div>

        <a href="<?= base_url('admin/mekanik/tambah') ?>" 
           class="btn btn-honda">

            + Tambah Mekanik

        </a>

    </div>

    <!-- ALERT -->
    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <!-- CARD -->
    <div class="card-box">

        <!-- TOP -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <strong>
                    Total Mekanik:
                    <?= count($mekanik) ?>
                </strong>
            </div>

            <div class="search-box">

                <input type="text" 
                       class="form-control"
                       placeholder="Cari mekanik...">

            </div>

        </div>

        <!-- TABLE -->
        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>
                        <th width="80">No</th>
                        <th>Nama Mekanik</th>
                        <th>No HP</th>
                        <th width="200">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($mekanik)): ?>

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data mekanik
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php $no = 1; ?>

                        <?php foreach($mekanik as $m): ?>

                            <tr>

                                <td>
                                    <?= $no++ ?>
                                </td>

                                <td>

                                    <strong>
                                        <?= esc($m['nama_mekanik']) ?>
                                    </strong>

                                </td>

                                <td>
                                    <?= esc($m['no_hp']) ?>
                                </td>

                                <td>

                                    <a href="<?= base_url('admin/mekanik/edit/'.$m['id_mekanik']) ?>"
                                       class="btn btn-warning btn-sm btn-action">

                                         Edit

                                    </a>

                                    <a href="<?= base_url('admin/mekanik/hapus/'.$m['id_mekanik']) ?>"
                                       class="btn btn-danger btn-sm btn-action"
                                       onclick="return confirm('Yakin ingin menghapus mekanik ini?')">

                                         Hapus

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>