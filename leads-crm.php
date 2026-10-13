<?php
// Set timezone to Asia/Kolkata (Indian Standard Time)
date_default_timezone_set('Asia/Kolkata');

session_start();
define('CRM_FILE',  __DIR__ . '/leads_crm_7a3e91f2.csv');
define('CRM_PASS',  'EEpAVV@*#1!oo$9'); // ⚠️ CHANGE THIS PASSWORD!

// ─── Auth ────────────────────────────────────────────────────────────────────
if (isset($_GET['logout'])) { session_destroy(); header('Location: '.$_SERVER['PHP_SELF']); exit; }
$login_error = '';
if (!empty($_POST['pwd'])) {
    if ($_POST['pwd'] === CRM_PASS) { $_SESSION['crm_ok'] = true; header('Location: '.$_SERVER['PHP_SELF']); exit; }
    else { $login_error = 'Incorrect password. Please try again.'; }
}
$auth = !empty($_SESSION['crm_ok']);

// ─── Load leads ───────────────────────────────────────────────────────────────
$leads = [];
if ($auth && file_exists(CRM_FILE)) {
    $fh = fopen(CRM_FILE, 'r'); $first = true; $hdrs = [];
    while (($row = fgetcsv($fh)) !== false) {
        if ($first) { $hdrs = $row; $first = false; continue; }
        $lead = []; foreach ($hdrs as $i => $k) $lead[$k] = $row[$i] ?? '';
        $leads[] = $lead;
    }
    fclose($fh);
    usort($leads, fn($a,$b) => strcmp($b['Date'], $a['Date']));
}

// ─── Stats ───────────────────────────────────────────────────────────────────
$total   = count($leads);
$paid    = count(array_filter($leads, fn($l) => $l['Status'] === 'Paid'));
$pending = count(array_filter($leads, fn($l) => $l['Status'] === 'Payment Pending'));

// ─── Filter + Search ─────────────────────────────────────────────────────────
$filter  = $_GET['filter'] ?? 'all';
$search  = trim($_GET['q'] ?? '');
$view = match($filter) {
    'paid'    => array_values(array_filter($leads, fn($l) => $l['Status'] === 'Paid')),
    'pending' => array_values(array_filter($leads, fn($l) => $l['Status'] === 'Payment Pending')),
    default   => $leads,
};
if ($search) {
    $view = array_values(array_filter($view, fn($l) =>
        stripos($l['Name']??'', $search)!==false ||
        stripos($l['Email']??'', $search)!==false ||
        stripos($l['Phone']??'', $search)!==false
    ));
}

// ─── CSV Export ──────────────────────────────────────────────────────────────
if ($auth && isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="agdm_leads_'.date('Ymd_His').'.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Date','Name','Email','Phone','Profile','Course','Status','Order ID','Payment ID','IP Address']);
    foreach ($view as $l) fputcsv($out, array_values($l));
    fclose($out); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AGDM Academy – Leads CRM</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
:root{
  --red:#dc1e28;--red-d:#a8131b;--red-bg:#fff0f1;
  --dark:#0f172a;--slate:#1e293b;--gray:#64748b;--light:#f8fafc;
  --white:#fff;--green:#16a34a;--green-bg:#f0fdf4;
  --amber:#d97706;--amber-bg:#fffbeb;
  --font:'Inter',system-ui,sans-serif;
}
body{font-family:var(--font);background:var(--light);color:var(--dark);min-height:100vh}
a{text-decoration:none;color:inherit}

/* ── LOGIN ── */
.login-page{display:flex;align-items:center;justify-content:center;min-height:100vh;
  background:linear-gradient(135deg,var(--dark) 0%,var(--slate) 100%)}
.login-card{background:var(--white);border-radius:12px;padding:48px 40px;width:100%;max-width:400px;
  box-shadow:0 24px 60px rgba(0,0,0,.3)}
.login-logo{display:flex;align-items:center;gap:12px;margin-bottom:32px;justify-content:center}
.login-logo-icon{width:44px;height:44px;background:var(--red);border-radius:10px;
  display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;font-weight:900}
.login-title{font-size:24px;font-weight:800;color:var(--dark);text-align:center;margin-bottom:6px}
.login-sub{font-size:14px;color:var(--gray);text-align:center;margin-bottom:28px}
.login-input{width:100%;padding:14px 16px;border:1.5px solid #e2e8f0;border-radius:8px;
  font-size:15px;font-family:var(--font);outline:none;transition:border-color .2s}
.login-input:focus{border-color:var(--red)}
.login-btn{width:100%;margin-top:16px;padding:15px;background:var(--red);color:#fff;
  border:none;border-radius:8px;font-size:16px;font-weight:700;cursor:pointer;transition:background .2s}
.login-btn:hover{background:var(--red-d)}
.login-error{background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:8px;
  font-size:14px;margin-bottom:16px;border:1px solid #fecaca}

/* ── LAYOUT ── */
.sidebar{position:fixed;top:0;left:0;width:220px;height:100vh;background:var(--dark);
  display:flex;flex-direction:column;z-index:100;padding:28px 0}
.sb-logo{padding:0 24px 28px;border-bottom:1px solid rgba(255,255,255,.1)}
.sb-logo-icon{width:36px;height:36px;background:var(--red);border-radius:8px;
  display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:14px;margin-bottom:8px}
.sb-logo-name{font-size:15px;font-weight:700;color:#fff}
.sb-logo-sub{font-size:11px;color:#94a3b8}
.sb-nav{padding:20px 0;flex:1}
.sb-link{display:flex;align-items:center;gap:10px;padding:11px 24px;font-size:14px;
  font-weight:500;color:#94a3b8;cursor:pointer;transition:all .2s;border:none;background:none;width:100%;text-align:left}
.sb-link:hover,.sb-link.active{color:#fff;background:rgba(255,255,255,.07)}
.sb-link .icon{font-size:16px;width:20px;text-align:center}
.sb-footer{padding:20px 24px;border-top:1px solid rgba(255,255,255,.1)}
.sb-logout{display:flex;align-items:center;gap:8px;font-size:13px;color:#94a3b8;
  cursor:pointer;background:none;border:none;font-family:var(--font);transition:color .2s}
.sb-logout:hover{color:#fff}

.main{margin-left:220px;padding:32px 36px;min-height:100vh}

/* ── TOP BAR ── */
.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:32px}
.page-title{font-size:24px;font-weight:800;color:var(--dark)}
.page-sub{font-size:14px;color:var(--gray);margin-top:2px}
.topbar-actions{display:flex;gap:10px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border-radius:8px;
  font-size:14px;font-weight:600;cursor:pointer;border:none;font-family:var(--font);transition:all .2s}
.btn-outline{background:var(--white);color:var(--dark);border:1.5px solid #e2e8f0}
.btn-outline:hover{border-color:var(--red);color:var(--red)}
.btn-red{background:var(--red);color:#fff}
.btn-red:hover{background:var(--red-d)}

/* ── STAT CARDS ── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:28px}
.stat-card{background:var(--white);border-radius:12px;padding:24px;
  box-shadow:0 1px 4px rgba(0,0,0,.06);display:flex;align-items:center;gap:18px}
.stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;
  justify-content:center;font-size:22px;flex-shrink:0}
.stat-icon.blue{background:#eff6ff;color:#2563eb}
.stat-icon.green{background:var(--green-bg);color:var(--green)}
.stat-icon.amber{background:var(--amber-bg);color:var(--amber)}
.stat-num{font-size:32px;font-weight:800;color:var(--dark);line-height:1}
.stat-label{font-size:13px;color:var(--gray);margin-top:4px}

/* ── TOOLBAR ── */
.toolbar{background:var(--white);border-radius:12px;padding:16px 20px;
  display:flex;align-items:center;gap:12px;margin-bottom:20px;
  box-shadow:0 1px 4px rgba(0,0,0,.06);flex-wrap:wrap}
.search-wrap{position:relative;flex:1;min-width:200px}
.search-wrap input{width:100%;padding:10px 14px 10px 40px;border:1.5px solid #e2e8f0;
  border-radius:8px;font-size:14px;font-family:var(--font);outline:none;transition:border-color .2s}
.search-wrap input:focus{border-color:var(--red)}
.search-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--gray);font-size:15px}
.filter-tabs{display:flex;gap:6px}
.ftab{padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;
  border:1.5px solid #e2e8f0;background:var(--white);color:var(--gray);transition:all .2s;font-family:var(--font)}
.ftab:hover{border-color:var(--red);color:var(--red)}
.ftab.active{background:var(--red);color:#fff;border-color:var(--red)}

/* ── TABLE ── */
.table-wrap{background:var(--white);border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden}
.table-scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:900px}
thead th{background:#f8fafc;padding:13px 16px;text-align:left;font-size:12px;
  font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.5px;
  border-bottom:1px solid #f1f5f9;white-space:nowrap}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .15s}
tbody tr:last-child{border:none}
tbody tr:hover{background:#fafafa}
td{padding:14px 16px;font-size:14px;color:var(--dark);vertical-align:middle}
.td-name{font-weight:600}
.td-email{color:var(--gray);font-size:13px}
.td-phone{font-weight:500}
.td-date{color:var(--gray);font-size:13px;white-space:nowrap}
.badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;
  border-radius:20px;font-size:12px;font-weight:700}
.badge-paid{background:var(--green-bg);color:var(--green)}
.badge-pending{background:var(--amber-bg);color:var(--amber)}
.badge-dot{width:6px;height:6px;border-radius:50%;background:currentColor;display:block}

/* ── ACTION BTNS ── */
.actions{display:flex;gap:6px}
.act-btn{width:32px;height:32px;border-radius:7px;border:none;cursor:pointer;
  display:flex;align-items:center;justify-content:center;font-size:14px;
  transition:all .15s;text-decoration:none}
.act-wa{background:#dcfce7;color:#16a34a}.act-wa:hover{background:#16a34a;color:#fff}
.act-call{background:#eff6ff;color:#2563eb}.act-call:hover{background:#2563eb;color:#fff}
.act-mail{background:#fef3c7;color:#d97706}.act-mail:hover{background:#d97706;color:#fff}

/* ── EMPTY ── */
.empty-state{text-align:center;padding:60px 20px}
.empty-icon{font-size:48px;margin-bottom:16px;opacity:.3}
.empty-msg{font-size:16px;color:var(--gray)}

/* ── FOOTER ── */
.table-footer{padding:14px 20px;display:flex;align-items:center;justify-content:space-between;
  border-top:1px solid #f1f5f9;font-size:13px;color:var(--gray)}

@media(max-width:768px){
  .sidebar{display:none}
  .main{margin-left:0;padding:20px 16px}
  .stats-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<?php if (!$auth): ?>
<!-- ══════════════════ LOGIN PAGE ══════════════════ -->
<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="login-logo-icon">A</div>
    </div>
    <h1 class="login-title">AGDM Academy CRM</h1>
    <p class="login-sub">Enter your dashboard password to continue</p>
    <?php if($login_error): ?>
      <div class="login-error">⚠️ <?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <input class="login-input" type="password" name="pwd" placeholder="Dashboard password" autofocus required>
      <button class="login-btn" type="submit">🔐 Sign In</button>
    </form>
  </div>
</div>

<?php else: ?>
<!-- ══════════════════ DASHBOARD ══════════════════ -->
<div class="sidebar">
  <div class="sb-logo">
    <div class="sb-logo-icon">A</div>
    <div class="sb-logo-name">AGDM Academy</div>
    <div class="sb-logo-sub">Leads CRM</div>
  </div>
  <nav class="sb-nav">
    <button class="sb-link active"><span class="icon">📊</span> All Leads</button>
  </nav>
  <div class="sb-footer">
    <a href="?logout=1" class="sb-logout">🚪 Logout</a>
  </div>
</div>

<div class="main">
  <!-- Top Bar -->
  <div class="topbar">
    <div>
      <div class="page-title">Leads Dashboard</div>
      <div class="page-sub">Google Ads 10-Day Workshop — All Registrations</div>
    </div>
    <div class="topbar-actions">
      <a href="?export=1&filter=<?= htmlspecialchars($filter) ?>&q=<?= htmlspecialchars($search) ?>" class="btn btn-outline">⬇️ Export CSV</a>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon blue">👥</div>
      <div><div class="stat-num"><?= $total ?></div><div class="stat-label">Total Leads</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">✅</div>
      <div><div class="stat-num"><?= $paid ?></div><div class="stat-label">Paid Registrations</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon amber">⏳</div>
      <div><div class="stat-num"><?= $pending ?></div><div class="stat-label">Payment Pending</div></div>
    </div>
  </div>

  <!-- Toolbar -->
  <div class="toolbar">
    <div class="search-wrap">
      <span class="search-icon">🔍</span>
      <form method="GET" id="searchForm">
        <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
        <input type="text" name="q" placeholder="Search by name, email or phone…" value="<?= htmlspecialchars($search) ?>" oninput="document.getElementById('searchForm').submit()">
      </form>
    </div>
    <div class="filter-tabs">
      <a href="?filter=all&q=<?= urlencode($search) ?>" class="ftab <?= $filter==='all'?'active':'' ?>">All (<?= $total ?>)</a>
      <a href="?filter=paid&q=<?= urlencode($search) ?>" class="ftab <?= $filter==='paid'?'active':'' ?>">✅ Paid (<?= $paid ?>)</a>
      <a href="?filter=pending&q=<?= urlencode($search) ?>" class="ftab <?= $filter==='pending'?'active':'' ?>">⏳ Pending (<?= $pending ?>)</a>
    </div>
  </div>

  <!-- Table -->
  <div class="table-wrap">
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name / Email</th>
            <th>Phone</th>
            <th>Profile</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($view)): ?>
          <tr><td colspan="7">
            <div class="empty-state">
              <div class="empty-icon">📭</div>
              <div class="empty-msg">No leads found<?= $search ? ' matching "'.$search.'"' : '' ?>.</div>
            </div>
          </td></tr>
        <?php else: ?>
          <?php foreach ($view as $i => $l): ?>
          <?php
            $phone   = preg_replace('/\D/', '', $l['Phone'] ?? '');
            $waPhone = strlen($phone) === 10 ? '91'.$phone : $phone;
            $waMsg   = urlencode("Hi {$l['Name']}, we noticed you registered for the AGDM Google Ads 10-Day Workshop. We'd love to help you complete your registration. Please let us know if you need any assistance!");
            $waLink  = "https://wa.me/{$waPhone}?text={$waMsg}";
          ?>
          <tr>
            <td style="color:var(--gray);font-size:13px"><?= $i + 1 ?></td>
            <td>
              <div class="td-name"><?= htmlspecialchars($l['Name'] ?? '') ?></div>
              <div class="td-email"><?= htmlspecialchars($l['Email'] ?? '') ?></div>
            </td>
            <td class="td-phone"><?= htmlspecialchars($l['Phone'] ?? '') ?></td>
            <td style="font-size:13px;color:var(--gray)"><?= htmlspecialchars($l['Profile'] ?? '') ?></td>
            <td>
              <?php if (($l['Status']??'') === 'Paid'): ?>
                <span class="badge badge-paid"><span class="badge-dot"></span>Paid</span>
              <?php else: ?>
                <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
              <?php endif; ?>
            </td>
            <td class="td-date"><?= htmlspecialchars(substr($l['Date']??'',0,16)) ?></td>
            <td>
              <div class="actions">
                <a class="act-btn act-wa" href="<?= $waLink ?>" target="_blank" title="WhatsApp">💬</a>
                <a class="act-btn act-call" href="tel:<?= htmlspecialchars($l['Phone']??'') ?>" title="Call">📞</a>
                <a class="act-btn act-mail" href="mailto:<?= htmlspecialchars($l['Email']??'') ?>" title="Email">✉️</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="table-footer">
      <span>Showing <strong><?= count($view) ?></strong> of <strong><?= $total ?></strong> leads</span>
      <span>Last updated: <?= date('d M Y, h:i A') ?></span>
    </div>
  </div>
</div>

<?php endif; ?>
</body>
</html>
