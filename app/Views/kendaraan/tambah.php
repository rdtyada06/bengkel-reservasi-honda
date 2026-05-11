<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3>Tambah Kendaraan</h3>

    <form action="<?= base_url('user/kendaraan/simpan') ?>" method="post">

        <div class="mb-3">
            <label>No Polisi</label>
            <input type="text" name="no_polisi" class="form-control" required>
        </div>

        <button class="btn btn-danger">Simpan</button>

        <!-- 🔥 TAMBAHKAN INI -->
        <a href="<?= base_url('user/kendaraan') ?>" class="btn btn-secondary mt-2">
            Kembali
        </a>

    </form>

</div>

</body>
</html>