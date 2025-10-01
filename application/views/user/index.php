<?php $this->load->view('partials/sidebar'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
.table-user th, .table-user td {
    white-space: nowrap;
    vertical-align: middle;
}
.table-user td.data-cell {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.table-user td.aksi-cell {
    white-space: nowrap;
}
@media (max-width: 991px) {
    .table-user th, .table-user td { font-size: 13px; }
}
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar User</h2>
                <?php if ($this->session->userdata('role') === 'superadmin'): ?>
                <a href="<?= base_url('user/add') ?>" class="btn btn-primary float-end mb-3">Tambah User</a>
                <?php endif; ?>
            </div>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
            <?php endif; ?>
            <form class="row g-2 mb-3" method="get">
                <div class="col-md-3">
                    <input type="text" name="q" class="form-control" placeholder="Cari nama/email/role/divisi..." value="<?= htmlspecialchars($q ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-user">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Staff</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Pendidikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="12" class="text-center">Tidak ada data</td></tr>
                        <?php else: foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u->staff_nama) ?></td>
                                <td><?= htmlspecialchars($u->email) ?></td>
                                <td><?= htmlspecialchars($u->jabatan) ?></td>
                                <td><?= htmlspecialchars($u->pendidikan) ?></td>
                                <td>
                                    <?php $login_id = $this->session->userdata('user_id'); ?>
                                    <?php if ($u->id != $login_id): ?>
                                    <button class="btn btn-primary btn-sm" onclick="openChatWithUser(<?= $u->id ?>, '<?= htmlspecialchars($u->staff_nama) ?>')">
                                        <i class="fas fa-comments"></i> Hubungi via Chat
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function openChatWithUser(userId, userName) {
    // Buka chatbox dan pilih user
    document.getElementById('floating-chat-popup').style.display = 'block';
    let select = document.getElementById('chat-user-select');
    select.value = userId;
    // Trigger event change agar chatbox benar-benar diarahkan ke user
    let event = new Event('change', { bubbles: true });
    select.dispatchEvent(event);
    // Scroll ke chatbox jika perlu
    setTimeout(function(){
        document.getElementById('floating-chat-popup').scrollIntoView({behavior:'smooth'});
    }, 200);
}
</script>
</body>
</html> 