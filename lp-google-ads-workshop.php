<?php
require_once __DIR__ . '/bootstrap.php';

$key_id = getenv('RAZORPAY_KEY_ID') ?: $_ENV['RAZORPAY_KEY_ID'] ?: $_SERVER['RAZORPAY_KEY_ID'] ?? '';
$key_secret = getenv('RAZORPAY_KEY_SECRET') ?: $_ENV['RAZORPAY_KEY_SECRET'] ?: $_SERVER['RAZORPAY_KEY_SECRET'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    $action = $_POST['action'];

    if ($action === 'create_order') {
        $name = strip_tags(trim($_POST['name'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = strip_tags(trim($_POST['phone'] ?? ''));
        $profile = strip_tags(trim($_POST['profile'] ?? ''));

        if (empty($name) || empty($email) || empty($phone) || empty($profile)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields marked with *']);
            exit;
        }

        // Verify Captcha securely
        $captcha = trim($_POST['agdm_captcha'] ?? '');
        if (empty($captcha)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Verification is required. Please solve the math problem.']);
            exit;
        } elseif (!agdm_validate_captcha($captcha)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Incorrect verification answer. Please try again.']);
            exit;
        }

        if (empty($key_id) || empty($key_secret)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Razorpay credentials not configured. Please contact administration.']);
            exit;
        }

        // Call Razorpay API to create order
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $payload = json_encode([
            'amount' => 49900, // ₹499 in paise (must be >= 100 paise)
            'currency' => 'INR',
            'receipt' => 'rcpt_' . uniqid()
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 401) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Razorpay API Authentication failed.']);
            exit;
        } elseif ($http_code !== 200) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to initiate payment. Please try again.']);
            exit;
        }

        $order = json_decode($response, true);
        $order_id = $order['id'] ?? '';
        
        if (empty($order_id)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Invalid order details returned from Razorpay.']);
            exit;
        }

        // ─── Save lead immediately as "Payment Pending" ─────────────────────
        $crmFile = __DIR__ . '/leads_crm_7a3e91f2.csv';
        $isCrmNew = !file_exists($crmFile);
        $cfp = @fopen($crmFile, 'a');
        if ($cfp) {
            if ($isCrmNew) {
                fputcsv($cfp, ['Date', 'Name', 'Email', 'Phone', 'Profile', 'Course', 'Status', 'Order ID', 'Payment ID', 'IP Address']);
            }
            fputcsv($cfp, [
                date('Y-m-d H:i:s'),
                $name, $email, $phone, $profile,
                'Google Ads 10-Day Workshop',
                'Payment Pending',
                $order_id,
                '',
                $_SERVER['REMOTE_ADDR'] ?? ''
            ]);
            fclose($cfp);
        }

        echo json_encode([
            'success' => true,
            'order_id' => $order_id,
            'amount' => 49900,
            'currency' => 'INR',
            'key_id' => $key_id
        ]);
        exit;
    }

    if ($action === 'verify_payment') {
        $name = strip_tags(trim($_POST['name'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = strip_tags(trim($_POST['phone'] ?? ''));
        $profile = strip_tags(trim($_POST['profile'] ?? ''));
        
        $razorpay_payment_id = strip_tags(trim($_POST['razorpay_payment_id'] ?? ''));
        $razorpay_order_id = strip_tags(trim($_POST['razorpay_order_id'] ?? ''));
        $razorpay_signature = strip_tags(trim($_POST['razorpay_signature'] ?? ''));

        if (empty($name) || empty($email) || empty($phone) || empty($profile) || 
            empty($razorpay_payment_id) || empty($razorpay_order_id) || empty($razorpay_signature)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required payment verification parameters.']);
            exit;
        }

        if (empty($key_id) || empty($key_secret)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Razorpay credentials not configured. Please contact administration.']);
            exit;
        }

        // Verify Signature
        $expected_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $key_secret);
        
        if (!hash_equals($expected_signature, $razorpay_signature)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Payment signature verification failed.']);
            exit;
        }

        // ─── Update CRM lead status to "Paid" ────────────────────────────────
        $crmFile = __DIR__ . '/leads_crm_7a3e91f2.csv';
        if (file_exists($crmFile)) {
            $rows = []; $fh = fopen($crmFile, 'r'); $updated = false;
            while (($row = fgetcsv($fh)) !== false) {
                // CSV cols: 0=Date,1=Name,2=Email,3=Phone,4=Profile,5=Course,6=Status,7=Order ID,8=Payment ID,9=IP
                if (!$updated && isset($row[7]) && $row[7] === $razorpay_order_id) {
                    $row[6] = 'Paid';
                    $row[8] = $razorpay_payment_id;
                    $updated = true;
                }
                $rows[] = $row;
            }
            fclose($fh);
            $fh = fopen($crmFile, 'w');
            foreach ($rows as $r) { fputcsv($fh, $r); }
            fclose($fh);
            if (!$updated) { // order not found – append as new Paid entry
                $fh = fopen($crmFile, 'a');
                fputcsv($fh, [date('Y-m-d H:i:s'), $name, $email, $phone, $profile,
                    'Google Ads 10-Day Workshop', 'Paid', $razorpay_order_id, $razorpay_payment_id, $_SERVER['REMOTE_ADDR'] ?? '']);
                fclose($fh);
            }
        } else {
            $fh = @fopen($crmFile, 'w');
            if ($fh) {
                fputcsv($fh, ['Date', 'Name', 'Email', 'Phone', 'Profile', 'Course', 'Status', 'Order ID', 'Payment ID', 'IP Address']);
                fputcsv($fh, [date('Y-m-d H:i:s'), $name, $email, $phone, $profile,
                    'Google Ads 10-Day Workshop', 'Paid', $razorpay_order_id, $razorpay_payment_id, $_SERVER['REMOTE_ADDR'] ?? '']);
                fclose($fh);
            }
        }

        // ─── Legacy paid-only CSV (backward compatible) ───────────────────────
        $course = 'Google Ads 10-Day Workshop';
        $csvFile = __DIR__ . '/leads_log_9d8f34bc.csv';
        $isNewFile = !file_exists($csvFile);
        $fp = fopen($csvFile, 'a');
        if ($fp) {
            if ($isNewFile) {
                fputcsv($fp, ['Date', 'Name', 'Email', 'Phone', 'City', 'Course', 'Batch', 'Profile', 'IP Address', 'Payment ID', 'Order ID']);
            }
            fputcsv($fp, [
                date('Y-m-d H:i:s'),
                $name, $email, $phone,
                'Zoom Workshop', $course, '3:00 PM - 5:00 PM', $profile,
                $_SERVER['REMOTE_ADDR'] ?? '',
                $razorpay_payment_id, $razorpay_order_id
            ]);
            fclose($fp);
        }

        $recipient = "info@agdmacademy.com";
        $subject = "AGDM Academy - New Paid Google Ads Workshop Registration";

        $email_content = "New Registration for 10-Day Google Ads Workshop (Paid):\n\n";
        $email_content .= "Full Name: $name\n";
        $email_content .= "Email Address: $email\n";
        $email_content .= "Phone / WhatsApp: $phone\n";
        $email_content .= "Profile Type: $profile\n";
        $email_content .= "Workshop Fee: ₹499 (Paid via Razorpay)\n";
        $email_content .= "Batch Time: 3:00 PM to 5:00 PM (Zoom)\n";
        $email_content .= "Payment ID: $razorpay_payment_id\n";
        $email_content .= "Order ID: $razorpay_order_id\n";

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
}
?>
<!DOCTYPE html>
<html lang="en-GB">
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
<title>10-Days Google Ads Workshop | AGDM Academy Delhi</title>
<meta name="description" content="Join AGDM Academy's intensive 10-Day Google Ads Workshop. Master Search, Display, and Video campaigns on Zoom. Register now!">
<meta name="keywords" content="google ads workshop, learn google ads, google ads course delhi, search campaigns workshop, display ads training, pay per click course, online google ads class">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Favicon -->
<link rel="icon" type="image/png" href="assets/logo-new.png">
<link rel="shortcut icon" type="image/png" href="assets/logo-new.png">
<link rel="apple-touch-icon" href="assets/logo-new.png">

<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --red: #dc1e28;
    --red-dark: #a8131b;
    --red-light: #fff0f1;
    --red-mid: #fde8ea;
    --black: #111827;
    --dark: #0f172a;
    --gray: #6b7280;
    --light-gray: #f9fafb;
    --white: #ffffff;
    --gold: #f59e0b;
    --green: #16a34a;
    --font-head: 'Outfit', sans-serif;
    --font-body: 'Inter', sans-serif;
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: var(--font-body);
    color: var(--black);
    background: var(--white);
    overflow-x: hidden;
    -webkit-text-size-adjust: 100%;
  }

  /* ─── COUNTDOWN BAR ─── */
  .countdown-bar {
    background: var(--red);
    color: white;
    text-align: center;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.5;
    position: sticky;
    top: 0;
    z-index: 1001;
  }
  .countdown-bar #timer {
    font-family: var(--font-head);
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 2px;
  }

  /* ─── STICKY HEADER ─── */
  .sticky-header {
    position: sticky;
    top: 41px; left: 0; right: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 2px solid var(--red);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 0 5%;
    height: 70px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    box-sizing: border-box;
  }
  .header-logo {
    display: flex;
    align-items: center;
    height: 100%;
    min-height: 48px;
    text-decoration: none;
  }
  .header-logo img {
    height: 44px;
    width: auto;
    display: block;
    object-fit: contain;
    flex-shrink: 0;
  }
  .header-phone {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
    color: var(--red);
    text-decoration: none;
    white-space: nowrap;
    min-height: 48px;
    padding: 8px 4px;
  }
  .header-phone svg { flex-shrink: 0; }
  .header-cta {
    background: var(--red);
    color: var(--white);
    font-family: var(--font-head);
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 0.5px;
    padding: 12px 20px;
    min-height: 48px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: background 0.2s;
    border-radius: 4px;
    flex-shrink: 0;
    box-sizing: border-box;
  }
  .header-cta:hover { background: var(--red-dark); }

  .header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .header-nav {
    display: flex;
    align-items: center;
    gap: 24px;
  }
  .header-nav a {
    color: var(--black);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    font-family: var(--font-head);
    transition: color 0.2s;
    letter-spacing: 0.3px;
    position: relative;
    padding: 8px 0;
  }
  .header-nav a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--red);
    transform: scaleX(0);
    transition: transform 0.2s ease;
  }
  .header-nav a:hover {
    color: var(--red);
  }
  .header-nav a:hover::after {
    transform: scaleX(1);
  }
  .nav-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    flex-direction: column;
    justify-content: space-between;
    width: 22px;
    height: 16px;
    padding: 0;
    margin-left: 4px;
  }
  .nav-toggle .bar {
    width: 100%;
    height: 2px;
    background-color: var(--black);
    transition: all 0.3s ease;
  }

  /* ─── HERO ─── */
  .hero {
    padding-top: 0;
    background: var(--dark);
    position: relative;
    overflow: hidden;
  }
  .hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -80px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(220,30,40,0.15) 0%, transparent 70%);
    pointer-events: none;
  }
  .hero-inner {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 48px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 56px 5% 0;
    align-items: start;
  }
  .hero-left {
    padding-bottom: 56px;
    min-width: 0; /* prevent grid blowout */
  }
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--red);
    color: var(--white);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 14px;
    margin-bottom: 20px;
    border-radius: 2px;
    max-width: 100%;
  }
  .hero-badge .badge-dot {
    width: 7px; height: 7px;
    background: #fff;
    border-radius: 50%;
    display: block;
    flex-shrink: 0;
    animation: pulse 1.5s infinite;
  }
  @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.8)} }

  .hero h1 {
    font-family: var(--font-head);
    font-size: clamp(28px, 3.5vw, 50px);
    font-weight: 800;
    color: var(--white);
    line-height: 1.15;
    margin-bottom: 18px;
    word-break: break-word;
  }
  .hero h1 em { font-style: normal; color: var(--red); }
  .hero-sub {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.7;
    margin-bottom: 28px;
    max-width: 540px;
  }
  .hero-benefits {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 32px;
  }
  .hero-benefits li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: #e2e8f0;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.45;
    min-width: 0;
    overflow: hidden;
  }
  .hero-benefits li .check-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px; height: 20px;
    min-width: 20px;
    background: var(--red);
    border-radius: 2px;
    margin-top: 2px;
    flex-shrink: 0;
  }
  .hero-benefits li span:not(.check-icon) {
    flex: 1;
    min-width: 0;
    word-break: break-word;
    overflow-wrap: break-word;
  }
  .hero-cta-group {
    display: flex;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
  }
  .cta-btn-large {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--red);
    color: white;
    font-family: var(--font-head);
    font-size: 17px;
    font-weight: 700;
    padding: 15px 32px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    letter-spacing: 0.4px;
    border-radius: 4px;
    white-space: nowrap;
  }
  .cta-btn-large:hover { background: var(--red-dark); transform: translateY(-1px); }
  .hero-cta-timing {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #94a3b8;
  }
  .hero-cta-timing strong { color: white; }

  /* ─── FORM ─── */
  .hero-form-col {
    padding-bottom: 0;
    align-self: start;
  }
  .hero-form-wrap {
    background: var(--white);
    padding: 32px 28px;
    position: relative;
    box-shadow: 0 8px 40px rgba(0,0,0,0.18);
    border-radius: 4px;
    width: 100%;
  }
  .hero-form-wrap::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: var(--red);
    border-radius: 4px 4px 0 0;
  }
  .form-headline {
    font-family: var(--font-head);
    font-size: 19px;
    font-weight: 800;
    color: var(--black);
    margin-bottom: 4px;
    text-align: center;
  }
  .form-sub {
    font-size: 13px;
    color: var(--gray);
    text-align: center;
    margin-bottom: 18px;
  }
  .form-sub strong { color: var(--red); }
  .seats-bar {
    background: var(--red-light);
    border: 1px solid rgba(220, 30, 40, 0.25);
    padding: 10px 14px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 6px;
    box-shadow: 0 4px 15px rgba(220, 30, 40, 0.06);
    animation: seatsPulse 2.5s infinite ease-in-out;
  }
  @keyframes seatsPulse {
    0%, 100% {
      box-shadow: 0 4px 15px rgba(220, 30, 40, 0.06);
      border-color: rgba(220, 30, 40, 0.25);
    }
    50% {
      box-shadow: 0 4px 20px rgba(220, 30, 40, 0.15);
      border-color: rgba(220, 30, 40, 0.5);
      background: var(--red-mid);
    }
  }
  .seats-bar-fill {
    flex: 1;
    height: 8px;
    background: rgba(220, 30, 40, 0.1);
    border-radius: 4px;
    overflow: hidden;
    min-width: 0;
  }
  .seats-bar-fill div {
    width: 73%;
    height: 100%;
    background: linear-gradient(90deg, var(--red) 0%, #ff4b55 100%);
    border-radius: 4px;
    position: relative;
    overflow: hidden;
  }
  .seats-bar-fill div::after {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0; right: 0;
    background: linear-gradient(
      90deg,
      rgba(255, 255, 255, 0) 0%,
      rgba(255, 255, 255, 0.4) 50%,
      rgba(255, 255, 255, 0) 100%
    );
    animation: shimmer 2s infinite linear;
  }
  @keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
  }
  .seats-text {
    font-size: 11.5px;
    font-weight: 800;
    color: var(--red);
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
  }
  .seats-text svg {
    animation: firePulse 1.5s infinite ease-in-out;
  }
  @keyframes firePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); color: #ff8c00; }
  }
  .form-group { margin-bottom: 12px; }
  .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 4px;
  }
  .form-group label span { color: var(--red); }
  .form-group input, .form-group select {
    width: 100%;
    padding: 13px 14px;
    border: 1.5px solid #ddd;
    font-family: var(--font-body);
    font-size: 16px;
    color: var(--black);
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
    border-radius: 4px;
    min-height: 48px;
  }
  .form-group input:focus, .form-group select:focus { border-color: var(--red); }
  .form-group input::placeholder { color: #aaa; }

  /* --- CAPTCHA --- */
  .captcha-wrapper { margin-top: 14px; margin-bottom: 14px; text-align: left; }
  .captcha-wrapper label { display: block; font-size: 12px; font-weight: 600; color: var(--black); margin-bottom: 6px; }
  .captcha-wrapper .input-group { display: flex; align-items: stretch; }
  .captcha-wrapper .input-group-text {
    background: var(--dark) !important;
    color: var(--white) !important;
    font-family: var(--font-head);
    font-weight: 700;
    font-size: 13px;
    padding: 13px 14px;
    min-height: 48px;
    border: 1.5px solid var(--dark);
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
    white-space: nowrap;
  }
  .captcha-wrapper input.form-control {
    flex: 1;
    min-width: 0;
    border: 1.5px solid #ddd;
    border-left: none;
    padding: 13px 14px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.2s;
    border-radius: 0;
    min-height: 48px;
  }
  .captcha-wrapper input.form-control:focus { border-color: var(--red); }
  .captcha-wrapper #refresh-captcha-btn {
    background: var(--white);
    border: 1.5px solid #ddd;
    border-left: none;
    color: var(--red);
    padding: 0 16px;
    cursor: pointer;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, color 0.2s;
    flex-shrink: 0;
    min-width: 48px;
    min-height: 48px;
  }
  .captcha-wrapper #refresh-captcha-btn:hover { background: var(--red-light); color: var(--red-dark); }

  .btn-submit {
    width: 100%;
    background: var(--red);
    color: white;
    border: none;
    padding: 16px;
    min-height: 52px;
    font-family: var(--font-head);
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .btn-submit:hover { background: var(--red-dark); }
  .btn-submit:active { transform: scale(0.99); }
  .btn-submit:disabled { background: #ccc; cursor: not-allowed; }
  .form-trust {
    margin-top: 14px;
  }
  .form-trust-text {
    font-size: 12px;
    color: #4b5563;
    line-height: 1.65;
    text-align: center;
    padding: 10px 4px 12px;
    border-top: 1px solid #f0f0f0;
  }
  .form-trust-text strong { color: var(--black); }
  .form-trust-badges {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    padding-top: 10px;
    border-top: 1px solid #ececec;
    flex-wrap: wrap;
  }
  .trust-badge-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    white-space: nowrap;
  }
  .trust-badge-item svg { flex-shrink: 0; }
  .trust-badge-item img { height: 16px; width: auto; opacity: 0.55; }

  /* ─── LOGOS BAR ─── */
  .logos-bar {
    background: #f8fafc;
    padding: 24px 5%;
    border-bottom: 1px solid #e2e8f0;
    text-align: center;
  }
  .logos-bar-label {
    font-size: 12px;
    color: var(--gray);
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 16px;
    display: block;
  }
  .logos-bar-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
  }
  .logo-pill {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 600;
    color: var(--black);
    background: white;
    padding: 8px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    transition: all 0.2s ease;
    cursor: default;
    user-select: none;
    min-height: 44px;
  }
  .logo-pill:hover {
    border-color: var(--red-mid);
    box-shadow: 0 4px 12px rgba(220,30,40,0.06);
    transform: translateY(-1px);
  }
  .logo-pill svg {
    flex-shrink: 0;
  }

  /* ─── SECTIONS ─── */
  .section { padding: 70px 5%; }
  .section-inner { max-width: 1100px; margin: 0 auto; }
  .section-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--red);
    margin-bottom: 10px;
  }
  .section-title {
    font-family: var(--font-head);
    font-size: clamp(24px, 3.5vw, 40px);
    font-weight: 800;
    color: var(--black);
    line-height: 1.2;
    margin-bottom: 14px;
  }
  .section-desc {
    font-size: 16px;
    color: var(--gray);
    max-width: 560px;
    line-height: 1.7;
    margin-bottom: 40px;
  }

  /* ─── LEARN CARDS ─── */
  .learn-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  .learn-card {
    border: 1.5px solid #eee;
    padding: 26px 24px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.2s, transform 0.2s;
    background: var(--white);
    border-radius: 4px;
  }
  .learn-card:hover { border-color: var(--red); transform: translateY(-3px); }
  .learn-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: var(--red);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s;
  }
  .learn-card:hover::after { transform: scaleX(1); }
  .card-number {
    font-family: var(--font-head);
    font-size: 42px;
    font-weight: 800;
    color: var(--red-mid);
    line-height: 1;
    margin-bottom: 12px;
  }
  .card-title {
    font-family: var(--font-head);
    font-size: 17px;
    font-weight: 700;
    color: var(--black);
    margin-bottom: 8px;
  }
  .card-desc { font-size: 14px; color: var(--gray); line-height: 1.6; }

  /* ─── PROOF STATS ─── */
  .proof-section { background: var(--red); padding: 56px 5%; }
  .proof-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: rgba(255,255,255,0.2);
  }
  .proof-stat { background: var(--red); text-align: center; padding: 36px 16px; }
  .proof-num {
    font-family: var(--font-head);
    font-size: 46px;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
  }
  .proof-label { font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 500; line-height: 1.4; }

  /* ─── TESTIMONIALS SLIDER ─── */
  .testi-slider-wrap {
    position: relative;
    margin-top: 40px;
  }
  .testi-slider {
    overflow: hidden;
    border-radius: 6px;
  }
  .testi-track {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    will-change: transform;
  }
  .testi-card {
    flex: 0 0 calc(33.333% - 14px);
    margin: 0 7px;
    border: 1.5px solid #eee;
    padding: 28px 24px;
    background: var(--white);
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 220px;
    transition: box-shadow 0.25s, border-color 0.25s;
    box-sizing: border-box;
  }
  .testi-card:hover { border-color: var(--red-mid); box-shadow: 0 6px 24px rgba(0,0,0,0.06); }
  .stars { color: var(--gold); font-size: 15px; margin-bottom: 14px; letter-spacing: 2px; }
  .testi-text { font-size: 14px; color: var(--gray); line-height: 1.75; margin-bottom: 20px; font-style: italic; flex: 1; }
  .testi-author { display: flex; align-items: center; gap: 12px; }
  .testi-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--red-mid);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; color: var(--red);
    flex-shrink: 0;
  }
  .testi-name { font-weight: 700; font-size: 14px; color: var(--black); }
  .testi-role { font-size: 12px; color: var(--gray); margin-top: 2px; }

  /* Slider Controls */
  .testi-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 32px;
  }
  .testi-btn {
    width: 48px; height: 48px;
    border-radius: 50%;
    border: 1.5px solid #ddd;
    background: var(--white);
    color: var(--black);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
  }
  .testi-btn:hover { border-color: var(--red); color: var(--red); background: var(--red-light); }
  .testi-btn svg { width: 20px; height: 20px; pointer-events: none; }
  .testi-dots {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .testi-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: #ddd;
    border: none;
    cursor: pointer;
    transition: all 0.25s;
    padding: 0;
  }
  .testi-dot.active {
    background: var(--red);
    width: 28px;
    border-radius: 5px;
  }

  /* Slider counter badge */
  .testi-counter {
    text-align: center;
    margin-top: 12px;
    font-size: 13px;
    color: var(--gray);
    font-weight: 500;
  }
  .testi-counter strong { color: var(--black); }

  @media (max-width: 1024px) {
    .testi-card { flex: 0 0 calc(50% - 14px); }
  }
  @media (max-width: 640px) {
    .testi-card { flex: 0 0 calc(100% - 14px); }
    .testi-controls { gap: 14px; margin-top: 24px; }
  }

  /* ─── WHO SHOULD ATTEND ─── */
  .who-section { background: var(--light-gray); padding: 70px 5%; }
  .who-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
    margin-top: 40px;
  }
  .who-card {
    background: white;
    border: 1.5px solid #e5e5e5;
    padding: 26px 18px;
    text-align: center;
    transition: border-color 0.2s, box-shadow 0.2s;
    border-radius: 4px;
  }
  .who-card:hover { border-color: var(--red); box-shadow: 0 4px 16px rgba(220,30,40,0.08); }
  .who-icon {
    width: 48px; height: 48px;
    margin: 0 auto 14px;
    background: var(--red-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
  }
  .who-title { font-family: var(--font-head); font-size: 15px; font-weight: 700; color: var(--black); margin-bottom: 6px; }
  .who-desc { font-size: 13px; color: var(--gray); line-height: 1.5; }

  /* ─── BOTTOM CTA ─── */
  .bottom-cta { background: var(--dark); padding: 80px 5%; text-align: center; }
  .bottom-cta-title {
    font-family: var(--font-head);
    font-size: clamp(26px, 4vw, 48px);
    font-weight: 800;
    color: white;
    margin-bottom: 14px;
    line-height: 1.2;
  }
  .bottom-cta-title em { font-style: normal; color: var(--red); }
  .bottom-cta-sub { font-size: 16px; color: #94a3b8; margin-bottom: 32px; line-height: 1.6; }
  .bottom-cta .cta-btn-large { font-size: 18px; padding: 16px 44px; }
  .cta-note {
    font-size: 13px;
    color: #718096;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 6px;
  }
  .cta-note-item { display: flex; align-items: center; gap: 5px; }
  .cta-note-divider { color: #4a5568; }

  /* ─── FOOTER ─── */
  .footer { background: #070b15; border-top: 1px solid #1e293b; padding: 28px 5%; text-align: center; }
  .footer img { height: 34px; width: auto; margin-bottom: 14px; }
  .footer p {
    font-size: 13px; color: #64748b; margin-bottom: 6px;
    display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 4px;
  }
  .footer a { color: #94a3b8; text-decoration: none; display: inline-flex; align-items: center; min-height: 48px; padding: 8px 4px; }
  .footer a:hover { color: var(--red); }
  .footer-divider { color: #334155; }

  /* ─── FLOATING WHATSAPP ─── */
  .wa-float {
    position: fixed;
    bottom: 24px; right: 24px;
    background: #25d366;
    color: white;
    width: 54px; height: 54px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    z-index: 999;
    box-shadow: 0 4px 20px rgba(37,211,102,0.4);
    transition: transform 0.2s, opacity 0.2s, visibility 0.2s;
  }
  .wa-float:hover { transform: scale(1.1); }
  .wa-float svg { fill: #fff; width: 26px; height: 26px; }
  
  body.form-focused .wa-float {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: scale(0);
  }

  /* ─── RESPONSIVE ─── */

  /* ≥1025px: Two-column hero (default, no query needed) */

  @media (max-width: 1200px) {
    .hero-inner { grid-template-columns: 1fr 380px; }
  }

  @media (max-width: 1024px) {
    .hero-inner {
      grid-template-columns: 1fr;
      padding: 40px 5% 0;
      gap: 32px;
    }
    .hero-left {
      max-width: 680px;
      margin: 0 auto;
      padding-bottom: 0;
      width: 100%;
    }
    .hero-form-col {
      width: 100%;
      max-width: 500px;
      margin: 0 auto 48px;
    }
    .hero-form-wrap { padding: 28px 24px; }
    .sticky-header .header-phone { display: none; }
    .proof-inner { grid-template-columns: repeat(2, 1fr); }
    
    .header-nav {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: rgba(255, 255, 255, 0.98);
      flex-direction: column;
      padding: 16px 0;
      gap: 0;
      border-bottom: 2px solid var(--red);
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      z-index: 999;
    }
    .header-nav.active {
      display: flex;
    }
    .header-nav a {
      width: 100%;
      text-align: center;
      padding: 12px 0;
      border-bottom: 1px solid #f3f4f6;
    }
    .header-nav a:last-child {
      border-bottom: none;
    }
    .header-nav a::after {
      display: none;
    }
    .nav-toggle {
      display: flex;
    }
    .nav-toggle.active .bar:nth-child(1) {
      transform: translateY(7px) rotate(45deg);
    }
    .nav-toggle.active .bar:nth-child(2) {
      opacity: 0;
    }
    .nav-toggle.active .bar:nth-child(3) {
      transform: translateY(-7px) rotate(-45deg);
    }
  }

  @media (max-width: 768px) {
    .section { padding: 50px 5%; }
    .who-section { padding: 50px 5%; }
    .section-desc { margin-bottom: 28px; }
    .proof-stat { padding: 28px 12px; }
    .proof-num { font-size: 38px; }
    .testi-grid { grid-template-columns: 1fr; }
    .hero h1 { font-size: clamp(26px, 6vw, 38px); }
    .hero-sub { font-size: 15px; }
  }

  @media (max-width: 576px) {
    .hero-inner { padding: 32px 5% 0; gap: 24px; }
    .hero-left { max-width: 100%; }
    .hero-form-col { max-width: 100%; margin-bottom: 0; }
    .hero-cta-group { flex-direction: column; align-items: stretch; gap: 12px; }
    .cta-btn-large { justify-content: center; width: 100%; }
    .hero-cta-timing { justify-content: center; }
    .who-grid { grid-template-columns: repeat(2, 1fr); }
    .cta-note { flex-direction: column; gap: 4px; }
    .cta-note-divider { display: none; }
    .bottom-cta .cta-btn-large { width: 100%; justify-content: center; padding: 14px 20px; font-size: 16px; }
    .bottom-cta-sub { font-size: 15px; }
    .footer p { flex-direction: column; gap: 4px; }
    .footer-divider { display: none; }
  }

  @media (max-width: 480px) {
    .sticky-header { height: 60px; padding: 0 16px; top: 34px; }
    .header-logo img { height: 36px; }
    .header-cta { font-size: 12px; padding: 10px 14px; min-height: 40px; }
    .hero h1 { font-size: 24px; }
    .hero-benefits li { font-size: 14px; }
    .hero-form-wrap { padding: 22px 16px; }
    .form-headline { font-size: 17px; }
    .learn-grid { grid-template-columns: 1fr; }
    .who-grid { grid-template-columns: 1fr; }
    .bottom-cta { padding: 50px 5%; }
    .bottom-cta-title { font-size: 24px; }
    .proof-stat { padding: 20px 8px; }
    .proof-num { font-size: 32px; }
    .wa-float { bottom: 16px; right: 16px; width: 48px; height: 48px; }
    .wa-float svg { width: 22px; height: 22px; }
    .countdown-bar { font-size: 12px; padding: 8px 12px; }
    .countdown-bar #timer { font-size: 15px; }
    .seats-bar {
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 6px 10px;
    }
    .seats-bar-fill {
      width: 100%;
      flex: none;
      order: 3;
    }
  }

  /* ─── BATCH BADGE ─── */
  .batch-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #1c1200;
    font-family: var(--font-head);
    font-size: 15px;
    font-weight: 700;
    padding: 9px 18px;
    border-radius: 50px;
    box-shadow: 0 3px 12px rgba(245,158,11,0.35);
    white-space: normal;
    flex-wrap: wrap;
    justify-content: center;
    gap: 6px;
    text-align: center;
  }
  .batch-badge .batch-dot {
    width: 8px; height: 8px;
    background: #fff;
    border-radius: 50%;
    flex-shrink: 0;
    animation: pulse 1.8s infinite;
  }
  .batch-badge-wrap {
    margin: 18px 0 24px;
  }
  .form-batch-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #1c1200;
    font-family: var(--font-head);
    font-size: 14px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 6px;
    margin: 8px 0 14px;
    box-shadow: 0 2px 8px rgba(245,158,11,0.3);
    text-align: center;
    flex-wrap: wrap;
  }

  @media (max-width: 576px) {
    .batch-badge {
      font-size: 13px;
      padding: 8px 14px;
      width: 100%;
      border-radius: 10px;
    }
    .batch-badge-wrap {
      text-align: center;
    }
  }

  @media (max-width: 360px) {
    .sticky-header { padding: 0 12px; }
    .header-logo img { height: 32px; }
    .header-cta { font-size: 11px; padding: 8px 10px; min-height: 36px; }
    .hero h1 { font-size: 22px; }
    .batch-badge { font-size: 12px; padding: 7px 12px; }
  }
</style>
</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFXS4WTB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- COUNTDOWN BAR -->
<div class="countdown-bar">
  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block; vertical-align:-1px; margin-right:4px; color: #ffc107;"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Workshop seats are filling fast — registration closes in: <span id="timer">00:00:00</span>
</div>

<!-- STICKY HEADER -->
<header class="sticky-header">
  <a href="./" class="header-logo" title="AGDM Academy Home">
    <img src="assets/logo-new.png" alt="AGDM Academy Logo">
  </a>
  
  <nav class="header-nav" id="headerNav">
    <a href="#curriculum">Curriculum</a>
    <a href="#reviews">Reviews</a>
    <a href="#who-for">Who It's For</a>
  </nav>

  <div class="header-actions">
    <a href="tel:+919643661661" class="header-phone">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> +91 96436 61661
    </a>
    <a href="#register" class="header-cta">
      Register Now (₹499)
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-left:4px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>
  </div>
</header>

<!-- HERO SECTION -->
<section class="hero">
  <div class="hero-inner">
    <!-- LEFT: Copy -->
    <div class="hero-left">
      <div class="hero-badge"><span class="badge-dot"></span> 10-Day Google Ads Workshop — Live on Zoom</div>
      <h1>
        Master <em>Google Ads</em><br>
        to Scale Campaigns &amp;<br>
        Maximize ROI
      </h1>
      <p class="hero-sub">
        An intensive 10-days practical workshop. Learn how to set up, optimize, and scale profitable Google Ads campaigns from scratch. Daily live sessions on Zoom from 3:00 PM to 5:00 PM.
      </p>
      <div class="batch-badge-wrap">
        <span class="batch-badge">
          <span class="batch-dot"></span>
          📅 Next Batch Starts: Julu 6, 2026 &nbsp;|&nbsp; Last few seats remaining
        </span>
      </div>
      <ul class="hero-benefits">
        <li>
          <span class="check-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color:white;"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          Complete Google Ads funnel setup &amp; campaign structure
        </li>
        <li>
          <span class="check-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color:white;"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          Master Keyword Search, Display, and Video campaigns
        </li>
        <li>
          <span class="check-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color:white;"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          Proven bidding strategies to double your ROAS
        </li>
        <li>
          <span class="check-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color:white;"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          Daily Live Zoom classes from 3:00 PM to 5:00 PM
        </li>
        <li>
          <span class="check-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color:white;"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          Hands-on training with live campaigns and real budgets
        </li>
      </ul>
      <div class="hero-cta-group">
        <a href="#register" class="cta-btn-large hero-cta-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:6px;"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
          Book My Seat — ₹499 Only
        </a>
        <div class="hero-cta-timing">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Timing: <strong style="color:white;">3:00 PM to 5:00 PM Daily</strong>
        </div>
      </div>
    </div>

    <!-- RIGHT: Form -->
    <div id="register" class="hero-form-col">
      <div class="hero-form-wrap">
        <div class="seats-bar">
          <div class="seats-text">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px; color: var(--red);"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
            73% of seats filled
          </div>
          <div class="seats-bar-fill"><div></div></div>
          <div class="seats-text">27 left</div>
        </div>
        <div class="form-headline">Register for the Workshop</div>
        <div class="form-batch-badge">
          📅 Next Batch: <strong>July 6, 2026</strong> — Book your seat before it fills up
        </div>
        <p class="form-sub">Join <strong>200+ students</strong>. Workshop Fee: <strong>₹499 only</strong></p>

        <form id="workshopForm" onsubmit="handleSubmit(event)">
          <div class="form-group">
            <label for="name">Full Name <span>*</span></label>
            <input type="text" id="name" placeholder="Your Full Name *" required>
          </div>
          <div class="form-group">
            <label for="phone">WhatsApp Number <span>*</span></label>
            <input type="tel" id="phone" placeholder="WhatsApp Number *" required pattern="[0-9]{10}">
          </div>
          <div class="form-group">
            <label for="email">Email Address <span>*</span></label>
            <input type="email" id="email" placeholder="Email Address *" required>
          </div>
          <div class="form-group">
            <label for="profile">I am a... <span>*</span></label>
            <select id="profile" required>
              <option value="" disabled selected>Select your profile *</option>
              <option value="Student">Student (12th / Graduate)</option>
              <option value="Working Professional">Working Professional</option>
              <option value="Business Owner">Business Owner</option>
              <option value="Freelancer">Freelancer</option>
              <option value="Job Seeker">Job Seeker</option>
            </select>
          </div>

          <!-- Captcha row dynamically rendered from helper -->
          <?= agdm_render_captcha(false); ?>

          <div id="formError" style="display: none; color: var(--red); font-size: 13px; font-weight: 600; text-align: center; margin-bottom: 14px; background: var(--red-light); padding: 10px; border: 1px solid var(--red-mid);"></div>

          <button type="submit" class="btn-submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:6px;"><polyline points="20 6 9 17 4 12"/></svg>
            REGISTER NOW (₹499 ONLY)
          </button>
        </form>
        <div class="form-trust">
          <p class="form-trust-text">
            🔒 <strong>Secure Checkout</strong> &mdash; After clicking register, the secure Razorpay payment window will open instantly to complete your <strong>&#8377;499 payment</strong> (UPI / GPay / Card / Net Banking).<br>
            Once completed successfully, Zoom details will be shared instantly via WhatsApp &amp; Email.
          </p>
          <div class="form-trust-badges">
            <span class="trust-badge-item">
              <img src="https://razorpay.com/assets/razorpay-glyph.svg" alt="Razorpay" onerror="this.style.display='none'">
              Razorpay
            </span>
            <span class="trust-badge-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              SSL Secured
            </span>
            <span class="trust-badge-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              100% Safe Payment
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LOGOS BAR -->
<div class="logos-bar">
  <span class="logos-bar-label">Our graduates work at:</span>
  <div class="logos-bar-inner">
    <div class="logo-pill">
      <svg viewBox="0 0 24 24" width="18" height="18" style="display:inline-block; vertical-align:middle; flex-shrink:0;"><path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.61 14.98 1 12 1 7.35 1 3.37 3.67 1.39 7.56l3.85 2.99c.9-2.7 3.4-4.51 6.76-4.51z"/><path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.44h6.43c-.28 1.48-1.11 2.73-2.37 3.58l3.69 2.87c2.16-1.99 3.49-4.92 3.49-8.55z"/><path fill="#FBBC05" d="M5.24 10.55c-.23-.69-.36-1.42-.36-2.18s.13-1.49.36-2.18L1.39 3.2C.5 4.97 0 6.93 0 9s.5 4.03 1.39 5.8l3.85-3.25z"/><path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.69-2.87c-1.02.68-2.33 1.09-3.97 1.09-3.36 0-5.86-1.81-6.76-4.51L1.69 16.8C3.67 20.33 7.35 23 12 23z"/></svg>
      Google
    </div>
    <div class="logo-pill">
      <svg viewBox="0 0 24 24" width="18" height="18" style="display:inline-block; vertical-align:middle; flex-shrink:0;"><path fill="#232F3E" d="M12.9 8.2c-.8.1-1.9.2-2.6.5-1 .3-1.8 1-2.2 1.9-.3.7-.4 1.6-.4 2.4 0 1.2.3 2.2 1 2.9.7.7 1.7 1.1 2.9 1.1.9 0 1.8-.3 2.5-.8.6-.4 1-1 1.2-1.7h.1l.1.8.1.7h2.1c-.1-.5-.2-1.3-.2-2.2V9.8c0-1.2-.3-2.1-.9-2.7-.8-.7-2.1-1-3.9-1-1.6 0-3 .3-4 .8l.5 1.9c.8-.4 1.9-.7 3.1-.7 1.1 0 1.9.2 2.3.6.4.3.6.9.6 1.7v1c-1 .1-2.1 0-3 .2zM15 12.8c0 .8-.2 1.5-.6 2-.4.4-1 .7-1.7.7-.6 0-1-.2-1.3-.5-.3-.4-.4-.9-.4-1.5 0-1.1.7-1.8 2-2 .6-.1 1.3-.1 2-.2v1.5z"/><path fill="#FF9900" d="M19.5 19c-2.8 2-7.3 2.6-10.8 2.6-5.1 0-9.2-1.6-12-4.3-.3-.3-.1-.8.4-.5 3.5 2.3 8.3 3.1 12.2 3.1 3.4 0 7.5-.8 10.6-2.4.5-.3.9.2.2.5z"/><path fill="#FF9900" d="M20.7 17c-.4.5-2.1.3-3 .2-.8-.1-1.1-.6-.7-.9.8-.5 2.5-.7 3.1-.2.6.4.7 1.1.6.9z"/></svg>
      Amazon
    </div>
    <div class="logo-pill">
      <svg viewBox="0 0 24 24" width="18" height="18" style="display:inline-block; vertical-align:middle; flex-shrink:0;"><path fill="#0668E1" d="M16.92 6a4.89 4.89 0 0 0-3.62 1.63L12 9.1l-1.3-1.47a4.91 4.91 0 0 0-7.23 0 5.43 5.43 0 0 0 0 7.46 4.91 4.91 0 0 0 7.23 0L12 13.62l1.3 1.47a4.91 4.91 0 0 0 7.23 0 5.43 5.43 0 0 0 0-7.46A4.89 4.89 0 0 0 16.92 6zm2.34 6.86a2.66 2.66 0 0 1-3.9 0L12 9.07l-3.36 3.79a2.66 2.66 0 0 1-3.9 0 2.94 2.94 0 0 1 0-4.04 2.66 2.66 0 0 1 3.9 0L12 12.61l3.36-3.79a2.66 2.66 0 0 1 3.9 0 2.94 2.94 0 0 1 0 4.04z"/></svg>
      Meta
    </div>
    <div class="logo-pill">
      <svg viewBox="0 0 23 23" width="16" height="16" style="display:inline-block; vertical-align:middle; flex-shrink:0; margin-right:2px;"><rect x="0" y="0" width="10.5" height="10.5" fill="#F25022"/><rect x="12.5" y="0" width="10.5" height="10.5" fill="#7FBA00"/><rect x="0" y="12.5" width="10.5" height="10.5" fill="#00A4EF"/><rect x="12.5" y="12.5" width="10.5" height="10.5" fill="#FFB900"/></svg>
      Microsoft
    </div>
    <div class="logo-pill">
      <svg viewBox="0 0 24 24" width="16" height="16" style="display:inline-block; vertical-align:middle; flex-shrink:0;"><path fill="#0077B5" d="M22.23 0H1.77C.8 0 0 .77 0 1.72v20.56C0 23.23.8 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.2 0 22.23 0zM7.12 20.45H3.56V9h3.56v11.45zM5.34 7.43c-1.14 0-2.06-.92-2.06-2.06 0-1.14.92-2.06 2.06-2.06 1.14 0 2.06.92 2.06 2.06 0 1.14-.92 2.06-2.06 2.06zm15.11 13.02h-3.56v-5.6c0-1.34-.03-3.05-1.86-3.05-1.86 0-2.14 1.45-2.14 2.95v5.7h-3.56V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29z"/></svg>
      LinkedIn
    </div>
    <div class="logo-pill">
      <svg viewBox="0 0 72 20" width="60" height="16" style="display:inline-block; vertical-align:middle; flex-shrink:0; margin-right:2px;"><text x="0" y="15" font-family="'Inter', 'Arial', sans-serif" font-weight="800" font-size="14" fill="#0c1d43" letter-spacing="-0.5">group</text><text x="44" y="15" font-family="'Georgia', serif" font-style="italic" font-weight="900" font-size="18" fill="#1d70b8">m</text></svg>
    </div>
  </div>
</div>

<!-- PROOF STATS -->
<div class="proof-section">
  <div class="proof-inner">
    <div class="proof-stat">
      <div class="proof-num">500+</div>
      <div class="proof-label">Students Trained</div>
    </div>
    <div class="proof-stat">
      <div class="proof-num">₹5Cr+</div>
      <div class="proof-label">Ad Spend Managed</div>
    </div>
    <div class="proof-stat">
      <div class="proof-num">50+</div>
      <div class="proof-label">Hiring Partners</div>
    </div>
    <div class="proof-stat">
      <div class="proof-num">100%</div>
      <div class="proof-label">Placement Assistance</div>
    </div>
  </div>
</div>

<!-- WHAT YOU WILL LEARN -->
<section class="section" id="curriculum">
  <div class="section-inner">
    <div class="section-label">Workshop Curriculum</div>
    <h2 class="section-title">Everything You'll Learn<br>in 10 Days — for ₹499</h2>
    <p class="section-desc">Every module is built around real campaign setup and optimization. Sessions are conducted live on Zoom daily from 3:00 PM to 5:00 PM.</p>

    <div class="learn-grid">
      <div class="learn-card">
        <div class="card-number">01</div>
        <div class="card-title">Google Ads Account &amp; Structure</div>
        <p class="card-desc">Set up your Google Ads account, understand campaign types, campaign hierarchy, and basic navigation parameters.</p>
      </div>
      <div class="learn-card">
        <div class="card-number">02</div>
        <div class="card-title">Search Ads &amp; Keyword Bidding</div>
        <p class="card-desc">Master keyword research, match types, writing high-CTR ad copy, and setting up bid strategies.</p>
      </div>
      <div class="learn-card">
        <div class="card-number">03</div>
        <div class="card-title">Display &amp; Video Campaigns</div>
        <p class="card-desc">Create visually appealing display banner ads and high-converting YouTube video campaigns from scratch.</p>
      </div>
      <div class="learn-card">
        <div class="card-number">04</div>
        <div class="card-title">Conversion Tracking &amp; GA4</div>
        <p class="card-desc">Implement Google Tag Manager, track leads and sales, and integrate your account with Google Analytics 4.</p>
      </div>
      <div class="learn-card">
        <div class="card-number">05</div>
        <div class="card-title">Remarketing &amp; Smart Bidding</div>
        <p class="card-desc">Set up audience remarketing lists and leverage Google's smart bidding algorithms to optimize your spend.</p>
      </div>
      <div class="learn-card">
        <div class="card-number">06</div>
        <div class="card-title">ROAS Optimization &amp; Q&amp;A</div>
        <p class="card-desc">Learn how to analyze performance, optimize Quality Score, and get direct answers to campaign challenges.</p>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS SLIDER -->
<section class="section" id="reviews">
  <div class="section-inner">
    <div class="section-label">Student Reviews</div>
    <h2 class="section-title">What Our Students Say<br>After Attending</h2>

    <div class="testi-slider-wrap">
      <div class="testi-slider">
        <div class="testi-track" id="testiTrack">

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I had absolutely no knowledge of Google Ads before the workshop. The daily 3 PM to 5 PM sessions were very interactive and helped me launch my first Search campaign."</p>
            <div class="testi-author"><div class="testi-avatar">PS</div><div><div class="testi-name">Priya Sharma</div><div class="testi-role">Digital Marketing Executive</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"The campaign setups shown in this workshop helped me double the ROAS for my agency campaigns. A highly recommended 10-day program."</p>
            <div class="testi-author"><div class="testi-avatar">RV</div><div><div class="testi-name">Rahul Verma</div><div class="testi-role">Digital Specialist</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"As a business owner, setting up my own Google Ads campaigns was crucial. After this 10-day workshop, I started generating leads on my own."</p>
            <div class="testi-author"><div class="testi-avatar">AS</div><div><div class="testi-name">Amit Singh</div><div class="testi-role">Business Owner</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I was spending ₹50K/month on Google Ads with zero tracking. This workshop taught me conversion tracking and GA4 integration — my cost per lead dropped by 40% within a week."</p>
            <div class="testi-author"><div class="testi-avatar">NK</div><div><div class="testi-name">Neha Kapoor</div><div class="testi-role">E-commerce Entrepreneur</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"The remarketing and audience segmentation modules were game-changers. I now run retargeting campaigns for my freelance clients and charge 3x what I used to."</p>
            <div class="testi-author"><div class="testi-avatar">VG</div><div><div class="testi-name">Vikram Gupta</div><div class="testi-role">Freelance Ads Consultant</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"Coming from an SEO background, I always avoided paid ads. This 10-day workshop made Google Ads approachable and logical. Now I offer both SEO and PPC to my clients."</p>
            <div class="testi-author"><div class="testi-avatar">SM</div><div><div class="testi-name">Sneha Mehta</div><div class="testi-role">SEO Specialist</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I attended as a complete fresher after my BBA. The hands-on campaign building gave me real portfolio work. I got placed as a PPC Executive within two months of completing the workshop."</p>
            <div class="testi-author"><div class="testi-avatar">AK</div><div><div class="testi-name">Arjun Kumar</div><div class="testi-role">PPC Executive</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"The best ₹499 I've ever spent. The trainer explained Quality Score optimization and bidding strategies in a way that finally made sense. My CTR improved from 1.2% to 4.8%."</p>
            <div class="testi-author"><div class="testi-avatar">DP</div><div><div class="testi-name">Deepika Patel</div><div class="testi-role">Marketing Manager</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I run a local dental clinic and was tired of paying agencies ₹25K/month. After this workshop I manage my own campaigns and get 3x more patient inquiries at half the cost."</p>
            <div class="testi-author"><div class="testi-avatar">RJ</div><div><div class="testi-name">Dr. Rajesh Jain</div><div class="testi-role">Clinic Owner, Delhi</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"The YouTube and Display campaign modules were outstanding. I learned how to create video ad campaigns from scratch. My brand awareness campaigns now reach 5 lakh people monthly."</p>
            <div class="testi-author"><div class="testi-avatar">MT</div><div><div class="testi-name">Meera Thakur</div><div class="testi-role">Brand Strategist</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I switched from a traditional sales job to digital marketing. This workshop gave me the practical Google Ads skills that my certification courses never covered. Highly practical."</p>
            <div class="testi-author"><div class="testi-avatar">KR</div><div><div class="testi-name">Karan Rao</div><div class="testi-role">Career Switcher</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"What sets this workshop apart is the live campaign building. We didn't just watch slides — we actually set up Search, Display, and Remarketing campaigns during the sessions."</p>
            <div class="testi-author"><div class="testi-avatar">PA</div><div><div class="testi-name">Pooja Agarwal</div><div class="testi-role">Digital Marketing Student</div></div></div>
          </div>

          <div class="testi-card">
            <div class="stars">★★★★★</div>
            <p class="testi-text">"I manage ads for 8 real estate clients. The smart bidding and ROAS optimization techniques from this workshop helped me reduce wasted ad spend by over 35% across all accounts."</p>
            <div class="testi-author"><div class="testi-avatar">ST</div><div><div class="testi-name">Saurabh Tiwari</div><div class="testi-role">Performance Marketing Lead</div></div></div>
          </div>

        </div>
      </div>

      <!-- Slider Controls -->
      <div class="testi-controls">
        <button class="testi-btn" id="testiPrev" aria-label="Previous reviews">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="testi-dots" id="testiDots"></div>
        <button class="testi-btn" id="testiNext" aria-label="Next reviews">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>

      <div class="testi-counter" id="testiCounter"></div>
    </div>
  </div>
</section>

<!-- WHO SHOULD ATTEND -->
<section class="who-section" id="who-for">
  <div class="section-inner">
    <div class="section-label">For Whom</div>
    <h2 class="section-title" style="text-align:center; margin-bottom:4px;">Who Is This Workshop For?</h2>
    <p style="text-align:center; color:var(--gray); font-size:16px; margin-bottom:0;">If any of these describe you, this workshop is for you.</p>
    <div class="who-grid">
      <div class="who-card">
        <div class="who-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--red); display: inline-block;"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
        </div>
        <div class="who-title">Students</div>
        <p class="who-desc">Looking to start a digital career after school or during your degree</p>
      </div>
      <div class="who-card">
        <div class="who-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--red); display: inline-block;"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div class="who-title">Job Seekers</div>
        <p class="who-desc">Pursuing a role in marketing, sales, or content and want an edge</p>
      </div>
      <div class="who-card">
        <div class="who-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--red); display: inline-block;"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="16"/><line x1="15" y1="22" x2="15" y2="16"/><line x1="9" y1="16" x2="15" y2="16"/><path d="M8 6h2v2H8zm4 0h2v2h-2zm0 4h2v2h-2zm-4 0h2v2H8zm8-4h2v2h-2zm0 4h2v2h-2z"/></svg>
        </div>
        <div class="who-title">Business Owners</div>
        <p class="who-desc">Want to run your own ads and stop relying on expensive agencies</p>
      </div>
      <div class="who-card">
        <div class="who-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--red); display: inline-block;"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="20" x2="22" y2="20"/><line x1="12" y1="20" x2="12" y2="17"/></svg>
        </div>
        <div class="who-title">Working Professionals</div>
        <p class="who-desc">Seeking a higher salary or a move into digital marketing</p>
      </div>
      <div class="who-card">
        <div class="who-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--red); display: inline-block;"><path d="M4.5 16.5c-1.5 1.25-2.5 3.5-2.5 3.5s2.25-1 3.5-2.5M12 2C6 2 2 6 2 12c0 2.5 1 4.5 2.5 6l4-4 2 2-4 4c1.5 1.5 3.5 2.5 6 2.5 6 0 10-4 10-10S18 2 12 2z"/><path d="M9 15l6-6M13 8a1.5 1.5 0 1 1 3-3 1.5 1.5 0 0 1-3 3z"/></svg>
        </div>
        <div class="who-title">Freelancers</div>
        <p class="who-desc">Want to deliver better results for clients and grow your income</p>
      </div>
    </div>
  </div>
</section>

<!-- BOTTOM CTA -->
<section class="bottom-cta">
  <h2 class="bottom-cta-title">
    Secure Your Seat <em>Today</em> —<br>Starts at ₹499 Only
  </h2>
  <p class="bottom-cta-sub">Limited seats. Classes on Zoom from 3:00 PM to 5:00 PM daily.</p>
  <a href="#register" class="cta-btn-large">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:6px;"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
    Register for the Workshop (₹499)
  </a>
  <p class="cta-note">
    <span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      AGDM Academy, Uttam Nagar East, New Delhi
    </span>
    <span class="cta-note-divider"> &nbsp;|&nbsp; </span>
    <span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      +91 96436 61661
    </span>
  </p>
</section>

<!-- FOOTER -->
<footer class="footer">
  <img src="assets/logo-new.png" alt="AGDM Academy">
  <p>
    <span>© 2026 AGDM Academy. All rights reserved.</span>
    <span class="footer-divider"> | </span>
    <span>Delhi's #1 Practical Digital Marketing Institute</span>
  </p>
  <p>
    <span>E90A, Pankha Rd, Uttam Nagar, New Delhi, 110059</span>
    <span class="footer-divider"> &nbsp;|&nbsp; </span>
    <span><a href="mailto:info@agdmacademy.com">info@agdmacademy.com</a></span>
    <span class="footer-divider"> &nbsp;|&nbsp; </span>
    <span><a href="privacy-policy.php">Privacy Policy</a></span>
  </p>
</footer>

<!-- FLOATING WHATSAPP -->
<a href="https://wa.me/919643661661?text=Hi%2C%20I%27d%20like%20to%20register%20for%20the%20Google%20Ads%20Workshop" class="wa-float" target="_blank" title="Chat on WhatsApp">
  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

<!-- Razorpay Standard Web Checkout SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
function startTimer() {
  var el = document.getElementById('timer');
  var storageKey = 'agdm_workshop_timer_expiry';
  var duration = 48 * 60 * 60 * 1000;
  var now = new Date().getTime();
  var end = localStorage.getItem(storageKey);
  
  if (!end || parseInt(end) <= now) {
    end = now + duration;
    localStorage.setItem(storageKey, end);
  } else {
    end = parseInt(end);
  }

  function update() {
    var currentTime = new Date().getTime();
    var diff = end - currentTime;
    if (diff <= 0) {
      end = currentTime + duration;
      localStorage.setItem(storageKey, end);
      diff = end - currentTime;
    }
    var h = Math.floor(diff / 3600000);
    var m = Math.floor((diff % 3600000) / 60000);
    var s = Math.floor((diff % 60000) / 1000);
    el.textContent = (h<10?'0':'')+h+':'+(m<10?'0':'')+m+':'+(s<10?'0':'')+s;
  }
  
  update();
  setInterval(update, 1000);
}
startTimer();

// Navigation Toggle
var navToggle = document.getElementById('navToggle');
var headerNav = document.getElementById('headerNav');
if (navToggle && headerNav) {
  navToggle.addEventListener('click', function() {
    navToggle.classList.toggle('active');
    headerNav.classList.toggle('active');
  });
  
  // Close menu when a link is clicked
  headerNav.querySelectorAll('a').forEach(function(link) {
    link.addEventListener('click', function() {
      navToggle.classList.remove('active');
      headerNav.classList.remove('active');
    });
  });
}

// Hide WhatsApp float when entering inputs/selects in the form on mobile (prevent keyboard overlay blocker)
var formElements = document.querySelectorAll('#workshopForm input, #workshopForm select');
formElements.forEach(function(el) {
  el.addEventListener('focus', function() {
    document.body.classList.add('form-focused');
  });
  el.addEventListener('blur', function() {
    document.body.classList.remove('form-focused');
  });
});

function handleSubmit(e) {
  e.preventDefault();
  
  const name = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const email = document.getElementById('email').value.trim();
  const profile = document.getElementById('profile').value;
  const captcha = document.getElementById('agdm_captcha').value.trim();
  const errorDiv = document.getElementById('formError');

  if (errorDiv) {
    errorDiv.style.display = 'none';
    errorDiv.innerText = '';
  }

  if (!name || !phone || !email || !profile || !captcha) {
    showError('Please fill out all required fields marked with *');
    return;
  }

  const btn = document.querySelector('.btn-submit');
  if (btn) {
    btn.disabled = true;
    btn.textContent = 'Processing Payment...';
  }

  // Step 1: Create Order on the Backend
  const formData = new FormData();
  formData.append('action', 'create_order');
  formData.append('name', name);
  formData.append('email', email);
  formData.append('phone', phone);
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
      throw new Error('Server returned an invalid response. Please try again.');
    });
  })
  .then(data => {
    if (!data.success) {
      throw new Error(data.message || 'Failed to initiate payment.');
    }

    // Step 2: Open Razorpay Modal
    const options = {
      key: data.key_id,
      amount: data.amount,
      currency: data.currency,
      name: "AGDM Academy",
      description: "Google Ads 10-Day Workshop",
      image: "assets/logo-new.png",
      order_id: data.order_id,
      prefill: {
        name: name,
        email: email,
        contact: phone
      },
      notes: {
        profile: profile
      },
      theme: {
        color: "#dc1e28" // AGDM Academy theme red
      },
      // Enable UPI ID input + QR + Intent flows
      config: {
        display: {
          blocks: {
            upi: {
              name: "Pay using UPI",
              instruments: [
                {
                  method: "upi",
                  flows: ["collect", "qr", "intent"],
                  apps: ["google_pay", "phonepe", "paytm", "bhim"]
                }
              ]
            }
          },
          sequence: ["block.upi"],
          preferences: {
            show_default_blocks: true
          }
        }
      },
      handler: function (response) {
        // Step 3: Verify Signature on Backend
        if (btn) {
          btn.textContent = 'Verifying Payment...';
        }
        
        const verifyData = new FormData();
        verifyData.append('action', 'verify_payment');
        verifyData.append('name', name);
        verifyData.append('email', email);
        verifyData.append('phone', phone);
        verifyData.append('profile', profile);
        verifyData.append('razorpay_payment_id', response.razorpay_payment_id);
        verifyData.append('razorpay_order_id', response.razorpay_order_id);
        verifyData.append('razorpay_signature', response.razorpay_signature);

        fetch(window.location.href, {
          method: 'POST',
          body: verifyData
        })
        .then(res => {
          if (res.ok) return res.json();
          throw new Error('Payment verification failed.');
        })
        .then(verifyResult => {
          if (verifyResult.success) {
            if (btn) {
              btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:6px;"><polyline points="20 6 9 17 4 12"/></svg> Payment Successful!';
              btn.style.background = '#16a34a';
            }
            setTimeout(() => {
              window.location.href = 'thank-you.php';
            }, 1500);
          } else {
            throw new Error(verifyResult.message || 'Payment verification failed.');
          }
        })
        .catch(err => {
          console.error('Verification error:', err);
          showError(err.message || 'Something went wrong during payment verification.');
          resetSubmitButton();
        });
      },
      modal: {
        ondismiss: function () {
          console.log('Payment modal dismissed by user.');
          showError('Payment cancelled. Please try again.');
          resetSubmitButton();
        }
      }
    };

    const rzp = new Razorpay(options);
    
    rzp.on('payment.failed', function (response) {
      console.error('Payment failed:', response.error);
      showError(response.error.description || 'Payment failed. Please check your card/account.');
      resetSubmitButton();
    });

    rzp.open();
  })
  .catch(error => {
    console.error('Form/order creation error:', error);
    showError(error.message || 'Something went wrong. Please refresh the page and try again.');
    
    // Auto refresh captcha on validation failure
    refreshCaptcha(document.getElementById('refresh-captcha-btn'));
    resetSubmitButton();
  });

  function showError(msg) {
    if (errorDiv) {
      errorDiv.innerText = msg;
      errorDiv.style.display = 'block';
    }
  }

  function resetSubmitButton() {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:6px;"><polyline points="20 6 9 17 4 12"/></svg> REGISTER NOW (₹499 ONLY)';
    }
  }
}

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

// Testimonials Slider Logic
(function() {
  const track = document.getElementById('testiTrack');
  const prevBtn = document.getElementById('testiPrev');
  const nextBtn = document.getElementById('testiNext');
  const dotsContainer = document.getElementById('testiDots');
  const counterContainer = document.getElementById('testiCounter');
  
  if (!track || !prevBtn || !nextBtn || !dotsContainer || !counterContainer) return;
  
  const cards = Array.from(track.children);
  const totalCards = cards.length;
  let currentIndex = 0;
  let autoSlideTimer = null;
  
  function getCardsPerView() {
    if (window.innerWidth > 1024) return 3;
    if (window.innerWidth > 640) return 2;
    return 1;
  }
  
  function getMaxIndex() {
    return Math.max(0, totalCards - getCardsPerView());
  }
  
  function updateSlider() {
    const cardsPerView = getCardsPerView();
    const maxIndex = getMaxIndex();
    
    // Clamp index
    if (currentIndex > maxIndex) currentIndex = maxIndex;
    if (currentIndex < 0) currentIndex = 0;
    
    // Calculate translate distance using container percentages
    const percentShift = currentIndex * (100 / cardsPerView);
    track.style.transform = `translateX(-${percentShift}%)`;
    
    // Update active dot
    const dots = Array.from(dotsContainer.children);
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentIndex);
    });
    
    // Update counter
    counterContainer.innerHTML = `Showing <strong>${currentIndex + 1} - ${Math.min(currentIndex + cardsPerView, totalCards)}</strong> of <strong>${totalCards}</strong> reviews`;
    
    // Disable buttons at bounds
    prevBtn.disabled = currentIndex === 0;
    prevBtn.style.opacity = currentIndex === 0 ? '0.4' : '1';
    prevBtn.style.cursor = currentIndex === 0 ? 'default' : 'pointer';
    
    nextBtn.disabled = currentIndex === maxIndex;
    nextBtn.style.opacity = currentIndex === maxIndex ? '0.4' : '1';
    nextBtn.style.cursor = currentIndex === maxIndex ? 'default' : 'pointer';
  }
  
  function createDots() {
    dotsContainer.innerHTML = '';
    const maxIndex = getMaxIndex();
    for (let i = 0; i <= maxIndex; i++) {
      const dot = document.createElement('button');
      dot.className = 'testi-dot';
      dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
      dot.addEventListener('click', () => {
        currentIndex = i;
        updateSlider();
        resetAutoSlide();
      });
      dotsContainer.appendChild(dot);
    }
  }
  
  function nextSlide() {
    const maxIndex = getMaxIndex();
    if (currentIndex < maxIndex) {
      currentIndex++;
    } else {
      currentIndex = 0; // Wrap around
    }
    updateSlider();
  }
  
  function prevSlide() {
    if (currentIndex > 0) {
      currentIndex--;
    } else {
      currentIndex = getMaxIndex(); // Wrap around
    }
    updateSlider();
  }
  
  function startAutoSlide() {
    stopAutoSlide();
    autoSlideTimer = setInterval(nextSlide, 5000);
  }
  
  function stopAutoSlide() {
    if (autoSlideTimer) {
      clearInterval(autoSlideTimer);
      autoSlideTimer = null;
    }
  }
  
  function resetAutoSlide() {
    startAutoSlide();
  }
  
  // Button listeners
  nextBtn.addEventListener('click', () => {
    nextSlide();
    resetAutoSlide();
  });
  
  prevBtn.addEventListener('click', () => {
    prevSlide();
    resetAutoSlide();
  });
  
  // Touch / Swipe support
  let touchStartX = 0;
  let touchEndX = 0;
  
  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    stopAutoSlide();
  }, { passive: true });
  
  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    startAutoSlide();
  }, { passive: true });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swiped left
        const maxIndex = getMaxIndex();
        if (currentIndex < maxIndex) {
          currentIndex++;
          updateSlider();
        }
      } else {
        // Swiped right
        if (currentIndex > 0) {
          currentIndex--;
          updateSlider();
        }
      }
    }
  }
  
  // Hover controls
  const sliderWrap = document.querySelector('.testi-slider-wrap');
  if (sliderWrap) {
    sliderWrap.addEventListener('mouseenter', stopAutoSlide);
    sliderWrap.addEventListener('mouseleave', startAutoSlide);
  }
  
  // Initialise
  createDots();
  updateSlider();
  startAutoSlide();
  
  // Handle resize events
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      createDots();
      updateSlider();
    }, 150);
  });
})();

document.querySelectorAll('a[href^="#"]').forEach(function(a) {
  a.addEventListener('click', function(e) {
    var target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      const header = document.querySelector('.sticky-header');
      const headerOffset = header ? header.offsetHeight : 70;
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
      
      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  });
});
</script>

</body>
</html>
