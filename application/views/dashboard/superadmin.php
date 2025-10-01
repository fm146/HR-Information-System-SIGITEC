<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @media (max-width: 991.98px) {
      #mainContent { margin-left: 0 !important; }
    }
    @media (min-width: 992px) {
      #mainContent { margin-left: 220px !important; }
    }
    </style>
</head>
<body>
    <?php $this->load->view('partials/sidebar'); ?>
    <div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">Super Admin Dashboard</h1>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success mt-3"> <?= $this->session->flashdata('success') ?> </div>
                    <?php endif; ?>
                    <!-- Card Today's Status -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Today's Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center mb-4">
                                        <h4>Check In Time</h4>
                                        <?php if (isset($presensi_today) && $presensi_today && $presensi_today->jam_masuk): ?>
                                            <h2 class="<?= ($presensi_today->jam_masuk > $jam_masuk_default) ? 'text-danger' : 'text-success' ?>">
                                                <?= date('H:i', strtotime($presensi_today->jam_masuk)) ?>
                                                <?= ($presensi_today->jam_masuk > $jam_masuk_default) ? '<span style="font-size:16px;">Terlambat</span>' : '' ?>
                                            </h2>
                                            <p class="text-muted">Today, <?= date('d M Y') ?></p>
                                        <?php else: ?>
                                            <h2 class="text-secondary">-</h2>
                                            <p class="text-danger">Belum Check In</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center mb-4">
                                        <h4>Check Out Time</h4>
                                        <?php if (isset($presensi_today) && $presensi_today && $presensi_today->jam_pulang): ?>
                                            <h2 class="text-primary">
                                                <?= date('H:i', strtotime($presensi_today->jam_pulang)) ?>
                                            </h2>
                                            <p class="text-success">Sudah Pulang</p>
                                        <?php elseif (isset($presensi_today) && $presensi_today && $presensi_today->jam_masuk): ?>
                                            <h2 class="text-secondary">-</h2>
                                            <p class="text-warning">Belum Check Out</p>
                                        <?php else: ?>
                                            <h2 class="text-secondary">-</h2>
                                            <p class="text-muted">Expected</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <form method="post" action="<?= base_url('presensi/check_in') ?>" style="display:inline;">
                                    <button type="submit" class="btn btn-success btn-lg me-2">
                                        <i class="fas fa-sign-in-alt"></i> Check In
                                    </button>
                                </form>
                                <form method="post" action="<?= base_url('presensi/check_out') ?>" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-lg">
                                        <i class="fas fa-sign-out-alt"></i> Check Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END Card Today's Status -->
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Recent Activities</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <?php if (empty($activities)): ?>
                                            <div class="list-group-item text-muted">Belum ada aktivitas.</div>
                                        <?php else: ?>
                                            <?php foreach ($activities as $a): ?>
                                                <div class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1"><?= htmlspecialchars($a->title) ?></h6>
                                                        <small><?= time_elapsed_string($a->created_at) ?></small>
                                                    </div>
                                                    <p class="mb-1"><?= htmlspecialchars($a->description) ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="<?= base_url('perizinan') ?>" class="btn btn-success">
                                            <i class="fas fa-envelope-open-text"></i> Ajukan Perizinan
                                        </a>
                                        <a href="<?= base_url('gaji') ?>" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export Rekap Gaji
                                        </a>
                                        <a href="<?= base_url('perizinan') ?>?resign=1" class="btn btn-warning">
                                            <i class="fas fa-sign-out-alt"></i> Ajukan Resign
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 