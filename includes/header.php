<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$stylePath = 'css/style.css';
$logoPath = 'assets/logo-new.png';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? (strpos($pageTitle, 'AGDM Academy') !== false ? htmlspecialchars($pageTitle) : htmlspecialchars($pageTitle) . " | AGDM Academy") : "Digital Marketing Institute in Delhi | AGDM Academy"; ?></title>
  <meta name="description" content="<?= isset($pageDescription) ? htmlspecialchars($pageDescription) : "AGDM Academy is Delhi's top digital marketing institute in Uttam Nagar. Learn SEO, Google Ads, Meta Ads & more with live projects. 100% placement assistance. Enroll now!"; ?>">
  <?php if (isset($pageKeywords)): ?>
  <meta name="keywords" content="<?= htmlspecialchars($pageKeywords); ?>">
  <?php endif; ?>
  <?php if (!empty($noIndex)): ?>
  <meta name="robots" content="noindex, nofollow">
  <?php else: ?>
  <meta name="robots" content="index, follow">
  <?php endif; ?>
  
  <!-- Google Tag Manager (AGDM Academy) -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TFXS4WTB');</script>
  <!-- End Google Tag Manager (AGDM Academy) -->
  <meta name="google-site-verification" content="UpScsAagBFLY9t2unNSFm4rHCe5gyZ01lQQ6_G8V8W0" />
  <?php if (empty($noIndex)): ?>
  <link rel="canonical" href="<?= isset($canonicalUrl) ? htmlspecialchars($canonicalUrl) : "https://agdmacademy.com/" . ($currentPage === 'index.php' ? '' : str_replace('.php', '', $currentPage)); ?>" />
  <?php endif; ?>

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="<?= isset($ogType) ? htmlspecialchars($ogType) : "website"; ?>" />
  <meta property="og:url" content="<?= isset($ogUrl) ? htmlspecialchars($ogUrl) : "https://agdmacademy.com/"; ?>" />
  <meta property="og:title" content="<?= isset($ogTitle) ? htmlspecialchars($ogTitle) : (isset($pageTitle) ? (strpos($pageTitle, 'AGDM Academy') !== false ? htmlspecialchars($pageTitle) : htmlspecialchars($pageTitle) . " | AGDM Academy") : "Digital Marketing Institute in Delhi | AGDM Academy"); ?>" />
  <meta property="og:description" content="<?= isset($ogDescription) ? htmlspecialchars($ogDescription) : (isset($pageDescription) ? htmlspecialchars($pageDescription) : "Delhi ka #1 practical digital marketing institute. SEO, Google Ads, Meta Ads training with live projects & placement."); ?>" />
  <meta property="og:image" content="<?= isset($ogImage) ? htmlspecialchars($ogImage) : "https://agdmacademy.com/assets/logo-new.png"; ?>" />

  <!-- Twitter -->
  <meta name="twitter:card" content="<?= isset($twitterCard) ? htmlspecialchars($twitterCard) : "summary_large_image"; ?>" />
  <meta name="twitter:url" content="<?= isset($ogUrl) ? htmlspecialchars($ogUrl) : "https://agdmacademy.com/"; ?>" />
  <meta name="twitter:title" content="<?= isset($twitterTitle) ? htmlspecialchars($twitterTitle) : (isset($ogTitle) ? htmlspecialchars($ogTitle) : (isset($pageTitle) ? (strpos($pageTitle, 'AGDM Academy') !== false ? htmlspecialchars($pageTitle) : htmlspecialchars($pageTitle) . " | AGDM Academy") : "Digital Marketing Institute in Delhi | AGDM Academy")); ?>" />
  <meta name="twitter:description" content="<?= isset($twitterDescription) ? htmlspecialchars($twitterDescription) : (isset($ogDescription) ? htmlspecialchars($ogDescription) : (isset($pageDescription) ? htmlspecialchars($pageDescription) : "Delhi ka #1 practical digital marketing institute. SEO, Google Ads, Meta Ads training with live projects & placement.")); ?>" />
  <meta name="twitter:image" content="<?= isset($twitterImage) ? htmlspecialchars($twitterImage) : (isset($ogImage) ? htmlspecialchars($ogImage) : "https://agdmacademy.com/assets/logo-new.png"); ?>" />

  <!-- Google Fonts: Outfit (Headings) & Inter (Body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Bootstrap & Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/logo-new.png">
  <link rel="shortcut icon" type="image/png" href="assets/logo-new.png">
  <link rel="apple-touch-icon" href="assets/logo-new.png">
  <meta name="theme-color" content="#dc3545">

  <link rel="stylesheet" href="<?= $stylePath; ?>">
  <?php if (isset($pageSchema)): ?>
  <?= $pageSchema ?>
  <?php endif; ?>
</head>
<body>
  <!-- Google Tag Manager (noscript) - AGDM Academy -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TFXS4WTB"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) - AGDM Academy -->
  <header class="site-header shadow-sm sticky-top glass-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="https://agdmacademy.com/">
          <img src="<?= $logoPath; ?>" alt="AGDM Academy Logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link <?= $currentPage === 'index.php' ? 'active' : ''; ?>" href="https://agdmacademy.com/">Home</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $currentPage === 'about.php' ? 'active' : ''; ?>" href="/about" role="button" data-bs-toggle="dropdown">About Us</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/about#who-we-are">Who We Are</a></li>
                <li><a class="dropdown-item" href="/about#our-leadership">Our Leadership</a></li>
                <li><a class="dropdown-item" href="/about#why-choose-us">Why Choose AGDM Academy</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $currentPage === 'courses.php' ? 'active' : ''; ?>" href="/courses" role="button" data-bs-toggle="dropdown">Training</a>
              <ul class="dropdown-menu">
                <li><h6 class="dropdown-header">Our Programs</h6></li>
                <li><a class="dropdown-item" href="/midm">Master in Digital Marketing (MIDM)</a></li>
                <li><a class="dropdown-item" href="/pidm">Professional in Digital Marketing</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item fw-bold text-danger" href="/courses"><i class="bi bi-grid-fill me-2"></i>View All Courses</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link <?= $currentPage === 'enrollment.php' ? 'active' : ''; ?>" href="/enrollment">Enrollment</a></li>
            <li class="nav-item"><a class="nav-link <?= $currentPage === 'blogs.php' ? 'active' : ''; ?>" href="/blogs">Blogs</a></li>
          </ul>
          <a class="btn btn-danger ms-lg-3" href="/contact">Contact Us</a>
        </div>
      </div>
    </nav>
  </header>
  <main>
