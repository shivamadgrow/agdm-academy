<?php
require_once __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enroll') {
    header('Content-Type: application/json');
    
    $name = strip_tags(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = strip_tags(trim($_POST['phone'] ?? ''));
    $city = strip_tags(trim($_POST['city'] ?? ''));
    $course = strip_tags(trim($_POST['course'] ?? ''));
    $batch = strip_tags(trim($_POST['batch'] ?? ''));
    $profile = strip_tags(trim($_POST['profile'] ?? ''));

    if (empty($name) || empty($email) || empty($phone) || empty($course)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields marked with *']);
        exit;
    }

    // Verify Captcha securely using core bootstrap libraries
    $captcha = trim($_POST['agdm_captcha'] ?? '');
    if (empty($captcha)) {
        echo json_encode(['success' => false, 'message' => 'Verification is required. Please solve the math problem.']);
        exit;
    } elseif (!agdm_validate_captcha($captcha)) {
        echo json_encode(['success' => false, 'message' => 'Incorrect verification answer. Please try again.']);
        exit;
    }

    // Save lead directly to the website (CSV secure storage)
    $csvFile = __DIR__ . '/leads_log_9d8f34bc.csv';
    $isNewFile = !file_exists($csvFile);
    $fp = fopen($csvFile, 'a');
    if ($fp) {
        if ($isNewFile) {
            fputcsv($fp, ['Date', 'Name', 'Email', 'Phone', 'City', 'Course', 'Batch', 'Profile', 'IP Address']);
        }
        fputcsv($fp, [
            date('Y-m-d H:i:s'),
            $name,
            $email,
            $phone,
            $city,
            $course,
            $batch,
            $profile,
            $_SERVER['REMOTE_ADDR'] ?? ''
        ]);
        fclose($fp);
    }

    $recipient = "info@adgrowmedia.com, info@agdmacademy.com";
    $subject = "AGDM Academy - New Course Enrollment Lead";

    $email_content = "New Enrollment Request from AGDM Academy Landing Page:\n\n";
    $email_content .= "Full Name: $name\n";
    $email_content .= "Email Address: $email\n";
    $email_content .= "Phone / WhatsApp: $phone\n";
    $email_content .= "City / Location: $city\n";
    
    // Map course values to readable text
    $course_text = $course;
    if ($course === 'midm') {
        $course_text = 'MIDM – Master in Digital Marketing (8 Months)';
    } elseif ($course === 'pidm') {
        $course_text = 'PIDM – Professional in Digital Marketing (4 Months)';
    } elseif ($course === 'crash') {
        $course_text = 'Crash Course – AI Digital Marketing (45 Days)';
    }
    
    $email_content .= "Selected Course: $course_text\n";
    $email_content .= "Preferred Batch: " . ($batch ?: 'Not Selected') . "\n";
    $email_content .= "Profile Type: " . ($profile ?: 'Not Selected') . "\n";

    $headers = "From: webmaster@agdmacademy.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($recipient, $subject, $email_content, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        // Safe fallback in case hosting mail sender is broken
        echo json_encode(['success' => true, 'note' => 'saved_locally']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TFXS4WTB');</script>
<!-- End Google Tag Manager -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AGDM Academy – AI-Powered Digital Marketing Course | Delhi</title>
<meta name="description" content="Join AGDM Academy's AI-Powered Digital Marketing Course in Delhi. 100% practical training in SEO, Google Ads, Meta Ads with placement assistance.">
<meta name="keywords" content="digital marketing course delhi, ai digital marketing training, learn seo delhi, google ads institute, meta ads course delhi, placement support, uttam nagar institute">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Favicon -->
<link rel="icon" type="image/png" href="assets/logo-new.png">
<link rel="shortcut icon" type="image/png" href="assets/logo-new.png">
<link rel="apple-touch-icon" href="assets/logo-new.png">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --red: #dc3545;
    --red-dark: #b02a37;
    --red-light: #fff5f5;
    --red-muted: #fde8ea;
    --dark: #0d0d0d;
    --dark2: #1a1a1a;
    --dark3: #2a2a2a;
    --gray: #6b7280;
    --gray-light: #f4f4f4;
    --white: #ffffff;
    --border: #e5e7eb;
    --font: 'Poppins', sans-serif;
    --shadow: 0 4px 24px rgba(220,53,69,0.12);
    --shadow-card: 0 2px 16px rgba(0,0,0,0.08);
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: var(--font);
    background: var(--white);
    color: var(--dark);
    line-height: 1.6;
    font-size: 16px;
  }

  /* ── STICKY NAV ── */
  .nav {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--dark);
    padding: 12px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 16px rgba(0,0,0,0.4);
  }
  .nav-logo img {
    height: 44px;
    display: block;
    object-fit: contain;
  }
  .nav-cta {
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .nav-phone {
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    opacity: 0.9;
  }
  .nav-phone:hover { opacity: 1; }
  .btn-nav {
    background: var(--red);
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 6px;
    font-family: var(--font);
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
  }
  .btn-nav:hover { background: var(--red-dark); }

  /* ── HERO ── */
  .hero {
    background: var(--dark);
    padding: 80px 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 48px;
    flex-wrap: wrap;
  }
  .hero-left {
    flex: 1;
    min-width: 300px;
    max-width: 580px;
  }
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(220,53,69,0.15);
    border: 1px solid rgba(220,53,69,0.4);
    color: #ff8a94;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 100px;
    margin-bottom: 20px;
  }
  .hero-badge span { font-size: 16px; }
  .hero h1 {
    font-size: clamp(28px, 4vw, 46px);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 16px;
  }
  .hero h1 .red { color: var(--red); }
  .hero-sub {
    color: #a0aec0;
    font-size: 16px;
    margin-bottom: 28px;
    font-weight: 400;
    line-height: 1.7;
  }
  .hero-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 32px;
  }
  .pill {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: #e2e8f0;
    font-size: 13px;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 100px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .pill .dot { width: 7px; height: 7px; background: var(--red); border-radius: 50%; flex-shrink: 0; }
  .hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 40px;
  }
  .btn-primary {
    background: var(--red);
    color: #fff;
    border: none;
    padding: 16px 32px;
    border-radius: 8px;
    font-family: var(--font);
    font-weight: 800;
    font-size: 15px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 20px rgba(220,53,69,0.4);
  }
  .btn-primary:hover { background: var(--red-dark); transform: translateY(-1px); }
  .btn-outline-w {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.3);
    padding: 16px 32px;
    border-radius: 8px;
    font-family: var(--font);
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: border-color 0.2s, background 0.2s;
  }
  .btn-outline-w:hover { border-color: #fff; background: rgba(255,255,255,0.08); }
  .hero-stats {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.1);
  }
  .hero-stat-num {
    font-size: 26px;
    font-weight: 800;
    color: var(--red);
    line-height: 1;
    margin-bottom: 4px;
  }
  .hero-stat-lbl {
    font-size: 12px;
    color: #718096;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* ── HERO FORM ── */
  .hero-right {
    flex-shrink: 0;
    width: 380px;
    max-width: 100%;
  }
  .form-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 28px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.3);
    border: 2px solid transparent;
    transition: all 0.3s ease-in-out;
  }
  .highlight-form {
    border: 2px solid var(--red) !important;
    box-shadow: 0 0 30px rgba(220, 53, 69, 0.6) !important;
    transform: scale(1.02);
  }
  .syllabus-alert {
    display: none;
    background: var(--red-light);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: var(--red-dark);
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 20px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    animation: slideDown 0.3s ease-out;
  }
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .form-card-header {
    text-align: center;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
  }
  .form-card-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 4px;
  }
  .form-card-sub {
    font-size: 12px;
    color: var(--gray);
    font-weight: 500;
  }
  .form-urgency {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #fff8f8;
    border: 1px solid #fecdd3;
    border-radius: 8px;
    padding: 8px 14px;
    margin-bottom: 20px;
    font-size: 12px;
    font-weight: 700;
    color: var(--red-dark);
  }
  .urgency-dot { width: 8px; height: 8px; background: var(--red); border-radius: 50%; animation: pulse 1.5s infinite; flex-shrink: 0; }
  @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.4; } }
  .frow {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
  }
  .fcol { display: flex; flex-direction: column; gap: 4px; }
  .fcol.full { grid-column: 1 / -1; }
  label {
    font-size: 12px;
    font-weight: 600;
    color: var(--dark);
  }
  label .req { color: var(--red); }
  input[type="text"], input[type="email"], input[type="tel"], select, input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-family: var(--font);
    font-size: 13px;
    color: var(--dark);
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    -webkit-appearance: none;
  }
  input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus, select:focus, input[type="number"]:focus {
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(220,53,69,0.1);
  }
  select { cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
  .captcha-box {
    background: var(--gray-light);
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    margin-top: 4px;
  }
  .captcha-question {
    background: var(--dark);
    color: #fff;
    font-weight: 800;
    font-size: 13px;
    padding: 8px 14px;
    border-radius: 6px;
    white-space: nowrap;
    flex-shrink: 0;
    letter-spacing: 0.03em;
  }
  .captcha-input { flex: 1; min-width: 0; margin: 0; }
  .btn-submit {
    width: 100%;
    background: var(--red);
    color: #fff;
    border: none;
    padding: 16px;
    border-radius: 10px;
    font-family: var(--font);
    font-weight: 800;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 20px rgba(220,53,69,0.35);
    margin-bottom: 10px;
  }
  .btn-submit:hover { background: var(--red-dark); transform: translateY(-1px); }
  .btn-submit:disabled { background: #ccc; cursor: not-allowed; transform: none; box-shadow: none; }
  .form-note {
    text-align: center;
    font-size: 11px;
    color: var(--gray);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
  }
  .form-success {
    display: none;
    text-align: center;
    padding: 32px 20px;
  }
  .form-success-icon {
    width: 64px; height: 64px;
    background: #f0fdf4;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 28px;
  }
  .form-success h3 {
    font-size: 20px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 8px;
  }
  .form-success p {
    font-size: 13px;
    color: var(--gray);
  }

  /* ── HERO BOTTOM STRIP ── */
  .hero-strip {
    background: var(--red);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    text-align: center;
  }
  .hero-strip span {
    color: #fff;
    font-weight: 700;
    font-size: 13px;
  }
  .hero-strip .sep {
    color: rgba(255,255,255,0.5);
    font-weight: 300;
  }

  /* ── SECTIONS ── */
  section { padding: 72px 24px; }
  .section-inner { max-width: 1100px; margin: 0 auto; }
  .section-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--red-muted);
    color: var(--red-dark);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 100px;
    margin-bottom: 12px;
  }
  .section-title {
    font-size: clamp(24px, 3.5vw, 38px);
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 12px;
    line-height: 1.2;
  }
  .section-title .red { color: var(--red); }
  .section-sub {
    font-size: 16px;
    color: var(--gray);
    max-width: 600px;
    line-height: 1.7;
  }
  .section-head { margin-bottom: 48px; }

  /* ── HIGHLIGHTS ── */
  .highlights { background: var(--gray-light); }
  .highlights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
  }
  .highlight-card {
    background: var(--white);
    border-radius: 14px;
    padding: 28px 24px;
    border: 1.5px solid var(--border);
    transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
  }
  .highlight-card:hover {
    border-color: var(--red);
    box-shadow: 0 4px 24px rgba(220,53,69,0.12);
    transform: translateY(-2px);
  }
  .hl-icon {
    width: 48px; height: 48px;
    background: var(--red-muted);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
  }
  .hl-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 6px;
  }
  .hl-desc {
    font-size: 13px;
    color: var(--gray);
    line-height: 1.6;
  }

  /* ── PROGRAMS ── */
  .programs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    align-items: start;
  }
  .program-card {
    border-radius: 16px;
    border: 2px solid var(--border);
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .program-card:hover { box-shadow: var(--shadow); transform: translateY(-3px); }
  .program-card.featured { border-color: var(--red); }
  .program-card-head {
    background: var(--dark2);
    padding: 24px 24px 20px;
    position: relative;
  }
  .program-card.featured .program-card-head { background: var(--red); }
  .program-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 4px 10px;
    border-radius: 100px;
    margin-bottom: 12px;
  }
  .program-name {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 4px;
  }
  .program-abbr {
    font-size: 12px;
    color: rgba(255,255,255,0.65);
    font-weight: 500;
  }
  .program-card-body {
    padding: 24px;
    background: var(--white);
  }
  .program-desc {
    font-size: 14px;
    color: var(--gray);
    line-height: 1.7;
    margin-bottom: 20px;
  }
  .program-features {
    list-style: none;
    margin-bottom: 24px;
  }
  .program-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
    color: var(--dark);
    padding: 7px 0;
    border-bottom: 1px solid var(--gray-light);
  }
  .program-features li:last-child { border-bottom: none; }
  .pf-check {
    width: 20px; height: 20px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
    color: #16a34a;
    font-weight: 700;
  }
  .btn-enroll {
    display: block;
    width: 100%;
    background: var(--dark);
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-family: var(--font);
    font-weight: 800;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: background 0.2s;
  }
  .program-card.featured .btn-enroll { background: var(--red); }
  .btn-enroll:hover { filter: brightness(0.9); }


  /* ── TOOLS ── */
  .tools { background: var(--gray-light); }
  .tools-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 40px;
  }
  .tool-chip {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    color: var(--dark);
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .tool-chip:hover {
    border-color: var(--red);
    box-shadow: 0 2px 12px rgba(220,53,69,0.1);
  }

  /* ── BATCHES ── */
  .batches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
  }
  .batch-card {
    background: var(--white);
    border: 2px solid var(--border);
    border-radius: 14px;
    padding: 28px 24px;
    text-align: center;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .batch-card:hover { border-color: var(--red); box-shadow: var(--shadow); }
  .batch-icon {
    font-size: 32px;
    margin-bottom: 12px;
  }
  .batch-name {
    font-size: 16px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 4px;
  }
  .batch-days {
    font-size: 13px;
    color: var(--gray);
    margin-bottom: 8px;
  }
  .batch-time {
    display: inline-block;
    background: var(--red-muted);
    color: var(--red-dark);
    font-size: 13px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 100px;
  }

  /* ── SOCIAL PROOF ── */
  .testimonials { background: var(--dark); }
  .testimonials .section-title { color: #fff; }
  .testimonials .section-sub { color: #718096; }
  .testi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
  }
  .testi-card {
    background: var(--dark3);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    padding: 28px 24px;
    transition: border-color 0.2s;
  }
  .testi-card:hover { border-color: rgba(220,53,69,0.4); }
  .stars {
    color: #f59e0b;
    font-size: 14px;
    margin-bottom: 12px;
    letter-spacing: 2px;
  }
  .testi-text {
    font-size: 14px;
    color: #a0aec0;
    line-height: 1.7;
    margin-bottom: 20px;
    font-style: italic;
  }
  .testi-author { display: flex; align-items: center; gap: 12px; }
  .testi-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: var(--red);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800;
    font-size: 14px;
    color: #fff;
    flex-shrink: 0;
  }
  .testi-name { font-size: 14px; font-weight: 700; color: #fff; }
  .testi-role { font-size: 12px; color: #718096; }

  /* ── COMPANIES ── */
  .companies {}
  .companies-logos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
    margin-top: 40px;
  }
  .company-chip {
    background: var(--gray-light);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 12px 24px;
    font-size: 13px;
    font-weight: 700;
    color: var(--gray);
  }

  /* ── PARTNERS ── */
  .partners { background: var(--gray-light); }
  .partners-logos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    align-items: center;
  }
  .partner-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 12px 20px;
    font-size: 13px;
    font-weight: 700;
    color: var(--dark);
  }

  /* ── CTA SECTION ── */
  .cta-section {
    background: var(--red);
    padding: 72px 24px;
    text-align: center;
  }
  .cta-section h2 {
    font-size: clamp(26px, 4vw, 42px);
    font-weight: 800;
    color: #fff;
    margin-bottom: 12px;
  }
  .cta-section p {
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    margin-bottom: 32px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }
  .btn-cta-white {
    background: #fff;
    color: var(--red);
    border: none;
    padding: 18px 40px;
    border-radius: 10px;
    font-family: var(--font);
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: opacity 0.2s, transform 0.15s;
    box-shadow: 0 4px 24px rgba(0,0,0,0.2);
  }
  .btn-cta-white:hover { opacity: 0.92; transform: translateY(-2px); }

  /* ── FOOTER ── */
  footer {
    background: var(--dark);
    padding: 48px 24px 24px;
    color: #718096;
  }
  .footer-inner {
    max-width: 1100px;
    margin: 0 auto;
  }
  .footer-top {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    flex-wrap: wrap;
  }
  .footer-logo-img { height: 44px; margin-bottom: 14px; display: block; }
  .footer-desc {
    font-size: 13px;
    color: #718096;
    line-height: 1.7;
    max-width: 280px;
    margin-bottom: 16px;
  }
  .footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    color: #a0aec0;
    margin-bottom: 8px;
    text-decoration: none;
  }
  .footer-contact-item:hover { color: #fff; }
  .footer-icon { color: var(--red); flex-shrink: 0; margin-top: 1px; }
  .footer-col-title {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 16px;
  }
  .footer-col ul { list-style: none; }
  .footer-col ul li { margin-bottom: 8px; }
  .footer-col ul li a { font-size: 13px; color: #718096; text-decoration: none; transition: color 0.2s; }
  .footer-col ul li a:hover { color: #fff; }
  .footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 24px;
    font-size: 12px;
    color: #4a5568;
  }
  .footer-bottom a { color: #4a5568; text-decoration: none; }
  .footer-bottom a:hover { color: #718096; }

  /* ── WHATSAPP FAB ── */
  .wa-fab {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 999;
    width: 58px; height: 58px;
    background: #25d366;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(37,211,102,0.4);
    transition: transform 0.2s;
  }
  .wa-fab:hover { transform: scale(1.08); }
  .wa-fab svg { fill: #fff; width: 28px; height: 28px; }

  /* ── RESPONSIVE ── */
  @media (max-width: 768px) {
    .hero { padding: 40px 20px; flex-direction: column; gap: 32px; align-items: stretch; }
    .hero-left { padding-bottom: 0; }
    .hero-right { width: 100%; transform: none; }
    .footer-top { grid-template-columns: 1fr; gap: 32px; }
    .frow { grid-template-columns: 1fr; }
    .nav-cta .nav-phone { display: none; }
  }
</style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFXS4WTB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- NAV -->
<nav class="nav">
  <a href="https://agdmacademy.com" class="nav-logo">
    <img src="assets/logo-new.png" alt="AGDM Academy Logo">
  </a>
  <div class="nav-cta">
    <a href="tel:+919643661661" class="nav-phone">
      <i class="bi bi-telephone-fill"></i> +91 9643661661
    </a>
    <a href="#enroll" class="btn-nav">Apply Now</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div class="hero-badge"><span><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.146 5.146a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 8.793l3.646-3.647z"/></svg></span> AI-Powered Digital Marketing Course</div>
    <h1>Master Digital Marketing <br><span class="red">With AI Tools in Delhi</span></h1>
    <p class="hero-sub">Delhi's #1 practical digital marketing institute. Master SEO, Google Ads, Meta Ads, and generative AI tool integration. Work on live campaigns with expert practitioners and get guaranteed career placement support.</p>
    <div class="hero-pills">
      <div class="pill"><span class="dot"></span> 100% Placement Assistance</div>
      <div class="pill"><span class="dot"></span> Paid Internship</div>
      <div class="pill"><span class="dot"></span> Live Ad Budgets</div>
      <div class="pill"><span class="dot"></span> 1-on-1 Mentorship</div>
    </div>
    <div class="hero-actions">
      <a href="#enroll" class="btn-primary">Reserve Free Demo <i class="bi bi-arrow-right"></i></a>
      <a href="assets/agdm_brochure.pdf" target="_blank" id="downloadSyllabusBtn" class="btn-outline-w"><i class="bi bi-download"></i> Syllabus</a>
    </div>
    <div class="hero-stats">
      <div>
        <div class="hero-stat-num">200+</div>
        <div class="hero-stat-lbl">Students Placed</div>
      </div>
      <div>
        <div class="hero-stat-num">100%</div>
        <div class="hero-stat-lbl">Practical Training</div>
      </div>
      <div>
        <div class="hero-stat-num">15+</div>
        <div class="hero-stat-lbl">Certifications</div>
      </div>
    </div>
  </div>
  
  <div class="hero-right" id="enroll">
    <div class="form-card">
      <div id="syllabusAlert" class="syllabus-alert">
        <i class="bi bi-info-circle-fill me-1"></i> Please complete this form to download the syllabus.
      </div>
      <div class="form-card-header">
        <h3 class="form-card-title">Book Your Free Seat</h3>
        <p class="form-card-sub">Admissions Open 2026 Batch</p>
      </div>
      <div class="form-urgency">
        <span class="urgency-dot"></span> Only 4 Seats Left for Next Batch!
      </div>
      
      <form id="enrollForm" onsubmit="event.preventDefault(); submitForm();">
        <div class="frow">
          <div class="fcol">
            <label for="f_name">Name <span class="req">*</span></label>
            <input type="text" id="f_name" placeholder="Full Name" required>
          </div>
          <div class="fcol">
            <label for="f_email">Email <span class="req">*</span></label>
            <input type="email" id="f_email" placeholder="your@email.com" required>
          </div>
        </div>
        
        <div class="frow">
          <div class="fcol">
            <label for="f_phone">Phone / WhatsApp <span class="req">*</span></label>
            <input type="tel" id="f_phone" placeholder="+91 XXXXXXXXXX" required>
          </div>
          <div class="fcol">
            <label for="f_city">City / Location</label>
            <input type="text" id="f_city" placeholder="e.g. New Delhi">
          </div>
        </div>
        
        <div class="frow">
          <div class="fcol">
            <label for="f_course">Course <span class="req">*</span></label>
            <select id="f_course" required>
              <option value="" disabled selected>Select Program</option>
              <option value="midm">MIDM – Master in Digital Marketing (8 Months)</option>
              <option value="pidm">PIDM – Professional in Digital Marketing (4 Months)</option>
              <option value="crash">Crash Course – AI Digital Marketing (45 Days)</option>
            </select>
          </div>
          <div class="fcol">
            <label for="f_batch">Batch Option</label>
            <select id="f_batch">
              <option value="" disabled selected>Select Batch</option>
              <option value="Weekday Batch">Weekday Batch (Mon–Fri, 10AM–6PM)</option>
              <option value="Weekend Batch">Weekend Batch (Sat–Sun, 11AM–4PM)</option>
            </select>
          </div>
        </div>
        
        <div class="frow">
          <div class="fcol full">
            <label for="f_profile">Your Profile</label>
            <select id="f_profile">
              <option value="" disabled selected>Who are you?</option>
              <option value="Student">Student</option>
              <option value="Fresher">Fresher / Job Seeker</option>
              <option value="Working Professional">Working Professional</option>
              <option value="Business Owner">Business Owner / Entrepreneur</option>
            </select>
          </div>
        </div>
        
        <div class="fcol full mt-3">
          <?= agdm_render_captcha(false); ?>
        </div>
        
        <div id="formError" class="alert alert-danger" style="display: none; font-size: 13px; margin-top: 15px; margin-bottom: 15px; padding: 10px; border-radius: 8px;"></div>
        
        <button type="submit" id="submitBtn" class="btn-submit">
          <i class="bi bi-check-circle-fill"></i> Submit Enrollment Request
        </button>
        <div class="form-note">
          <i class="bi bi-shield-lock-fill text-success"></i> Your details are 100% secure. No spam.
        </div>
      </form>
      
      <div class="form-success" id="formSuccess" style="display: none;">
        <div class="form-success-icon"><i class="bi bi-check2-circle text-success" style="font-size: 60px;"></i></div>
        <h3>Application Submitted!</h3>
        <p>Thank you for enrolling. Our senior counsellor will call you within 24 hours to confirm your free counselling session and early bird discount.</p>
      </div>
    </div>
  </div>
</section>

<!-- HERO STRIP -->
<section class="hero-strip">
  <span><svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" style="vertical-align:-2px"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM3.5 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1H5.707l2.647 2.646a.5.5 0 0 1-.708.708L5 5.707V6a.5.5 0 0 1-1 0V4.5z"/><path d="M10 8a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V9.707l-2.646 2.647a.5.5 0 0 1-.708-.708L8.793 9H8.5a.5.5 0 0 1 0-1H10z"/></svg> ADMISSIONS OPEN 2026</span>
  <span class="sep">|</span>
  <span>PRACTICAL LIVE PROJECTS</span>
  <span class="sep">|</span>
  <span>50+ BRAND PARTNERS</span>
  <span class="sep">|</span>
  <span>100% PLACEMENT ASSISTANCE</span>
</section>

<!-- KEY HIGHLIGHTS -->
<section class="highlights">
  <div class="section-inner">
    <div class="section-head text-center">
      <span class="section-tag">Key Highlights</span>
      <h2 class="section-title">Why AGDM Academy is Delhi's <span class="red">Top Choice</span></h2>
      <p class="section-sub mx-auto">We don't just teach theory. We build actual skills through practical, agency-style execution.</p>
    </div>
    <div class="highlights-grid">
      <div class="highlight-card">
        <div class="hl-icon"><i class="bi bi-building"></i></div>
        <h4 class="hl-title">Agency-Style Training</h4>
        <p class="hl-desc">Work on real campaigns and structures just like digital marketing professionals do in agencies.</p>
      </div>
      <div class="highlight-card">
        <div class="hl-icon"><i class="bi bi-cash-coin"></i></div>
        <h4 class="hl-title">Paid Internships</h4>
        <p class="hl-desc">Get hands-on experience and start earning while learning with local agency partnerships.</p>
      </div>
      <div class="highlight-card">
        <div class="hl-icon"><i class="bi bi-award-fill"></i></div>
        <h4 class="hl-title">100% Placement Support</h4>
        <p class="hl-desc">Comprehensive support with custom resume building, LinkedIn optimization, and mock interview prep.</p>
      </div>
      <div class="highlight-card">
        <div class="hl-icon"><i class="bi bi-cpu-fill"></i></div>
        <h4 class="hl-title">AI Tool Integration</h4>
        <p class="hl-desc">Learn how to double your speed and results with ChatGPT, Midjourney, and 20+ other modern AI platforms.</p>
      </div>
    </div>
  </div>
</section>

<!-- PROGRAMS -->
<section class="programs">
  <div class="section-inner">
    <div class="section-head text-center">
      <span class="section-tag">Our Programs</span>
      <h2 class="section-title">Choose Your Certification <span class="red">Path</span></h2>
      <p class="section-sub mx-auto">Accelerated programs designed to fit your goals, whether you are starting fresh or leveling up.</p>
    </div>
    <div class="programs-grid">
      <!-- MIDM Card -->
      <div class="program-card featured">
        <div class="program-card-head">
          <span class="program-badge"><svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" style="vertical-align:-2px"><path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73z"/></svg> FLAGSHIP</span>
          <h3 class="program-name">Master in Digital Marketing</h3>
          <span class="program-abbr">MIDM – 8 Months</span>
        </div>
        <div class="program-card-body">
          <p class="program-desc">Comprehensive, in-depth training designed to take you from a complete beginner to an agency-grade marketing specialist.</p>
          <ul class="program-features">
            <li><span class="pf-check">✓</span> 500+ Hours Agency-level Training</li>
            <li><span class="pf-check">✓</span> 17+ Advanced Core Modules</li>
            <li><span class="pf-check">✓</span> Guaranteed Paid Internship</li>
            <li><span class="pf-check">✓</span> Google & Meta Certifications</li>
            <li><span class="pf-check">✓</span> 100% Career Placement Support</li>
          </ul>
          <a href="#enroll" class="btn-enroll">Enroll in MIDM</a>
        </div>
      </div>
      
      <!-- PIDM Card -->
      <div class="program-card">
        <div class="program-card-head">
          <span class="program-badge"><svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" style="vertical-align:-2px"><path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5z"/></svg> PROFESSIONAL</span>
          <h3 class="program-name">Professional in Digital Marketing</h3>
          <span class="program-abbr">PIDM – 4 Months</span>
        </div>
        <div class="program-card-body">
          <p class="program-desc">Practical, fast-paced program perfect for working professionals, entrepreneurs, and freelancers wanting to scale skills.</p>
          <ul class="program-features">
            <li><span class="pf-check">✓</span> 13+ Practical Modules</li>
            <li><span class="pf-check">✓</span> 100% Practical Campaign Execution</li>
            <li><span class="pf-check">✓</span> Flexible Weekday/Weekend Batches</li>
            <li><span class="pf-check">✓</span> Industry recognized Certifications</li>
            <li><span class="pf-check">✓</span> Full Job Placement Assistance</li>
          </ul>
          <a href="#enroll" class="btn-enroll">Enroll in PIDM</a>
        </div>
      </div>
      
      <!-- Crash Course Card -->
      <div class="program-card">
        <div class="program-card-head">
          <span class="program-badge"><svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" style="vertical-align:-2px"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.146 5.146a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 8.793l3.646-3.647z"/></svg> CRASH COURSE</span>
          <h3 class="program-name">AI Digital Marketing</h3>
          <span class="program-abbr">AI Course – 45 Days</span>
        </div>
        <div class="program-card-body">
          <p class="program-desc">Learn how to leverage generative AI models to build content, graphics, and performance marketing strategies in no time.</p>
          <ul class="program-features">
            <li><span class="pf-check">✓</span> AI Tool Masterclass & Prompting</li>
            <li><span class="pf-check">✓</span> Automated Content Creation Workflows</li>
            <li><span class="pf-check">✓</span> Dynamic Graphic & Copywriting AI</li>
            <li><span class="pf-check">✓</span> Hands-on projects & Certificate</li>
            <li><span class="pf-check">✓</span> Highly Affordable Fast-track Course</li>
          </ul>
          <a href="#enroll" class="btn-enroll">Enroll in AI Course</a>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- TOOLS -->
<section class="tools">
  <div class="section-inner">
    <div class="section-head text-center">
      <span class="section-tag">Modern Tool Stack</span>
      <h2 class="section-title">Tools & Platforms You Will <span class="red">Master</span></h2>
      <p class="section-sub mx-auto">Get comfortable with the industry-standard software that top marketing agencies use every single day.</p>
    </div>
    <div class="tools-grid">
      <span class="tool-chip">Google Ads</span>
      <span class="tool-chip">Meta Ads</span>
      <span class="tool-chip">Google Analytics 4</span>
      <span class="tool-chip">SEMrush</span>
      <span class="tool-chip">Ahrefs</span>
      <span class="tool-chip">ChatGPT</span>
      <span class="tool-chip">Midjourney</span>
      <span class="tool-chip">Mailchimp</span>
      <span class="tool-chip">Canva</span>
      <span class="tool-chip">HubSpot CRM</span>
    </div>
  </div>
</section>

<!-- BATCHES -->
<section class="batches">
  <div class="section-inner">
    <div class="section-head text-center">
      <span class="section-tag">Flexible Schedules</span>
      <h2 class="section-title">Select Your Preferred <span class="red">Schedule</span></h2>
      <p class="section-sub mx-auto">Choose a batch that easily fits your lifestyle, whether you are a college student or a full-time professional.</p>
    </div>
    <div class="batches-grid">
      <div class="batch-card">
        <div class="batch-icon"><svg width="28" height="28" viewBox="0 0 16 16" fill="currentColor"><path d="M8 3.5a.5.5 0 0 0-1 0V8a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 7.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg></div>
        <h4 class="batch-name">Weekday Batch</h4>
        <p class="batch-days">Monday – Friday</p>
        <span class="batch-time">10:00 AM – 6:00 PM</span>
      </div>
      <div class="batch-card">
        <div class="batch-icon"><svg width="28" height="28" viewBox="0 0 16 16" fill="currentColor"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/></svg></div>
        <h4 class="batch-name">Weekend Batch</h4>
        <p class="batch-days">Saturday – Sunday</p>
        <span class="batch-time">11:00 AM – 4:00 PM</span>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials">
  <div class="section-inner">
    <div class="section-head text-center">
      <span class="section-tag">Alumni Success</span>
      <h2 class="section-title">Hear From Our <span class="red">Successful Graduates</span></h2>
      <p class="section-sub mx-auto">Join hundreds of students who transformed their careers and landed high-paying digital roles.</p>
    </div>
    <div class="testi-grid">
      <div class="testi-card">
        <div class="stars">★★★★★</div>
        <p class="testi-text">"I give AGDM Academy a solid 5-star rating! The mentors are highly supportive. I joined with zero knowledge, and within 4 months, I landed an internship. Best digital marketing institute in Delhi!"</p>
        <div class="testi-author">
          <div class="testi-avatar">PS</div>
          <div>
            <h5 class="testi-name">Priya Sharma</h5>
            <small class="testi-role">Digital Marketing Executive</small>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="stars">★★★★★</div>
        <p class="testi-text">"Definitely a 5-star experience! AGDM Academy doesn't just teach theory; they make you work on live projects. Secured a job at a top agency immediately after the MIDM course."</p>
        <div class="testi-author">
          <div class="testi-avatar">RV</div>
          <div>
            <h5 class="testi-name">Rahul Verma</h5>
            <small class="testi-role">Placed at GroupM</small>
          </div>
        </div>
      </div>
      <div class="testi-card">
        <div class="stars">★★★★★</div>
        <p class="testi-text">"The 1-on-1 mentorship at AGDM is unmatched. They helped me scale my freelance business to 6 figures within months. Highly recommend their professional course!"</p>
        <div class="testi-author">
          <div class="testi-avatar">AS</div>
          <div>
            <h5 class="testi-name">Amit Singh</h5>
            <small class="testi-role">Freelance Media Buyer</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PLACEMENT PARTNERS -->
<section class="companies">
  <div class="section-inner text-center">
    <h4 class="section-title" style="font-size: 14px; margin-bottom: 24px; color: #718096; letter-spacing: 1px;">OUR ALUMNI WORK AT TOP BRANDS</h4>
    <div class="companies-logos">
      <span class="company-chip">Google</span>
      <span class="company-chip">Meta</span>
      <span class="company-chip">Amazon</span>
      <span class="company-chip">Microsoft</span>
      <span class="company-chip">LinkedIn</span>
      <span class="company-chip">GroupM</span>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
  <h2>Launch Your Marketing Career Today</h2>
  <p>Reserve your seat in our next free demo session and get up to 50% early bird registration discount!</p>
  <a href="#enroll" class="btn-cta-white">Claim My Free Demo <i class="bi bi-arrow-right"></i></a>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div>
        <img src="assets/logo-new.png" alt="AGDM Academy Logo" class="footer-logo-img bg-white p-1 rounded">
        <p class="footer-desc">AGDM Academy is Delhi's premier institute for AI-powered digital marketing courses. We empower students, freshers, professionals, and business owners to master modern marketing with AI tools.</p>
        <a href="tel:+919643661661" class="footer-contact-item">
          <svg class="footer-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          +91 9643661661
        </a>
        <a href="mailto:info@agdmacademy.com" class="footer-contact-item">
          <svg class="footer-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          info@agdmacademy.com
        </a>
      </div>
      <div class="footer-col">
        <div class="footer-col-title">Courses</div>
        <ul>
          <li><a href="#enroll">Master in Digital Marketing</a></li>
          <li><a href="#enroll">Professional in Digital Marketing</a></li>
          <li><a href="#enroll">AI DM Crash Course</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <div class="footer-col-title">Academy</div>
        <ul>
          <li><a href="https://agdmacademy.com/about">About Us</a></li>
          <li><a href="#enroll">Batches</a></li>
          <li><a href="https://agdmacademy.com/contact">Contact</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div>© 2026 AGDM Academy. All Rights Reserved.</div>
      <div><a href="privacy-policy.php">Privacy Policy</a> | <a href="refund-policy.php">Refund Policy</a></div>
    </div>
  </div>
</footer>

<!-- WHATSAPP FAB -->
<a href="https://wa.me/919643661661?text=Hi,%20I'm%20interested%20in%20the%20AI%20Digital%20Marketing%20Course." class="wa-fab" target="_blank">
  <svg viewBox="0 0 24 24" width="28" height="28">
    <path d="M12.031 2c-5.502 0-9.973 4.471-9.973 9.973 0 1.761.458 3.477 1.332 5.006l-1.42 5.185 5.309-1.392c1.479.807 3.143 1.233 4.846 1.233 5.502 0 9.973-4.471 9.973-9.973S17.533 2 12.031 2zm0 18.256c-1.542 0-3.056-.411-4.385-1.189l-.315-.187-3.256.853.868-3.175-.205-.327c-.854-1.358-1.305-2.929-1.305-4.542 0-4.536 3.69-8.226 8.226-8.226 4.536 0 8.226 3.69 8.226 8.226s-3.69 8.226-8.226 8.226zm4.516-6.172c-.247-.124-1.463-.722-1.689-.805-.226-.083-.391-.124-.556.124-.165.247-.639.805-.783.969-.144.165-.288.186-.535.062-.247-.124-1.043-.385-1.987-1.227-.733-.653-1.229-1.461-1.373-1.708-.144-.247-.015-.38.109-.503.111-.11.247-.288.371-.433.124-.144.165-.247.247-.412.082-.165.041-.309-.021-.433-.062-.124-.556-1.34-.762-1.835-.2-.485-.402-.418-.556-.426-.144-.008-.309-.008-.474-.008s-.433.062-.659.309c-.226.247-.865.845-.865 2.06s.886 2.39 1.01 2.556c.124.165 1.742 2.66 4.22 3.73.589.254 1.05.405 1.408.519.592.188 1.13.162 1.556.099.474-.07 1.463-.598 1.669-1.175.206-.577.206-1.072.144-1.175-.062-.103-.226-.165-.473-.288z"/>
  </svg>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Captcha and AJAX Submit Logic
function submitForm() {
  const name = document.getElementById('f_name').value.trim();
  const email = document.getElementById('f_email').value.trim();
  const phone = document.getElementById('f_phone').value.trim();
  const city = document.getElementById('f_city').value.trim();
  const course = document.getElementById('f_course').value;
  const batch = document.getElementById('f_batch').value;
  const profile = document.getElementById('f_profile').value;
  const captcha = document.getElementById('agdm_captcha').value.trim();
  const errorDiv = document.getElementById('formError');

  if (errorDiv) {
    errorDiv.style.display = 'none';
    errorDiv.innerText = '';
  }

  if (!name || !email || !phone || !course || !captcha) {
    if (errorDiv) {
      errorDiv.innerText = 'Please fill out all required fields marked with *';
      errorDiv.style.display = 'block';
    }
    return;
  }

  const submitBtn = document.getElementById('submitBtn');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting Request...';
  }

  const formData = new FormData();
  formData.append('action', 'enroll');
  formData.append('name', name);
  formData.append('email', email);
  formData.append('phone', phone);
  formData.append('city', city);
  formData.append('course', course);
  formData.append('batch', batch);
  formData.append('profile', profile);
  formData.append('agdm_captcha', captcha);

  fetch(window.location.href, {
    method: 'POST',
    body: formData
  })
  .then(response => {
    const contentType = response.headers.get('content-type');
    if (contentType && contentType.includes('application/json')) {
      return response.json();
    }
    return response.text().then(txt => {
      console.error('Server returned non-JSON:', txt.substring(0, 200));
      throw new Error('Server error');
    });
  })
  .then(data => {
    if (data.success) {
      // Mark leadPopupShown as true so they don't get locked out from future downloads
      localStorage.setItem('leadPopupShown', 'true');
      
      // Check if we should download syllabus
      const shouldDownload = sessionStorage.getItem('downloadSyllabus') === 'true';
      sessionStorage.removeItem('downloadSyllabus');
      
      // Redirect to Thank You page relative link (with download param if applicable)
      const redirectUrl = 'thank-you.php' + (shouldDownload ? '?download=syllabus' : '');
      window.location.href = redirectUrl;
      return;
    } else {
      if (errorDiv) {
        errorDiv.innerText = data.message || 'Something went wrong. Please try again.';
        errorDiv.style.display = 'block';
      }
      
      // Auto refresh captcha on validation failure
      refreshCaptcha(document.getElementById('refresh-captcha-btn'));
      
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Submit Enrollment Request';
      }
    }
  })
  .catch(error => {
    console.error('Form submit error:', error);
    if (errorDiv) {
      errorDiv.innerText = 'Something went wrong. Please refresh the page and try again.';
      errorDiv.style.display = 'block';
    }
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Submit Enrollment Request';
    }
  });
}

// Captcha Refresh Utility (AJAX text-based, matches site-wide pattern)
function refreshCaptcha(btn) {
  if (!btn) return;
  const icon = btn.querySelector('i');
  if (icon) {
    icon.style.transition = 'transform 0.5s ease';
    icon.style.transform = 'rotate(360deg)';
  }
  fetch('refresh_captcha.php')
    .then(r => r.json())
    .then(data => {
      if (data.status === 'success') {
        document.querySelectorAll('#captcha-question-addon').forEach(el => {
          el.textContent = data.question;
        });
        document.querySelectorAll('#agdm_captcha').forEach(el => {
          el.value = '';
        });
      }
    })
    .catch(err => console.error('Captcha refresh error:', err))
    .finally(() => {
      if (icon) {
        setTimeout(() => { icon.style.transform = 'none'; }, 500);
      }
    });
}

// Syllabus Download Lock Handler
document.addEventListener('DOMContentLoaded', function() {
  const downloadBtn = document.getElementById('downloadSyllabusBtn');
  if (downloadBtn) {
    downloadBtn.addEventListener('click', function(e) {
      e.preventDefault();
      sessionStorage.setItem('downloadSyllabus', 'true');
      
      const syllabusAlert = document.getElementById('syllabusAlert');
      if (syllabusAlert) {
        syllabusAlert.style.display = 'block';
      }
      
      const enrollSec = document.getElementById('enroll');
      if (enrollSec) {
        enrollSec.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      
      const formCard = document.querySelector('.form-card');
      if (formCard) {
        formCard.classList.add('highlight-form');
        setTimeout(() => {
          formCard.classList.remove('highlight-form');
        }, 3000);
      }
    });
  }
});
</script>
</body>
</html>
