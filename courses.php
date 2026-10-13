<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Digital Marketing Course Programs & Batches | AGDM Academy";
$pageDescription = "Explore AGDM Academy's industry-leading digital marketing courses — MIDM and PIDM — designed to make you job-ready with live projects and certifications.";
$pageKeywords = "digital marketing courses delhi, midm program, pidm course, professional digital marketing certificate, master digital marketing syllabus, weekend batches digital marketing, weekday batches digital marketing";
agdm_include_part('header.php');
?>

<!-- HERO BANNER -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1 text-center">
    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">Our Programs</span>
    <h1 class="display-4 fw-bold mb-3">Career-Ready <span class="text-danger">Digital Marketing</span> Courses</h1>
    <p class="lead text-white-50 mx-auto mb-4" style="max-width: 620px;">Practical, industry-focused training for students, freelancers, working professionals, and business owners.</p>
    <a href="enrollment.php" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow me-2">Enroll Now</a>
    <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">
      <i class="bi bi-download me-2"></i>Download Brochure
    </a>
  </div>
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 400px; height: 400px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
</section>

<!-- PROGRAMS SECTION -->
<section class="py-5 bg-white" id="programs">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Choose Your Path</span>
      <h2 class="fw-bold">Our Flagship Programs</h2>
      <p class="section-subtitle">Two world-class programs — pick the one that fits your goals and timeline.</p>
    </div>
    <div class="row g-4 justify-content-center">

      <!-- MIDM -->
      <div class="col-lg-5 col-md-10" id="midm">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden position-relative">
          <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius:1rem;">🔥 FLAGSHIP</div>
          <div class="card-body p-5 d-flex flex-column">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mb-4" style="width:64px;height:64px;">
              <i class="bi bi-mortarboard-fill fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">Master in Digital Marketing</h3>
            <p class="text-muted text-uppercase fw-bold small mb-3 tracking-wider">MIDM &mdash; 6+2 Months &bull; 500+ Hours</p>
            <p class="text-muted mb-4">An agency-level, end-to-end digital marketing program covering SEO, SEM, social media, content, email automation, analytics, and AI tools — with live project experience.</p>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>25+ Industry Modules</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>Paid Internship Opportunity</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>1-on-1 Mentorship Sessions</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>Google &amp; Meta Certifications</span></li>
              <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-danger"></i><span>100% Placement Assistance</span></li>
            </ul>
            <div class="d-flex gap-2 flex-wrap">
              <a href="midm.php" class="btn btn-danger rounded-pill fw-bold px-4 flex-grow-1">View Details</a>
              <a href="enrollment.php" class="btn btn-outline-danger rounded-pill fw-bold px-3">Enroll</a>
              <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-download"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- PIDM -->
      <div class="col-lg-5 col-md-10" id="pidm">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden position-relative">
          <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius:1rem;">⚡ FAST TRACK</div>
          <div class="card-body p-5 d-flex flex-column">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-4" style="width:64px;height:64px;">
              <i class="bi bi-briefcase-fill fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">Professional in Digital Marketing</h3>
            <p class="text-muted text-uppercase fw-bold small mb-3 tracking-wider">PIDM &mdash; 3+1 Months &bull; 200+ Hours</p>
            <p class="text-muted mb-4">A fast-track, hands-on program designed for freshers, working professionals, and business owners who want to master digital marketing essentials quickly.</p>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>15+ Practical Modules</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Weekday &amp; Weekend Batches</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Live Project Exposure</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Industry Certification</span></li>
              <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Job Placement Assistance</span></li>
            </ul>
            <div class="d-flex gap-2 flex-wrap">
              <a href="pidm.php" class="btn btn-primary rounded-pill fw-bold px-4 flex-grow-1">View Details</a>
              <a href="enrollment.php" class="btn btn-outline-primary rounded-pill fw-bold px-3">Enroll</a>
              <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-download"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- BATCH SCHEDULE -->
<section class="py-5 bg-light" id="upcoming-batches">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Flexible Timings</span>
      <h2 class="fw-bold">Upcoming Batch Schedule</h2>
      <p class="section-subtitle">Pick a time that works for you — morning, evening, or weekends.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-5 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center tool-box">
          <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width:65px;height:65px;">
            <i class="bi bi-sun-fill fs-2"></i>
          </div>
          <h5 class="fw-bold mb-1">Weekday Morning</h5>
          <p class="text-warning fw-bold small mb-1">Mon – Fri</p>
          <p class="text-muted mb-3">10:00 AM – 12:00 PM</p>
          <a href="enrollment.php" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">Book This Slot</a>
        </div>
      </div>
      <div class="col-lg-5 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center tool-box">
          <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width:65px;height:65px;">
            <i class="bi bi-calendar-week-fill fs-2"></i>
          </div>
          <h5 class="fw-bold mb-1">Weekend Batch</h5>
          <p class="text-danger fw-bold small mb-1">Sat – Sun</p>
          <p class="text-muted mb-3">11:00 AM – 3:00 PM</p>
          <a href="enrollment.php" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Book This Slot</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="py-5 bg-dark text-white" id="enrollment">
  <div class="container py-4 text-center">
    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill">🎓 Admissions Open 2026</span>
    <h2 class="display-6 fw-bold mb-3">Ready to Start Your Digital Marketing Journey?</h2>
    <p class="text-white-50 mb-4 mx-auto" style="max-width: 550px;">Limited seats per batch. Secure your spot today and get a free career counseling session.</p>
    <div class="d-flex justify-content-center flex-wrap gap-3">
      <a href="enrollment.php" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow">Enroll Now</a>
      <a href="contact.php" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">Talk to a Counselor</a>
    </div>
  </div>
</section>

<?php agdm_include_part('footer.php'); ?>
