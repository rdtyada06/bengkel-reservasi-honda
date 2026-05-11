<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

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
    border-radius:20px;
    padding:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.card-ui{
    text-align:center;
    transition:0.2s;
}

.card-ui:hover{
    transform:translateY(-3px);
}

/* STAT */
.card-ui h4{
    font-weight:700;
    margin-bottom:8px;
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
    padding:8px 12px;
    border-radius:10px;
    font-size:12px;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h5>ADMIN HONDA</h5>

    <a href="<?= base_url('admin/dashboard') ?>" class="active">
        Dashboard
    </a>

    <a href="<?= base_url('admin/booking') ?>">
         Booking
    </a>

    <a href="<?= base_url('admin/mekanik') ?>">
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
    <div class="page-title mb-4">

        <h3>Halo Admin 👋</h3>

        <p>
            Ringkasan data sistem reservasi bengkel Honda
        </p>

    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card-ui">

                <h4><?= $total_booking ?></h4>

                <small class="text-muted">
                    Total Booking
                </small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">

                <h4><?= $menunggu ?></h4>

                <small class="text-muted">
                    Menunggu
                </small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">

                <h4><?= $proses ?? 0 ?></h4>

                <small class="text-muted">
                    Proses
                </small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-ui">

                <h4><?= $selesai ?></h4>

                <small class="text-muted">
                    Selesai
                </small>

            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="row g-4">

        <!-- STATUS -->
        <div class="col-md-6">

            <div class="box">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="mb-0">
                        Grafik Status Booking
                    </h5>

                </div>

                <canvas id="chartStatus"></canvas>

            </div>

        </div>

        <!-- TANGGAL -->
        <div class="col-md-6">

            <div class="box">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="mb-0">
                        Booking per Tanggal
                    </h5>

                    <form method="get">

                        <select name="filter"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                            <option value="">Semua</option>

                            <option value="7"
                                <?= ($filter=='7')?'selected':'' ?>>

                                7 Hari

                            </option>

                            <option value="30"
                                <?= ($filter=='30')?'selected':'' ?>>

                                30 Hari

                            </option>

                        </select>

                    </form>

                </div>

                <canvas id="chartTanggal"></canvas>

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="box mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">
                Booking Terbaru
            </h5>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>
                        <th>No Polisi</th>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach($booking as $b): ?>

                    <tr>

                        <td>
                            <strong>
                                <?= esc($b['no_polisi']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= esc($b['nama_user']) ?>
                        </td>

                        <td>
                            <?= esc($b['tanggal']) ?>
                        </td>

                        <td>

                            <span class="badge bg-<?=
                                $b['status']=='menunggu' ? 'warning' :
                                ($b['status']=='proses' ? 'primary' :
                                ($b['status']=='selesai' ? 'success' : 'danger'))
                            ?>">

                                <?= ucfirst($b['status']) ?>

                            </span>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
// BAR CHART
new Chart(document.getElementById('chartStatus'), {

    type: 'bar',

    data: {

        labels: [
            'Menunggu',
            'Proses',
            'Selesai',
            'Batal'
        ],

        datasets: [{
            data: [
                <?= $chart_status['menunggu'] ?? 0 ?>,
                <?= $chart_status['proses'] ?? 0 ?>,
                <?= $chart_status['selesai'] ?? 0 ?>,
                <?= $chart_status['batal'] ?? 0 ?>
            ],
            borderRadius: 10
        }]
    }

});

// LINE CHART
new Chart(document.getElementById('chartTanggal'), {

    type: 'line',

    data: {

        labels: <?= json_encode($chart_tanggal ?? []) ?>,

        datasets: [{
            data: <?= json_encode($chart_total ?? []) ?>,
            tension: 0.3,
            fill: false
        }]
    }

});
</script>

</body>
</html>