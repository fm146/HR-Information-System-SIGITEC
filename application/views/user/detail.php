<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @media (max-width: 991.98px) {
      #mainContent { margin-left: 0 !important; }
    }
    @media (min-width: 992px) {
      #mainContent { margin-left: 220px !important; }
    }
    </style>
</head>
<body class="bg-light">
    <div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Detail User & Staff</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Username</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->username ?? '') ?> </dd>
                                <dt class="col-sm-4">Role</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->role_nama ?? '') ?> </dd>
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->staff_nama ?? '') ?> </dd>
                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->email ?? '') ?> </dd>
                                <dt class="col-sm-4">Divisi</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->divisi_nama ?? '') ?> </dd>
                                <dt class="col-sm-4">Jabatan</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->jabatan ?? '') ?> </dd>
                                <dt class="col-sm-4">Pendidikan</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->pendidikan ?? '') ?> </dd>
                                <dt class="col-sm-4">Telepon</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->telepon ?? '') ?> </dd>
                                <dt class="col-sm-4">Rekening ATM</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->rekening_atm ?? '') ?> </dd>
                                <dt class="col-sm-4">No. KTP</dt>
                                <dd class="col-sm-8"> <?= htmlspecialchars($user->no_ktp ?? '') ?> </dd>
                                <dt class="col-sm-4">Gaji Bulanan</dt>
                                <dd class="col-sm-8"> <?= isset($user->gaji_bulanan) ? number_format($user->gaji_bulanan,0,',','.') : '' ?> </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Rekap Gaji Bulanan</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Jumlah (Rp)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($rekap_gaji)): ?>
                                            <tr><td colspan="3" class="text-center">Tidak ada data gaji</td></tr>
                                        <?php else: foreach ($rekap_gaji as $g): ?>
                                            <tr>
                                                <td><?= date('F Y', strtotime($g->tanggal)) ?></td>
                                                <td><?= number_format($g->jumlah,0,',','.') ?></td>
                                                <td><?= htmlspecialchars($g->keterangan ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary mt-3">Kembali ke Daftar User</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 