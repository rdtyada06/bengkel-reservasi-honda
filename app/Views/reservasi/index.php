<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reservasi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('<?= base_url("assets/images/bengkel.png") ?>') no-repeat center center/cover;
}

/* OVERLAY */
.overlay {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(4px);
    min-height: 100vh;
    padding: 40px 0;
}

/* CARD */
.card-reservasi {
    max-width: 650px;
    margin: auto;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* SECTION */
.section-title {
    font-weight: 600;
    margin-top: 20px;
    margin-bottom: 10px;
}

/* INPUT */
.form-control {
    border-radius: 10px;
}

/* LAYANAN */
.layanan-box {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 8px;
    transition: 0.2s;
    cursor: pointer;
}

.layanan-box:hover {
    background: #f9f9f9;
}

/* BUTTON */
.btn-honda {
    background: #e60012;
    color: white;
    border-radius: 12px;
    font-weight: bold;
}

.btn-honda:hover {
    background: #c4000f;
}
</style>

</head>
<body>

<div class="overlay">

    <div class="container">

        <div class="card card-reservasi p-4">

            <h4 class="text-center mb-2">Reservasi Servis</h4>
            <p class="text-center text-muted">Isi data untuk booking bengkel</p>

            <!-- SUCCESS -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/reservasi/simpan') ?>" method="post">

                <!-- KENDARAAN -->
                <div class="section-title"> Pilih Kendaraan</div>
                <select name="no_polisi" class="form-control mb-3" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    <?php foreach($kendaraan as $k): ?>
                        <option value="<?= $k['no_polisi'] ?>">
                            <?= $k['no_polisi'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- MEKANIK -->
                <div class="section-title"> Pilih Mekanik</div>
                <select name="id_mekanik"
                        id="mekanik"
                        class="form-control mb-3"
                        required>                    
                    <option value="">-- Pilih Mekanik --</option>
                    <?php foreach($mekanik as $m): ?>
                        <option value="<?= $m['id_mekanik'] ?>">
                            <?= $m['nama_mekanik'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- LAYANAN -->
                <div class="section-title"> Pilih Layanan</div>
                <?php foreach($layanan as $l): ?>
                    <label class="layanan-box d-block">
                        <input 
                            type="checkbox" 
                            name="layanan[]" 
                            value="<?= $l['id_layanan'] ?>"
                        >
                        <?= $l['nama_layanan'] ?>
                        <span class="float-end text-danger">
                            Rp <?= number_format($l['harga'], 0, ',', '.') ?>
                        </span>
                    </label>
                <?php endforeach; ?>

                <!-- JADWAL -->
                <div class="section-title"> Jadwal Servis</div>
                <input type="date"
                    name="tanggal"
                    id="tanggal"
                    class="form-control mb-2"
                    required>                
                    <select name="jam"
                    id="jam"
                    class="form-control mb-3"
                    required>

                <option value="">
                    -- Pilih Jam --
                </option>

            </select>
                <!-- BUTTON -->
                <button class="btn btn-honda w-100">
                    Booking Sekarang
                </button>

            </form>

            <!-- BACK -->
            <div class="text-center mt-3">
                <a href="<?= base_url('user/dashboard') ?>" class="text-decoration-none">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>

    </div>

</div>

<script>

function loadJam() {

    let tanggal = document.getElementById('tanggal').value;
    let mekanik = document.getElementById('mekanik').value;

    if(tanggal && mekanik){

        fetch(
            `<?= base_url('cek-jam') ?>?tanggal=${tanggal}&mekanik=${mekanik}`
        )

        .then(response => response.json())

        .then(data => {

            let jamSelect = document.getElementById('jam');

            jamSelect.innerHTML =
                '<option value="">-- Pilih Jam --</option>';

            if(data.length === 0){

                jamSelect.innerHTML += `
                    <option disabled>
                        Semua jam penuh
                    </option>
                `;

            } else {

                data.forEach(function(jam){

                    jamSelect.innerHTML += `
                        <option value="${jam}">
                            ${jam.substring(0,5)}
                        </option>
                    `;

                });

            }

        });

    }
}

// EVENT
document.getElementById('tanggal')
    .addEventListener('change', loadJam);

document.getElementById('mekanik')
    .addEventListener('change', loadJam);

</script>
</body>
</html>