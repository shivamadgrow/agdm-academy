<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Best Digital Marketing Course in Delhi | AGDM Academy – Uttam Nagar";
$pageDescription = "Join AGDM Academy – Delhi's top digital marketing institute in Uttam Nagar. Learn SEO, Google Ads, Meta Ads, AI Marketing with live projects & Best Digital Marketing Course in Delhi with 100% job Assistance Support";

$ogTitle = "Best Digital Marketing Course in Delhi | AGDM Academy";
$ogDescription = "Delhi's #1 practical digital marketing institute. SEO, Google Ads, Meta Ads training with live projects & 100% placement. Join now.";
$ogUrl = "https://agdmacademy.com/";
$ogType = "website";
$ogImage = "https://agdmacademy.com/assets/og-home.jpg";

$twitterCard = "summary_large_image";
$twitterTitle = "Best Digital Marketing Course in Delhi | AGDM Academy";
$twitterDescription = "Delhi's #1 practical digital marketing institute. SEO, Google Ads, Meta Ads training with live projects & 100% placement.";
$twitterImage = "https://agdmacademy.com/assets/og-home.jpg";

$canonicalUrl = "https://agdmacademy.com/";

$pageSchema = <<<HTML
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "additionalType": "https://schema.org/EducationalOrganization",
  "name": "AGDM Academy",
  "alternateName": "Ad Grow Digital Marketing Academy",
  "url": "https://agdmacademy.com",
  "logo": "https://agdmacademy.com/assets/logo-new.png",
  "image": "https://agdmacademy.com/assets/banner_image.jpeg",
  "description": "AGDM Academy is Delhi's top digital marketing institute in Uttam Nagar offering practical training in SEO, Google Ads, Meta Ads, and AI Marketing with 100% placement assistance.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Third Floor, E90A, Pankha Rd, opposite Palazzo Inn, Block F, Jivan Park",
    "addressLocality": "Uttam Nagar",
    "addressRegion": "New Delhi",
    "postalCode": "110059",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 28.6202379,
    "longitude": 77.06878131500001
  },
  "telephone": "+919643661661",
  "email": "info@agdmacademy.com",
  "sameAs": [
    "https://www.instagram.com/agdmacademy",
    "https://www.linkedin.com/company/adgrow-digital-marketing-academy/",
    "https://www.facebook.com/profile.php?id=61572105166409"
  ],
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
      "opens": "09:00",
      "closes": "20:00"
    }
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "200",
    "bestRating": "5",
    "worstRating": "1"
  },
  "review": [
    {
      "@type": "Review",
      "author": {"@type": "Person", "name": "Priya Sharma"},
      "reviewRating": {"@type": "Rating", "ratingValue": "5"},
      "reviewBody": "Best digital marketing institute in Delhi. Joined with zero knowledge and landed an internship in 4 months."
    },
    {
      "@type": "Review",
      "author": {"@type": "Person", "name": "Rahul Verma"},
      "reviewRating": {"@type": "Rating", "ratingValue": "5"},
      "reviewBody": "AGDM Academy makes you work on live projects. Secured a job at a top agency right after the MIDM course."
    }
  ]
}
</script>
HTML;

$pageKeywords = "best digital marketing course in delhi, digital marketing institute in delhi, seo training delhi, google ads course delhi, meta ads training delhi, digital marketing placement uttam nagar, agdm academy delhi";
$pageKeywords = "digital marketing institute near me, best digital marketing institute near me, digital marketing course institute near me, digital marketing training institute near me, near by digital marketing institute, digital marketing institutions near me, top digital marketing institute near me, digital marketing institute in delhi, best digital marketing institute in delhi, top 10 digital marketing institute in delhi, best institute of digital marketing in delhi, best digital marketing institute in delhi with placement, digital marketing institute in south delhi, digital marketing course institute delhi, top digital marketing institute in delhi, best offline digital marketing institute in delhi, digital marketing best institute in delhi, digital marketing training institute in delhi";

$formSuccess = false;
$formErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'request_session') {
  $name = trim($_POST['name'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $email = trim($_POST['email'] ?? '');

  if ($name === '') $formErrors[] = "Name is required.";
  if ($phone === '') $formErrors[] = "Phone is required.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $formErrors[] = "Valid email is required.";

  $captcha = trim($_POST['agdm_captcha'] ?? '');
  if ($captcha === '') {
    $formErrors[] = "Verification is required. Please solve the math problem.";
  } elseif (!agdm_validate_captcha($captcha)) {
    $formErrors[] = "Incorrect verification answer. Please try again.";
  }

  if (empty($formErrors)) {
    $to = "info@agdmacademy.com";
    $subject = "New Free Session Request from AGDM Academy Homepage";
    $body = "You have received a new free session request.\n\nName: $name\nPhone: $phone\nEmail: $email";
    $headers = "From: no-reply@agdmacademy.com\r\nReply-To: $email\r\n";
    @mail($to, $subject, $body, $headers);
    header('Location: thank-you.php');
    exit;
  }
}

agdm_include_part('header.php');
?>

<section class="agdm-top-strip py-2">
  <div class="container d-flex flex-wrap justify-content-between">
    <div><i class="bi bi-clock me-2"></i> Admissions Open 2026 | Weekend & Weekday Batches</div>
    <div>
      <span class="me-3"><i class="bi bi-telephone ms-1 me-1"></i> <a href="tel:+919643661661" class="text-white text-decoration-none">+91 9643661661</a></span>
      <span class="me-3 d-none d-md-inline"><i class="bi bi-telephone ms-1 me-1"></i> <a href="tel:+918796911169" class="text-white text-decoration-none">+91 8796911169</a></span>
      <span><i class="bi bi-envelope ms-1 me-1"></i> <a href="mailto:info@agdmacademy.com" class="text-white text-decoration-none">info@agdmacademy.com</a></span>
    </div>
  </div>
</section>

<section class="hero-section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-lightning-charge-fill me-1"></i> Built by Marketers. Taught by Experts.</span>
        <h1 class="display-4 fw-bold mb-4 text-dark" style="line-height: 1.2;">Best Digital Marketing Course in Delhi with <span class="text-danger">100% Job Placement Assistance</span></h1>
        <p class="lead mb-4 text-muted">Join the industry's most comprehensive <strong>Digital Marketing Institute in Delhi</strong>. Master SEO, Google Ads, Meta Ads, and AI-driven marketing with hands-on live project training.</p>
        <div class="d-flex gap-3 flex-wrap mb-4">
          <a href="courses.php" class="btn btn-danger btn-lg px-4 rounded-pill">Explore Courses <i class="bi bi-arrow-right ms-2"></i></a>
          <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-dark btn-lg px-4 rounded-pill border fw-semibold shadow-sm"><i class="bi bi-download me-2"></i>Download Syllabus</a>
          <a href="contact.php" class="btn btn-light btn-lg px-4 rounded-pill border fw-semibold text-dark shadow-sm">Get Free Counselling</a>
        </div>
        <div class="d-flex gap-3 flex-wrap hero-points">
          <span><i class="bi bi-check-circle-fill"></i> 100% Placement</span>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image-wrapper position-relative">
          <img src="assets/banner_image.jpeg" alt="Digital Marketing course training in Delhi — AGDM Academy" class="img-fluid w-100 rounded-4 shadow-lg border border-white border-4">
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Brand Ticker Section -->
<div class="pt-5 bg-white text-center">
  <span class="text-danger fw-bold text-uppercase tracking-wider small mb-2 d-block">Our Students Work At</span>
  <h2 class="fw-bold mb-4">Our Brand Partners</h2>
</div>
<div class="brand-ticker">
  <div class="ticker-wrap">
    <div class="ticker-item brand-google">
      <svg width="24" height="24" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg> Google
    </div>
    <div class="ticker-item brand-chatbot">
      <svg width="48" height="24" viewBox="0 0 100 40" fill="none">
        <rect width="100" height="40" rx="20" fill="#001d6c"/>
        <rect x="5" y="5" width="90" height="30" rx="15" fill="white"/>
        <circle cx="30" cy="20" r="4" fill="#00e5ff"/>
        <circle cx="70" cy="20" r="4" fill="#00e5ff"/>
        <path d="M40 20h20" stroke="#001d6c" stroke-width="4" stroke-linecap="round"/>
      </svg> <span style="color: #ffffff; font-weight: 800; font-size: 22px; text-transform: lowercase;">chatbot</span>
    </div>
    <div class="ticker-item brand-meta">
      <img src="assets/meta-icon.png" alt="Meta" style="width: 24px; height: 24px; object-fit: contain;"> Meta
    </div>
    <div class="ticker-item brand-shopify">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="#96bf48"><path d="M18.8 6.4L17.1 2.5C16.8 1.9 16.1 1.5 15.4 1.5H8.6C7.9 1.5 7.2 1.9 6.9 2.5L5.2 6.4H2.2V21C2.2 21.8 2.9 22.5 3.7 22.5H20.3C21.1 22.5 21.8 21.8 21.8 21V6.4H18.8ZM12 4.5C13.4 4.5 14.6 5.3 15.2 6.4H8.8C9.4 5.3 10.6 4.5 12 4.5ZM14.6 15.4C13.8 16.2 12.7 16.5 12 16.5C11.3 16.5 10.2 16.2 9.4 15.4C8.6 14.6 8.2 13.5 8.2 12.7C8.2 11.9 8.6 10.8 9.4 10C10.2 9.2 11.3 8.9 12 8.9C12.7 8.9 13.8 9.2 14.6 10C15.4 10.8 15.8 11.9 15.8 12.7C15.8 13.5 15.4 14.6 14.6 15.4Z"/></svg> Shopify
    </div>
    <div class="ticker-item brand-microsoft">
      <svg width="24" height="24" viewBox="0 0 24 24"><path fill="#f25022" d="M1 1h10v10H1z"/><path fill="#7fba00" d="M13 1h10v10H13z"/><path fill="#00a4ef" d="M1 13h10v10H1z"/><path fill="#ffb900" d="M13 13h10v10H13z"/></svg> Microsoft
    </div>
    <div class="ticker-item brand-hubspot">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="#ff7a59"><path d="M21.5 12.5C21.5 13.8807 20.3807 15 19 15C17.6193 15 16.5 13.8807 16.5 12.5C16.5 11.1193 17.6193 10 19 10C20.3807 10 21.5 11.1193 21.5 12.5ZM13 19C13 20.3807 11.8807 21.5 10.5 21.5C9.11929 21.5 8 20.3807 8 19C8 17.6193 9.11929 16.5 10.5 16.5C11.8807 16.5 13 17.6193 13 19ZM13 6C13 7.38071 11.8807 8.5 10.5 8.5C9.11929 8.5 8 7.38071 8 6C8 4.61929 9.11929 3.5 10.5 3.5C11.8807 3.5 13 4.61929 13 6ZM10.5 13.5C11.3284 13.5 12 12.8284 12 12C12 11.1716 11.3284 10.5 10.5 10.5C9.67157 10.5 9 11.1716 9 12C9 12.8284 9.67157 13.5 10.5 13.5Z"/></svg> <span class="fw-bold">HUBSPOT</span>
    </div>
    <!-- Duplicate for seamless loop -->
    <div class="ticker-item brand-google">
      <svg width="24" height="24" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg> Google
    </div>
    <div class="ticker-item brand-chatbot">
      <svg width="48" height="24" viewBox="0 0 100 40" fill="none">
        <rect width="100" height="40" rx="20" fill="#001d6c"/>
        <rect x="5" y="5" width="90" height="30" rx="15" fill="white"/>
        <circle cx="30" cy="20" r="4" fill="#00e5ff"/>
        <circle cx="70" cy="20" r="4" fill="#00e5ff"/>
        <path d="M40 20h20" stroke="#001d6c" stroke-width="4" stroke-linecap="round"/>
      </svg> <span style="color: #ffffff; font-weight: 800; font-size: 22px; text-transform: lowercase;">chatbot</span>
    </div>
    <div class="ticker-item brand-meta">
      <img src="assets/meta-icon.png" alt="Meta" style="width: 24px; height: 24px; object-fit: contain;"> Meta
    </div>
    <div class="ticker-item brand-shopify">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="#96bf48"><path d="M18.8 6.4L17.1 2.5C16.8 1.9 16.1 1.5 15.4 1.5H8.6C7.9 1.5 7.2 1.9 6.9 2.5L5.2 6.4H2.2V21C2.2 21.8 2.9 22.5 3.7 22.5H20.3C21.1 22.5 21.8 21.8 21.8 21V6.4H18.8ZM12 4.5C13.4 4.5 14.6 5.3 15.2 6.4H8.8C9.4 5.3 10.6 4.5 12 4.5ZM14.6 15.4C13.8 16.2 12.7 16.5 12 16.5C11.3 16.5 10.2 16.2 9.4 15.4C8.6 14.6 8.2 13.5 8.2 12.7C8.2 11.9 8.6 10.8 9.4 10C10.2 9.2 11.3 8.9 12 8.9C12.7 8.9 13.8 9.2 14.6 10C15.4 10.8 15.8 11.9 15.8 12.7C15.8 13.5 15.4 14.6 14.6 15.4Z"/></svg> Shopify
    </div>
    <div class="ticker-item brand-microsoft">
      <svg width="24" height="24" viewBox="0 0 24 24"><path fill="#f25022" d="M1 1h10v10H1z"/><path fill="#7fba00" d="M13 1h10v10H13z"/><path fill="#00a4ef" d="M1 13h10v10H1z"/><path fill="#ffb900" d="M13 13h10v10H13z"/></svg> Microsoft
    </div>
    <div class="ticker-item brand-hubspot">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="#ff7a59"><path d="M21.5 12.5C21.5 13.8807 20.3807 15 19 15C17.6193 15 16.5 13.8807 16.5 12.5C16.5 11.1193 17.6193 10 19 10C20.3807 10 21.5 11.1193 21.5 12.5ZM13 19C13 20.3807 11.8807 21.5 10.5 21.5C9.11929 21.5 8 20.3807 8 19C8 17.6193 9.11929 16.5 10.5 16.5C11.8807 16.5 13 17.6193 13 19ZM13 6C13 7.38071 11.8807 8.5 10.5 8.5C9.11929 8.5 8 7.38071 8 6C8 4.61929 9.11929 3.5 10.5 3.5C11.8807 3.5 13 4.61929 13 6ZM10.5 13.5C11.3284 13.5 12 12.8284 12 12C12 11.1716 11.3284 10.5 10.5 10.5C9.67157 10.5 9 11.1716 9 12C9 12.8284 9.67157 13.5 10.5 13.5Z"/></svg> <span class="fw-bold">HUBSPOT</span>
    </div>
  </div>
</div>

<section class="stats-section">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-md-3 col-6">
        <div class="stat-box">
          <div class="icon-wrapper"><i class="bi bi-people-fill"></i></div>
          <div class="h3 fw-bold">200+</div>
          <p>Students Trained</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-box">
          <div class="icon-wrapper"><i class="bi bi-building-check"></i></div>
          <div class="h3 fw-bold">50+</div>
          <p>Hiring Partners</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-box">
          <div class="icon-wrapper"><i class="bi bi-award-fill"></i></div>
          <div class="h3 fw-bold">20+</div>
          <p>Batches Completed</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-box">
          <div class="icon-wrapper"><i class="bi bi-laptop"></i></div>
          <div class="h3 fw-bold">100%</div>
          <p>Practical Learning</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Placement Partners Section -->
<section class="py-4 border-bottom border-top bg-white">
  <div class="container text-center">
    <p class="text-muted fw-bold mb-4 text-uppercase tracking-wider">Our Alumni Work At</p>
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-5">
      <h4 class="fw-bold text-dark mb-0 d-flex align-items-center"><img src="assets/google.svg" alt="Google" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">Google</h4>
      <h4 class="fw-bold text-dark mb-0 d-flex align-items-center"><img src="assets/amazon.svg" alt="Amazon" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">Amazon</h4>
      <h4 class="fw-bold text-dark mb-0 d-flex align-items-center"><img src="assets/meta-icon.png" alt="Meta" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">Meta</h4>
      <h4 class="fw-bold text-dark mb-0 d-flex align-items-center"><img src="assets/microsoft.svg" alt="Microsoft" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">Microsoft</h4>
      <h4 class="fw-bold text-dark mb-0 d-flex align-items-center"><img src="assets/linkedin.svg" alt="LinkedIn" class="me-2" style="width: 24px; height: 24px; object-fit: contain;">LinkedIn</h4>
    </div>
  </div>
</section>

<section class="py-5 mt-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Choose Your Digital Marketing Certification Program in Delhi</h2>
      <p class="section-subtitle">Industry-focused programs at the <strong>best digital marketing training in New Delhi</strong> designed to launch your career.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-4 col-md-6">
        <div class="course-box">
          <div class="course-icon"><i class="bi bi-mortarboard"></i></div>
          <h4>Master in Digital Marketing (MIDM)</h4>
          <div class="course-meta">
            <span><i class="bi bi-clock"></i> 6+2 Months</span>
            <span><i class="bi bi-bar-chart"></i> Advanced Level</span>
          </div>
          <p class="text-muted mb-4">500+ hours practical training, paid internship, and guaranteed career placement.</p>
          <div class="mb-4">
            <span class="badge bg-light text-dark border p-2 px-3 fs-6">Get Free Quote</span>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-danger rounded-pill fw-semibold px-4" href="midm.php">View MIDM Course Details</a>
            <a class="btn btn-outline-dark rounded-pill fw-semibold" href="assets/agdm_brochure.pdf" target="_blank"><i class="bi bi-download me-2"></i>Syllabus</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="course-box">
          <div class="course-icon"><i class="bi bi-briefcase"></i></div>
          <h4>Professional Digital Marketing</h4>
          <div class="course-meta">
            <span><i class="bi bi-clock"></i> 3+1 Months</span>
            <span><i class="bi bi-bar-chart"></i> Entry Level</span>
          </div>
          <p class="text-muted mb-4">Fast-track customized modules perfect for working professionals and business owners.</p>
          <div class="mb-4">
            <span class="badge bg-light text-dark border p-2 px-3 fs-6">Get Free Quote</span>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-danger rounded-pill fw-semibold px-4" href="pidm.php">View PIDM Course Details</a>
            <a class="btn btn-outline-dark rounded-pill fw-semibold" href="assets/agdm_brochure.pdf" target="_blank"><i class="bi bi-download me-2"></i>Syllabus</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Tools You Will Learn Section -->
<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Master The Tools</span>
      <h2 class="fw-bold">Tools & Platforms You Will Learn</h2>
      <p class="section-subtitle">Get hands-on experience with industry-standard digital marketing tools.</p>
    </div>
    <div class="row g-4 text-center justify-content-center">
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/google-ads.png" alt="Google Ads" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">Google Ads</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/meta-icon.png" alt="Meta Ads" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">Meta Ads</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/google-analytics.png" alt="Analytics" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">Analytics</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/mailchimp-dark.png" alt="Mailchimp" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">Mailchimp</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/chat-gpt.png" alt="ChatGPT" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">ChatGPT</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-4">
        <div class="p-3 border rounded shadow-sm tool-box h-100 d-flex flex-column justify-content-center align-items-center bg-light">
          <img src="assets/microsoft-icon.png" alt="Microsoft Ads" class="img-fluid mb-2" style="height: 48px; width: 48px; object-fit: contain;" loading="lazy">
          <p class="mb-0 fw-semibold text-dark">Microsoft Ads</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Trainer Section -->
<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Expert Mentors</span>
      <h2 class="fw-bold">Learn from Industry Practitioners</h2>
      <p class="section-subtitle">Our trainers don't just teach — they run successful digital campaigns for global brands.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <!-- Trainer 1: Rasleen Kaur -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 trainer-card">
          <img src="assets/rasleenkaur.jpg" class="card-img-top" alt="Rasleen Kaur - Social Media Expert" style="height: 480px; object-fit: cover; object-position: center 5%;" loading="lazy">
          <div class="card-body p-4 text-center">
            <h4 class="fw-bold mb-1">Rasleen Kaur</h4>
            <p class="text-danger fw-semibold mb-3">Founder & CEO</p>
            <p class="text-muted small mb-4">Expert in Content Strategy and Social Media growth. Helped 50+ brands build organic presence and viral campaigns.</p>
            <a href="https://www.linkedin.com/in/rasleen-kaur-ba657b119?utm_source=share_via&utm_content=profile&utm_medium=member_ios" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4"><i class="bi bi-linkedin me-2"></i>LinkedIn Profile</a>
          </div>
        </div>
      </div>
      <!-- Trainer 2: Jasdeep Singh -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 trainer-card">
          <img src="assets/sir-new.jpeg" class="card-img-top" alt="Jasdeep Singh - Digital Marketing Trainer" style="height: 480px; object-fit: cover; object-position: center 5%;" loading="lazy">
          <div class="card-body p-4 text-center">
            <h4 class="fw-bold mb-1">Jasdeep Singh</h4>
            <p class="text-danger fw-semibold mb-3">Co-Founder & Managing Director</p>
            <p class="text-muted small mb-4">10+ years of experience in Performance Marketing and SEO. Trained 200+ students and managed ₹5Cr+ in ad spend.</p>
            <a href="https://www.linkedin.com/in/jasdeep-singh-a79b4a33?utm_source=share_via&utm_content=profile&utm_medium=member_ios" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4"><i class="bi bi-linkedin me-2"></i>LinkedIn Profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="row g-5 align-items-center">
      <div class="col-lg-7">
        <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Why Choose Us</span>
        <h2 class="display-6 fw-bold mb-4">Why AGDM Academy is Delhi's Best Digital Marketing Training Institute</h2>
        <p class="lead text-muted mb-5">As the <strong>best digital marketing institute in Delhi</strong>, we combine practical execution, modern strategy, and 1-on-1 mentorship to make you job-ready.</p>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-graph-up-arrow"></i>
              <span>Live Campaign Execution</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-file-earmark-person"></i>
              <span>Resume & Interview Prep</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-patch-check"></i>
              <span>Google & Meta Certifications</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-globe"></i>
              <span>Freelancing Masterclass</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-camera-video"></i>
              <span>Backup Classes & LMS Access</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="feature-box">
              <i class="bi bi-person-workspace"></i>
              <span>Mentorship by Practitioners</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="enquiry-box" id="request-session">
          <h3 class="h4 mb-3 fw-bold">Request a Free Session</h3>
          <p class="text-white-50 mb-4">Get a callback from our expert counsellor within 24 hours.</p>
          
          <?php if ($formSuccess): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 p-3 mb-4 rounded-3 border-0 bg-success bg-opacity-25 text-white">
              <i class="bi bi-check-circle-fill"></i>
              <p class="mb-0 small fw-medium">Request sent successfully! Our counsellor will contact you soon.</p>
            </div>
          <?php endif; ?>

          <?php if ($formErrors): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 p-3 mb-4 rounded-3 border-0 bg-danger bg-opacity-25 text-white">
              <i class="bi bi-exclamation-triangle-fill"></i>
              <p class="mb-0 small fw-medium"><?= htmlspecialchars($formErrors[0]) ?></p>
            </div>
          <?php endif; ?>

          <form action="https://agdmacademy.com/#request-session" method="post">
            <input type="hidden" name="action" value="request_session">
            <div class="mb-3">
              <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?= htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
              <input type="tel" name="phone" class="form-control" placeholder="Phone Number" value="<?= htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
            </div>
            <div class="mb-4">
              <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>
            <?= agdm_render_captcha(true); ?>
            <button class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow" type="submit">Submit Request</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 testimonials-band">
  <div class="container py-4">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5">
        <span class="badge bg-white text-danger mb-3 px-3 py-2 rounded-pill">Success Stories</span>
        <h2 class="display-6 fw-bold text-white mb-4">Our Students' Success Stories — Digital Marketing Careers in Delhi</h2>
        <p class="lead text-white-50 mb-0">Join the <strong>best digital marketing course in Uttam Nagar</strong>. Our alumni work across top agencies and global brands.</p>
      </div>
      <div class="col-lg-7">
        <div class="row g-4">
          <!-- Testimonial 1 -->
          <div class="col-md-6">
             <div class="testimonial-card h-100 d-flex flex-column">
              <i class="bi bi-quote quote-icon text-danger opacity-50"></i>
              <div class="rating-stars mb-2 mt-2">
                <i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i>
              </div>
              <p class="mt-2 flex-grow-1 text-muted fst-italic small">"I give AGDM Academy a solid 5-star rating! The mentors are highly supportive. I joined with zero knowledge, and within 4 months, I landed an internship. Best digital marketing institute in Delhi!"</p>
              <div class="testimonial-author mt-3 pt-3 border-top">
                <img src="https://ui-avatars.com/api/?name=Priya+Sharma&background=fee2e2&color=dc1e28" alt="Priya">
                <div>
                  <h6 class="mb-0 fw-bold small">Priya Sharma</h6>
                  <small class="text-muted extra-small">Digital Marketing Executive</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Testimonial 2 -->
           <div class="col-md-6">
             <div class="testimonial-card h-100 d-flex flex-column">
              <i class="bi bi-quote quote-icon text-danger opacity-50"></i>
              <div class="rating-stars mb-2 mt-2">
                <i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i>
              </div>
              <p class="mt-2 flex-grow-1 text-muted fst-italic small">"Definitely a 5-star experience! AGDM Academy doesn't just teach theory; they make you work on live projects. Secured a job at a top agency immediately after the MIDM course."</p>
              <div class="testimonial-author mt-3 pt-3 border-top">
                <img src="https://ui-avatars.com/api/?name=Rahul+Verma&background=e0e7ff&color=dc1e28" alt="Rahul">
                <div>
                  <h6 class="mb-0 fw-bold small">Rahul Verma</h6>
                  <small class="text-muted extra-small">Placed at GroupM</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Testimonial 3 -->
          <div class="col-md-6">
             <div class="testimonial-card h-100 d-flex flex-column">
              <i class="bi bi-quote quote-icon text-danger opacity-50"></i>
              <div class="rating-stars mb-2 mt-2">
                <i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i>
              </div>
              <p class="mt-2 flex-grow-1 text-muted fst-italic small">"The 1-on-1 mentorship at AGDM is unmatched. They helped me scale my freelance business to 6 figures within months. Highly recommend their professional course!"</p>
              <div class="testimonial-author mt-3 pt-3 border-top">
                <img src="https://ui-avatars.com/api/?name=Amit+Singh&background=dcfce7&color=166534" alt="Amit">
                <div>
                  <h6 class="mb-0 fw-bold small">Amit Singh</h6>
                  <small class="text-muted extra-small">Freelance Media Buyer</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Testimonial 4 -->
          <div class="col-md-6">
             <div class="testimonial-card h-100 d-flex flex-column">
              <i class="bi bi-quote quote-icon text-danger opacity-50"></i>
              <div class="rating-stars mb-2 mt-2">
                <i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i><i class="bi bi-star-fill text-warning fs-5"></i>
              </div>
              <p class="mt-2 flex-grow-1 text-muted fst-italic small">"Best experience learning Meta Ads. The strategy part is what sets AGDM apart. I'm now handling 5+ client accounts with confidence."</p>
              <div class="testimonial-author mt-3 pt-3 border-top">
                <img src="https://ui-avatars.com/api/?name=Sneha+Kapoor&background=fdf2f8&color=9d174d" alt="Sneha">
                <div>
                  <h6 class="mb-0 fw-bold small">Sneha Kapoor</h6>
                  <small class="text-muted extra-small">Paid Media Specialist</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-white" id="blogs">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Resources</span>
      <h2 class="fw-bold">Latest Growth Insights</h2>
      <p class="section-subtitle">Read practical insights on SEO, paid ads, social media, and digital strategy.</p>
    </div>
    <div class="row g-5">
      <!-- Blog Item 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="SEO Checklist" style="height: 240px; object-fit: cover;" loading="lazy">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-danger bg-opacity-10 text-danger mb-3 align-self-start px-3 py-2 rounded-pill">SEO</span>
            <h5 class="fw-bold mb-3">The Ultimate SEO Checklist for 2026</h5>
            <p class="text-muted flex-grow-1">Actionable on-page and technical SEO checklist to improve your organic rankings faster and dominate the SERPs.</p>
            <a href="blog-seo-checklist" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read: The Ultimate SEO Checklist for 2026 <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1533750349088-cd871a92f312?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="Meta Ads Guide" style="height: 240px; object-fit: cover;" loading="lazy">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 align-self-start px-3 py-2 rounded-pill">Paid Ads</span>
            <h5 class="fw-bold mb-3">How to Start Scaling Meta Ads</h5>
            <p class="text-muted flex-grow-1">A beginner-friendly roadmap to launch profitable ad campaigns with a clear funnel structure and optimal ROAS.</p>
            <a href="blog-meta-ads" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read: How to Start Scaling Meta Ads <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Blog Item 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden blog-hover-effect">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop" class="card-img-top" alt="AI Tools" style="height: 240px; object-fit: cover;" loading="lazy">
          <div class="card-body d-flex flex-column p-4">
            <span class="badge bg-success bg-opacity-10 text-success mb-3 align-self-start px-3 py-2 rounded-pill">AI & Tech</span>
            <h5 class="fw-bold mb-3">Top 10 AI Tools for Modern Marketers</h5>
            <p class="text-muted flex-grow-1">Discover the top AI tools to drastically speed up deep research, content planning, ad creatives, and reporting.</p>
            <a href="blog-ai-tools" class="text-danger fw-semibold text-decoration-none mt-3 d-inline-flex align-items-center gap-2 stretched-link">Read: Top 10 AI Tools for Modern Marketers <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container text-center py-4">
    <h2 class="display-6 fw-bold mb-3">Ready to Build Your Digital Career?</h2>
    <p class="lead text-muted mb-4 max-w-700 mx-auto">Join AGDM Academy and learn from seasoned experts who run real campaigns every day.</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="courses.php" class="btn btn-danger btn-lg px-5 rounded-pill shadow-sm">Explore Digital Marketing Courses in Delhi <i class="bi bi-arrow-right ms-2"></i></a>
      <a href="contact.php" class="btn btn-white text-dark border bg-white btn-lg px-5 rounded-pill shadow-sm">Talk to Counsellor</a>
    </div>
  </div>
</section>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/919643661661" target="_blank" class="whatsapp-float shadow-lg d-flex align-items-center justify-content-center" style="position: fixed; bottom: 30px; right: 30px; background-color: #25D366; color: white; width: 60px; height: 60px; border-radius: 50%; font-size: 30px; z-index: 1000; text-decoration: none; transition: transform 0.3s ease;">
  <i class="bi bi-whatsapp"></i>
</a>

<style>
  .whatsapp-float:hover {
    transform: scale(1.1);
  }
  .tool-box {
    transition: all 0.3s ease;
  }
  .tool-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
  }
  .trainer-card {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  .trainer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
  }
  .trainer-card img {
    transition: transform 0.6s ease;
  }
  .trainer-card:hover img {
    transform: scale(1.05);
  }
</style>

<!-- Lead Generation Popup Modal -->
<div class="modal fade" id="leadPopupModal" tabindex="-1" aria-labelledby="leadPopupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
      <!-- Offer Header Section -->
      <div class="bg-danger text-white text-center position-relative p-4 pb-5">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <span class="badge bg-white text-danger mb-2 px-3 py-1 rounded-pill fw-bold text-uppercase tracking-wider">Limited Time Offer</span>
        <h2 class="display-5 fw-bold mb-1">50% OFF</h2>
        <p class="lead mb-0 fw-medium">For the First 50 Students!</p>
        
        <!-- Decorative SVG wave at the bottom to transition into the form -->
        <svg class="position-absolute bottom-0 start-0 w-100" style="height: 30px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
          <path fill="#ffffff" fill-opacity="1" d="M0,128L48,138.7C96,149,192,171,288,181.3C384,192,480,192,576,176C672,160,768,128,864,122.7C960,117,1056,139,1152,149.3C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
      </div>

      <!-- Form Section -->
      <div class="modal-body p-4 p-lg-5 pt-3 bg-white">
        <div class="text-center mb-4">
          <h4 class="fw-bold text-dark mb-2">Claim Your Discount Now</h4>
          <p class="text-muted small">Enroll for a free counselling session and secure your seat with 50% discount on registration.</p>
        </div>
        <form action="https://agdmacademy.com/" method="post">
          <input type="hidden" name="action" value="request_session">
          <div class="mb-3">
            <div class="input-group input-group-lg">
              <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-person"></i></span>
              <input type="text" name="name" class="form-control bg-light border-0 fs-6 ps-0" placeholder="Full Name" required>
            </div>
          </div>
          <div class="mb-3">
            <div class="input-group input-group-lg">
              <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-telephone"></i></span>
              <input type="tel" name="phone" class="form-control bg-light border-0 fs-6 ps-0" placeholder="Phone Number" required>
            </div>
          </div>
          <div class="mb-4">
            <div class="input-group input-group-lg">
              <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control bg-light border-0 fs-6 ps-0" placeholder="Email Address" required>
            </div>
          </div>
          <?= agdm_render_captcha(false); ?>
          <button class="btn btn-dark btn-lg w-100 rounded-pill fw-bold shadow-sm" type="submit">Claim 50% Off & Free Session</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Google Maps Section -->
<section class="py-5 bg-white border-top">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-5">
        <h2 class="fw-bold mb-4">Visit Our Campus</h2>
        <p class="text-muted mb-4">Located in the heart of West Delhi, our campus is easily accessible via Uttam Nagar East Metro Station. Come over for a free counselling session and see our practical learning environment.</p>
        <div class="d-flex align-items-start gap-3 mb-3">
          <i class="bi bi-geo-alt-fill text-danger fs-4 mt-1"></i>
          <div>
            <h6 class="fw-bold mb-1">Our Address</h6>
            <p class="text-muted small mb-0">Third Floor, E90A, Pankha Rd, opposite Palazzo Inn, Block F, Jivan Park, Uttam Nagar, New Delhi, 110059</p>
          </div>
        </div>
        <div class="d-flex align-items-start gap-3">
          <i class="bi bi-telephone-fill text-danger fs-4 mt-1"></i>
          <div>
            <h6 class="fw-bold mb-1">Call Us</h6>
            <p class="text-muted small mb-0">+91 9643661661 | +91 8796911169</p>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="rounded-4 overflow-hidden shadow-lg border" style="height: 400px;">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.317316086241!2d77.06878131500001!3d28.6202379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d05d9bde61561%3A0xb0b4aab093037dfd!2sAGDM%20Academy%20-%20Best%20Digital%20Marketing%20Institute!5e0!3m2!1sen!2sin!4v1715058866123!5m2!1sen!2sin" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is this course suitable for beginners?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our programs are designed from scratch. Whether you are a student, professional, or business owner with no prior technical knowledge, you can easily grasp the concepts."
      }
    },
    {
      "@type": "Question",
      "name": "Do you provide placement assistance?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! We offer 100% placement assistance. We help with resume building, mock interviews, and connect you with our 50+ hiring partners."
      }
    },
    {
      "@type": "Question",
      "name": "Will I get to work on live projects?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our training is 100% practical. You will work on live campaigns, allocate real ad budgets, and track real-time analytics to build a strong portfolio."
      }
    }
  ]
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  <?php if (!$formSuccess): ?>
  const popupModalElement = document.getElementById('leadPopupModal');
  if (popupModalElement) {
    // Check if the user has already seen the popup
    if (!localStorage.getItem('leadPopupShown')) {
      const popupModal = new bootstrap.Modal(popupModalElement);
      
      // Show the popup after a 1-second delay (shuruaat me)
      setTimeout(function() {
        if (!document.body.classList.contains('modal-open')) {
          popupModal.show();
          // Mark as shown so it doesn't appear again on subsequent visits/refreshes
          localStorage.setItem('leadPopupShown', 'true');
        }
      }, 1000);
    }
  }
  <?php else: ?>
  // If the form was successfully submitted, ensure the popup won't show again
  localStorage.setItem('leadPopupShown', 'true');
  <?php endif; ?>
});
</script>

<?php agdm_include_part('footer.php'); ?>
