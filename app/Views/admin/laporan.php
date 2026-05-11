<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    background:#fff2f2;
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
.page-title h3{
    font-weight:700;
}

.page-title p{
    color:#888;
}

/* CARD */
.card-ui,
.box{
    background:white;
    border-radius:22px;
    padding:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.card-ui{
    transition:0.2s;
}

.card-ui:hover{
    transform:translateY(-3px);
}

/* STAT */
.stat-icon{
    width:55px;
    height:55px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin-bottom:15px;
}

.bg-red{
    background:#ffe5e5;
    color:#e60012;
}

.bg-green{
    background:#e8fff0;
    color:green;
}

.bg-orange{
    background:#fff3dd;
    color:#ff9800;
}

.bg-dark{
    background:#f1f1f1;
    color:#333;
}

/* FILTER */
.filter-box{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

/* TABLE */
.table tbody tr{
    transition:0.2s;
}

.table tbody tr:hover{
    background:#fff8f8;
}

/* BADGE */
.badge{
    border-radius:10px;
    padding:8px 12px;
    font-size:12px;
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

.chart-container{
    height:350px;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h5>ADMIN HONDA</h5>

    <a href="<?= base_url('admin/dashboard') ?>">
        🏠 Dashboard
    </a>

    <a href="<?= base_url('admin/booking') ?>">
        📋 Booking
    </a>

    <a href="<?= base_url('admin/mekanik') ?>">
        👨‍🔧 Mekanik
    </a>

    <a href="<?= base_url('admin/layanan') ?>">
        🛠️ Layanan
    </a>

    <a href="<?= base_url('admin/laporan') ?>" class="active">
        📊 Laporan
    </a>

    <hr>

    <a href="<?= base_url('logout') ?>">
        🚪 Logout
    </a>

</div>

<!-- CONTENT -->
<div class="content">

    <!-- HEADER -->
    <div class="page-title mb-4">

        <h3>Laporan Bengkel</h3>

        <p>
            Ringkasan booking dan pendapatan bengkel Honda
        </p>

    </div>

    <!-- FILTER -->
    <div class="box mb-4">

        <form method="get">

            <div class="filter-box">

                <div>
                    <label class="form-label">
                        Dari Tanggal
                    </label>

                    <input type="date"
                           name="dari"
                           value="<?= $dari ?>"
                           class="form-control">
                </div>

                <div>
                    <label class="form-label">
                        Sampai
                    </label>

                    <input type="date"
                           name="sampai"
                           value="<?= $sampai ?>"
                           class="form-control">
                </div>

                <div class="d-flex align-items-end">

                    <button class="btn btn-honda">
                        Filter
                    </button>

                </div>

            </div>

        </form>

    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card-ui">

                <div class="stat-icon bg-red">
                    📋
                </div>

                <h4><?= $totalBooking ?></h4>

                <small class="text-muted">
                    Total Booking
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-ui">

                <div class="stat-icon bg-green">
                    💰
                </div>

                <h4>
                    Rp <?= number_format($pendapatan,0,',','.') ?>
                </h4>

                <small class="text-muted">
                    Pendapatan
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-ui">

                <div class="stat-icon bg-orange">
                    🔧
                </div>

                <h4><?= $proses ?></h4>

                <small class="text-muted">
                    Proses
                </small>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card-ui">

                <div class="stat-icon bg-dark">
                    ✅
                </div>

                <h4><?= $selesai ?></h4>

                <small class="text-muted">
                    Selesai
                </small>

            </div>

        </div>

    </div>

    <!-- GRAFIK -->
    <div class="box mb-4">

        <h5 class="mb-4">
            Grafik Status Booking
        </h5>

        <div class="chart-container">
            <canvas id="laporanChart"></canvas>
        </div>

    </div>

    <!-- TABLE -->
    <div class="box">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">
                Data Laporan
            </h5>

<a href="<?= base_url('admin/laporan/pdf?dari='.$dari.'&sampai='.$sampai) ?>" 
   class="btn btn-outline-dark btn-sm">

    📄 Export PDF

</a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Mekanik</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($laporan)): ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Tidak ada data laporan
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach($laporan as $l): ?>

                        <tr>

                            <td>
                                <?= esc($l['tanggal']) ?>
                            </td>

                            <td>
                                <?= esc($l['nama_user']) ?>
                            </td>

                            <td>
                                <?= esc($l['nama_mekanik']) ?>
                            </td>

                            <td>

                                <span class="badge bg-<?=
                                    $l['status']=='menunggu' ? 'warning' :
                                    ($l['status']=='proses' ? 'primary' :
                                    ($l['status']=='selesai' ? 'success' : 'danger'))
                                ?>">

                                    <?= ucfirst($l['status']) ?>

                                </span>

                            </td>

                            <td>

                                <strong>
                                    Rp <?= number_format($l['total_bayar'],0,',','.') ?>
                                </strong>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('laporanChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'Proses',
            'Selesai',
            'Batal'
        ],

        datasets: [{

            label: 'Jumlah Booking',

            data: [
                <?= $proses ?>,
                <?= $selesai ?>,
                <?= $batal ?>
            ],

            borderRadius: 14,

            borderSkipped: false,

            backgroundColor: [
                '#ff9800',
                '#16c47f',
                '#e60012'
            ],

            hoverBackgroundColor: [
                '#ffb340',
                '#1fdd8c',
                '#ff1f34'
            ]

        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            }

        },

        scales: {

            y: {

                beginAtZero: true,

                ticks: {
                    precision: 0
                },

                grid: {
                    color: '#f1f1f1'
                }

            },

            x: {

                grid: {
                    display: false
                }

            }

        }

    }

});

</script>

</body>
</html>
```
