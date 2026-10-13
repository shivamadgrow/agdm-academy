<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = "Enroll Now for Digital Marketing Training | AGDM Academy";
$pageDescription = "Enroll in AGDM Academy's digital marketing programs. Choose between MIDM and PIDM and start your journey towards a high-paying career.";
$pageKeywords = "enroll digital marketing course, admissions open 2026, digital marketing course fees delhi, join digital marketing class, apply for midm, apply for pidm, digital marketing training admission";

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enroll') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $phone   = trim($_POST['phone']   ?? '');
  $course  = trim($_POST['course']  ?? '');
  $batch   = trim($_POST['batch']   ?? '');
  $profile = trim($_POST['profile'] ?? '');
  $city    = trim($_POST['city']    ?? '');

  if ($name === '')  $errors[] = "Full name is required.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email is required.";
  if ($phone === '') $errors[] = "Phone number is required.";
  if ($course === '') $errors[] = "Please select a course.";

  $captcha = trim($_POST['agdm_captcha'] ?? '');
  if ($captcha === '') {
    $errors[] = "Verification is required. Please solve the math problem.";
  } elseif (!agdm_validate_captcha($captcha)) {
    $errors[] = "Incorrect verification answer. Please try again.";
  }

  if (empty($errors)) {
    $to      = "info@agdmacademy.com";
    $subject = "New Enrollment Request - AGDM Academy";
    $body    = "New Enrollment Request\n\n";
    $body   .= "Name: $name\nEmail: $email\nPhone: $phone\nCity: $city\n";
    $body   .= "Course: $course\nPreferred Batch: $batch\nProfile: $profile\n";
    $headers = "From: no-reply@agdmacademy.com\r\nReply-To: $email\r\n";
    @mail($to, $subject, $body, $headers);
    // Redirect to Thank You page for Google Ads conversion tracking
    header('Location: thank-you.php');
    exit;
  }
}

agdm_include_part('header.php');
?>

<!-- HERO SECTION -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden">
  <div class="container py-5 position-relative z-1">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill shadow-sm text-uppercase tracking-wider">🎓 Admissions Open 2026</span>
        <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2;">Enroll Now &amp; <span class="text-danger">Launch Your Career</span></h1>
        <p class="lead text-white-50 mb-4">Take the first step towards a high-paying digital marketing career. Limited seats available — enroll today and lock in your spot.</p>
        <div class="d-flex flex-wrap gap-4 mb-4">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger fs-5"></i>
            <span class="fw-medium">Weekend &amp; Weekday Batches</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger fs-5"></i>
            <span class="fw-medium">100% Placement Support</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill text-danger fs-5"></i>
            <span class="fw-medium">Google &amp; Meta Certifications</span>
          </div>
        </div>
        <a href="#enroll-form" class="btn btn-danger btn-lg px-5 rounded-pill fw-bold shadow">
          Secure My Seat <i class="bi bi-arrow-down ms-2"></i>
        </a>
      </div>
      <div class="col-lg-5">
        <div class="row g-3">
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">200<span class="text-danger">+</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Students Trained</p>
            </div>
          </div>
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">50<span class="text-danger">+</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Hiring Partners</p>
            </div>
          </div>
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">20<span class="text-danger">+</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Batches Done</p>
            </div>
          </div>
          <div class="col-6">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 text-center border border-light border-opacity-25 h-100">
              <h2 class="display-5 fw-bold text-white mb-0">100<span class="text-danger">%</span></h2>
              <p class="text-white-50 mb-0 small text-uppercase tracking-wider mt-2">Practical Training</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="position-absolute top-0 end-0 opacity-25" style="width: 400px; height: 400px; background: radial-gradient(circle, #dc3545 0%, transparent 70%); border-radius: 50%; transform: translate(30%, -30%);"></div>
  <div class="position-absolute bottom-0 start-0 opacity-25" style="width: 300px; height: 300px; background: radial-gradient(circle, #0d6efd 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, 30%);"></div>
</section>

<!-- PROGRAMS SECTION -->
<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Our Programs</span>
      <h2 class="fw-bold">Choose Your Program</h2>
      <p class="section-subtitle">Industry-focused certifications designed to make you job-ready and business-ready.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <!-- MIDM Card -->
      <div class="col-lg-5 col-md-10">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden position-relative">
          <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius:1rem;">🔥 FLAGSHIP</div>
          <div class="card-body p-5 d-flex flex-column">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mb-4" style="width:60px;height:60px;">
              <i class="bi bi-mortarboard-fill fs-3"></i>
            </div>
            <h3 class="fw-bold mb-2">Master in Digital Marketing</h3>
            <p class="text-muted small text-uppercase fw-bold mb-3 tracking-wider">MIDM — 8 Months</p>
            <p class="text-muted mb-4">500+ hours of agency-level training covering SEO, Google Ads, Meta Ads, content, analytics, and much more with live project experience.</p>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>17+ Core Modules</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>Paid Internship</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>1-on-1 Mentorship</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-danger"></i><span>Google &amp; Meta Certifications</span></li>
              <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-danger"></i><span>100% Placement Support</span></li>
            </ul>
            <div class="d-flex gap-3">
              <a href="#enroll-form" class="btn btn-danger rounded-pill fw-bold px-4 flex-grow-1">Enroll in MIDM</a>
              <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-download"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- PIDM Card -->
      <div class="col-lg-5 col-md-10">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden position-relative">
          <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 fw-bold small shadow-sm" style="border-bottom-left-radius:1rem;">⚡ FAST TRACK</div>
          <div class="card-body p-5 d-flex flex-column">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-4" style="width:60px;height:60px;">
              <i class="bi bi-briefcase-fill fs-3"></i>
            </div>
            <h3 class="fw-bold mb-2">Professional in Digital Marketing</h3>
            <p class="text-muted small text-uppercase fw-bold mb-3 tracking-wider">PIDM — 4 Months</p>
            <p class="text-muted mb-4">Fast-track, practical program for freshers, working professionals, and business owners who want to gain strong digital marketing skills quickly.</p>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>13+ Practical Modules</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Weekday &amp; Weekend Batches</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Live Project Exposure</span></li>
              <li class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Certification Provided</span></li>
              <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-primary"></i><span>Job Placement Assistance</span></li>
            </ul>
            <div class="d-flex gap-3">
              <a href="#enroll-form" class="btn btn-primary rounded-pill fw-bold px-4 flex-grow-1">Enroll in PIDM</a>
              <a href="assets/agdm_brochure.pdf" target="_blank" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-download"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BATCH SCHEDULE -->
<section class="py-5 bg-white">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Upcoming Batches</span>
      <h2 class="fw-bold">Select Your Preferred Schedule</h2>
      <p class="section-subtitle">Choose a batch that fits your lifestyle — mornings, evenings, or weekends.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-5 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center tool-box">
          <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width:65px;height:65px;">
            <i class="bi bi-sun-fill fs-2"></i>
          </div>
          <h5 class="fw-bold mb-1">Weekday Morning</h5>
          <p class="text-warning fw-bold mb-1 small">Mon – Fri</p>
          <p class="text-muted mb-0">10:00 AM – 12:00 PM</p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center tool-box">
          <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width:65px;height:65px;">
            <i class="bi bi-calendar-week-fill fs-2"></i>
          </div>
          <h5 class="fw-bold mb-1">Weekend Batch</h5>
          <p class="text-danger fw-bold mb-1 small">Sat – Sun</p>
          <p class="text-muted mb-0">11:00 AM – 3:00 PM</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ENROLLMENT FORM -->
<section class="py-5 bg-light" id="enroll-form">
  <div class="container py-4">
    <div class="row g-5 align-items-start">
      <div class="col-lg-5">
        <span class="text-danger fw-bold text-uppercase tracking-wider mb-2 d-block">Secure Your Seat</span>
        <h2 class="display-6 fw-bold mb-4">Fill the Enrollment Form</h2>
        <p class="text-muted mb-4">Our admissions counselor will contact you within 24 hours to confirm your seat and guide you through the process.</p>
        <div class="d-flex flex-column gap-3">
          <div class="d-flex align-items-center gap-3 bg-white p-3 rounded-3 shadow-sm border border-light">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;"><i class="bi bi-telephone-fill"></i></div>
            <div>
              <p class="mb-0 fw-bold text-dark small">Call / WhatsApp</p>
              <a href="tel:+919643661661" class="text-muted text-decoration-none small">+91 9643661661</a>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 bg-white p-3 rounded-3 shadow-sm border border-light">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;"><i class="bi bi-envelope-fill"></i></div>
            <div>
              <p class="mb-0 fw-bold text-dark small">Email Us</p>
              <a href="mailto:info@agdmacademy.com" class="text-muted text-decoration-none small">info@agdmacademy.com</a>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3 bg-white p-3 rounded-3 shadow-sm border border-light">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;"><i class="bi bi-geo-alt-fill"></i></div>
            <div>
              <p class="mb-0 fw-bold text-dark small">Visit Us</p>
              <span class="text-muted small">Uttam Nagar, New Delhi – 110059</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
          <h4 class="fw-bold mb-4">Enrollment Request Form</h4>

          <?php if ($success): ?>
            <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 border-0 bg-success bg-opacity-10 text-success p-4 mb-4">
              <i class="bi bi-check-circle-fill fs-3"></i>
              <div>
                <h5 class="fw-bold mb-1">Request Received!</h5>
                <p class="mb-0 small">Our counselor will contact you within 24 hours to confirm your enrollment.</p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($errors): ?>
            <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger p-4 mb-4">
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <h6 class="fw-bold mb-0">Please fix the following:</h6>
              </div>
              <ul class="mb-0 ps-4">
                <?php foreach ($errors as $err): ?>
                  <li><?= htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" action="enrollment.php#enroll-form">
            <input type="hidden" name="action" value="enroll">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-lg bg-light border-0" name="name" placeholder="Your Full Name" value="<?= htmlspecialchars($_POST['name'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-lg bg-light border-0" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Phone / WhatsApp <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-lg bg-light border-0" name="phone" placeholder="+91 XXXXXXXXXX" value="<?= htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">City / Location</label>
                <input type="text" class="form-control form-control-lg bg-light border-0" name="city" placeholder="e.g. New Delhi" value="<?= htmlspecialchars($_POST['city'] ?? ''); ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Course <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg bg-light border-0" name="course" required>
                  <option value="" disabled <?= empty($_POST['course']) ? 'selected' : ''; ?>>Select Program</option>
                  <option value="MIDM">MIDM – Master in Digital Marketing (8 Months)</option>
                  <option value="PIDM">PIDM – Professional in Digital Marketing (4 Months)</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium text-dark">Preferred Batch</label>
                <select class="form-select form-select-lg bg-light border-0" name="batch">
                  <option value="" disabled <?= empty($_POST['batch']) ? 'selected' : ''; ?>>Select Batch</option>
                  <option value="Weekday Morning (Mon-Fri 10AM-12PM)">Weekday Morning (Mon–Fri, 10AM–12PM)</option>
                  <option value="Weekend (Sat-Sun 11AM-3PM)">Weekend Batch (Sat–Sun, 11AM–3PM)</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium text-dark">Your Profile</label>
                <select class="form-select form-select-lg bg-light border-0" name="profile">
                  <option value="" disabled <?= empty($_POST['profile']) ? 'selected' : ''; ?>>Who are you?</option>
                  <option value="Student">Student</option>
                  <option value="Fresher / Job Seeker">Fresher / Job Seeker</option>
                  <option value="Working Professional">Working Professional</option>
                  <option value="Business Owner / Entrepreneur">Business Owner / Entrepreneur</option>
                  <option value="Freelancer">Freelancer</option>
                </select>
              </div>
              <div class="col-12">
                <?= agdm_render_captcha(false); ?>
              </div>
              <div class="col-12 mt-2">
                <button class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow" type="submit">
                  <i class="bi bi-check-circle me-2"></i> Submit Enrollment Request
                </button>
                <p class="text-muted text-center small mt-3 mb-0"><i class="bi bi-shield-lock me-1"></i> Your details are safe with us. No spam, ever.</p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('a[href="#enroll-form"]').forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      document.getElementById("enroll-form").scrollIntoView({ behavior: "smooth" });
    });
  });
});
</script>

<?php agdm_include_part('footer.php'); ?>
