<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perizinan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @media (max-width: 991.98px) { #mainContent { margin-left: 0 !important; } }
    @media (min-width: 992px) { #mainContent { margin-left: 220px !important; } }
    </style>
</head>
<body class="bg-light">
    <div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
        <div class="container mt-4">
            <h2 class="mb-4">Perizinan</h2>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('perizinan/submit') ?>" id="form-izin">
                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <select name="perihal" id="perihal" class="form-select" required>
                        <option value="">-- Pilih Perihal --</option>
                        <option value="Izin Tidak Masuk">Izin Tidak Masuk</option>
                        <option value="Pengunduran Diri">Pengunduran Diri</option>
                    </select>
                </div>
                <div class="mb-3" id="alasan-izin-group" style="display:none;">
                    <label for="alasan" class="form-label">Alasan</label>
                    <select name="alasan" id="alasan" class="form-select">
                        <option value="">-- Pilih Alasan --</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Melahirkan">Melahirkan</option>
                        <option value="Keluarga Berduka">Keluarga Berduka</option>
                    </select>
                </div>
                <div class="mb-3" id="alasan-detail-group" style="display:none;">
                    <label for="alasan_detail" class="form-label">Alasan Detail</label>
                    <textarea name="alasan_detail" id="alasan_detail" class="form-control" rows="3" placeholder="Jelaskan alasan pengunduran diri..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan</button>
            </form>
            <hr>
            <h4>Riwayat Pengajuan Perizinan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Perihal</th>
                            <th>Alasan</th>
                            <th>Alasan Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($perizinan)): ?>
                            <tr><td colspan="4" class="text-center">Belum ada pengajuan</td></tr>
                        <?php else: foreach ($perizinan as $p): ?>
                            <tr>
                                <td><?= date('d-m-Y H:i', strtotime($p->created_at)) ?></td>
                                <td><?= htmlspecialchars($p->perihal) ?></td>
                                <td><?= htmlspecialchars($p->alasan ?? '') ?></td>
                                <td><?= htmlspecialchars($p->alasan_detail ?? '') ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('perihal').addEventListener('change', function() {
        var v = this.value;
        document.getElementById('alasan-izin-group').style.display = (v === 'Izin Tidak Masuk') ? '' : 'none';
        document.getElementById('alasan-detail-group').style.display = (v === 'Pengunduran Diri') ? '' : 'none';
    });
    </script>
</body>
</html> 