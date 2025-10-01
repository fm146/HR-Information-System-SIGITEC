<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - Divisi Saya</title>
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
<body class="bg-light">
    <?php $this->load->view('partials/sidebar'); ?>
    <div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
        <div class="container mt-4">
            <h2 class="mb-4">Attendance - Divisi Saya</h2>
            <form class="row g-2 mb-3" method="get">
                <div class="col-auto">
                    <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($tanggal) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Username</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status Masuk</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($presensi)): ?>
                            <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                        <?php else: foreach ($presensi as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->staff_nama) ?></td>
                                <td><?= htmlspecialchars($p->divisi_nama) ?></td>
                                <td><?= htmlspecialchars($p->username) ?></td>
                                <td><?= $p->jam_masuk ?></td>
                                <td><?= $p->jam_pulang ?></td>
                                <td><?= htmlspecialchars($p->status_final) ?></td>
                                <td><?= htmlspecialchars($p->status_pulang) ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 