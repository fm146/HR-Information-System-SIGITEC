<?php
$role = $this->session->userdata('role');
$username = $this->session->userdata('username');
?>
<!-- Sidebar Offcanvas for mobile -->
<div class="d-lg-none">
  <button class="btn btn-primary m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
    <i class="fas fa-bars"></i> Menu
  </button>
  <div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel" style="width:220px;">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarOffcanvasLabel"><i class="fas fa-users"></i> HRIS Sigma</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="<?= base_url('dashboard/'.strtolower($role)) ?>" class="nav-link text-white">
            <i class="fas fa-home"></i> Dashboard
          </a>
        </li>
        <?php if ($role == 'superadmin' || $role == 'admin'): ?>
        <li>
          <a href="<?= base_url('user') ?>" class="nav-link text-white">
            <i class="fas fa-users"></i> Users
          </a>
        </li>
        <?php endif; ?>
        <?php if ($role == 'superadmin'): ?>
        <li>
          <a href="<?= base_url('gaji') ?>" class="nav-link text-white">
            <i class="fas fa-money-bill"></i> Penggajian
          </a>
        </li>
        <li>
          <a href="<?= base_url('attendance/index') ?>" class="nav-link text-white">
            <i class="fas fa-calendar-check"></i> Attendance
          </a>
        </li>
        <li>
          <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
            <i class="fas fa-envelope-open-text"></i> Perizinan
          </a>
        </li>
        <?php elseif ($role == 'admin'): ?>
        <li>
          <a href="<?= base_url('gaji/my') ?>" class="nav-link text-white">
            <i class="fas fa-money-bill"></i> Penggajian
          </a>
        </li>
        <li>
          <a href="<?= base_url('attendance/divisi') ?>" class="nav-link text-white">
            <i class="fas fa-calendar-check"></i> Attendance
          </a>
        </li>
        <li>
          <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
            <i class="fas fa-envelope-open-text"></i> Perizinan
          </a>
        </li>
        <?php endif; ?>
        <?php if ($role == 'staff'): ?>
        <li>
          <a href="<?= base_url('gaji/my') ?>" class="nav-link text-white">
            <i class="fas fa-money-bill"></i> Penggajian
          </a>
        </li>
        <li>
          <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
            <i class="fas fa-envelope-open-text"></i> Pengajuan
          </a>
        </li>
        <?php endif; ?>
        <li>
          <a href="<?= base_url('event') ?>" class="nav-link text-white">
            <i class="fas fa-calendar-alt"></i> Event
          </a>
        </li>
        <li>
          <a href="<?= base_url('reports') ?>" class="nav-link text-white">
            <i class="fas fa-file-alt"></i> Reports
          </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle fa-2x me-2"></i>
          <strong><?= $username ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Sidebar fixed for desktop -->
<div class="d-none d-lg-block">
  <div class="d-flex flex-column flex-shrink-0 p-3 bg-primary text-white position-fixed" style="width: 220px; height: 100vh;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <span class="fs-4"><i class="fas fa-users"></i> HRIS Sigma</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="<?= base_url('dashboard/'.strtolower($role)) ?>" class="nav-link text-white">
          <i class="fas fa-home"></i> <span class="sidebar-label">Dashboard</span>
        </a>
      </li>
      <?php if ($role == 'superadmin' || $role == 'admin'): ?>
      <li>
        <a href="<?= base_url('user') ?>" class="nav-link text-white">
          <i class="fas fa-users"></i> Users
        </a>
      </li>
      <?php endif; ?>
      <?php if ($role == 'superadmin'): ?>
      <li>
        <a href="<?= base_url('gaji') ?>" class="nav-link text-white">
          <i class="fas fa-money-bill"></i> Penggajian
        </a>
      </li>
      <li>
        <a href="<?= base_url('attendance/index') ?>" class="nav-link text-white">
          <i class="fas fa-calendar-check"></i> Attendance
        </a>
      </li>
      <li>
        <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
          <i class="fas fa-envelope-open-text"></i> Perizinan
        </a>
      </li>
      <?php elseif ($role == 'admin'): ?>
      <li>
        <a href="<?= base_url('gaji/my') ?>" class="nav-link text-white">
          <i class="fas fa-money-bill"></i> Penggajian
        </a>
      </li>
      <li>
        <a href="<?= base_url('attendance/divisi') ?>" class="nav-link text-white">
          <i class="fas fa-calendar-check"></i> Attendance
        </a>
      </li>
      <li>
        <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
          <i class="fas fa-envelope-open-text"></i> Perizinan
        </a>
      </li>
      <?php endif; ?>
      <?php if ($role == 'staff'): ?>
      <li>
        <a href="<?= base_url('gaji/my') ?>" class="nav-link text-white">
          <i class="fas fa-money-bill"></i> Penggajian
        </a>
      </li>
      <li>
        <a href="<?= base_url('perizinan') ?>" class="nav-link text-white">
          <i class="fas fa-envelope-open-text"></i> Pengajuan
        </a>
      </li>
      <?php endif; ?>
      <li>
        <a href="<?= base_url('event') ?>" class="nav-link text-white">
          <i class="fas fa-calendar-alt"></i> Event
        </a>
      </li>
      <li>
        <a href="<?= base_url('reports') ?>" class="nav-link text-white">
          <i class="fas fa-file-alt"></i> Reports
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-circle fa-2x me-2"></i>
        <strong><?= $username ?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <?php if ($role == 'superadmin'): ?>
        <li><a class="dropdown-item" href="<?= base_url('settings/index') ?>"><i class="fas fa-cogs"></i> Pengaturan Sistem</a></li>
        <?php endif; ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- Floating Chat Button & Popup -->
<div id="floating-chat-btn" style="position:fixed;right:32px;bottom:32px;z-index:9999;">
    <button class="btn btn-primary rounded-circle shadow" style="width:56px;height:56px;position:relative;" onclick="toggleChatPopup()">
        <i class="fas fa-comments fa-lg"></i>
        <span id="chat-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">!</span>
    </button>
</div>
<div id="floating-chat-popup" style="display:none;position:fixed;right:32px;bottom:100px;width:340px;max-width:95vw;z-index:10000;box-shadow:0 2px 16px rgba(0,0,0,0.2);">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <span><i class="fas fa-comments"></i> Chat</span>
            <button class="btn btn-sm btn-light" onclick="toggleChatPopup()"><i class="fas fa-times"></i></button>
        </div>
        <div class="card-body p-2" style="height:260px;overflow-y:auto;" id="chat-messages-area">
            <div class="text-center text-muted small">Pilih user atau broadcast, lalu mulai chat...</div>
        </div>
        <div class="card-footer p-2">
            <div class="input-group mb-2">
                <select id="chat-user-select" class="form-select form-select-sm">
                    <option value="">Broadcast ke Semua</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control" placeholder="Ketik pesan..." onkeydown="if(event.key==='Enter'){sendChatMessage();}">
                <button class="btn btn-primary" onclick="sendChatMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>
<script>
let chatPopupOpen = false;
let chatWithUser = '';
let lastMessageCount = 0;

function toggleChatPopup() {
    chatPopupOpen = !chatPopupOpen;
    document.getElementById('floating-chat-popup').style.display = chatPopupOpen ? 'block' : 'none';
    if (chatPopupOpen) {
        document.getElementById('chat-badge').style.display = 'none';
        loadChatUsers();
        loadChatMessages();
        markChatAsRead();
    }
}

function loadChatUsers() {
    fetch('<?= base_url('chat/getAllUsers') ?>')
        .then(res => res.json())
        .then(users => {
            let select = document.getElementById('chat-user-select');
            let val = select.value;
            select.innerHTML = '<option value="">Broadcast ke Semua</option>';
            users.forEach(u => {
                select.innerHTML += `<option value="${u.id}">${u.username} (${u.role})</option>`;
            });
            select.value = val;
        });
}

document.getElementById('chat-user-select').addEventListener('change', function() {
    chatWithUser = this.value;
    loadChatMessages();
    markChatAsRead();
});

function loadChatMessages() {
    let url = '<?= base_url('chat/getMessages') ?>';
    if (chatWithUser) url += '?with_user=' + chatWithUser;
    fetch(url)
        .then(res => res.json())
        .then(messages => {
            let area = document.getElementById('chat-messages-area');
            if (!messages.length) {
                area.innerHTML = '<div class="text-center text-muted small">Belum ada pesan.</div>';
                return;
            }
            let html = '';
            messages.forEach(msg => {
                let align = msg.sender_id == <?= json_encode($this->session->userdata('user_id')) ?> ? 'text-end' : 'text-start';
                let bg = msg.sender_id == <?= json_encode($this->session->userdata('user_id')) ?> ? 'bg-primary text-white' : 'bg-light';
                // Tampilkan nama pengirim jika bukan pesan sendiri
                let sender = '';
                if (msg.sender_id != <?= json_encode($this->session->userdata('user_id')) ?>) {
                    sender = `<div class="small fw-bold text-secondary">${msg.sender_name}</div>`;
                }
                html += `<div class="mb-1 ${align}">${sender}<span class="d-inline-block px-2 py-1 rounded ${bg}" style="max-width:80%;word-break:break-word;">${msg.message}</span><br><small class="text-muted">${msg.created_at.substr(11,5)}</small></div>`;
            });
            area.innerHTML = html;
            area.scrollTop = area.scrollHeight;
            lastMessageCount = messages.length;
        });
}

function sendChatMessage() {
    let input = document.getElementById('chat-input');
    let msg = input.value.trim();
    if (!msg) return;
    let data = new FormData();
    data.append('message', msg);
    if (chatWithUser) data.append('receiver_id', chatWithUser);
    fetch('<?= base_url('chat/sendMessage') ?>', {method:'POST',body:data})
        .then(res => res.json())
        .then(response => {
            if (response.status !== 'ok') {
                alert(response.msg || 'Gagal mengirim pesan!');
                return;
            }
            input.value = '';
            loadChatMessages();
        });
}

function markChatAsRead() {
    let data = new FormData();
    if (chatWithUser) data.append('with_user', chatWithUser);
    fetch('<?= base_url('chat/markAsRead') ?>', {method:'POST',body:data});
}

// Polling pesan baru & badge notif
setInterval(function() {
    if (!chatPopupOpen) {
        let url = '<?= base_url('chat/getMessages') ?>';
        fetch(url)
            .then(res => res.json())
            .then(messages => {
                if (messages && messages.length > lastMessageCount) {
                    document.getElementById('chat-badge').style.display = 'inline-block';
                }
            });
    } else {
        loadChatMessages();
    }
}, 2000);
</script>
<style>
#sidebar-fixed.sidebar-minimized .sidebar-label, #sidebar-fixed.sidebar-minimized .dropdown strong, #sidebar-fixed.sidebar-minimized .dropdown-toggle::after {
  display: none !important;
}
#sidebar-fixed.sidebar-minimized { width: 60px !important; }
#sidebar-fixed.sidebar-expanded { width: 220px !important; }
#sidebar-fixed .btn#sidebar-minimize-btn { padding: 2px 6px; font-size: 18px; }
#sidebar-fixed.sidebar-minimized .nav-link { justify-content: center; text-align: center; padding-left: 0.5rem; padding-right: 0.5rem; }
#sidebar-fixed.sidebar-minimized i.fas, #sidebar-fixed.sidebar-minimized i.fa-solid { font-size: 1.4rem !important; }
#sidebar-fixed .nav-link i.fas, #sidebar-fixed .nav-link i.fa-solid { min-width: 24px; text-align: center; }
#sidebar-fixed.sidebar-minimized .dropdown { justify-content: center; }
#sidebar-fixed.sidebar-minimized .dropdown-menu { left: 60px !important; }
#sidebar-fixed .dropdown-toggle { width: 100%; }
</style> 