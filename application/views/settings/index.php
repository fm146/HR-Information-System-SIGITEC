<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @media (max-width: 991.98px) { #mainContent { margin-left: 0 !important; } }
    @media (min-width: 992px) { #mainContent { margin-left: 220px !important; } }
    </style>
</head>
<body class="bg-light">
    <div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
        <div class="container mt-4">
            <h2 class="mb-4">Pengaturan Sistem</h2>
            <?php if ($msg): ?>
                <div class="alert alert-info"> <?= $msg ?> </div>
            <?php endif; ?>
            <form method="post" class="row g-3" style="max-width:400px;">
                <div class="col-12">
                    <label for="timezone" class="form-label">Timezone Server</label>
                    <select name="timezone" id="timezone" class="form-select" required>
                        <?php foreach ($timezones as $tz): ?>
                            <option value="<?= $tz ?>" <?= $current_timezone == $tz ? 'selected' : '' ?>><?= $tz ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            <div class="mt-4">
                <h5>Timezone Aktif:</h5>
                <div class="alert alert-secondary"> <?= $current_timezone ?> </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 