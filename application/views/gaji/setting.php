<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Gaji per Jam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Pengaturan Gaji per Jam</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
                        <?php endif; ?>
                        <form action="<?= base_url('auth/gaji_setting_action') ?>" method="post">
                            <div class="mb-3">
                                <label for="nominal_per_jam" class="form-label">Nominal Gaji per Jam (Rp)</label>
                                <input type="number" class="form-control" id="nominal_per_jam" name="nominal_per_jam" min="1" value="<?= $gaji_per_jam ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 