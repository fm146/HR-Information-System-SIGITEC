<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penggajian - Superadmin</title>
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
            <h2 class="mb-4">Rekap Penggajian Staff</h2>
            <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-2" method="post" action="<?= base_url('auth/generate_gaji_bulanan') ?>">
                        <div class="col-md-4">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select" required>
                                <?php for (
                                    $i=1; $i<=12; $i++): ?>
                                    <option value="<?= sprintf('%02d', $i) ?>" <?= $filter['bulan']==sprintf('%02d', $i)?'selected':'' ?>><?= date('F', mktime(0,0,0,$i,1)) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $filter['tahun'] ?>" required>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-coins"></i> Generate Gaji Bulanan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Inline filter nama + hari kerja dalam satu form baris -->
            <form method="get" class="d-flex align-items-center flex-wrap gap-2 mb-4">
                <input type="text" name="nama" class="form-control" placeholder="Nama Staff" value="<?= htmlspecialchars($filter['nama'] ?? '') ?>" style="min-width:180px;max-width:220px;">
                <button type="submit" class="btn btn-primary">Cari</button>
                <?php if ($this->session->userdata('role') === 'superadmin'): ?>
                    <span class="ms-2">Hari Kerja Bulan Ini</span>
                    <input type="number" min="1" max="31" class="form-control" style="width:80px;" id="jumlah_hari_kerja" name="jumlah_hari_kerja" value="<?= isset($jumlah_hari_kerja) ? $jumlah_hari_kerja : HARI_AKTIF_KERJA_DEFAULT ?>">
                    <input type="hidden" name="bulan" value="<?= $filter['bulan'] ?>">
                    <input type="hidden" name="tahun" value="<?= $filter['tahun'] ?>">
                    <button type="submit" formaction="" formmethod="post" class="btn btn-success">Simpan Hari Kerja</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary ms-auto" onclick="printRekapTable()"><i class="fas fa-print"></i> Print Report</button>
            </form>

            <!-- Tabel rekap -->
            <div class="table-responsive" id="rekapTablePrintArea">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Role</th>
                            <th>Bulan</th>
                            <th>Jam Kerja</th>
                            <th>Jumlah Hari Kerja</th>
                            <th>Gaji (Rp)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rekap)): ?>
                            <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
                        <?php else: foreach ($rekap as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r->staff_nama) ?></td>
                                <td><?= htmlspecialchars($r->divisi_nama) ?></td>
                                <td><?= htmlspecialchars($r->role_nama) ?></td>
                                <td><?= date('F Y', strtotime($r->tanggal)) ?></td>
                                <td><?= $r->total_jam ?></td>
                                <td><?= isset($r->total_hari_kerja) ? $r->total_hari_kerja : 0 ?></td>
                                <td><?= number_format($r->jumlah,0,',','.') ?></td>
                                <td><?= htmlspecialchars($r->keterangan) ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Floating Alerts (Notifikasi) -->
            <div id="floating-alerts" style="position:fixed;right:24px;bottom:24px;z-index:9999;min-width:320px;max-width:90vw;">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mb-2"> <?= $this->session->flashdata('success') ?> </div>
                <?php endif; ?>
                <?php if (isset($msg_hari_kerja) && $msg_hari_kerja): ?>
                    <div class="alert alert-info mb-2"> <?= $msg_hari_kerja ?> </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = 0;
                setTimeout(function() { alert.style.display = 'none'; }, 500);
            });
        }, 1000);

        // Auto-hide floating alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('#floating-alerts .alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = 0;
                setTimeout(function() { alert.style.display = 'none'; }, 500);
            });
        }, 1000);

        // Print only the rekap table
        function printRekapTable() {
            var printContents = document.getElementById('rekapTablePrintArea').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</body>
</html> 