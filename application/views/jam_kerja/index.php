<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Jam Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="main-content" style="margin-left:220px; padding-top:24px;">
        <div class="container mt-4">
            <h2 class="mb-4">Pengaturan Jam Kerja Default</h2>
            <?php if ($msg): ?>
                <div class="alert alert-info"> <?= $msg ?> </div>
            <?php endif; ?>
            <form method="post" class="row g-3" style="max-width:400px;">
                <div class="col-12">
                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" required value="<?= $jam_kerja->jam_masuk ?? '' ?>">
                </div>
                <div class="col-12">
                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" required value="<?= $jam_kerja->jam_pulang ?? '' ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            <?php if ($jam_kerja): ?>
                <div class="mt-4">
                    <h5>Jam Kerja Saat Ini:</h5>
                    <ul>
                        <li>Jam Masuk: <b><?= $jam_kerja->jam_masuk ?></b></li>
                        <li>Jam Pulang: <b><?= $jam_kerja->jam_pulang ?></b></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 