<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form User</title>
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
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h4><?= isset($user) ? 'Edit User' : 'Tambah User' ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
                            <?php endif; ?>
                            <form action="<?= isset($user) ? base_url('user/edit_action/'.$user->id) : base_url('user/add_action') ?>" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= isset($user) ? htmlspecialchars($user->username) : '' ?>" required <?= isset($user) ? 'readonly' : '' ?> >
                                </div>
                                <?php if (!isset($user)): ?>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Role</label>
                                    <select class="form-select" id="role_id" name="role_id" required>
                                        <option value="">-- Pilih Role --</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role->id ?>" <?= (isset($user) && $user->role_id == $role->id) ? 'selected' : '' ?>><?= ucfirst($role->nama) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff Terkait</label>
                                    <select class="form-select" id="staff_id" name="staff_id">
                                        <option value="">-- Staff Baru --</option>
                                        <?php foreach ($staffs as $staff): ?>
                                            <option value="<?= $staff->id ?>" <?= (isset($user) && $user->staff_id == $staff->id) ? 'selected' : '' ?>><?= htmlspecialchars($staff->nama) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (isset($user)): ?>
                                    <!-- Mode edit: field staff selalu tampil -->
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user->staff_nama ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->email ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="divisi_id" class="form-label">Divisi</label>
                                        <select class="form-select" id="divisi_id" name="divisi_id">
                                            <option value="">-- Pilih Divisi --</option>
                                            <?php foreach ($divisi_list as $i => $divisi): ?>
                                                <option value="<?= $i+1 ?>" <?= ($user->divisi_id ?? '') == ($i+1) ? 'selected' : '' ?>><?= ucfirst($divisi) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Job Section</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= htmlspecialchars($user->jabatan ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="telepon" name="telepon" value="<?= htmlspecialchars($user->telepon ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rekening_atm" class="form-label">Rekening ATM</label>
                                        <input type="text" class="form-control" id="rekening_atm" name="rekening_atm" value="<?= htmlspecialchars($user->rekening_atm ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_ktp" class="form-label">Nomor KTP</label>
                                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?= htmlspecialchars($user->no_ktp ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan</label>
                                        <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="<?= htmlspecialchars($user->pendidikan ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gaji_bulanan" class="form-label">Gaji (Manual per Bulan)</label>
                                        <input type="number" class="form-control" id="gaji_bulanan" name="gaji_bulanan" value="<?= htmlspecialchars($user->gaji_bulanan ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_masuk" class="form-label">Jam Masuk Khusus</label>
                                        <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= isset($user) ? htmlspecialchars($user->jam_masuk ?? '') : '' ?>">
                                        <small class="form-text text-muted">Kosongkan jika ingin ikut jam kerja default.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_pulang" class="form-label">Jam Pulang Khusus</label>
                                        <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" value="<?= isset($user) ? htmlspecialchars($user->jam_pulang ?? '') : '' ?>">
                                        <small class="form-text text-muted">Kosongkan jika ingin ikut jam kerja default.</small>
                                    </div>
                                <?php else: ?>
                                    <!-- Mode tambah: field staff baru hanya tampil jika staff_id kosong -->
                                    <div id="staffBaruFields" style="display:none;">
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="divisi_id" class="form-label">Divisi</label>
                                            <select class="form-select" id="divisi_id" name="divisi_id">
                                                <option value="">-- Pilih Divisi --</option>
                                                <?php foreach ($divisi_list as $i => $divisi): ?>
                                                    <option value="<?= $i+1 ?>"><?= ucfirst($divisi) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label">Job Section</label>
                                            <input type="text" class="form-control" id="jabatan" name="jabatan">
                                        </div>
                                        <div class="mb-3">
                                            <label for="telepon" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="telepon" name="telepon">
                                        </div>
                                        <div class="mb-3">
                                            <label for="rekening_atm" class="form-label">Rekening ATM</label>
                                            <input type="text" class="form-control" id="rekening_atm" name="rekening_atm">
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_ktp" class="form-label">Nomor KTP</label>
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="pendidikan" class="form-label">Pendidikan</label>
                                            <input type="text" class="form-control" id="pendidikan" name="pendidikan">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gaji_bulanan" class="form-label">Gaji (Manual per Bulan)</label>
                                            <input type="number" class="form-control" id="gaji_bulanan" name="gaji_bulanan">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jam_masuk" class="form-label">Jam Masuk Khusus</label>
                                            <input type="time" class="form-control" id="jam_masuk" name="jam_masuk">
                                            <small class="form-text text-muted">Kosongkan jika ingin ikut jam kerja default.</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jam_pulang" class="form-label">Jam Pulang Khusus</label>
                                            <input type="time" class="form-control" id="jam_pulang" name="jam_pulang">
                                            <small class="form-text text-muted">Kosongkan jika ingin ikut jam kerja default.</small>
                                        </div>
                                    </div>
                                    <script>
                                    // Tampilkan field staff baru jika staff_id kosong (mode tambah)
                                    const staffSelect = document.getElementById('staff_id');
                                    const staffBaruFields = document.getElementById('staffBaruFields');
                                    function toggleStaffBaruFields() {
                                        if (staffSelect.value === "") {
                                            staffBaruFields.style.display = '';
                                        } else {
                                            staffBaruFields.style.display = 'none';
                                        }
                                    }
                                    staffSelect.addEventListener('change', toggleStaffBaruFields);
                                    window.addEventListener('DOMContentLoaded', toggleStaffBaruFields);
                                    </script>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                <a href="<?= base_url('user') ?>" class="btn btn-secondary w-100 mt-2">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 