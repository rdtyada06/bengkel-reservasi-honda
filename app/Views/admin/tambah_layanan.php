<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Layanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    overflow:hidden;
    font-family:'Segoe UI', sans-serif;

    background:
        linear-gradient(
            rgba(0,0,0,0.25),
            rgba(0,0,0,0.25)
        ),
        url('<?= base_url("assets/images/bengkel.png") ?>');

    background-size:cover;
    background-position:center;
}

/* BLUR OVERLAY */
body::before{
    content:'';
    position:absolute;
    inset:0;

    backdrop-filter: blur(8px);

    background: rgba(255,255,255,0.08);

    z-index:0;
}

/* CARD */
.form-box{
    width:450px;
    position:relative;
    z-index:2;

    background: rgba(255,255,255,0.88);

    backdrop-filter: blur(14px);

    border-radius:28px;

    padding:35px;

    box-shadow:
        0 15px 40px rgba(0,0,0,0.12);

    border:1px solid rgba(255,255,255,0.3);
}

/* TITLE */
.title{
    text-align:center;
    margin-bottom:28px;
}

.title h3{
    font-weight:700;
    color:#222;
    margin-bottom:6px;
}

.title p{
    color:#777;
    font-size:14px;
}

/* ICON */
.icon{
    width:65px;
    height:65px;

    background:#ffe5e8;

    color:#e60012;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:20px;

    font-size:30px;

    margin:auto;
    margin-bottom:18px;
}

/* LABEL */
.form-label{
    font-weight:600;
    color:#444;
    margin-bottom:8px;
}

/* INPUT */
.form-control{
    border-radius:16px;
    padding:14px;
    border:1px solid #ddd;
    transition:0.25s;
    font-size:15px;
}

.form-control:focus{
    border-color:#e60012;
    box-shadow:
        0 0 0 4px rgba(230,0,18,0.08);
}

/* BUTTON */
.btn-honda{
    background:#e60012;
    color:white;
    border:none;
    border-radius:16px;
    padding:13px;
    font-weight:600;
    transition:0.3s;
}

.btn-honda:hover{
    background:#c4000f;
    color:white;
    transform:translateY(-1px);
}

/* BACK BUTTON */
.btn-back{
    border-radius:16px;
    padding:13px;
    font-weight:600;
    background:white;
}

/* PREVIEW */
.preview-box{
    margin-top:28px;

    background:white;

    border-radius:20px;

    padding:22px;

    border:1px solid #eee;

    box-shadow:
        0 4px 15px rgba(0,0,0,0.03);
}

.preview-title{
    font-size:13px;
    color:#888;
    margin-bottom:12px;
}

.preview-layanan{
    font-size:22px;
    font-weight:700;
    color:#222;
}

.preview-harga{
    margin-top:5px;

    color:#e60012;

    font-size:19px;

    font-weight:600;
}

/* RESPONSIVE */
@media(max-width:500px){

    .form-box{
        width:92%;
        padding:28px;
    }

}

</style>

</head>
<body>

<div class="form-box">

    <!-- TITLE -->
    <div class="title">

        <div class="icon">
            ➕
        </div>

        <h3>Tambah Layanan</h3>

        <p>
            Tambahkan layanan baru untuk bengkel
        </p>

    </div>

    <!-- FORM -->
    <form action="<?= base_url('admin/layanan/simpan') ?>"
          method="post">

        <!-- NAMA -->
        <div class="mb-3">

            <label class="form-label">
                Nama Layanan
            </label>

            <input type="text"
                   name="nama"
                   id="nama"
                   class="form-control"
                   placeholder="Contoh: Servis Lengkap"
                   required>

        </div>

        <!-- HARGA -->
        <div class="mb-4">

            <label class="form-label">
                Harga Layanan
            </label>

            <input type="number"
                   name="harga"
                   id="harga"
                   class="form-control"
                   placeholder="Contoh: 150000"
                   required>

        </div>

        <!-- BUTTON -->
        <button class="btn btn-honda w-100">

            Simpan Layanan

        </button>

        <a href="<?= base_url('admin/layanan') ?>"
           class="btn btn-light border w-100 mt-2 btn-back">

            Kembali

        </a>

    </form>

    <!-- PREVIEW -->
    <div class="preview-box">

        <div class="preview-title">
            Preview Layanan
        </div>

        <div class="preview-layanan"
             id="previewNama">

            Nama Layanan

        </div>

        <div class="preview-harga"
             id="previewHarga">

            Rp 0

        </div>

    </div>

</div>

<script>

const nama = document.getElementById('nama');
const harga = document.getElementById('harga');

nama.addEventListener('input', () => {

    document.getElementById('previewNama')
        .innerText =
        nama.value || 'Nama Layanan';

});

harga.addEventListener('input', () => {

    let val = harga.value.replace(/\\D/g,'');

    document.getElementById('previewHarga')
        .innerText =
        'Rp ' + Number(val).toLocaleString('id-ID');

});

</script>

</body>
</html>