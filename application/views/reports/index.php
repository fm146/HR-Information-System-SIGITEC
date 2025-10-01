<?php $role = $this->session->userdata('role'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Masukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @media (max-width: 991.98px) { #mainContent { margin-left: 0 !important; } }
    @media (min-width: 992px) { #mainContent { margin-left: 220px !important; } }
    </style>
</head>
<body>
<?php $this->load->view('partials/sidebar'); ?>
<div class="main-content px-2 px-md-4" style="padding-top:24px;" id="mainContent">
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-md-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="mb-3"><i class="fas fa-file-alt"></i> Laporan & Masukan</h3>
            <?php if ($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if ($role != 'superadmin'): ?>
            <form method="post" action="<?= base_url('reports/submit') ?>" class="mb-4">
              <div class="mb-3">
                <label for="perihal" class="form-label">Perihal</label>
                <input type="text" class="form-control" id="perihal" name="perihal" required placeholder="Contoh: Gaji, Kasus, dll">
              </div>
              <div class="mb-3">
                <label for="isi" class="form-label">Tulis laporan atau masukan Anda</label>
                <textarea class="form-control" id="isi" name="isi" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
            </form>
            <h5>Riwayat Laporan/Masukan Anda</h5>
            <div class="list-group mb-2">
              <?php if (empty($reports)): ?>
                <div class="text-muted small px-2 py-3">Belum ada laporan/masukan.</div>
              <?php else: ?>
                <?php foreach ($reports as $r): ?>
                  <div class="list-group-item">
                    <div class="mb-1 text-secondary small"><?= date('d M Y H:i', strtotime($r->created_at)) ?> | <b><?= htmlspecialchars($r->perihal) ?></b></div>
                    <div><?= nl2br(htmlspecialchars($r->isi)) ?></div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <?php else: ?>
            <h5>Daftar Semua Laporan/Masukan Karyawan</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Perihal</th>
                    <th>Isi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($reports)): ?>
                    <tr><td colspan="4" class="text-center text-muted">Belum ada laporan/masukan.</td></tr>
                  <?php else: ?>
                    <?php foreach ($reports as $r): ?>
                      <tr>
                        <td><?= date('d M Y H:i', strtotime($r->created_at)) ?></td>
                        <td><?= htmlspecialchars(isset($r->username) ? $r->username : '-') ?></td>
                        <td><?= htmlspecialchars($r->perihal) ?></td>
                        <td><?= nl2br(htmlspecialchars($r->isi)) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- Tambahkan tabel pengajuan perizinan -->
            <h5 class="mt-4">Daftar Semua Pengajuan Perizinan</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Perihal</th>
                    <th>Alasan</th>
                    <th>Alasan Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($izin)): ?>
                    <tr><td colspan="5" class="text-center text-muted">Belum ada pengajuan perizinan.</td></tr>
                  <?php else: ?>
                    <?php foreach ($izin as $i): ?>
                      <tr>
                        <td><?= date('d M Y H:i', strtotime($i->created_at)) ?></td>
                        <td><?= htmlspecialchars(isset($i->username) ? $i->username : '-') ?></td>
                        <td><?= htmlspecialchars($i->perihal) ?></td>
                        <td><?= htmlspecialchars($i->alasan ?? '') ?></td>
                        <td><?= htmlspecialchars($i->alasan_detail ?? '') ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 