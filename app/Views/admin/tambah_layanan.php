<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Layanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
}

/* GLASS CARD */
.form-box {
    width: 420px;
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.15);
    color: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* INPUT */
.form-control {
    border-radius: 10px;
    border: none;
    padding: 12px;
}

/* BUTTON */
.btn-primary {
    background: white;
    color: #ff4b2b;
    font-weight: bold;
    border: none;
}

.btn-primary:hover {
    background: #f1f1f1;
}

/* PREVIEW CARD */
.preview {
    background: white;
    color: black;
    padding: 15px;
    border-radius: 12px;
    margin-top: 15px;
    text-align: center;
}
</style>

</head>
<body>

<div class="form-box">

    <h4 class="mb-3 text-center">✨ Tambah Layanan</h4>

    <form action="<?= base_url('admin/layanan/simpan') ?>" method="post">

        <div class="mb-3">
            <input type="text" name="nama" id="nama" class="form-control"
                   placeholder="Nama layanan" required>
        </div>

        <div class="mb-3">
            <input type="number" name="harga" id="harga" class="form-control"
                   placeholder="Harga" required>
        </div>

        <button class="btn btn-primary w-100">Simpan</button>

        <a href="<?= base_url('admin/layanan') ?>" class="btn btn-light w-100 mt-2">
            Kembali
        </a>

    </form>

    <!-- 🔥 LIVE PREVIEW -->
    <div class="preview mt-4">
        <strong id="previewNama">Nama Layanan</strong><br>
        <span id="previewHarga">Rp 0</span>
    </div>

</div>

<script>
const nama = document.getElementById('nama');
const harga = document.getElementById('harga');

nama.addEventListener('input', () => {
    document.getElementById('previewNama').innerText =
        nama.value || 'Nama Layanan';
});

harga.addEventListener('input', () => {
    let val = harga.value.replace(/\D/g,'');
    document.getElementById('previewHarga').innerText =
        'Rp ' + Number(val).toLocaleString('id-ID');
});
</script>

</body>
</html>