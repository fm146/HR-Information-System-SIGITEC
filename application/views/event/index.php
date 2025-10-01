<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event & Jadwal</title>
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
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h3 class="mb-3"><i class="fas fa-calendar-alt"></i> Event & Jadwal</h3>
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
            <?php if ($role == 'superadmin'): ?>
            <form method="post" action="<?= base_url('event/add') ?>" class="mb-4">
              <div class="row g-2">
                <div class="col-md-4">
                  <label for="judul" class="form-label">Judul Acara</label>
                  <input type="text" class="form-control" id="judul" name="judul" required>
                </div>
                <div class="col-md-3">
                  <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                  <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                </div>
                <div class="col-md-3">
                  <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                  <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                  <button type="submit" class="btn btn-primary w-100"><i class="fas fa-plus"></i> Tambah</button>
                </div>
              </div>
              <div class="mb-2 mt-2">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
              </div>
            </form>
            <?php endif; ?>
            <h5>Daftar Event/Jadwal</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Deskripsi</th>
                    <?php if ($role == 'superadmin'): ?><th>Aksi</th><?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($events)): ?>
                    <tr><td colspan="4" class="text-center text-muted">Belum ada event/acara.</td></tr>
                  <?php else: ?>
                    <?php foreach ($events as $e): ?>
                      <tr>
                        <td><b><?= htmlspecialchars($e->judul) ?></b></td>
                        <td><?= date('d M Y', strtotime($e->tanggal_mulai)) ?></td>
                        <td><?= date('d M Y', strtotime($e->tanggal_selesai)) ?></td>
                        <td><?= nl2br(htmlspecialchars($e->deskripsi)) ?></td>
                        <?php if ($role == 'superadmin'): ?>
                        <td>
                          <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editEventModal<?= $e->id ?>"><i class="fas fa-edit"></i></button>
                          <a href="<?= base_url('event/delete/'.$e->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus acara ini?')"><i class="fas fa-trash"></i></a>
                          <!-- Modal Edit Event -->
                          <div class="modal fade" id="editEventModal<?= $e->id ?>" tabindex="-1" aria-labelledby="editEventModalLabel<?= $e->id ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <form method="post" action="<?= base_url('event/edit/'.$e->id) ?>">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editEventModalLabel<?= $e->id ?>">Edit Acara</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="mb-2">
                                      <label class="form-label">Judul Acara</label>
                                      <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($e->judul) ?>" required>
                                    </div>
                                    <div class="mb-2">
                                      <label class="form-label">Tanggal Mulai</label>
                                      <input type="date" class="form-control" name="tanggal_mulai" value="<?= $e->tanggal_mulai ?>" required>
                                    </div>
                                    <div class="mb-2">
                                      <label class="form-label">Tanggal Selesai</label>
                                      <input type="date" class="form-control" name="tanggal_selesai" value="<?= $e->tanggal_selesai ?>" required>
                                    </div>
                                    <div class="mb-2">
                                      <label class="form-label">Deskripsi</label>
                                      <textarea class="form-control" name="deskripsi" rows="2"><?= htmlspecialchars($e->deskripsi) ?></textarea>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </td>
                        <?php endif; ?>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- Floating Alert -->
            <div id="event-alert-floating" style="display:none;position:fixed;right:32px;bottom:32px;z-index:9999;min-width:320px;max-width:90vw;"></div>
            <script>
            // Pindahkan alert ke floating bawah tabel jika ada
            window.addEventListener('DOMContentLoaded', function() {
              var alert = document.querySelector('.alert-dismissible');
              if(alert) {
                var floating = document.getElementById('event-alert-floating');
                floating.appendChild(alert);
                floating.style.display = 'block';
                setTimeout(function(){
                  alert.classList.remove('show');
                  setTimeout(function(){ floating.style.display = 'none'; }, 500);
                }, 1000);
              }
            });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 