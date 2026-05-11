<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>

        body{
            font-family: Arial, sans-serif;
            color:#333;
            font-size:14px;
        }

        .header{
            text-align:center;
            margin-bottom:30px;
        }

        .header h2{
            color:#e60012;
            margin-bottom:5px;
        }

        .box{
            border:1px solid #ddd;
            border-radius:10px;
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            padding:12px;
            border-bottom:1px solid #eee;
        }

        .label{
            width:40%;
            font-weight:bold;
        }

        .total{
            font-size:18px;
            color:#e60012;
            font-weight:bold;
        }

        .footer{
            margin-top:30px;
            text-align:center;
            font-size:12px;
            color:#777;
        }

    </style>

</head>

<body>

<div class="header">

    <h2>Invoice Servis Kendaraan</h2>

    <p>Reservasi Bengkel Honda</p>

</div>

<div class="box">

    <table>

        <tr>
            <td class="label">Kode Invoice</td>
            <td><?= $booking['kode_invoice'] ?></td>
        </tr>

        <tr>
            <td class="label">Nama Customer</td>
            <td><?= $booking['nama_user'] ?></td>
        </tr>

        <tr>
            <td class="label">No Polisi</td>
            <td><?= $booking['no_polisi'] ?></td>
        </tr>

        <tr>
            <td class="label">Tanggal Booking</td>
            <td><?= $booking['tanggal'] ?></td>
        </tr>

        <tr>
            <td class="label">Jam Booking</td>
            <td><?= $booking['jam'] ?></td>
        </tr>

        <tr>
            <td class="label">Mekanik</td>
            <td><?= $booking['nama_mekanik'] ?></td>
        </tr>

        <tr>
            <td class="label">Status</td>
            <td><?= ucfirst($booking['status']) ?></td>
        </tr>

        <tr>
            <td class="label">Total Bayar</td>
            <td class="total">
                Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?>
            </td>
        </tr>

    </table>

</div>

<div class="footer">

    Terima kasih telah menggunakan layanan Bengkel Honda.

</div>

</body>
</html>