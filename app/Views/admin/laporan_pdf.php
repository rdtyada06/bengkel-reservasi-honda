<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bengkel Honda</title>

<style>
body{
    font-family: Arial, sans-serif;
    font-size: 13px;
    color:#333;
}

.header{
    text-align:center;
    margin-bottom:25px;
}

.header h2{
    margin:0;
    color:#e60012;
}

.header p{
    margin-top:5px;
    color:#777;
}

.info{
    margin-bottom:20px;
}

.info table{
    width:100%;
}

.info td{
    padding:4px 0;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#e60012;
    color:white;
    padding:10px;
    text-align:left;
}

table td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

/* STATUS */
.status{
    padding:4px 8px;
    border-radius:6px;
    font-size:11px;
    color:white;
}

.menunggu{
    background:orange;
}

.proses{
    background:#0d6efd;
}

.selesai{
    background:green;
}

.batal{
    background:red;
}

/* TOTAL */
.total-box{
    margin-top:25px;
    width:300px;
    margin-left:auto;
}

.total-box table td{
    border:none;
    padding:6px 0;
}

.footer{
    margin-top:40px;
    text-align:right;
}

</style>

</head>
<body>

<!-- HEADER -->
<div class="header">

    <h2>HONDA SERVICE</h2>

    <p>
        Laporan Reservasi Bengkel
    </p>

</div>

<!-- INFO -->
<div class="info">

    <table>

        <tr>
            <td width="150">
                Tanggal Cetak
            </td>

            <td>
                : <?= date('d M Y') ?>
            </td>
        </tr>

        <tr>
            <td>
                Total Data
            </td>

            <td>
                : <?= count($laporan) ?> Booking
            </td>
        </tr>

    </table>

</div>

<!-- TABLE -->
<table>

    <thead>

        <tr>
            <th width="40">No</th>
            <th>Tanggal</th>
            <th>User</th>
            <th>Mekanik</th>
            <th>Status</th>
            <th>Total</th>
        </tr>

    </thead>

    <tbody>

        <?php
        $no = 1;
        $totalPendapatan = 0;
        ?>

        <?php foreach($laporan as $l): ?>

            <?php
            if($l['status'] == 'selesai'){
                $totalPendapatan += $l['total_bayar'];
            }
            ?>

            <tr>

                <td>
                    <?= $no++ ?>
                </td>

                <td>
                    <?= date('d M Y', strtotime($l['tanggal'])) ?>
                </td>

                <td>
                    <?= esc($l['nama_user']) ?>
                </td>

                <td>
                    <?= esc($l['nama_mekanik']) ?>
                </td>

                <td>

                    <span class="status <?= $l['status'] ?>">

                        <?= ucfirst($l['status']) ?>

                    </span>

                </td>

                <td>

                    Rp <?= number_format($l['total_bayar'],0,',','.') ?>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<!-- TOTAL -->
<div class="total-box">

    <table>

        <tr>

            <td>
                <strong>Total Pendapatan</strong>
            </td>

            <td align="right">

                <strong>
                    Rp <?= number_format($totalPendapatan,0,',','.') ?>
                </strong>

            </td>

        </tr>

    </table>

</div>

<!-- FOOTER -->
<div class="footer">

    <p>
        Dicetak oleh Admin Honda Service
    </p>

</div>

</body>
</html>